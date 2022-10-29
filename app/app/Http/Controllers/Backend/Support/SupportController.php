<?php

namespace App\Http\Controllers\Backend\Support;

use App\Http\Controllers\Controller;
use App\Models\Hrm\Support\SupportTicket;
use App\Repositories\Support\SupportTicketRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    protected $support;

    public function __construct(SupportTicketRepository $repository)
    {
        $this->support = $repository;
    }

    public function index()
    {
        $data['title'] = _trans('support.Support ticket');
        $data['id'] = auth()->id();
        $data['url'] = route('supportTicket.dataTable');
        return view('backend.support.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('support.Create support ticket');
        $data['id'] = auth()->id();
        $data['url'] = route('supportTicket.dataTable');
        return view('backend.support.create', compact('data'));
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $ticket = $this->support->store($request);
        try {
            if ($ticket->original['result']) {
                Toastr::success(_trans('response.Operation successfull'), 'Success');
            } else {
                Toastr::error($ticket->original['message'], 'Error');
            }
            return redirect()->route('user.supportTicket');
        } catch (\Throwable $throwable) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }


    public function ticketReplyStore(Request $request,SupportTicket $ticket)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $ticket = $this->support->ticketReply($request,$ticket);
            if ($ticket->original['result']) {
                Toastr::success(_trans('response.Operation successfull'), 'Success');
            } else {
                Toastr::error($ticket->original['message'], 'Error');
            }
            return redirect()->back();
        } catch (\Throwable $throwable) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }

    public function staffTicket()
    {
        $data['title'] = _trans('support.Support ticket');
        $data['id'] = auth()->id();
        $data['url'] = route('user.supportTicket.dataTable', auth()->id());
        return view('backend.user.support_ticket', compact('data'));
    }


    public function ticketReply(SupportTicket $ticket, $code)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $data['title'] = _trans('support.Support ticket reply');
            if ($ticket->code != decrypt($code)) {
                return abort(400);
            }
            $data['show'] = $ticket->load('user','supportTickets.user');
            return view('backend.support.reply', compact('data'));
        } catch (\Throwable $exception) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }




    public function dataTable(Request $request)
    {
        return $this->support->dataTable($request);
    }

    public function userTicketDatatable(Request $request, $id)
    {
        return $this->support->dataTable($request, $id);
    }

    public function delete($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $ticketDelete = $this->support->destroy($id);
            if ($ticketDelete) {
                Toastr::success(_trans('response.Operation successfull'), 'Success');
            } else {
                Toastr::error(_trans('response.Ticket did not deleted'), 'Error');
            }
            return redirect()->back();
        } catch (\Throwable $throwable) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }
}
