<?php

namespace App\Repositories\Settings;

use App\Repositories\UserRepository;
use App\Models\coreApp\Setting\IpSetup;
use App\Repositories\Interfaces\IpInterface;

class IpRepository implements IpInterface
{
    protected $ipSetup;
    protected $userRepo;

    public function __construct(IpSetup $ipSetup,UserRepository $userRepo)
    {
        $this->ipSetup = $ipSetup;
        $this->userRepo = $userRepo;

    }

    public function storeIp($request)
    {
        try {

            $ipconfig= new IpSetup;
            $ipconfig->location = $request->location;
            $ipconfig->ip_address = $request->ip_address;
            $ipconfig->status_id = $request->status_id;
            $ipconfig->is_office = $request->is_office;
            $ipconfig->company_id = auth()->user()->company->id;
            $ipconfig->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function updateIp($request,$id)
    {
        try {
            $ipconfig= IpSetup::where('id',$id)->first();
            $ipconfig->location = $request->location;
            $ipconfig->ip_address = $request->ip_address;
            $ipconfig->status_id = $request->status_id;
            $ipconfig->is_office = $request->is_office;
            $ipconfig->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function dataTable()
    {
        $ip_list = $this->ipSetup->query();

        return datatables()->of($ip_list->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                    $action_button .= '<a href="' . route('ipConfig.show', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`admin/company-setup/ip-whitelist/delete/`)', 'delete');

                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('location', function ($data) {
                return @$data->location;
            })
            ->addColumn('ip_address', function ($data) {
                return @$data->ip_address;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->addColumn('IsOffice', function ($data) {
                return '<span class="badge badge-' . @$data->IsOffice->class . '">' . @$data->IsOffice->name . '</span>';
            })
            ->rawColumns(array('location', 'ip_address','status', 'IsOffice', 'action'))
            ->make(true);
    }
   

    public function showIp($id)
    {
        try {
            $ip = $this->ipSetup->find($id);
            return $ip;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function deleteIp($id)
    {
        try {
            $this->ipSetup->where('id', $id)->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

}