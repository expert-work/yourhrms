<nav class="vertical-menu navbar navbar-expand-lg navbar-light bg-light"
    style="background-color: #fff !important; margin-bottom:25px">
    <button class="navbar-toggler ml-3 ml-md-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
{{-- @dd(auth()->user()->myHr()) --}}
    <div class="collapse navbar-collapse ml-sm-4 ml-md-4 ml-lg-1 ml-xl-1" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link {{ menu_active_by_route('staff.profile') }}"
                    href="{{ route('staff.profile', 'official') }}">
                    Profile
                </a>
            </li>
            @if (auth()->user()->role_id != 1)
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','contract')) }}"
                        href="{{ route('staff.profile.info','contract') }}">
                        Contract
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info', 'attendance')) }}"
                        href="{{ route('staff.profile.info', 'attendance') }}">
                        Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','notice')) }}"
                        href="{{ route('staff.profile.info','notice') }}">
                        Notices
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','leave_request')) }}"
                        href="{{ route('staff.profile.info','leave_request') }}">
                        Leaves
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','visit')) }}"
                        href="{{ route('staff.profile.info','visit') }}">
                        Visit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','phonebook')) }}"
                        href="{{ route('staff.profile.info','phonebook') }}">
                        Phonebook
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','appointment')) }}"
                        href="{{ route('staff.profile.info','appointment') }}">
                       {{ _trans('appointment.Appointment') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','ticket')) }}"
                        href="{{ route('staff.profile.info','ticket') }}">
                        Support Ticket
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','advance')) }}"
                        href="{{ route('staff.profile.info','advance') }}">
                        Advance
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','commission')) }}"
                        href="{{ route('staff.profile.info','commission') }}">
                        Commission
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','salary')) }}"
                        href="{{ route('staff.profile.info','salary') }}">
                        Salary
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','project')) }}"
                        href="{{ route('staff.profile.info','project') }}">
                        Project
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','tasks')) }}"
                        href="{{ route('staff.profile.info','tasks') }}">
                        Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','award')) }}"
                        href="{{ route('staff.profile.info','award') }}">
                        Awards
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','travel')) }}"
                        href="{{ route('staff.profile.info','travel') }}">
                        Travels
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
