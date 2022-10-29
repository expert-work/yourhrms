<?php

namespace App\Http\Controllers\Backend\VirtualMeeting;

use App\Models\Role\Role;
use App\Scopes\CompanyScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Hrm\Meeting\VirtualMeetingRepository;
use App\Repositories\Hrm\Meeting\VirtualMeetingSetupRepository;

class VirtualMeetingController extends Controller
{
    protected $virtualMeetingRepo;
    protected $SetupRepo;


    public function __construct()
    {
        $this->virtualMeetingRepo = new VirtualMeetingRepository();
        $this->SetupRepo = new VirtualMeetingSetupRepository();
    }

    public function index()
    {
        $virtualMeetings = $this->virtualMeetingRepo->get();
        return view('backend.virtual-meeting.index', compact('virtualMeetings'));
    }

    public function setup()
    {
        $data['setup'] = $this->SetupRepo->setup();
        return $data;
        return view('backend.virtual-meeting.setup', $data);
    }
}
