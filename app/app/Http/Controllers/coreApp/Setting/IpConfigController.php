<?php

namespace App\Http\Controllers\coreApp\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Settings\IpRepository;

class IpConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ipConfig;
    protected $userRepo;

    public function __construct(IpRepository $ipConfig,UserRepository $userRepo)
    {
        $this->ipConfig = $ipConfig;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        if (!checkFeature('user_location_binds')){
            $data['title'] = _trans('settings.IP Whitelist');
            return view('backend.ip_setting.index',compact('data'));
        } else {
            $data['title'] = _trans('settings.Users IP Whitelist');
            return view('backend.ip_setting.user_wise',compact('data'));
        }
        
       
    }
    public function UserWise()
    {
        if (!checkFeature('user_location_binds'))
        {
            Toastr::error(_trans('response.Please contact with Aplication Vendor!'), 'Error');
            return redirect()->back();
        }
        $data['title'] = _trans('settings.Users IP Whitelist');
        return view('backend.ip_setting.user_wise',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = _trans('settings.Add New IP Address');
        return view('backend.ip_setting.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }


        $request->validate([
            'location' => 'required',
            'ip_address' => 'required',
            'status_id' => 'required',
            'is_office' => 'required',
        ]);
       try {
        // return $request;
        $store=$this->ipConfig->storeIp($request);
          if ($store) {
                Toastr::success(_trans('response.IP Address Added Successfully'), 'Success');
                return redirect()->route('ipConfig.index');
          } else {
            Toastr::error(_trans('response.IP Address Not Added'), 'Error');
            return redirect()->back();
          }
       } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function datatable()
    {
        return $this->ipConfig->dataTable();
    }
    public function userDatatable(Request $request)
    {
        return $this->userRepo->ip_data_table($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = _trans('response.Edit IP Configuration');
        $data['show'] = $this->ipConfig->showIp($id);
        // return $data['show'];
        return view('backend.ip_setting.edit', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $request->validate([
            'location' => 'required',
            'ip_address' => 'required',
            'status_id' => 'required',
            'is_office' => 'required',
        ]);
        try {
            $update = $this->ipConfig->updateIp($request, $id);
            if ($update) {
                Toastr::success('Ip Address Updated Successfully', 'Success');
                return redirect()->route('ipConfig.index');
            } else {
                Toastr::error('IP Address Not Updated', 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $delete = $this->ipConfig->deleteIp($id);
            if ($delete) {
                Toastr::success('IP Address Deleted Successfully', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('IP Address Not Deleted', 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
}
