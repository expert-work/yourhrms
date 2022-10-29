<?php


use Illuminate\Database\Seeder;
use Database\Seeders\GoalSeeder;
use Database\Seeders\AwardSeeder;
use Database\Seeders\LeaveSeeder;
use Database\Seeders\NoticeSeeder;
use Database\Seeders\UploadSeeder;
use Database\Seeders\ExpenseSeeder;
use Database\Seeders\FeatureSeeder;
use Database\Seeders\PayrollSeeder;
use Database\Seeders\DemoDataSeeder;
use Database\Seeders\Hrm\TeamSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\IndicatorSeeder;
use Database\Seeders\Task\TaskSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\UserSeeder;
use Database\Seeders\AttendanceSeeder;
use Database\Seeders\DesignationSeeder;
use Database\Seeders\Hrm\HolidaySeeder;
use Database\Seeders\Hrm\MeetingSeeder;
use Database\Seeders\Hrm\PaymentSeeder;
use Database\Seeders\TestimonialSeeder;
use Database\Seeders\Admin\StatusSeeder;
use Database\Seeders\DutyScheduleSeeder;
use Database\Seeders\WeekendSetupSeeder;
use Database\Seeders\Admin\CompanySeeder;
use Database\Seeders\CompanyConfigSeeder;
use Database\Seeders\Travel\TravelSeeder;
use Database\Seeders\Hrm\AllContentSeeder;
use Database\Seeders\Hrm\Visit\NoteSeeder;
use Database\Seeders\Hrm\AppointmentSeeder;
use Database\Seeders\Hrm\Shift\ShiftSeeder;
use Database\Seeders\Hrm\Visit\VisitSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Hrm\LeaveSettingSeeder;
use Database\Seeders\Hrm\SubscriptionSeeder;
use Database\Seeders\NotificationTypeSeeder;
use Database\Seeders\Hrm\EmployeeTasksSeeder;
use Database\Seeders\Management\ClientSeeder;
use Database\Seeders\Hrm\Visit\ScheduleSeeder;
use Database\Seeders\Management\ProjectSeeder;
use Database\Seeders\Hrm\Country\CountrySeeder;
use Database\Seeders\Traits\ApplicationKeyGenerate;
use Database\Seeders\Hrm\AppSetting\AppScreenSeeder;
use Jmrashed\Geolocation\Database\Seeders\GeoSeeder;
use Database\Seeders\Hrm\Notification\NotificationSeeder;

class DatabaseSeeder extends Seeder
{
        use ApplicationKeyGenerate;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->keyGenerate();
        $this->call(CountrySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ShiftSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(WeekendSetupSeeder::class);
        $this->call(DutyScheduleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(UploadSeeder::class);
        $this->call(LeaveSettingSeeder::class);
        $this->call(CompanyConfigSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(LeaveSeeder::class);
        $this->call(HolidaySeeder::class);
        // $this->call(PaymentSeeder::class);
        $this->call(AppScreenSeeder::class);
        $this->call(AllContentSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(PayrollSeeder::class);
        // $this->call(TeamSeeder::class);
        // $this->call(NotificationTypeSeeder::class);


        //Demo Data Start
        // $this->call(VisitSeeder::class);
        // $this->call(NoteSeeder::class);
        // $this->call(ScheduleSeeder::class);
        // $this->call(NoticeSeeder::class);
        // $this->call(EmployeeTasksSeeder::class);
        // $this->call(AppointmentSeeder::class);
        // $this->call(MeetingSeeder::class);
        // $this->call(NotificationSeeder::class);
        // $this->call(SubscriptionSeeder::class);
        // $this->call(AttendanceSeeder::class);
        // $this->call(ExpenseSeeder::class);
        
        // goal seeder
        $this->call(GoalSeeder::class);
        // client seeder
        $this->call(ClientSeeder::class);
        // project seeder
        $this->call(ProjectSeeder::class);
        // task seeder
        $this->call(TaskSeeder::class);
        // award seeder 
        $this->call(AwardSeeder::class);
        // travel seeder
        $this->call(TravelSeeder::class);

        // IndicatorSeeder
        $this->call(IndicatorSeeder::class);


                // this seeder will come from package
                //       $this->call(GeoSeeder::class);

        }
}
