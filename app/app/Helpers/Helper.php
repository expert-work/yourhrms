<?php

use Carbon\Carbon;
use App\Models\Upload;
use App\Models\Translation;
use Illuminate\Support\Str;
use App\Models\Settings\ApiSetup;
use Illuminate\Support\Facades\DB;
use App\Models\Visit\VisitSchedule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Models\Settings\HrmLanguage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Models\coreApp\Setting\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Hrm\Attendance\Attendance;
use App\Models\Hrm\Attendance\EmployeeBreak;
use App\Notifications\HrmSystemNotification;
use App\Models\coreApp\Setting\CompanyConfig;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
/*
 * Set active class
 */

function menu_active_by_route($route)
{
    return request()->routeIs($route) ? 'active' : 'in-active';
}
function menu_active_by_url($url)
{
    return url()->current()==$url ? 'active' : 'in-active';
}

function set_active($path, $active = 'show')
{
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

if (!function_exists('appMode')) {
    function appMode()
    {
        $app_sync= Config::get('app.app_sync');
        $app_style= Config::get('app.APP_STYLE');
        if($app_sync){
            if($app_style=='demo'){
                return true;
            }else{
                return false; 
            }
        }else{
            return false;
        }
    }
}

if (!function_exists('demoCheck')) {
    function demoCheck($message = '')
    {
        if (appMode()) {
            if (empty($message)) {
                $message = 'For the demo version, you cannot change this';
            }
            Toastr::error($message, 'Failed');
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        try {
            $data = ApiSetup::where('name', $name)
                ->select('key', 'secret', 'endpoint', 'status_id')
                ->first();
            return $data;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
if (!function_exists('_trasnlation')) {
    function _trasnlation($key)
    {
       $trans= trans($key);
        try {
            $exp=explode('.', $trans);
            if (count($exp) == 2) {
                return $exp[1];
            }else{
                return $trans;
            }
        } catch (\Throwable $th) {
            return $key;
        }
    }
}
if (!function_exists('_trans')) {
    function _trans($value)
    {
        try {
            $local = app()->getLocale();

            $langPath = resource_path('lang/' . $local . '/');

            if (!file_exists($langPath)) {
                mkdir($langPath, 0777, true);
            }

            if (str_contains($value, '.')) {
                $new_trns = explode('.', $value);
                $file_name = $new_trns[0];
                $trans_key = $new_trns[1];


                $file_path = $langPath . '' . $file_name . '.json';
                if (file_exists($file_path)) {

                    $file_data = json_decode(file_get_contents($file_path), true);
                    $file_content = new \stdClass;
                    // dd(gettype($file_content));
                    foreach (array_keys($file_data) as $property) {
                        $file_content->{$property} = $file_data[$property];
                    }
                    if (array_key_exists($trans_key, $file_data)) {
                        return $file_content->{$trans_key};
                    } else {
                        $file_content->{$trans_key} = $trans_key;
                        $str = <<<EOT
                                            {
                                            EOT;
                        foreach ($file_content as $key => $val) {
                            if (gettype($val) == 'string') {

                                $line = <<<EOT
                                                                    "{$key}" : "{$val}",\n
                                                                EOT;
                            }
                            if (gettype($val) == 'array') {
                                $line =  <<<EOT
                                                                            "{$key}": [\n
                                                                        EOT;
                                $str .= $line;
                                foreach ($val as $lang_key => $lang_val) {

                                    $line =  <<<EOT
                                                                            "{$lang_key}": "{$lang_val}",\n
                                                                        EOT;

                                    $str .= $line;
                                }

                                $line =  <<<EOT
                                                                        ],\n
                                                                    EOT;
                            }

                            $str .= $line;
                        }
                        $end = <<<EOT
                                                 }
                                            EOT;
                        $str .= $end;

                        $new_setting = [];
                        $new_setting[$trans_key] = $trans_key;
                        $merged_array = array_merge($file_data, $new_setting);
                        $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
                        file_put_contents($file_path, $merged_array);
                    }
                } else {

                    fopen($file_path, 'w');

                    $file_content = [];
                    $file_content[$trans_key] = $trans_key;


                    $str = <<<EOT
                                            {
                                            EOT;
                    foreach ($file_content as $key => $val) {
                        if (gettype($val) == 'string') {

                            $line = <<<EOT
                                                                    "{$key}" : "{$val}"\n
                                                                EOT;
                        }
                        if (gettype($val) == 'array') {
                            $line =  <<<EOT
                                                                            "{$key}" : [\n
                                                                        EOT;
                            $str .= $line;
                            foreach ($val as $lang_key => $lang_val) {

                                $line =  <<<EOT
                                                                            "{$lang_key}" : "{$lang_val}",\n
                                                                        EOT;

                                $str .= $line;
                            }

                            $line =  <<<EOT
                                                                        ]\n
                                                                    EOT;
                        }

                        $str .= $line;
                    }
                    $end = <<<EOT
                                                }
                                            EOT;
                    $str .= $end;
                    $file_data = json_encode($str);
                    $file_data = json_decode($file_data, true);
                    $new_setting = [];
                    $new_setting[$trans_key] = $trans_key;
                    file_put_contents($file_path, $file_data);
                }
                return _trasnlation($value);
            } else {

                $trans_key = $value;
                $file_path = resource_path('lang/' . $local . '/' . $local . '.json');

                fopen($file_path, 'w');
                $file_content = [];
                $file_content[$trans_key] = $trans_key;
                $str = <<<EOT
                                            {
                                            EOT;
                foreach ($file_content as $key => $val) {
                    if (gettype($val) == 'string') {

                        $line = <<<EOT
                                                                    "{$key}" : "{$val}",\n
                                                                EOT;
                    }
                    if (gettype($val) == 'array') {
                        $line =  <<<EOT
                                                                            "{$key}" : [\n
                                                                        EOT;
                        $str .= $line;
                        foreach ($val as $lang_key => $lang_val) {

                            $line =  <<<EOT
                                                                            "{$lang_key}" : "{$lang_val}",\n
                                                                        EOT;

                            $str .= $line;
                        }

                        $line =  <<<EOT
                                                                        ],\n
                                                                    EOT;
                    }

                    $str .= $line;
                }
                $end = <<<EOT
                                                }

                                            EOT;
                $str .= $end;

                $file_data = json_encode($str);
                $file_data = json_decode($file_data, true);
                $new_setting = [];
                $new_setting[$trans_key] = $trans_key;
                file_put_contents($file_path, $file_data);

                return _trasnlation($value);
            }
            return _trasnlation($value);
        } catch (Exception $exception) {
            return $value;
        }
    }
}



function set_menu(array $path, $active = 'show')
{
    foreach ($path as $route) {
        print_r($route);
        if (Route::currentRouteName() == $route) {
            return $active;
        }
    }
    return (request()->is($path)) ? $active : '';
    // return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

function random($length = 8)
{
    if (!function_exists('openssl_random_pseudo_bytes')) {
        throw new RuntimeException('OpenSSL extension is required.');
    }

    $bytes = openssl_random_pseudo_bytes($length * 2);

    if ($bytes === false) {
        throw new RuntimeException('Unable to generate random string.');
    }

    return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
}

function string_clean($string)
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), ' ', $string);
    return strtolower(trim($string, ' '));
}

function main_date_format($data)
{
    return date('d M y', strtotime($data));
}

function main_time_format($data)
{
    return date('H:i:s', strtotime($data));
}
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return my_asset($asset->img_path);
        } else {
            return url('public/static/blank_small.png');
        }
        return url('public/static/blank_small.png');
    }
}

if (!function_exists('uploaded_asset_with_type')) {
    function uploaded_asset_with_type($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return [
                'path' => my_asset($asset->img_path),
                'type' => $asset->type
            ];
        } else {
            return [
                'path' => url('public/static/blank_small.png'),
                'type' => 'image'
            ];
        }
    }
}
if (!function_exists('check_file_exist')) {
    function check_file_exist($file_path)
    {
        if (file_exists($file_path)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('my_asset')) {
    function my_asset($path, $secure = null)
    {
        // \Log::info($path);
        if ($path == "") {
            return url('public/static/blank_small.png');
        } else {
            if (env('FILESYSTEM_DRIVER') == 's3') {
                return Storage::disk('s3')->url($path);
            } elseif (env('FILESYSTEM_DRIVER') == 'local') {
                // return file_exists($path) ? Storage::url($path) : url('public/static/blank_small.png');
                return Storage::url($path);
            } else {
                return Storage::url($path);
            }
        }
    }
}
// if (!function_exists('my_asset')) {
//     function my_asset($path, $secure = null)
//     {
//         if ($path == "") {
//             return url('public/static/blank_small.jpg');
//         } else {
//             if (env('FILESYSTEM_DRIVER') == 's3' && Storage::disk('s3')->has($path)) {
//                 return Storage::disk('s3')->url($path);
//             } else {
//                 file_exists($path) ? $path = asset($path) : $path = url('public/static/blank_small.png');
//                 return $path;
//             }
//         }
//     }
// }

function asset_path($id)
{
    $path = Upload::find($id);
    if ($path)
        return $path->img_path;
    return false;
}

function date_format_for_db($date)
{
    $strtotime = strtotime($date);
    $date = date('Y-m-d', $strtotime);
    return $date;
}

function date_format_for_view($date)
{
    $strtotime = strtotime($date);
    $date = date('d/m/Y', $strtotime);
    return $date;
}

// where between is date search string
if (!function_exists('start_end_datetime')) {
    function start_end_datetime($start_date, $end_date)
    {
        $date = [$start_date . ' ' . '00:00:00', $end_date . ' ' . '23:59:59'];
        return $date;
    }
}

function openJSONFile($lang)
{
    $jsonString = [];
    if (File::exists(base_path('resources/lang/' . $lang . '.json'))) {
        $jsonString = file_get_contents(base_path('resources/lang/' . $lang . '.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}

function saveJSONFile($lang, $data)
{
    $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/' . $lang . '.json'), stripslashes($jsonData));
}

// translate funcation for laravel
if (!function_exists('__translate')) {
    function __translate($key)
    {
        return $key;
    }
}

// translate funcation for laravel
if (!function_exists('_translate')) {
    function _translate($key, $type = true)
    {
        return $key;
    }
}
if (!function_exists('_trans')) {
    function _trans($key, $type = true)
    {
        return $key;
    }
    //asd
}

// random number generated from
function rand_string($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
}

function actionButton($string, $param, $type = Null)
{
    if ($type == 'delete') {
        return
            '<a href="javascript:;" class="dropdown-item" onclick="' . $param . '">
            ' . $string . '
        </a>';
    } elseif ($type == 'approve') {
        return auth()->user() ?
            '<a href="javascript:;" class="dropdown-item" onclick="' . $param . '">
        ' . $string . '
        </a>'
            : '';
    } elseif ($type == 'reject') {
        return auth()->user() ?
            '<a href="javascript:;" class="dropdown-item" onclick="' . $param . '">
        ' . $string . '
        </a>'
            : '';
    } elseif ($type == 'modal') {
        return auth()->user() ?
            '<a href="javascript:;" class="dropdown-item" onclick="' . $param . '">
        ' . $string . '
        </a>'
            : '';
    } else {
        return auth()->user() ?
            '<a class="dropdown-item" href="' . $param . '">
            ' . _translate($string, false) . '
            </a>'
            : '';
    }
}

if (!function_exists('numberTowords')) {
    function numberTowords($num)
    {

        $ones = array(
            0 => "ZERO",
            1 => "ONE",
            2 => "TWO",
            3 => "THREE",
            4 => "FOUR",
            5 => "FIVE",
            6 => "SIX",
            7 => "SEVEN",
            8 => "EIGHT",
            9 => "NINE",
            10 => "TEN",
            11 => "ELEVEN",
            12 => "TWELVE",
            13 => "THIRTEEN",
            14 => "FOURTEEN",
            15 => "FIFTEEN",
            16 => "SIXTEEN",
            17 => "SEVENTEEN",
            18 => "EIGHTEEN",
            19 => "NINETEEN",
            "01" => "ZERO ONE",
            "02" => "ZERO TWO",
            "03" => "ZERO THREE",
            "04" => "ZERO FOUR",
            "05" => "ZERO FIVE",
            "06" => "ZERO SIX",
            "07" => "ZERO SEVEN",
            "08" => "ZERO EIGHT",
            "09" => "ZERO NINE",
        );
        $tens = array(
            0 => "ZERO",
            1 => "TEN",
            2 => "TWENTY",
            3 => "THIRTY",
            4 => "FORTY",
            5 => "FIFTY",
            6 => "SIXTY",
            7 => "SEVENTY",
            8 => "EIGHTY",
            9 => "NINETY",
        );
        $hundreds = array(
            "HUNDRED",
            "THOUSAND",
            "MILLION",
            "BILLION",
            "TRILLION",
            "QUARDRILLION",
        ); /*limit t quadrillion */
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr, 1);
        $rettxt = "";
        foreach ($whole_arr as $key => $i) {

            while (substr($i, 0, 1) == "0") {
                $i = substr($i, 1, 5);
            }

            if ($i < 20) {
                /* echo "getting:".$i; */
                $rettxt .= @$ones[$i];
            } elseif ($i < 100) {
                if (substr($i, 0, 1) != "0") {
                    $rettxt .= $tens[substr($i, 0, 1)];
                }

                if (substr($i, 1, 1) != "0") {
                    $rettxt .= " " . $ones[substr($i, 1, 1)];
                }
            } else {
                if (substr($i, 0, 1) != "0") {
                    $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                }

                if (substr($i, 1, 1) != "0") {
                    $rettxt .= " " . $tens[substr($i, 1, 1)];
                }

                if (substr($i, 2, 1) != "0") {
                    $rettxt .= " " . $ones[substr($i, 2, 1)];
                }
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }
        if ($decnum > 0) {
            $rettxt .= " and ";
            if (@$decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }
}

if (!function_exists('breadcrumb')) {
    function breadcrumb($list)
    {
        $output = '<ol class="breadcrumb bg-transparent float-sm-right" >';
        foreach ($list as $url => $value) {
            if ($url == '#') {
                $output .= '<li class="breadcrumb-item mt-0 active text-danger"> ' . __($value) . '</li>';
            } else {
                $output .= '<li class="breadcrumb-item mt-0 "> <a href="' . url($url) . '">' . __($value) . '</a></li>';
            }
        }
        $output .= '</ol>';
        //  dd($output);
        return $output;
    }
}
if (!function_exists('settings')) {
    function settings($key)
    {
        try {
            return CompanyConfig::where('key', $key)->first()->value;
        } catch (Exception $e) {
            return null;
        }
    }
}
if (!function_exists('showAmount')) {
    function showAmount($amount)
    {
        try {
            return settings('currency_symbol').' '. $amount;
        } catch (Exception $e) {
            return null;
        }
    }
}
if (!function_exists('checkFeature')) {
    function checkFeature($feature_name)
    {
        try {
            return config('feature.'.$feature_name);
        } catch (Exception $e) {
            return false;
        }
    }
}
if (!function_exists('showDate')) {
    function showDate($date)
    {
        try {
            if ($date != null) {
                return Carbon::parse($date)->locale(app()->getLocale())->translatedFormat(Settings('date_format'));
            } else {
                return 'N/A';
            }
        } catch (\Exception $e) {
            return;
        }
    }
}
if (!function_exists('showTime')) {
    function showTime($time)
    {
        if (settings('time_format') == 'h') {
            return Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
        } else {
            return Carbon::createFromFormat('H:i:s', $time)->format('H:i');
        }
    }
}
if (!function_exists('showTimeFromTimeStamp')) {
    function showTimeFromTimeStamp($time)
    {
        if (settings('time_format') == 'h') {
            return Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('h:i A');
        } else {
            return Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('H:i');
        }
    }
}
if (!function_exists('timeDiff')) {
    function timeDiff($start_time, $end_time, $format, $start_date = null, $end_date = null)
    {
        if ($start_date == null) {
            $start_date = date('Y-m-d');
        }
        if ($end_date == null) {
            $end_date = date('Y-m-d');
        }
        $start_time = Carbon::parse($start_date . ' ' . $start_time);
        $end_time = Carbon::parse($end_date . ' ' . $end_time);
        $diff = $start_time->diffInSeconds($end_time);

        $hours = floor($diff / 3600);
        $minutes = floor(($diff - ($hours * 3600)) / 60);
        $seconds = $diff - ($hours * 3600) - ($minutes * 60);
        if ($format == 'h') {
            return $hours;
        }
        if ($format == 'm') {
            return $minutes;
        }
        if ($format == 's') {
            return $seconds;
        }
        return $hours . ':' . $minutes . ':' . $seconds;
    }
}

function date_diff_days($date , $date2 = null){
    $date1 = Carbon::parse($date);
    $date2 = $date2??Carbon::now();
    return $date1->diffInDays($date2);
}


if (!function_exists('appSuperUser')) {

    function appSuperUser()
    {
        if (auth()->user()->is_admin == 1 || auth()->user()->is_hr == 1 || auth()->user()->role_id == 1) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('is_Admin')) {

    function is_Admin()
    {
        if (auth()->user()->role->slug == 'superadmin' || auth()->user()->role->slug == 'admin' || auth()->user()->role->slug == 'hr') {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('myCompanyData')) {
    function myCompanyData($company_id)
    {
        if ($company_id == auth()->user()->company->id || auth()->user()->role_id == 1) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('dateFormet')) {
    function dateFormet($date, $format)
    {
        try {
            return Carbon::parse($date)->locale(app()->getLocale())->translatedFormat($format);
        } catch (\Throwable $th) {
            return;
        }
    }
}
if (!function_exists('hasPermission')) {

    function hasPermission($key_word)
    {
        if (config('app.APP_BRANCH')!='saas' && auth()->user()->is_admin == 1) {
            return true;
        }elseif (in_array($key_word, auth()->user()->permissions)) {
            return true;
        }else{
            return false;
        }
    }
}

//if function not exists
if (!function_exists('sendDatabaseNotification')) {
    function sendDatabaseNotification($user, $details)
    {
        try {
            \Notification::send($user, new HrmSystemNotification($details));
        } catch (\Throwable $th) {
            Log::error('Notification Error:' . $th->getMessage());
        }
    }
}
//if function not exists
if (!function_exists('getUserIpAddr')) {
    function getUserIpAddr()
    {
        try {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if(isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = \request()->ip();  
                
            return $ipaddress;
        } catch (\Throwable $th) {
            return \request()->ip();  
        }
    }
}
if(!function_exists('SendNotification')){
    function SendNotification($user,$title,$notify_body){
        try {
            //Send FCM Notification
            $details = [
                'title' => $title,
                'body' => $notify_body,
                'actionText' => 'View',
                'actionURL' => [
                    'app' => 'meeting',
                    'web' => '',
                    'target' => '_blank',
                ],
                'sender_id' => $user->id
            ];
            FirebaseNotification::sendCustomFirebaseNotification($user->id, 'notice', '', 'notice', $title, $notify_body);
            //Send Database Notification
            // $user->notify(new HrmSystemNotification($details));
            sendDatabaseNotification($user, $details);
        } catch (\Throwable $th) {
            Log::error('Notification Error:'.$th->getMessage());
        }
    }
}


if (!function_exists('getActionButtons')) {

    function getActionButtons($action_button)
    {
        return '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
    }
}
if (!function_exists('visitStatusColor')) {

    function visitStatusColor($status)
    {
        $status_color = 'FF8F5E';
        switch ($status) {
            case 'started':
                $status_color = 'FF8F5E';
                break;
            case 'reached':
                $status_color = '8A21F3';
                break;
            case 'cancelled':
                $status_color = 'BBC0CC';
                break;
            case 'created':
                $status_color = 'FF8F5E';
                break;
            case 'completed':
                $status_color = '12B89D';
                break;

            default:
                $status_color = 'FF8F5E';
                break;
        }

        return '0xFF' . $status_color;
    }
}
if (!function_exists('arrayObjectUnique')) {

    function arrayObjectUnique($array, $keep_key_assoc = false)
    {
        $duplicate_keys = array();
        $tmp = array();

        foreach ($array as $key => $val) {
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }
}

function appColorCodePrefix(): string
{
    return "0xFF";
}

function getReached($visit)
{
    $reached_at = VisitSchedule::where('visit_id', $visit->id)->where('status', "reached")->latest()->first();
    if ($reached_at) {
        return onlyTimePlainText($reached_at->reached_at);
    }
    return null;
}
function getDurration($visit)
{
    $started_at = VisitSchedule::where('visit_id', $visit->id)->where('status', "started")->first();
    $reached_at = VisitSchedule::where('visit_id', $visit->id)->where('status', "reached")->latest()->first();
    if ($started_at != '' && $reached_at != '') {
        $start_time = strtotime($started_at->started_at);
        $end_time = strtotime($reached_at->reached_at);
        $diff = $end_time - $start_time;
        $hours = floor($diff / 3600);
        $minutes = floor(($diff - ($hours * 3600)) / 60);
        $seconds = $diff - ($hours * 3600) - ($minutes * 60);
        return $hours . 'hr ' . $minutes . 'm ' . $seconds . 's';
    }
    return null;
}


function dateFormatInPlainText($date): string
{
    return Carbon::parse($date)->format("F j, Y, g:i a");
}

function onlyTimePlainText($date): string
{
    return Carbon::parse($date)->format("g:i a");
}
function onlyDateMonthYear($date): string
{
    return Carbon::parse($date)->isoFormat('Do MMM, YYYY');
}

if (!function_exists('aboutSystem')) {
    function aboutSystem()
    {
        $data = [
            'version' => '',
            'release_date' => ''
        ];
       try {
            $about_system=base_path('version.json');
            $about_system=file_get_contents($about_system);
            $about_system=json_decode($about_system,true);
            $data['version']=$about_system['version'];
            $data['release_date']=$about_system['release_date'];
            return $data;
       } catch (\Throwable $th) {
            return $data;
       }

    }
}

function dummyEmployeeList()
{

   return  $list = [
        // [
        //     "name" => "Admin",
        //     "company_id" => 2,
        //     "country_id" => 17,
        //     "phone" => "+88018887",
        //     "role_id" => 5,
        //     "department_id" => 17,
        //     "designation_id" => 30,
        //     "shift_id" => 4,
        //     "is_hr" => 0,
        //     "is_admin" => 1,
        //     "email" => "admin@onesttech.com",
        // ],
        [
            "name" => "Hr Manager",
            "company_id" => 2,
            "country_id" => 17,
            "phone" => "+88014555887",
            "role_id" => 6,
            "department_id" => 17,
            "designation_id" => 33,
            "shift_id" => 4,
            "is_hr" => 1,
            "email" => "hr@onesttech.com",
        ],
        [
            "name" => "Staff",
            "company_id" => 2,
            "country_id" => 17,
            "phone" => "+8855412547",
            "role_id" => 7,
            "department_id" => 18,
            "designation_id" => 44,
            "shift_id" => 4,
            "is_hr" => 0,
            "email" => "staff@onesttech.com",
        ]
    ];
}

function isBreakRunning()
{

    $user = auth()->user();
    date_default_timezone_set($user->country->time_zone);
    $takeBreak = EmployeeBreak::query()
        ->where([
            'company_id' => $user->company->id,
            'user_id' => $user->id,
            'date' => date('Y-m-d')
        ])->whereNull('back_time')
        ->first();
    if ($takeBreak) {
        $status = "start";
    } else {
        $status = "end";
    }
    return $status;
}

function isAttendee()
{
    if (Auth::check()) {
        $attendance = Attendance::where(['user_id' => auth()->user()->id, 'date' => date('Y-m-d')])->latest()->first();
        if ($attendance) {
            if ($attendance->check_out) {
                return [
                    'id' => $attendance->id,
                    'checkin' => true,
                    'checkout' => true,
                ];
            } else {
                return [
                    'id' => $attendance->id,
                    'checkin' => true,
                    'checkout' => false,
                ];
            }
        } else {
            return [
                'checkin' => false,
                'checkout' => false,
                'in_time' => null,
                'out_time' => null,
                'stay_time' => null
            ];
        }
    } else {
        return [
            'checkin' => false,
            'checkout' => false,
            'in_time' => null,
            'out_time' => null,
            'stay_time' => null
        ];
    };
}

function RawTable($table)
{
    return DB::table($table);
}

function dbTable($table, $select = '*', $where = [])
{
    $query = RawTable($table);
    if (count($where) > 0) {
        $query = $query->where($where);
    }
    return $query->select($select);
}

function dateTimeIn($time): string
{
    $userCountry = auth()->user()->company->country;
    date_default_timezone_set($userCountry->time_zone);
    $now = Carbon::now();
    return $now->parse($time)->format('g:i A');
}

if (!function_exists('userLocal')) {
    function userLocal()
    {
        try {
            $user = auth()->user();
            if (isset($user->lang)) {
                $user_lang = $user->lang;
            } elseif ($user->company->configs) {
                $user_lang = $user->company->configs->where('key', 'lang')->first()->value;
            } else {
                $user_lang = App::getLocale();
            }
            return $user_lang;
        } catch (\Throwable $th) {
            return 'en';
        }
    }
}

if (!function_exists('putEnvConfigration')) {
    function putEnvConfigration($envKey, $envValue)
    {
        $envValue = str_replace('\\', '\\' . '\\', $envValue);
        $value = '"' . $envValue . '"';
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n";
        $keyPosition = strpos($str, "{$envKey}=");


        if (is_bool($keyPosition)) {

            $str .= $envKey . '="' . $envValue . '"';
        } else {
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$value}", $str);

            $str = substr($str, 0, -1);
        }

        if (!file_put_contents($envFile, $str)) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('hrm_languages')) {
    function hrm_languages()
    {
        $languages = HrmLanguage::where('status_id', 1)->get();

        return $languages;
    }
}
if (!function_exists('api_setup')) {
    function api_setup($name, $slug)
    {
        $api_setup = ApiSetup::where('name', $name)->first("{$slug}");
        return $api_setup->{$slug};
    }
}

function currency_format($value){
    $currency_symbol =auth()->user()->company->configs->where('key', 'currency_symbol')->first()->value;
    return $currency_symbol.''.$value;
}

function distanceCalculate($lat1, $lon1, $lat2, $lon2)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    // meters
    return $dist * 60 * 1.1515 * 1.609344 * 1000;
}
if (!function_exists('plain_text')) {
    function plain_text($text)
    {
        return Str::title(Str::replace('_',' ',$text));
    }
}

function cleanSpecialCharacters($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }
