<?php

namespace App\Repositories\Support;

use Validator;
use Carbon\Carbon;
use App\Models\Hrm\Support\TicketReply;
use App\Models\Hrm\Support\SupportTicket;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Http\Resources\Hrm\SupportTicketCollection;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\InvoiceGenerateTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class SupportTicketRepository
{
    use RelationshipTrait, FileHandler, ApiReturnFormatTrait, InvoiceGenerateTrait, DateHandler;

    protected $support;

    public function __construct(SupportTicket $support)
    {
        $this->support = $support;
    }

    public function ticketList($request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }
        $month = $this->onlyMonth($request->month);

        $tickets = $this->support->query()->where('user_id', auth()->id())->whereMonth('created_at', $month);
        $tickets->when($request->type, function (Builder $builder) use ($request) {
            $builder->where('type_id', $request->type);
        });
        $tickets = $tickets->get();
        $data = new SupportTicketCollection($tickets);
        return $this->responseWithSuccess('Ticket list', $data, 200);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $ticket = $this->support->query()->where(['id' => $id, 'user_id' => auth()->id()])->first();
        if ($ticket) {
            $data['code'] = $ticket->code;
            $data['subject'] = $ticket->subject;
            $data['description'] = $ticket->description;
            $data['type_name'] = @$ticket->type->name;
            $data['type_color'] = appColorCodePrefix() . @$ticket->type->color_code;
            $data['priority_name'] = @$ticket->priority->name;
            $data['priority_color'] = appColorCodePrefix() . @$ticket->priority->color_code;
            $data['date'] = $this->dateFormatInPlainText($ticket->created_at);
            $data['file'] = uploaded_asset($ticket->attachment_file_id);

            $replies=[];
            foreach ($ticket->supportTickets as $key => $reply) {
                $now = Carbon::now();
                

                $replies[$key]['name']=$reply->user->name;
                $replies[$key]['role']=$reply->user->role->name;
                $replies[$key]['message']=$reply->message;
                $replies[$key]['time']=$reply->created_at->diffForHumans();
            }
            $data['replies']=$replies;

            return $this->responseWithSuccess('Ticket view', $data, 200);
        } else {
            return $this->responseWithError('No data found', [], 400);
        }
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|max:50',
            'description' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required fields are missing'), $validator->errors(), 422);
        }
        $support = new $this->support();
        $support->code = $this->generateCode($this->support, 'ST');
        $support->user_id = auth()->id();
        $support->company_id = $this->companyInformation()->id;
        $support->type_id = 12;
        $support->priority_id = $request->priority_id;
        $support->subject = $request->subject;
        $support->date = date('Y-m-d');
        $support->description = $request->description;
        if ($request->hasFile('attachment_file')) {
            $support->attachment_file_id = $this->uploadImage($request->attachment_file, 'uploads/supportTicket')->id;
        }
        $support->save();
        if ($support) {
            return $this->responseWithSuccess('Ticket created successfully', [], 200);
        } else {
            return $this->responseWithError('Ticket dose not created', [], 400);
        }
    }

    public function ticketReply($request, $ticket)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required fields are missing'), $validator->errors(), 422);
        }

        $ticket->type_id = $request->type_id;
        $ticket->save();
        if ($ticket) {
            $ticket->supportTickets()->create([
                'user_id' => auth()->id(),
                'message' => $request->message
            ]);
            return $this->responseWithSuccess('Operation successfull', [], 200);
        } else {
            return $this->responseWithError('Dose not created', [], 400);
        }

    }

    public function staffSupportDataTable($request, $id = null)
    {
        $tickets = $this->support->query()->where('user_id', auth()->user()->id);
        $tickets->when(\request()->get('date'), function (Builder $builder) {
            $date = explode(' - ', \request()->get('date'));
            return $builder->whereBetween('date', [$this->databaseFormat($date[0]), $this->databaseFormat($date[1])]);
        });
        if (auth()->user()->role->slug == 'staff') {
            $tickets = $tickets->where('user_id', auth()->id());
        }
       return $this->suportDatatable($tickets);
    }
    public function dataTable($request, $id = null)
    {
        $tickets = $this->support->query();
        $tickets->when(\request()->get('date'), function (Builder $builder) {
            $date = explode(' - ', \request()->get('date'));
            return $builder->whereBetween('date', [$this->databaseFormat($date[0]), $this->databaseFormat($date[1])]);
        });
        $tickets->when($id, function (Builder $builder) use ($id) {
            return $builder->where('user_id', $id);
        });
        if (auth()->user()->role->slug == 'staff') {
            $tickets = $tickets->where('user_id', auth()->id());
        }
       return $this->suportDatatable($tickets);
    }

    public function suportDatatable($tickets)
    {
        return datatables()->of($tickets->latest()->get())
        ->addColumn('action', function ($data) {
            $action_button = '';

            if (hasPermission('support_reply')) {
                $action_button .= '<a href="' . route('supportTicket.reply', [$data->id, encrypt($data->code)]) . '" class="dropdown-item">Reply</a>';
            }
            if (hasPermission('support_delete')) {
                $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`hrm/support/ticket/delete/`)', 'delete');
            }

            if (hasPermission('support_delete')) {
                $button = '<div class="flex-nowrap">
                <div class="dropdown">
                    <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                </div>
            </div>';
                return $button;
            }
        })
        ->addColumn('date', function ($data) {
            return @$data->date;
        })
        ->addColumn('code', function ($data) {
            return @$data->code;
        })
        ->addColumn('employee_name', function ($data) {
            return @$data->user->name;
        })
        ->addColumn('subject', function ($data) {
            return @$data->subject;
        })
        ->addColumn('type', function ($data) {
            return '<span class="badge badge-' . @$data->type->class . '">' . @$data->type->name . '</span>';

        })
        ->addColumn('priority', function ($data) {
            return '<span class="badge badge-' . @$data->priority->class . '">' . @$data->priority->name . '</span>';
        })
        ->rawColumns(array('date', 'code', 'employee_name', 'subject', 'employee_name', 'type', 'priority', 'action'))
        ->make(true);
    }

    public function destroy($id)
    {
        $ticket = $this->support->query()->find($id);
        if ($ticket) {
            $ticket->delete();
            return true;
        } else {
            return false;
        }
    }
}
