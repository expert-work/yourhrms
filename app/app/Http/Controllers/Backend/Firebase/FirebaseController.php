<?php

namespace App\Http\Controllers\Backend\Firebase;

use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserDevice\UserDevice;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;

class FirebaseController extends Controller
{
    use FirebaseNotification, ApiReturnFormatTrait;

    public function firebaseToken(Request $request)
    {
        try {
            $agent = new Agent();
            $device_name = @$request->device_name ?? $agent->device() . '-' . $_SERVER['REMOTE_ADDR'] ;
            $info = UserDevice::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'device_name' => $device_name,
                ],
                [
                    'device_name' => $device_name,
                    'device_token' => $request->firebase_token,
                ]
            );
            $user = User::find($request->user_id);
            $user->device_token=$request->firebase_token;
            $user->save();
            return $this->responseWithSuccess('Token Assigned successfully', [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError('Something went wrong! try again', [], 400);
        }
    }

    public function initFirebase()
    {
        return response()->view('vendor.notifications.sw_firebase')->header('Content-Type', 'application/javascript');
    }



    function test(){
       return $this->sendFirebaseNotification(59,'leave_request',1,url('/'));
    }
    public function SendNotification(Request $request)
    {
        return $this->sendCustomFirebaseNotification($request->user_id, 'notice', '', 'notice', $request->title, $request->message);
    }
}
