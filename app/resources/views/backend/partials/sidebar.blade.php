{{-- @php
     $path=config('settings.app')['company_logo_backend'];
    // $path=Storage::disk('local')->url($path);
    $path=url('/.env');
    dump($path);
    dd(file_exists($path));
@endphp --}}


<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 dark-sidebar right-box-shadow">
    <div class="sidebar-top-side">
        <a href="{{ route('admin.dashboard') }}" class="img-tag sidebar_logo">
            @if (env('FILESYSTEM_DRIVER') == 's3')
                <img src="{{ Storage::disk('s3')->url(config('settings.app')['company_logo_backend']) }}"
                    class="mt-3 logo-cus" alt="{{ config('app.name') }}">
            @elseif(env('FILESYSTEM_DRIVER') == 'local')
                @php
                    if (config('settings.app')['company_logo_backend']) {
                        $URL = Storage::url(config('settings.app')['company_logo_backend']);
                    } else {
                        $URL = url('public/assets/logo-white.png');
                    }
                @endphp
                <img src=" {{ @$URL }}" class="mt-3 logo-cus" alt="{{ config('app.name') }}">
            @else
                <img src="{{ url('public/assets/logo-white.png') }}" class="mt-3 logo-cus"
                    alt="{{ config('app.name') }}">
            @endif
        </a>
    </div>


    <!-- Sidebar -->
    <div class="sidebar mt-4">
        <nav class="">
            <ul class="nav flex-column" id="nav_accordion">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link d-flex align-items-center {{ set_active('dashboard/dashboard') }}">
                        <div class="icon-badge-circle">
                            <i class="nav-icon bi bi-house-door cus-icon"></i>
                        </div>
                        <span class="nav-link-text ml-3">
                            {{ _trans('common.Dashboard') }}
                        </span>
                    </a>
                </li>


                {{-- <li class="nav-item has-submenu">
                    <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                        <div class="icon-badge-circle">
                            <i class="nav-icon bi bi-card-checklist"></i>
                        </div>
                        <span class="nav-link-text ml-3 font-purple">
                            {{ _trans('subscription.Subscriptions') }}
                            <i class="down fas fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="submenu collapse {{ set_active(['dashboard/subscriptions*']) }}">

                        <li class="nav-item {{ menu_active_by_route(['dashboard/subscriptions*']) }}">
                            <a href="{{ route('subscriptions.index') }}"
                                class="nav-link  {{ set_active(route('subscriptions.index')) }}">
                                <span>Subscriptions</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}



                {{-- <li class="nav-item">
                    <a href="{{ url('dashboard/user/show/' . auth()->user()->id . '/official') }}"
                       class="nav-link d-flex align-items-center {{ set_active('dashboard/user/*') }}">
                        <div class="icon-badge-circle">
                            <i class="bi-person cus-icon"></i>
                        </div>
                        <span class="nav-link-text ml-3">
                            {{ _trans('My Dashboard') }}
                        </span>
                    </a>
                </li> --}}
                {{-- superadmin sidebar --}}
                @if (hasPermission('company_read') && config('app.APP_BRANCH') != 'nonsaas')
                    <li class="nav-item has-submenu">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-card-checklist"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('common.Company') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="submenu collapse {{ set_active(['dashboard/companies*']) }}">
                            @if (hasPermission('company_read'))
                                <li class="nav-item {{ menu_active_by_route(['dashboard/companies*']) }}">
                                    <a href="{{ route('company.index') }}"
                                        class="nav-link  {{ set_active(route('company.index')) }}">
                                        <span>{{ _trans('common.Company List') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- end superadmin sidebar --}}
                @if (hasPermission('user_menu') || hasPermission('role_read') || hasPermission('designation_read') || hasPermission('department_read'))
                    <li class="nav-item has-submenu">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-card-checklist"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('common. User & Roles') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul
                            class="submenu collapse {{ set_active(['dashboard/user', 'hrm/designation*', 'hrm/department*', 'hrm/roles*']) }}">

                            @if (hasPermission('designation_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['designation.index', 'designation.edit', 'designation.create']) }}">
                                    <a href="{{ route('designation.index') }}"
                                        class="nav-link  {{ set_active(route('designation.index')) }}">
                                        <span>{{ _trans('common.Designations') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('department_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['department.index', 'department.edit', 'department.create']) }}">
                                    <a href="{{ route('department.index') }}"
                                        class="nav-link  {{ set_active(route('department.index')) }}">
                                        <span>{{ _trans('common.Departments') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('user_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['user.index', 'user.edit', 'user.create']) }}">
                                    <a href="{{ route('user.index') }}"
                                        class="nav-link  {{ set_active(route('user.index')) }}">
                                        <span>{{ _trans('common.Users') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('role_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['roles.index', 'roles.edit', 'roles.create']) }}">
                                    <a href="{{ route('roles.index') }}"
                                        class="nav-link {{ set_active('dashboard/roles') }}">
                                        <span>{{ _trans('common.Roles') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (hasPermission('leave_menu'))
                    <li
                        class="nav-item has-submenu {{ set_menu([route('leave.index'), route('assignLeave.index')]) }}">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-file-earmark-x"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('attendance.Leave') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul
                            class="submenu collapse {{ set_active(['hrm/leave*', 'hrm/leave/assign*', 'hrm/leave/request*']) }}">
                            @if (hasPermission('leave_type_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['leave.index', 'leave.create', 'leave.edit']) }}">
                                    <a href="{{ route('leave.index') }}"
                                        class="nav-link {{ set_active(route('leave.index')) }}">
                                        <span>{{ _trans('common.Type') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('leave_assign_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['assignLeave.index', 'assignLeave.create', 'assignLeave.edit']) }}">
                                    <a href="{{ route('assignLeave.index') }}"
                                        class="nav-link {{ set_active(route('assignLeave.index')) }}">
                                        <span> {{ _trans('leave.Assign Leave') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('leave_request_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['leaveRequest.index', 'leaveRequest.create']) }}">
                                    <a href="{{ route('leaveRequest.index') }}"
                                        class="nav-link {{ set_active(route('leaveRequest.index')) }}">
                                        <span>{{ _trans('leave.Leave Request') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (hasPermission('attendance_menu') || hasPermission('shift_read') || hasPermission('generate_qr_code'))
                    <li class="nav-item has-submenu {{ set_menu([route('weekendSetup.index')]) }}">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-file-check"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('attendance.Attendance') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="submenu collapse {{ set_active(['hrm/attendance*']) }}">



                            @if (hasPermission('attendance_read'))
                                <li class="nav-item {{ menu_active_by_route('attendance.index') }}">
                                    <a href="{{ route('attendance.index') }}"
                                        class="nav-link {{ set_active(route('attendance.index')) }}">
                                        <span>{{ _trans('attendance.Attendance') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('generate_qr_code') && settings('attendance_method')=='QR')
                                <li class="nav-item {{ menu_active_by_route('hrm.qr.index') }}">
                                    <a href="{{ route('hrm.qr.index') }}"
                                        class="nav-link {{ set_active(route('hrm.qr.index')) }}">
                                        <span>{{ _trans('attendance.QR Code') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- @if(hasPermission('report_menu'))
                <li class="nav-item has-submenu {{ set_menu([route('expense.index')]) }}">
                    <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                        <div class="icon-badge-circle">
                            <i class="nav-icon bi bi-file-earmark-medical"></i>
                        </div>
                        <span class="nav-link-text ml-3 font-purple">
                          Expense
                            <i class="down fas fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="submenu collapse {{ set_active(['hrm/expense*']) }}">
                        @if(hasPermission('expense_read'))
                            <li class="nav-item {{menu_active_by_route(['expense.index'])}}">
                                <a href="{{ route('expense.index') }}"
                                   class="nav-link {{ set_active(route('expense.index')) }}">
                                    <span>Manage expense</span>
                                </a>
                            </li>
                        @endif
                        @if(hasPermission('claim_read'))
                            <li class="nav-item {{menu_active_by_route(['claim.index'])}}">
                                <a href="{{ route('claim.index') }}"
                                   class="nav-link {{ set_active(route('claim.index')) }}">
                                    <span>Manage claims</span>
                                </a>
                            </li>
                        @endif
                        @if(hasPermission('payment_read'))
                            <li class="nav-item {{menu_active_by_route(['payment.index'])}}">
                                <a href="{{ route('payment.index') }}"
                                   class="nav-link {{ set_active(route('payment.index')) }}">
                                    <span>Payment history</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif --}}

                @if (hasPermission('payroll_menu'))
                    <li class="nav-item has-submenu {{ set_menu([route('hrm.payroll_items.index')]) }}">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-file-earmark-medical"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('payroll.Payroll') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="submenu collapse {{ set_active(['hrm/payroll*']) }}">
                            {{-- @if (hasPermission('list_payroll_item'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.payroll_items.index']) }}">
                                    <a href="{{ route('hrm.payroll_items.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Payroll Item') }}</span>
                                    </a>
                                </li>
                            @endif --}}

                            @if (hasPermission('payroll_set_menu'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.payroll_setup.index']) }}">
                                    <a href="{{ route('hrm.payroll_setup.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Setup') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('advance_salaries_list'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.payroll_advance_salary.index']) }}">
                                    <a href="{{ route('hrm.payroll_advance_salary.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Advance') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('payroll_set_menu'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.payroll_salary.index']) }}">
                                    <a href="{{ route('hrm.payroll_salary.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Salary') }}</span>
                                    </a>
                                </li>
                            @endif



                        </ul>
                    </li>
                @endif
                @if (hasPermission('account_menu') || hasPermission('deposit_menu') || hasPermission('expense_menu') || hasPermission('transaction_menu'))
                    <li class="nav-item has-submenu {{ set_menu([route('hrm.accounts.index')]) }}">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-file-earmark-medical"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('payroll.Accounts') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul
                            class="submenu collapse {{ set_active(['hrm/accounts*', 'hrm/transactions*', 'hrm/deposit*', 'hrm/expenses*', 'hrm/account-settings*', 'hrm/payment-method*']) }}">


                            @if (hasPermission('account_menu'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.accounts.index']) }}">
                                    <a href="{{ route('hrm.accounts.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Account List') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('deposit_menu'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.deposits.index']) }}">
                                    <a href="{{ route('hrm.deposits.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Deposit') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('expense_menu'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.expenses.index']) }}">
                                    <a href="{{ route('hrm.expenses.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Expense') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('transaction_menu'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.transactions.index']) }}">
                                    <a href="{{ route('hrm.transactions.index') }}" class="nav-link">
                                        <span> {{ _trans('payroll.Transaction History') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('deposit_category_menu'))
                                <li
                                    class="nav-item has-submenu {{ set_menu([route('hrm.deposit_category.expense')]) }}">
                                    <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                                        <span class="nav-link-text font-purple">
                                            {{ _trans('payroll.Accounts Settings') }}
                                            <i class="down fas fa-angle-down mt--3"></i>
                                        </span>
                                    </a>
                                    <ul
                                        class="submenu collapse {{ set_active(['hrm/account-settings*', 'hrm/payment-method*']) }} pl-20">


                                        @if (hasPermission('deposit_category_menu'))
                                            <li
                                                class="nav-item {{ menu_active_by_route(['hrm.deposit_category.deposit']) }}">
                                                <a href="{{ route('hrm.deposit_category.deposit') }}"
                                                    class="nav-link">
                                                    <span> {{ _trans('payroll.Deposit Category') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if (hasPermission('deposit_category_menu'))
                                            <li
                                                class="nav-item {{ menu_active_by_route(['hrm.deposit_category.expense']) }}">
                                                <a href="{{ route('hrm.deposit_category.expense') }}"
                                                    class="nav-link">
                                                    <span> {{ _trans('expense.Expense Category') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if (hasPermission('payment_method_menu'))
                                            <li
                                                class="nav-item {{ menu_active_by_route(['hrm.payment_method.index']) }}">
                                                <a href="{{ route('hrm.payment_method.index') }}" class="nav-link">
                                                    <span> {{ _trans('payment_method.Payment Method') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- Start Client Module --}}
                @include('backend.client.sidebar')
                {{-- End Client Module --}}

                {{-- task management start --}}
                @include('backend.task.sidebar')
                {{-- project management end --}}

                {{-- project management start --}}
                @include('backend.project.sidebar')
                {{-- project management end --}}

                {{-- award management start --}}
                @include('backend.award.sidebar')
                {{-- award management end --}}

                {{-- Start Travel Routes --}}
                @include('backend.travel.sidebar')
                {{-- End Travel Routes --}}

                {{-- Start performance Routes --}}
                @include('backend.performance.sidebar')
                {{-- End performance Routes --}}


                

                <li class="nav-item has-submenu">
                    <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                        <div class="icon-badge-circle">
                            <i class="nav-icon bi bi-card-checklist"></i>
                        </div>
                        <span class="nav-link-text ml-3 font-purple">
                            {{ _trans('appointment.Appointment') }}
                            <i class="down fas fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="submenu collapse {{ set_active(['hrm/appointment*']) }}">

                        <li class="nav-item {{ menu_active_by_route(['hrm/appointment*']) }}">
                            <a href="{{ route('appointment.index') }}"
                                class="nav-link  {{ set_active(route('appointment.index')) }}">
                                <span>{{ _trans('common.List') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @if (hasPermission('visit_menu'))
                    <li class="nav-item has-submenu {{ set_menu([route('visit.index')]) }}">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-file-earmark-medical"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('common.Visit') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="submenu collapse {{ set_active(['hrm/visit*']) }}">
                            @if (hasPermission('visit_read'))
                                <li class="nav-item {{ menu_active_by_route(['visit.index']) }}">
                                    <a href="{{ route('visit.index') }}" class="nav-link">
                                        <span>{{ _trans('common.Manage visit') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                
                {{-- support_menu --}}
                @if (hasPermission('support_menu'))
                    <li class="nav-item has-submenu {{ set_menu([route('team.index')]) }}">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-people"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('common.Support') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="submenu collapse {{ set_active(['hrm/support/ticket/list*']) }}">
                            @if (hasPermission('support_read'))
                                <li class="nav-item {{ menu_active_by_route(['supportTicket.index']) }}">
                                    <a href="{{ route('supportTicket.index') }}" class="nav-link">
                                        <span> {{ _trans('common.Tickets') }}</span> </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li class="nav-item has-submenu d-none">
                    <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                        <div class="icon-badge-circle">
                            <i class="nav-icon bi bi-file-earmark-medical"></i>
                        </div>
                        <span class="nav-link-text ml-3 font-purple">
                            {{ _trans('common.Chat/Messages ') }}<span class="badge badge-danger "
                                style="font-size: 8px; padding:5px !important;">8</span>
                            <i class="down fas fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="submenu collapse ">
                        <li class="nav-item ">
                            <a href="#" class="nav-link"> <span>{{ _trans('common.Team Chats') }}</span> </a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link"> <span>{{ _trans('common.Groups Chats') }}</span>
                                <span class="badge badge-warning "
                                    style="font-size: 8px; padding:5px !important;">1</span> </a>
                        </li>
                    </ul>
                </li>

                @if (hasPermission('announcement_menu'))
                    <li
                        class="nav-item has-submenu  {{ set_menu(['notice.index', 'notice.create', 'notice.edit']) }} ">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-bell"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('common.Announcement') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul
                            class="submenu collapse  {{ set_active(['announcement/*', 'dashboard/announcement/*']) }}">

                            @if (hasPermission('notice_menu'))
                                <li class="nav-item  {{ menu_active_by_route(['notice.index', 'notice.create', 'notice.edit']) }} ">
                                    <a href="{{ route('notice.index') }}"
                                        class="nav-link  {{ menu_active_by_route(['notice.index', 'notice.create', 'notice.edit']) }} ">
                                        <span>{{ _trans('common.Notice') }}</span> <span class="badge badge-info d-none"
                                            style="font-size: 8px; padding:5px !important;">5</span> </a>
                                </li>
                            @endif
                            @if (hasPermission('push_notification'))
                                <li class="nav-item  {{ menu_active_by_route(['notice.pushNotification']) }} ">
                                    <a href="{{ route('notice.pushNotification') }}"
                                        class="nav-link  {{ menu_active_by_route(['notice.pushNotification']) }} ">
                                        <span>{{ _trans('common.Push Notification') }}</span></a>
                                </li>
                            @endif
                            {{-- @if (hasPermission('send_sms_menu'))
                                <li class="nav-item ">
                                    <a href="{{route('sms.index')}}"  class="nav-link">  <span>Send SMS</span>  </a>
                                </li>
                            @endif --}}
                            @if (hasPermission('send_email_menu'))
                                <li class="nav-item d-none">
                                    <a href="#" class="nav-link">
                                        <span>{{ _trans('common.Send E-mail') }}</span> </a>
                                </li>
                            @endif
                            @if (hasPermission('send_notification_menu'))
                                <li class="nav-item d-none">
                                    <a href="#" class="nav-link">
                                        <span>{{ _trans('common.Send Notification') }}</span> </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if (hasPermission('report'))
                    <li class="nav-item has-submenu {{ set_menu([route('attendanceReport.index')]) }}">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-file-earmark-medical"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-purple">
                                {{ _trans('common.Report') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="submenu collapse {{ set_active(['hrm/report/*', 'hrm/break/*']) }}">

                            @if (hasPermission('attendance_report_read'))
                                <li class="nav-item {{ menu_active_by_route(['live_trackingReport.index']) }}">
                                    <a href="{{ route('live_trackingReport.index') }}"
                                        class="nav-link {{ set_active(route('live_trackingReport.index')) }}">
                                        <span>{{ _trans('common.Live Tracking') }}</span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ menu_active_by_route(['live_trackingReportHistory.index']) }}">
                                    <a href="{{ route('live_trackingReportHistory.index') }}"
                                        class="nav-link {{ set_active(route('live_trackingReportHistory.index')) }}">
                                        <span>{{ _trans('common.Location History') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('attendance_report_read'))
                                <li class="nav-item {{ menu_active_by_route(['attendanceReport.index']) }}">
                                    <a href="{{ route('attendanceReport.index') }}"
                                        class="nav-link {{ set_active(route('attendanceReport.index')) }}">
                                        <span>{{ _trans('attendance.Attendance Report') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ menu_active_by_route(['breakReport.index']) }}">
                                    <a href="{{ route('breakReport.index') }}"
                                        class="nav-link {{ set_active(route('breakReport.index')) }}">
                                        <span>{{ _trans('common.Break Report') }}</span>
                                    </a>
                                </li>
                            @endif


                            {{-- @if (hasPermission('expense_read'))
                                <li class="nav-item {{ menu_active_by_route(['hrm.expenses.report']) }}">
                                    <a href="{{ route('hrm.expenses.report') }}"
                                        class="nav-link {{ set_active(route('hrm.expenses.report')) }}">
                                        <span>{{ _trans('common.Expense Report') }}</span>
                                    </a>
                                </li>
                            @endif --}}
                            @if (hasPermission('visit_read'))
                                <li class="nav-item {{ menu_active_by_route(['visit.index']) }}">
                                    <a href="{{ route('visit.index') }}" class="nav-link">
                                        <span>{{ _trans('common.Visit Report') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('leave_request_read'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['leaveRequest.index', 'leaveRequest.create']) }}">
                                    <a href="{{ route('leaveRequest.index') }}"
                                        class="nav-link {{ set_active(route('leaveRequest.index')) }}">
                                        <span>{{ _trans('common.Leave Report') }}</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                @if (hasPermission('company_setup_menu'))
                    <li class="nav-item has-submenu">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-gear"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-blue">
                                {{ _trans('common.Setup & Configuration') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul
                            class="submenu collapse  {{ set_active(['admin/company-setup*', 'hrm/weekend/setup*', 'hrm/holiday/setup*', 'hrm/duty/schedule*', 'hrm/shift*']) }}">

                            @if (hasPermission('company_settings_update'))
                                <li class="nav-item {{ menu_active_by_route(['company.settings.configuration']) }}">
                                    <a href="{{ route('company.settings.configuration') }}" class="nav-link ">
                                        <span>{{ _trans('common.Configurations') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('weekend_read'))
                                <li class="nav-item {{ menu_active_by_route(['weekendSetup.index']) }}">
                                    <a href="{{ route('weekendSetup.index') }}"
                                        class="nav-link {{ set_active([route('weekendSetup.index')]) }}">
                                        <span>{{ _trans('attendance.Weekend Setup') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('holiday_read'))
                                <li class="nav-item {{ menu_active_by_route('holidaySetup.index') }}">
                                    <a href="{{ route('holidaySetup.index') }}"
                                        class="nav-link {{ set_active(route('holidaySetup.index')) }}">
                                        <span>{{ _trans('attendance.Holiday Setup') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('shift_read'))
                                <li class="nav-item {{ menu_active_by_route('shift.index') }}">
                                    <a href="{{ route('shift.index') }}"
                                        class="nav-link {{ set_active(route('shift.index')) }}">
                                        <span>{{ _trans('attendance.Shift Setup') }}</span>
                                    </a>
                                </li>
                            @endif
                            
                            @if (hasPermission('schedule_read'))
                                <li class="nav-item {{ menu_active_by_route('dutySchedule.index') }}">
                                    <a href="{{ route('dutySchedule.index') }}"
                                        class="nav-link {{ set_active(route('dutySchedule.index')) }}">
                                        <span>{{ _trans('attendance.Duty Schedule') }}</span>
                                    </a>
                                </li>
                            @endif




                            @if (hasPermission('company_setup_ip_whitelist'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['ipConfig.index', 'ipConfig.create']) }}">
                                    <a href="{{ route('ipConfig.index') }}" class="nav-link">
                                        <span>{{ _trans('common.IP Whitelist') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('company_setup_location'))
                                <li
                                    class="nav-item {{ menu_active_by_route(['company.settings.location', 'company.settings.locationCreate']) }}">
                                    <a href="{{ route('company.settings.location') }}" class="nav-link">
                                        <span>{{ _trans('common.Locations') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('company_setup_activation'))
                                <li class="nav-item {{ menu_active_by_route('company.settings.activation') }}">
                                    <a href="{{ route('company.settings.activation') }}" class="nav-link">
                                        <span>{{ _trans('common.Activation') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (hasPermission('general_settings_read') || hasPermission('general_settings_update'))
                    <li class="nav-item has-submenu mb-5">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                            <div class="icon-badge-circle">
                                <i class="nav-icon bi bi-gear"></i>
                            </div>
                            <span class="nav-link-text ml-3 font-blue">
                                {{ _trans('common.Settings') }}
                                <i class="down fas fa-angle-down"></i>
                            </span>
                        </a>
                        <ul
                            class="submenu collapse  {{ set_active(['admin/settings/list', 'admin/settings/leave*', 'admin/settings/ip-configuration*', 'company/settings', 'admin/settings/app-setting/dashboard', 'admin/settings/content*', 'admin/settings/contact*', 'admin/settings/language-setup']) }}">
                            @if (hasPermission('general_settings_read'))
                                <li class="nav-item {{ menu_active_by_route('manage.settings.view') }}">
                                    <a href="{{ route('manage.settings.view') }}"
                                        class="nav-link {{ set_active('admin/settings/list') }}">
                                        <span>{{ _trans('common.General Settings') }}</span>
                                    </a>
                                </li>
                            @endif

                            {{-- get config file value --}}
                            @if (auth()->user()->role_id == 1 || Config::get('app.APP_BRANCH') == 'nonsaas')
                                <li class="nav-item {{ menu_active_by_route('appScreenSetup') }}">
                                    <a href="{{ route('appScreenSetup') }}"
                                        class="nav-link {{ set_active('admin/settings/contact/*') }}">
                                        <span>{{ _trans('common.App Setting') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ menu_active_by_route(['content.list', 'ipConfig.create']) }}">
                                    <a href="{{ route('content.list') }}" class="nav-link {{ set_active('admin/settings/app-setting/dashboard/*') }}">
                                        <span>{{ _trans('common.Contents') }}</span>
                                    </a>
                                </li>
                            @if (Config::get('app.APP_BRANCH') != 'nonsaas')
                                <li class="nav-item {{ menu_active_by_route('contact.index') }}">
                                    <a href="{{ route('contact.index') }}" class="nav-link {{ set_active('admin/settings/contact/*') }}">
                                        <span>{{ _trans('common.Contacts') }}</span>
                                    </a>
                                </li>
                            @endif
                                <li class="nav-item {{ menu_active_by_route('language.index') }}">
                                    <a href="{{ route('language.index') }}"
                                        class="nav-link {{ set_active('admin/settings/language/*') }}">
                                        <span>{{ _trans('settings.Language') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
