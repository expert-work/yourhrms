<?php

namespace App\Helpers\CoreApp\Traits;

use App\Models\User;
use App\Models\Role\Role;
use Illuminate\Support\Str;
use App\Models\Role\RoleUser;
use App\Models\Company\Company;
use App\Models\Hrm\Shift\Shift;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLogs\AuthorInfo;
use App\Models\Hrm\Department\Department;
use App\Models\Hrm\Designation\Designation;

trait PermissionTrait
{

    public function announcementModule()
    {
        return [
            'announcement_menu',
            'notice_menu',
            'notice_list',
            'notice_create',
            'notice_update',
            'notice_edit',
            'notice_delete',
            'push_notification',

            'send_sms_menu',
            'send_sms_list',
            'send_sms_create',
            'send_sms_update',
            'send_sms_edit',
            'send_sms_delete',

            'send_email_menu',
            'send_email_list',
            'send_email_create',
            'send_email_update',
            'send_email_edit',
            'send_email_delete',

            'send_notification_menu',
            'send_notification_list',
            'send_notification_create',
            'send_notification_update',
            'send_notification_edit',
            'send_notification_delete',
        ];
    }


    public function teamModule()
    {
        return [
            'team_menu',
            'team_list',
            'team_create',
            'team_update',
            'team_edit',
            'team_delete',
            'team_member_view',
            'team_member_create',
            'team_member_edit',
            'team_member_delete',
            'team_member_assign',
            'team_member_unassign',
        ];
    }

    public function support()
    {
        return [
            'support_menu',
            'support_read',
            'support_create',
            'support_reply',
            'support_delete',
        ];
    }

    public function superAdminPermissions()
    {
        return [
            'company_read',
            'company_create',
            'company_update',
            'company_delete',
            'user_banned',
            'user_unbanned',
            'general_settings_read',
            'general_settings_update',
            'email_settings_read',
            'email_settings_update',
            'storage_settings_update',
            'user_read',
            'user_edit',
            'user_update',
            'content_update',
            'subscriptions_read'
        ];
    }

    public function adminPermissions(): array
    {

        $team_module = $this->teamModule();
        $announcement_module = $this->announcementModule();
        $support_module = $this->support();
        $lists = [
            'dashboard',
            'designation_read',
            'designation_create',
            'designation_update',
            'designation_delete',

            'shift_read',
            'shift_create',
            'shift_update',
            'shift_delete',

            'department_read',
            'department_create',
            'department_update',
            'department_delete',

            'user_menu',
            'user_read',
            'profile_view',
            'user_create',
            'user_edit',
            'user_update',
            'user_delete',
            'user_banned',
            'user_unbanned',
            'make_hr',

            'role_read',
            'role_create',
            'role_update',
            'role_delete',
            'role_delete',
            'permission_update',

            'leave_menu',
            'leave_type_read',
            'leave_type_create',
            'leave_type_update',
            'leave_type_delete',

            'leave_assign_read',
            'leave_assign_create',
            'leave_assign_update',
            'leave_assign_delete',

            'leave_request_read',
            'leave_request_create',
            'leave_request_approve',
            'leave_request_reject',
            'leave_request_delete',

            'appointment_read',
            'appointment_create',
            'appointment_approve',
            'appointment_reject',
            'appointment_delete',

            'weekend_read',
            'weekend_update',
            'attendance_update',

            'holiday_read',
            'holiday_create',
            'holiday_update',
            'holiday_delete',

            'schedule_read',
            'schedule_create',
            'schedule_update',
            'schedule_delete',

            'attendance_menu',
            'attendance_read',
            'attendance_create',
            'attendance_update',
            'attendance_delete',
            'generate_qr_code',

            'leave_settings_read',
            'leave_settings_update',
            'company_settings_read',
            'company_settings_update',
            'locationApi',

            'company_setup_menu' , 
            'company_setup_activation', 
            'company_setup_configuration', 
            'company_setup_ip_whitelist',
            'company_setup_location',

            'location_create', 
            'location_store', 
            'location_edit', 
            'location_update', 
            'location_delete',

            'ip_read',
            'ip_create',
            'ip_update',
            'ip_delete',
            'user_ip_binding',

            'attendance_report_read',
            'live_tracking_read',
            'report_menu',
            'report',


            'claim_read',
            'claim_create',
            'claim_update',
            'claim_delete',

            'payment_read',
            'payment_create',
            'payment_update',
            'payment_delete',

            'visit_menu',
            'visit_read',
            'visit_view',
            'visit_update',


            'payroll_menu',
            'list_payroll_item',
            'create_payroll_item',
            'store_payroll_item',
            'update_payroll_item',
            'delete_payroll_item',
            'view_payroll_item',
            'payroll_item_menu',

            'list_payroll_set',
            'create_payroll_set',
            'store_payroll_set',
            'update_payroll_set',
            'delete_payroll_set',
            'view_payroll_set',
            'edit_payroll_set',
            'payroll_set_menu',


            'advance_salaries_menu',
            'advance_salaries_create',
            'advance_salaries_store',
            'advance_salaries_edit',
            'advance_salaries_update',
            'advance_salaries_delete',
            'advance_salaries_view',
            'advance_salaries_approve',
            'advance_salaries_list',
            'advance_salaries_pay',
            'advance_salaries_invoice',
            'advance_salaries_search',

            'payslip_menu',
            'salary_generate',
            'salary_view',
            'salary_delete',
            'salary_edit',
            'salary_update',
            'salary_payment',
            'payslip_list',


            'advance_type_menu',
            'advance_type_create',
            'advance_type_store',
            'advance_type_edit',
            'advance_type_update',
            'advance_type_delete',
            'advance_type_view',
            'advance_type_list',

            // salary
            'salary_menu',
            'salary_store',
            'salary_edit',
            'salary_update',
            'salary_delete',
            'salary_view',
            'salary_list',
            'salary_search',
            'salary_pay',
            'salary_invoice',
            'salary_approve',
            'salary_generate',
            'salary_calculate',


            //account_menu
            'account_menu',
            'account_create',
            'account_store',
            'account_edit',
            'account_update',
            'account_delete',
            'account_view',
            'account_list',
            'account_search',

            // deposit_menu
            'deposit_menu',
            'deposit_create',
            'deposit_store',
            'deposit_edit',
            'deposit_update',
            'deposit_delete',
            'deposit_list',

            // expense_menu
            'expense_menu',
            'expense_create',
            'expense_store',
            'expense_edit',
            'expense_update',
            'expense_delete',
            'expense_list',
            'expense_view',
            'expense_approve',
            'expense_invoice',
            'expense_pay',



            // transaction_menu
            'transaction_menu',
            'transaction_create',
            'transaction_store',
            'transaction_edit',
            'transaction_update',
            'transaction_delete',
            'transaction_view',
            'transaction_list',


            // deposit_settings_menu
            'deposit_category_menu',
            'deposit_category_create',
            'deposit_category_store',
            'deposit_category_edit',
            'deposit_category_update',
            'deposit_category_delete',
            'deposit_category_list',


            // expense_settings_menu
            'payment_method_menu',
            'payment_method_create',
            'payment_method_store',
            'payment_method_edit',
            'payment_method_update',
            'payment_method_delete',
            'payment_method_list',


            // project module
            'project_menu', 
            'project_create', 
            'project_store', 
            'project_edit', 
            'project_update', 
            'project_delete', 
            'project_view', 
            'project_list',
            'project_activity_view',
            'project_member_view', 
            'project_member_delete',
            'project_complete',
            'project_payment',
            'project_invoice_view',
           

            // project discussion
            'project_discussion_create', 
            'project_discussion_store', 
            'project_discussion_edit', 
            'project_discussion_update', 
            'project_discussion_delete', 
            'project_discussion_view', 
            'project_discussion_list', 
            'project_discussion_comment',
            'project_discussion_reply', 
            

            // project file module
            'project_file_create', 
            'project_file_store', 
            'project_file_edit', 
            'project_file_update', 
            'project_file_delete', 
            'project_file_view', 
            'project_file_list', 
            'project_file_download', 
            'project_file_comment', 
            'project_file_reply',

            // project_notes module

            'project_notes_create', 
            'project_notes_store', 
            'project_notes_edit', 
            'project_notes_update', 
            'project_notes_delete',  
            'project_notes_list',

            //Client Module
            'client_menu',
            'client_create',
            'client_store',
            'client_edit',
            'client_update',
            'client_delete',
            'client_view',
            'client_list',


            // task module

            'task_menu', 
            'task_create', 
            'task_store', 
            'task_edit', 
            'task_update', 
            'task_delete', 
            'task_view', 
            'task_list',
            'task_activity_view', 
            'task_assign_view', 
            'task_assign_delete',
            'task_complete',

            // task discussion
            
            'task_discussion_create', 
            'task_discussion_store', 
            'task_discussion_edit', 
            'task_discussion_update',             
            'task_discussion_delete', 
            'task_discussion_view', 
            'task_discussion_list', 
            'task_discussion_comment',
            'task_discussion_reply', 

            // task file
            
            'task_file_create', 
            'task_file_store', 
            'task_file_edit', 
            'task_file_update', 
            'task_file_delete',             
            'task_file_view',
            'task_file_list', 
            'task_file_download', 
            'task_file_comment', 
            'task_file_reply',

            // task notes

            'task_notes_create', 
            'task_notes_store', 
            'task_notes_edit',
            'task_notes_update', 
            'task_notes_delete',             
            'task_notes_list',
            'task_files_comment',

            // award type module
            'award_type_menu',
            'award_type_create', 
            'award_type_store',
            'award_type_edit', 
            'award_type_update',                 
            'award_type_delete', 
            'award_type_view', 
            'award_type_list',

            // award module
                
            'award_menu',
            'award_create', 
            'award_store', 
            'award_edit', 
            'award_update', 
            'award_delete', 
            'award_list',

            // travel type module
            'travel_type_menu',
            'travel_type_create', 
            'travel_type_store',
            'travel_type_edit', 
            'travel_type_update',                 
            'travel_type_delete', 
            'travel_type_view', 
            'travel_type_list',

            //Travel_menu
            'travel_menu',
            'travel_create', 
            'travel_store', 
            'travel_edit', 
            'travel_update', 
            'travel_delete', 
            'travel_list',
            'travel_approve', 
            'travel_payment',

            //performance
            'performance_menu',
            'performance_settings',

            // performance indicator module
            'performance_indicator_menu', 
            'performance_indicator_list',
            'performance_indicator_create', 
            'performance_indicator_store',
            'performance_indicator_edit', 
            'performance_indicator_update',             
            'performance_indicator_delete', 

            //performance_appraisal module
            'performance_appraisal_menu', 
            'performance_appraisal_create', 
            'performance_appraisal_store', 
            'performance_appraisal_edit', 
            'performance_appraisal_update',            
            'performance_appraisal_delete', 
            'performance_appraisal_list', 
            'performance_appraisal_view',

            // performance_goal_type module
            'performance_goal_type_menu', 
            'performance_goal_type_create', 
            'performance_goal_type_store', 
            'performance_goal_type_edit', 
            'performance_goal_type_update', 
            'performance_goal_type_delete', 
            'performance_goal_type_list',

            // performance_goal module
            'performance_goal_menu', 
            'performance_goal_create', 
            'performance_goal_store', 
            'performance_goal_edit', 
            'performance_goal_update', 
            'performance_goal_delete', 
            'performance_goal_view', 
            'performance_goal_list',

            // competence type module
            'performance_competence_type_list',
            'performance_competence_type_menu',
            'performance_competence_type_create',
            'performance_competence_type_store',
            'performance_competence_type_edit',
            'performance_competence_type_update',
            'performance_competence_type_delete',
            'performance_competence_type_view',

            // competence module
            'performance_competence_menu',
            'performance_competence_create',
            'performance_competence_store',
            'performance_competence_edit',
            'performance_competence_update',
            'performance_competence_delete',
            'performance_competence_view',
            'performance_competence_list',
            




        ];
        $permissions = array_merge($team_module, $lists);
        $permissions = array_merge($permissions, $announcement_module);
        $permissions = array_merge($permissions, $announcement_module, $support_module);
        return $permissions;
    }
    public function hrPermissions(): array
    {

        $team_module = $this->teamModule();
        $announcement_module = $this->announcementModule();
        $support_module = $this->support();
        $lists = [
            'dashboard',
            'designation_read',
            'designation_create',
            'designation_update',
            'designation_delete',

            'shift_read',
            'shift_create',
            'shift_update',
            'shift_delete',

            'department_read',
            'department_create',
            'department_update',
            'department_delete',

            'user_menu',
            'user_read',
            'profile_view',
            'user_create',
            'user_edit',
            'user_update',
            'user_delete',
            'user_banned',
            'user_unbanned',
            'make_hr',

            'role_read',
            'role_create',
            'role_update',
            'role_delete',

            'leave_menu',
            'leave_type_read',
            'leave_type_create',
            'leave_type_update',
            'leave_type_delete',

            'leave_assign_read',
            'leave_assign_create',
            'leave_assign_update',
            'leave_assign_delete',

            'leave_request_read',
            'leave_request_create',
            'leave_request_approve',
            'leave_request_reject',
            'leave_request_delete',

            'appointment_read',
            'appointment_create',
            'appointment_approve',
            'appointment_reject',
            'appointment_delete',

            'weekend_read',
            'weekend_update',
            'attendance_update',

            'holiday_read',
            'holiday_create',
            'holiday_update',
            'holiday_delete',

            'schedule_read',
            'schedule_create',
            'schedule_update',
            'schedule_delete',

            'attendance_menu',
            'attendance_read',
            'attendance_create',
            'attendance_update',
            'attendance_delete',

            'leave_settings_read',
            'leave_settings_update',
            'company_settings_read',
            'company_settings_update',
            'locationApi',

            'company_setup_menu' , 
            'company_setup_activation', 
            'company_setup_configuration', 
            'company_setup_ip_whitelist',
            'company_setup_location',

            'ip_read',
            'ip_create',
            'ip_update',
            'ip_delete',
            'user_ip_binding',

            'attendance_report_read',
            'live_tracking_read',
            'report_menu',
            'report',


            'claim_read',
            'claim_create',
            'claim_update',
            'claim_delete',

            'payment_read',
            'payment_create',
            'payment_update',
            'payment_delete',

            'visit_menu',
            'visit_read',
            'visit_view',
            'visit_update',


            'payroll_menu',
            'list_payroll_item',
            'create_payroll_item',
            'store_payroll_item',
            'update_payroll_item',
            'delete_payroll_item',
            'view_payroll_item',
            'payroll_item_menu',

            'list_payroll_set',
            'create_payroll_set',
            'store_payroll_set',
            'update_payroll_set',
            'delete_payroll_set',
            'view_payroll_set',
            'edit_payroll_set',
            'payroll_set_menu',


            'advance_salaries_menu',
            'advance_salaries_create',
            'advance_salaries_store',
            'advance_salaries_edit',
            'advance_salaries_update',
            'advance_salaries_delete',
            'advance_salaries_view',
            'advance_salaries_approve',
            'advance_salaries_list',
            'advance_salaries_pay',
            'advance_salaries_invoice',
            'advance_salaries_search',

            'payslip_menu',
            'salary_generate',
            'salary_view',
            'salary_delete',
            'salary_edit',
            'salary_update',
            'salary_payment',
            'payslip_list',


            'advance_type_menu',
            'advance_type_create',
            'advance_type_store',
            'advance_type_edit',
            'advance_type_update',
            'advance_type_delete',
            'advance_type_view',
            'advance_type_list',

            // salary
            'salary_menu',
            'salary_store',
            'salary_edit',
            'salary_update',
            'salary_delete',
            'salary_view',
            'salary_list',
            'salary_search',
            'salary_pay',
            'salary_invoice',
            'salary_approve',
            'salary_generate',
            'salary_calculate',


            //account_menu
            'account_menu',
            'account_create',
            'account_store',
            'account_edit',
            'account_update',
            'account_delete',
            'account_view',
            'account_list',
            'account_search',

            // deposit_menu
            'deposit_menu',
            'deposit_create',
            'deposit_store',
            'deposit_edit',
            'deposit_update',
            'deposit_delete',
            'deposit_list',

            // expense_menu
            'expense_menu',
            'expense_create',
            'expense_store',
            'expense_edit',
            'expense_update',
            'expense_delete',
            'expense_list',
            'expense_view',
            'expense_approve',
            'expense_invoice',
            'expense_pay',



            // transaction_menu
            'transaction_menu',
            'transaction_create',
            'transaction_store',
            'transaction_edit',
            'transaction_update',
            'transaction_delete',
            'transaction_view',
            'transaction_list',


            // deposit_settings_menu
            'deposit_category_menu',
            'deposit_category_create',
            'deposit_category_store',
            'deposit_category_edit',
            'deposit_category_update',
            'deposit_category_delete',
            'deposit_category_list',


            // expense_settings_menu
            'payment_method_menu',
            'payment_method_create',
            'payment_method_store',
            'payment_method_edit',
            'payment_method_update',
            'payment_method_delete',
            'payment_method_list',

            //Travel_menu
            'travel_menu',
            'travel_create',
            'travel_store',
            'travel_edit',
            'travel_update',
            'travel_delete',
            'travel_list',
            'travel_view',
            'travel_approve',
            'travel_invoice',
            'travel_pay',





        ];
        $permissions = array_merge($team_module, $lists);
        $permissions = array_merge($permissions, $announcement_module);
        $permissions = array_merge($permissions, $announcement_module, $support_module);
        return $permissions;
    }


    public function staffPermissions(): array
    {
        return [
            'dashboard',
            'profile_view',
            // 'user_menu',
            // 'leave_menu',
            'attendance_menu',
            // 'user_read',
            'user_update',
            'attendance_read',
            'attendance_create',
            'leave_request_read',
            'leave_request_create',
            'support_menu',
            'support_read',
            'support_create',
            'support_reply',
            'support_delete',
        ];
    }



    public function customPermissions($role)
    {
        if ($role == "superadmin") {
            return $this->superAdminPermissions();
        } elseif ($role == "admin") {
            return $this->adminPermissions();
        } elseif ($role == "staff") {
            return $this->staffPermissions();
        } else {
            return $this->hrPermissions();
        }
    }

    public function adminRolePermissions(): array
    {
        return [
            //for user & roles
            'designations' => ['read' => 'designation_read', 'create' => 'designation_create', 'update' => 'designation_update', 'delete' => 'designation_delete'],
            'departments' => ['read' => 'department_read', 'create' => 'department_create', 'update' => 'department_update', 'delete' => 'department_delete'],
            'users' => ['read' => 'user_read', 'profile' => 'profile_view', 'create' => 'user_create', 'edit' => 'user_edit', 'update' => 'user_update', 'delete' => 'user_delete', 'menu' => 'user_menu', 'make_hr' => 'make_hr'],
            'roles' => ['read' => 'role_read', 'create' => 'role_create', 'update' => 'role_update', 'delete' => 'role_delete','permission_update'=>'permission_update'],

            // leave module
            'leave_type' => ['read' => 'leave_type_read', 'create' => 'leave_type_create', 'update' => 'leave_type_update', 'delete' => 'leave_type_delete', 'menu' => 'leave_menu'],
            'leave_assign' => ['read' => 'leave_assign_read', 'create' => 'leave_assign_create', 'update' => 'leave_assign_update', 'delete' => 'leave_assign_delete'],
            'leave_request' => ['read' => 'leave_request_read', 'create' => 'leave_request_create', 'approve' => 'leave_request_approve', 'reject' => 'leave_request_reject', 'delete' => 'leave_request_delete'],

            // attendance
            'weekend' => ['read' => 'wekeend_read', 'update' => 'wekeend_update'],
            'holiday' => ['read' => 'holiday_read', 'create' => 'holiday_create', 'update' => 'holiday_update', 'delete' => 'holiday_delete'],
            'schedule' => ['read' => 'schedule_read', 'create' => 'schedule_create', 'update' => 'schedule_update', 'delete' => 'schedule_delete'],
            'attendance' => ['read' => 'attendance_read', 'create' => 'attendance_create', 'update' => 'attendance_update', 'delete' => 'attendance_delete', 'menu' => 'attendance_menu'],
            'shift' => ['read' => 'shift_read', 'create' => 'shift_create', 'update' => 'shift_update', 'delete' => 'shift_delete', 'menu' => 'shift_menu'],

            //payroll_menu
            'payroll' => [
                'menu' => 'payroll_menu',
                'payroll_item read' => 'list_payroll_item', 'payroll_item create' => 'create_payroll_item', 'payroll_item store' => 'store_payroll_item', 'payroll_item edit' => 'edit_payroll_item', 'payroll_item update' => 'update_payroll_item',  'payroll_item delete' => 'delete_payroll_item', 'payroll_item view' => 'view_payroll_item', 'payroll_item menu' => 'payroll_item_menu',
                'list_payroll_set ' => 'list_payroll_set', 'create_payroll_set' => 'create_payroll_set', 'store_payroll_set' => 'store_payroll_set', 'edit_payroll_set' => 'edit_payroll_set', 'update_payroll_set' => 'update_payroll_set', 'delete_payroll_set' => 'delete_payroll_set', 'view_payroll_set' => 'view_payroll_set', 'payroll_set_menu' => 'payroll_set_menu',
            ],

            //payslip module
            'payslip' => [
                'menu' => 'payslip_menu', 'salary_generate' => 'salary_generate', 'salary_view' => 'salary_view', 'salary_delete' => 'salary_delete', 'salary_edit' => 'salary_edit', 'salary_update' => 'salary_update', 'salary_payment' => 'salary_payment', 'payslip_list' => 'payslip_list',
            ],
            //advance module
            'advance_type' => [
                'menu' => 'advance_type_menu', 'advance_type_create' => 'advance_type_create', 'advance_type_store' => 'advance_type_store', 'advance_type_edit' => 'advance_type_edit', 'advance_type_update' => 'advance_type_update', 'advance_type_delete' => 'advance_type_delete', 'advance_type_view' => 'advance_type_view',
                'advance_type_list' => 'advance_type_list'
            ],

            // advance_salaries
            'advance_pay' => [
                'menu' => 'advance_salaries_menu', 'advance_salaries_create' => 'advance_salaries_create', 'advance_salaries_store' => 'advance_salaries_store',  'advance_salaries_edit' => 'advance_salaries_edit', 'advance_salaries_update' => 'advance_salaries_update',
                'advance_salaries_delete' => 'advance_salaries_delete', 'advance_salaries_view' => 'advance_salaries_view', 'advance_salaries_approve' => 'advance_salaries_approve', 'advance_salaries_list' => 'advance_salaries_list',
                'advance_salaries_pay' => 'advance_salaries_pay', 'advance_salaries_invoice' => 'advance_salaries_invoice','advance_salaries_search'=> 'advance_salaries_search',
            ],

            // salary module
            'salary' => [
                'menu' => 'salary_menu', 'salary_store' => 'salary_store', 'salary_edit' => 'salary_edit', 'salary_update' => 'salary_update', 'salary_delete' => 'salary_delete', 'salary_view' => 'salary_view',
                'salary_list' => 'salary_list', 'salary_pay' => 'salary_pay', 'salary_invoice' => 'salary_invoice', 'salary_approve' => 'salary_approve',  'salary_generate' => 'salary_generate', 'salary_calculate' => 'salary_calculate',
                'salary_search' =>'salary_search',
            ],

            // account module
            'account' => [
                'menu' => 'account_menu', 'account_create' => 'account_create', 'account_store' => 'account_store', 'account_edit' => 'account_edit', 'account_update' => 'account_update', 'account_delete' => 'account_delete', 
                'account_view' => 'account_view', 'account_list' => 'account_list','account_search' => 'account_search',
            ],

            // deposit module
            'deposit' => [
                'menu' => 'deposit_menu', 'deposit_create' => 'deposit_create', 'deposit_store' => 'deposit_store', 'deposit_edit' => 'deposit_edit', 'deposit_update' => 'deposit_update', 'deposit_delete' => 'deposit_delete', 'deposit_list' => 'deposit_list',
            ],

            // expense module
            'expense' => [
                'menu' => 'expense_menu', 'expense_create' => 'expense_create', 'expense_store' => 'expense_store', 'expense_edit' => 'expense_edit', 'expense_update' => 'expense_update', 'expense_delete' => 'expense_delete', 'expense_list' => 'expense_list',
                'expense_approve' => 'expense_approve', 'expense_invoice' => 'expense_invoice', 'expense_pay' => 'expense_pay', 'expense_view' => 'expense_view'
            ],
            // deposit_category module
            'deposit_category' => [
                'menu' => 'deposit_category_menu', 'deposit_category_create' => 'deposit_category_create', 'deposit_category_store' => 'deposit_category_store', 'deposit_category_edit' => 'deposit_category_edit', 'deposit_category_update' => 'deposit_category_update', 'deposit_category_delete' => 'deposit_category_delete', 'deposit_category_list' => 'deposit_category_list',
            ],

            // payment_method module
            'payment_method' => [
                'menu' => 'payment_method_menu', 'payment_method_create' => 'payment_method_create', 'payment_method_store' => 'payment_method_store', 'payment_method_edit' => 'payment_method_edit', 'payment_method_update' => 'payment_method_update', 'payment_method_delete' => 'payment_method_delete', 'payment_method_list' => 'payment_method_list',
            ],

            // transaction module
            'transaction' => [
                'menu' => 'transaction_menu', 'transaction_create' => 'transaction_create', 'transaction_store' => 'transaction_store', 'transaction_edit' => 'transaction_edit', 'transaction_update' => 'transaction_update', 'transaction_delete' => 'transaction_delete', 'transaction_view' => 'transaction_view', 'transaction_list' => 'transaction_list',
            ],


            // project module
            'project' => [
                'menu' => 'project_menu', 'project_create' => 'project_create', 'project_store' => 'project_store', 'project_edit' => 'project_edit', 'project_update' => 'project_update', 'project_delete' => 'project_delete', 'project_view' => 'project_view', 'project_list' => 'project_list',
                'project_activity_view' => 'project_activity_view', 'project_member_view' => 'project_member_view', 'project_member_delete' => 'project_member_delete', 'project_complete' => 'project_complete', 'project_payment' => 'project_payment',
                'project_invoice_view' => 'project_invoice_view'
            ],

            // project_discussion module
            'project_discussion' => [
                'project_discussion_create' => 'project_discussion_create', 'project_discussion_store' => 'project_discussion_store', 'project_discussion_edit' => 'project_discussion_edit', 'project_discussion_update' => 'project_discussion_update', 
                'project_discussion_delete' => 'project_discussion_delete', 'project_discussion_view' => 'project_discussion_view', 'project_discussion_list' => 'project_discussion_list', 'project_discussion_comment' => 'project_discussion_comment',
                'project_discussion_reply' => 'project_discussion_reply', 
            ],

            // project_file module
            'project_file' => [
                'project_file_create' => 'project_file_create', 'project_file_store' => 'project_file_store', 'project_file_edit' => 'project_file_edit', 'project_file_update' => 'project_file_update', 'project_file_delete' => 'project_file_delete', 
                'project_file_view' => 'project_file_view', 'project_file_list' => 'project_file_list', 'project_file_download' => 'project_file_download', 'project_file_comment' => 'project_file_comment', 'project_file_reply' => 'project_file_reply',
            ],

            // project_notes module

            'project_notes' => [
                'project_notes_create' => 'project_notes_create', 'project_notes_store' => 'project_notes_store', 'project_notes_edit' => 'project_notes_edit', 'project_notes_update' => 'project_notes_update', 'project_notes_delete' => 'project_notes_delete',  
                'project_notes_list' => 'project_notes_list', 'project_files_comment' => 'project_files_comment'
            ],


            // task module

            'task' => [
                'menu' => 'task_menu', 'task_create' => 'task_create', 'task_store' => 'task_store', 'task_edit' => 'task_edit', 'task_update' => 'task_update', 'task_delete' => 'task_delete', 'task_view' => 'task_view', 'task_list' => 'task_list',
                'task_activity_view' => 'task_activity_view', 'task_assign_view' => 'task_assign_view', 'task_assign_delete' => 'task_assign_delete', 'task_complete' => 'task_complete'
            ],

            // task discussion
            'task_discussion' => [
                'task_discussion_create' => 'task_discussion_create', 'task_discussion_store' => 'task_discussion_store', 'task_discussion_edit' => 'task_discussion_edit', 'task_discussion_update' => 'task_discussion_update', 
                'task_discussion_delete' => 'task_discussion_delete', 'task_discussion_view' => 'task_discussion_view', 'task_discussion_list' => 'task_discussion_list', 'task_discussion_comment' => 'task_discussion_comment',
                'task_discussion_reply' => 'task_discussion_reply', 
            ],

            // task file
            'task_file' => [
                'task_file_create' => 'task_file_create', 'task_file_store' => 'task_file_store', 'task_file_edit' => 'task_file_edit', 'task_file_update' => 'task_file_update', 'task_file_delete' => 'task_file_delete', 
                'task_file_view' => 'task_file_view', 'task_file_list' => 'task_file_list', 'task_file_download' => 'task_file_download', 'task_file_comment' => 'task_file_comment', 'task_file_reply' => 'task_file_reply',
            ],

            // task notes
            'task_notes' => [
                'task_notes_create' => 'task_notes_create', 'task_notes_store' => 'task_notes_store', 'task_notes_edit' => 'task_notes_edit', 'task_notes_update' => 'task_notes_update', 'task_notes_delete' => 'task_notes_delete',  
                'task_notes_list' => 'task_notes_list', 'task_files_comment' => 'task_files_comment', 
            ],


            // award type module
            'award_type' => [
                'menu' => 'award_type_menu', 'award_type_create' => 'award_type_create', 'award_type_store' => 'award_type_store', 'award_type_edit' => 'award_type_edit', 'award_type_update' => 'award_type_update', 
                'award_type_delete' => 'award_type_delete', 'award_type_list' => 'award_type_list',
            ],

            // award module
            'award' => [
                'menu' => 'award_menu', 'award_create' => 'award_create', 'award_store' => 'award_store', 'award_edit' => 'award_edit', 'award_update' => 'award_update', 'award_delete' => 'award_delete', 
                'award_view' => 'award_view', 'award_list' => 'award_list'
            ],

            // travel type module
            'travel_type' => [
                'menu' => 'travel_type_menu', 'travel_type_create' => 'travel_type_create', 'travel_type_store' => 'travel_type_store', 'travel_type_edit' => 'travel_type_edit', 'travel_type_update' => 'travel_type_update', 
                'travel_type_delete' => 'travel_type_delete', 'travel_type_list' => 'travel_type_list',
            ],

            // travel module
            'travel' => [
                'menu' => 'travel_menu', 'travel_create' => 'travel_create', 'travel_store' => 'travel_store', 'travel_edit' => 'travel_edit', 'travel_update' => 'travel_update', 'travel_delete' => 'travel_delete', 
                'travel_view' => 'travel_view', 'travel_list' => 'travel_list', 'travel_approve' => 'travel_approve', 'travel_payment' => 'travel_payment'
            ],

            // performance module
            'performance' => [ 'menu' => 'performance_menu','settings' => 'performance_settings'],

            // performance_indicator module
            'performance_indicator' => [
                'menu' => 'performance_indicator_menu', 'performance_indicator_create' => 'performance_indicator_create', 'performance_indicator_store' => 'performance_indicator_store', 'performance_indicator_edit' => 'performance_indicator_edit', 'performance_indicator_update' => 'performance_indicator_update', 
                'performance_indicator_delete' => 'performance_indicator_delete', 'performance_indicator_list' => 'performance_indicator_list',
            ],

            //performance_appraisal module
            'performance_appraisal' => [
                'menu' => 'performance_appraisal_menu', 'performance_appraisal_create' => 'performance_appraisal_create', 'performance_appraisal_store' => 'performance_appraisal_store', 'performance_appraisal_edit' => 'performance_appraisal_edit', 'performance_appraisal_update' => 'performance_appraisal_update', 
                'performance_appraisal_delete' => 'performance_appraisal_delete', 'performance_appraisal_list' => 'performance_appraisal_list', 'performance_appraisal_view' => 'performance_appraisal_view'
            ],

            // performance_goal_type module
            'performance_goal_type' => [
                'menu' => 'performance_goal_type_menu', 'performance_goal_type_create' => 'performance_goal_type_create', 'performance_goal_type_store' => 'performance_goal_type_store', 'performance_goal_type_edit' => 'performance_goal_type_edit', 'performance_goal_type_update' => 'performance_goal_type_update', 
                'performance_goal_type_delete' => 'performance_goal_type_delete', 'performance_goal_type_list' => 'performance_goal_type_list',
            ],

            // performance_goal module
            'performance_goal' => [
                'menu' => 'performance_goal_menu', 'performance_goal_create' => 'performance_goal_create', 'performance_goal_store' => 'performance_goal_store', 'performance_goal_edit' => 'performance_goal_edit', 'performance_goal_update' => 'performance_goal_update', 'performance_goal_delete' => 'performance_goal_delete', 
                'performance_goal_view' => 'performance_goal_view', 'performance_goal_list' => 'performance_goal_list'
            ],

            // performance_competence_type module
            'performance_competence_type' => [
                'menu' => 'performance_competence_type_menu', 'performance_competence_type_create' => 'performance_competence_type_create', 'performance_competence_type_store' => 'performance_competence_type_store', 'performance_competence_type_edit' => 'performance_competence_type_edit', 'performance_competence_type_update' => 'performance_competence_type_update', 
                'performance_competence_type_delete' => 'performance_competence_type_delete', 'performance_competence_type_list' => 'performance_competence_type_list',
            ],
            // performance_competence module
            'performance_competence' => [
                'menu' => 'performance_competence_menu', 'performance_competence_create' => 'performance_competence_create', 'performance_competence_store' => 'performance_competence_store', 'performance_competence_edit' => 'performance_competence_edit', 'performance_competence_update' => 'performance_competence_update', 
                'performance_competence_delete' => 'performance_competence_delete', 'performance_competence_list' => 'performance_competence_list',
            ],










            //report
            'report' => ['attendance_report' => 'attendance_report_read', 'live_tracking_read' => 'live_tracking_read', 'menu' => 'report_menu'],
            // settings

            'leave_settings' => ['read' => 'leave_settings_read', 'update' => 'leave_settings_update'],
            'ip' => ['read' => 'ip_read', 'create' => 'ip_create', 'update' => 'ip_update', 'delete' => 'ip_delete','user_ip_binding'=>'user_ip_binding'],

            'company_setup' => [
                'menu' => 'company_setup_menu' , 'activation_read' => 'company_setup_activation', 'activation_update' => 'company_setup_activation_update', 'configuration_read' => 'company_setup_configuration',
                'configuration_update' => 'company_setup_configuration_update','ip_whitelist_read' => 'company_setup_ip_whitelist',
                'location_read' => 'company_setup_location'
            ],
            'location' => [
                'location_create' => 'location_create', 'location_store' => 'location_store', 'location_edit' => 'location_edit', 'location_update' => 'location_update', 'location_delete' => 'location_delete',
            ],

            'api_setup' => ['read' => 'locationApi'],

            'claim' => ['read' => 'claim_read', 'create' => 'claim_create', 'update' => 'claim_update', 'delete' => 'claim_delete'],
            'payment' => ['read' => 'payment_read', 'create' => 'payment_create', 'update' => 'payment_update', 'delete' => 'payment_delete'],

            //visit
            'visit' => ['menu' => 'visit_menu', 'read' => 'visit_read', 'update' => 'visit_update', 'view' => 'visit_view'],

            // team
            // 'team' => [
            //     'team_menu' => 'team_menu',
            //     'team_list' => 'team_list',
            //     'team_create' => 'team_create',
            //     'team_update' => 'team_update',
            //     'team_edit' => 'team_edit',
            //     'team_delete' => 'team_delete',
            //     'team_member_view' => 'team_member_view',
            //     'team_member_create' => 'team_member_create',
            //     'team_member_edit' => 'team_member_edit',
            //     'team_member_delete' => 'team_member_delete',
            //     'team_member_assign' => 'team_member_assign',
            //     'team_member_unassign' => 'team_member_unassign'
            // ],

            //support
            'support' => [
                'support_menu' => 'support_menu',
                'support_read' => 'support_read',
                'support_create' => 'support_create',
                'support_reply' => 'support_reply',
                'support_delete' => 'support_delete',
            ]
        ];
    }


    public function createNewUser($list)
    {

        $fake = \Faker\Factory::create();
        $list['role_id'] = $list['role_id'] ?? 1;
        $role = Role::where('id', $list['role_id'])->first();
        $user = User::create([
            'name' => $list['name'] ?? $fake->name,
            'email' => $list['email'] ?? $fake->email,
            'password' => Hash::make('12345678'),
            'is_admin' => $list['is_admin'] ?? 0,
            'is_hr' => $list['is_hr'] ?? 0,
            'status_id' => 1,
            'company_id' => $list['company_id'] ?? 1,
            'country_id' => $list['country_id'] ?? 17,
            'shift_id' => $list['shift_id'] ?? 1,
            'department_id' => $list['department_id'] ?? 1,
            'designation_id' => $list['designation_id'] ?? 1,
            'phone' => $list['phone'] ?? $fake->phoneNumber,
            // verify
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_email_verified' => 'verified',
            'email_verify_token' => Str::random(10),
            'role_id' => $list['role_id'],
            //hrPermissions
            // 'permissions' => $this->customPermissions($role->slug),
            'permissions' => $list['is_hr']==1 ? $this->hrPermissions() : $this->customPermissions($role->slug),

        ]);

        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => 1,
        ]);


        $author = new AuthorInfo();
        $author->created_by = 1;
        $author->authorable_type = 'App\Models\User';
        $author->authorable_id = $user->id;
        $author->save();
    }

    public function createCompanyAdmin()
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $department = Department::where('company_id', $company->id)->orderBy('id', 'asc')->first();
            $designation = Designation::where('company_id', $company->id)->orderBy('id', 'asc')->first();
            $shift = Shift::where('company_id', $company->id)->orderBy('id', 'asc')->first();

            $roles = Role::where('company_id', $company->id);
            if ($company->id == 1) {
                $roles = $roles->whereIn('slug', ['superadmin']);
            } else {
                $roles = $roles->whereIn('slug', ['admin']);
            }
            $roles = $roles->get();

            foreach ($roles as $key => $role) {
                $list = [
                    'name' => $company->name,
                    'email' => $company->email,
                    'is_admin' => 1,
                    'is_hr' => 0,
                    'role_id' => $role->id,
                    'company_id' => $company->id,
                    'country_id' => 17,
                    'shift_id' => $shift->id,
                    'department_id' => $department->id,
                    'designation_id' => $designation->id,
                    'phone' => $company->phone,
                ];

                $this->createNewUser($list);
            }
        }
    }
}
