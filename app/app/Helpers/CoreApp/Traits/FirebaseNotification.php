<?php

namespace App\Helpers\CoreApp\Traits;

use Illuminate\Support\Facades\Log;
use App\Models\UserDevice\UserDevice;
use App\Models\Notification\NotificationType;
use App\Repositories\Settings\ApiSetupRepository;

trait FirebaseNotification
{
    protected $apiSetupRepo;

    public function __construct(ApiSetupRepository $apiSetupRepo)
    {
        $this->apiSetupRepo = $apiSetupRepo;
    }
    function sendFirebaseNotification($user_id, $notification_type, $id = null, $url)
    {
        try {
            //if env app is not production then return
            if (env('APP_ENV') == 'production' && !env('APP_SYNC')) {
                $notification = NotificationType::where('type', $notification_type)->firstOrFail();
                $firebaseToken = UserDevice::where('user_id', $user_id)->whereNotNull('device_token')->pluck('device_token')->all();
                
                $SERVER_API_KEY=settings('firebase');
                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification" => [
                        "title"             => $notification->title,
                        "body"              => $notification->description,
                        "badge"             => "1",
                        "click_action"      => $url,
                        "type"              => $notification->type,
                        "image"             => $notification->icon ? uploaded_asset($notification->icon) : null,
                        "sound"             => "default",
                        "content_available" => true,
                        "priority"          => "high",
                    ],
                    "data" => [
                        "title" => $notification->title,
                        "body" => $notification->description,
                        "url" => $url,
                        "id" => $id,
                        "type" => $notification->type,
                        "image" => $notification->icon ? uploaded_asset($notification->icon) : null,
                    ],
                    "aps" => [
                        "title" => $notification->title,
                        "body" => $notification->description,
                        "badge" => "1",
                        "click_action" => $url,
                        "id" => $id,
                        "type" => $notification->type,
                        "sound" => "default",
                        "image" => $notification->icon ? uploaded_asset($notification->icon) : null,
                        "content_available" => true,
                        "priority" => "high",
                    ],
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
                Log::info("firebase response: ".$response);
                return $response;
            }else{
               return true;
            }

        } catch (\Throwable $th) {
            return $th;
        }
    }

    function sendCustomFirebaseNotification($user_id, $notification_type, $id = null, $url,$title,$body,$image=null)
    {
        try {
            if (env('APP_ENV') == 'production' && !env('APP_SYNC')) {
            $firebaseToken = UserDevice::where('user_id', $user_id)->whereNotNull('device_token')->pluck('device_token')->all();

            $SERVER_API_KEY=settings('firebase');
            $data = [
                "registration_ids" => $firebaseToken,
                "data" => [
                    "title" => $title,
                    "body" => $body,
                    "url" => $url,
                    "id" => $id,
                    "type" => $notification_type,
                    "image" => $image,
                    "sound" => "default",
                    "priority" => "high",
                    "content_available" => true,
                ],
                // "aps" => [
                //     "title" => $title,
                //     "body" => $body,
                //     "badge" => "1",
                //     "click_action" => $url,
                //     "id" => $id,
                //     "type" => $notification_type,
                //     "sound" => "default",
                //     "image" => $image,
                //     "content_available" => true,
                //     "priority" => "high",
                // ],
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                    "badge" => "1",
                    "click_action" => $url,
                    "id" => $id,
                    "type" => $notification_type,
                    "image" => $image,
                    "sound" => "default",
                    "content_available" => true,
                    "priority" => "high",
                ],
            ];
            $dataString = json_encode($data);
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);
            // dd($response);
            Log::info("firebase response: ".$response);
            return $response;
        }else{
            return true;
        }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function sendToChannel($title,$message,$type)
    {
        try {
            if (env('APP_ENV') == 'production' && !env('APP_SYNC')) {
                $headers = array (
                    'Authorization:key=' .settings('firebase'),
                    'Content-Type:application/json'
                );
    
                // Add notification content to a variable for easy reference
                $notifyData = [
                    'title'        => $title,
                    'body'         => $message,
                    'message'      => $message,
                    // 'image'        => $image ? $image : null,
                    'type'         => $type,
                    // 'click_action' => $click_action ? $click_action : null,
                    'sound'        => '1',
                    'vibrate'      => '1'
                ];
                // Create the api body
                $apiBody = [
                    'notification' => $notifyData,                                       // Optional - Trigers mulitple notification
                    'data' => $notifyData,
                    // "time_to_live" => "60",                                              // Optional
                    'to' =>  '/topics/'.settings('fcm_topic'),                              // Notification Channel. Example: '/topics/mytargettopic'
                ];
    
                // Initialize curl with the prepared headers and body
                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt ($ch, CURLOPT_POST, true );
                curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));
    
                // Execute call and save result
                $result = curl_exec ( $ch );
    
                // Close curl after call
                curl_close ( $ch );
                
                // dd($result);
                return $result;
            } else {
                return true;
            } 
        } catch (\Throwable $th) {
            return false;
        }
    }
}
