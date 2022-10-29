<?php

namespace App\Http\Controllers\Backend\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Hrm\Client\ClientRepository;

class ClientController extends Controller
{
    protected $clientRepo;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }


    public function index()
    {
        $data['title']=_trans('client.Client List');

        return view('backend.client.index',compact('data'));
    }
    public function create()
    {

        $data['title']=_trans('client.Add New Client');

        return view('backend.client.create',compact('data'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|unique:clients',
            'website' => 'required',
        ]);
        try {
            $result=$this->clientRepo->storeClient($request);
            if ($result) {
                Toastr::success(_trans('response.Operation successfull'), 'Created');
                return redirect()->route('client.index');
            } else {
                Toastr::error(_trans('response.Something went wrong!'), 'Error');
                return redirect()->route('client.create');
            }
            
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->route('client.create');
        }
    }
    public function update(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,'.$request->id,
            'phone' => 'required|unique:clients,phone,'.$request->id,
            'website' => 'required',
        ]);
        try {
            $result=$this->clientRepo->updateClient($request);
            if ($result) {
                Toastr::success(_trans('response.Operation successfull'), 'Updated');
                return redirect()->route('client.index');
            } else {
                Toastr::error(_trans('response.Something went wrong!'), 'Error');
                return redirect()->back();
            }
            
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function datatable(Request $request)
    {
        return $this->clientRepo->dataTable($request);
    }

    public function edit($id)
    {
        $data['title']=_trans('Edit Client Information');
        $data['show']=$this->clientRepo->getById($id);
        return view('backend.client.create',compact('data'));

    }
    public function delete($id)
    {
        try {
            $result=$this->clientRepo->deleteClient($id);
            if ($result) {
                Toastr::success(_trans('response.Operation successfull'), 'Deleted');
                return redirect()->route('client.index');
            } else {
                Toastr::error(_trans('response.Something went wrong!'), 'Error');
                return redirect()->back();
            }
            
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
}
