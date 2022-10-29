<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Feature;
use App\Models\Role\Role;
use App\Models\Hrm\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use App\Models\Role\RoleUser;
use App\Models\Company\Company;
use App\Models\Hrm\Shift\Shift;
use Analytics;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Hrm\Attendance\Holiday;
use App\Models\ActivityLogs\AuthorInfo;
use App\Helpers\CoreApp\Traits\PermissionTrait;

class NavigatorController extends Controller
{
use PermissionTrait;
public function index()
{

    $data['title'] = _trans('common.Home');
    return redirect()->route('adminLogin');
    // return view('frontend.index', compact('data'));
}


/*********** Analytics Static Functions ***********/
static function country($days) {
    $country = Analytics::performQuery(Period::days($days),'ga:sessions',  ['dimensions'=>'ga:country','sort'=>'-ga:sessions']);
    $result= collect($country['rows'] ?? [])->map(function (array $dateRow) {
        return [
            'country' =>  $dateRow[0],
            'sessions' => (int) $dateRow[1],
        ];
    });
    return $result;
}

/*********** Analytics Static Functions End***********/


public function analytics(Request $request)
{
    $days = 30;
    $data['frequency'] = 'monthly';

    if($request->frequency) {
        switch ($request->frequency) {
            case 'daily':
                $days = 1;
                $data['frequency'] = 'daily';
                break;
            case 'weekly':
                $days = 7;
                $data['frequency'] = 'weekly';
                break;
            case 'monthly':
                $days = 30;
                $data['frequency'] = 'monthly';
                break;
            case 'yearly':
                $days = 365;
                $data['frequency'] = 'yearly';
                break;
            default:
                $days = 30;
                $data['frequency'] = 'monthly';
                break;
        }
    }

    $data['title'] = _trans('common.analytics');
    //fetch the most visited pages
    $data['most_visited_pages'] = Analytics::fetchMostVisitedPages(Period::days($days));

    //fetch visitors and page views for the past week
    $data['pageviews'] = Analytics::fetchVisitorsAndPageViews(Period::days($days));

    //fetch visitors
    $data['visitors']=Analytics::fetchUserTypes(Period::days($days));

    //fetch refferers
    $data['refferers']=Analytics::fetchTopReferrers(Period::days($days));

    //fetch top browsers
    $data['topbrowsers'] = Analytics::fetchTopBrowsers(Period::days($days));

    //fetch top countries
    $data['country'] = self::country($days);

    return view('frontend.analytics', compact('data'));
}


    public function pricing()
    {
        $data['title'] = _trans('common.pricing');

        $data['pricing'] = [
            [
                'title' => 'Free',
                'price' => 0,
                'subscription' => 'No Cost At All',
                'class' => 'btn-warning',
                'description' => 'Free Package Description',
                'features' => [

                    'user limitation' => 'Free up to 5 users',
                    'Extra Costs' => 'No Hidden Costs',
                    'Features' => 'Limited Features',
                    'Setup Cost' => 'No Setup Cost',
                    'Manager' => 'Dedicated Manager',
                    'support' => 'Tech Support',
                ]
            ],
            [
                'title' => 'Lite',
                'price' => 11,
                'subscription' => '$88 / 1 Year',
                'class' => 'btn-primary',
                'description' => 'Lite Package Description',
                'features' => [

                    'user limitation' => 'Up to 10 users',
                    'Extra Costs' => 'No Hidden Costs',
                    'Features' => 'All Features',
                    'Setup Cost' => 'No Setup Cost',
                    'Manager' => 'Dedicated Manager 24x7',
                    'support' => 'Tech Support 24x7',
                ]
            ],
            [
                'title' => 'Standard',
                'price' => 55,
                'subscription' => '$444 / 1 Year',
                'class' => 'btn-success',
                'description' => 'Standard Package Description and so on',
                'features' => [

                    'user limitation' => 'Up to 50 users',
                    'Extra Costs' => 'No Hidden Costs',
                    'Features' => 'All Features',
                    'Setup Cost' => 'No Setup Cost',
                    'Manager' => 'Dedicated Manager 24x7',
                    'support' => 'Tech Support 24x7',
                ]
            ],
            [
                'title' => 'Premium',
                'price' => '1.5' ,
                'subscription' => 'Based on Employee',
                'class' => 'btn-danger',
                'description' => 'Premium Package Description and so on',
                'features' => [

                    // 'user limitation' => 'Free up to 10 users',
                    // 'storage' => 'Free storage to 10 GB',
                    // 'domain' => 'Free domain to 10 domain',
                    // 'email' => 'Free email to 10 email',
                    // 'support' => 'Free support to 10 support',


                    'user limitation' => 'Unlimited users',
                    'Extra Costs' => 'No Hidden Costs',
                    'Features' => 'All Features',
                    'Setup Cost' => 'No Setup Cost',
                    'Manager' => 'Dedicated Manager 24x7',
                    'support' => 'Tech Support 24x7',
                ]
            ],
        ];

        return view('frontend.pricing', compact('data'));
    }
    function contact()
    {
        $data['title'] = _trans('common.Contact');
        return view('frontend.contact',compact('data'));
    }
    function features()
    {
        $data['title'] = _trans('common.Features');
        return view('frontend.features',compact('data'));
    }
    public function storeContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            // 'contact_for' => 'required',
            'message' => 'required',
        ]);
        try {
            $contact = new Contact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->contact_for = $request->contact_for ?? 1;
            $contact->phone = $request->phone ?? '';
            $contact->message = $request->message;
            $contact->contact_status = 0;
            $contact->save();
            if (isset($request->is_ajax)) {
                return response()->json(['success' => true, 'message' => _trans('response.Your message has been sent successfully.')]);
            } else {
                Toastr::success(_trans('response.Your message has been sent successfully'), 'Success');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            if (isset($request->is_ajax)) {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            } else {
                Toastr::error(_trans('response.Something went wrong'), 'Error');
                return redirect()->back();
            }
        }
    }
}
