<?php

namespace App\Http\Controllers\Frontend\Policy;

use App\Http\Controllers\Controller;
use App\Models\Content\AllContent;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function privacyPolicy()
    {
        $data['title'] = _trans('common.Privacy Policy');
        $data['show'] = AllContent::where('slug','privacy-policy')->first();
        return view('frontend.policy.privacyPolicy',compact('data'));
    }
    public function termsAndConditions()
    {
        $data['title'] = _trans('common.Terms And Conditions');
        $data['show'] = AllContent::where('slug','terms-of-use')->first();
        return view('frontend.termsConditions.termsAndConditions',compact('data'));
    }
     public function supportTwentyFour()
    {
        $data['title'] = _trans('common.Support 24/7');
        $data['show'] = AllContent::where('slug','support-24-7')->first();
        return view('frontend.support.supportTwentyFour',compact('data'));
    }
}
