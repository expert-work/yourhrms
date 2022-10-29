<nav class="vertical-menu navbar navbar-expand-lg navbar-light bg-light"
    style="background-color: #fff !important; margin-bottom:25px">
    <button class="navbar-toggler ml-3 ml-md-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-sm-4 ml-md-4 ml-lg-1 ml-xl-1" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link {{ menu_active_by_route('staff.staffProfileEditView') }}"
                    href="{{ route('staff.staffProfileEditView', 'official') }}">
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
                {{-- <li class="nav-item">
            <a class="nav-link {{menu_active_by_route('user.expense')}}" href="{{ route('user.expense',$data['id']) }}">
              Expenses
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
              <a class="dropdown-item" href="#">Claim Expense</a>
            </div>
          </li> --}}
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


                {{-- <li class="nav-item dropdown">
                    <a class="nav-link {{ menu_active_by_route('user.visit') }} {{ menu_active_by_route('user.visitHistory') }}  dropdown-toggle"
                        href="#" id="navbarDropdown5" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Visit
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown5">
                        <a class="dropdown-item" href="{{ route('visit.user', $data['id']) }}">Schedule</a>
                    </div>
                </li> --}}
                {{-- <li class="nav-item">
            <a class="nav-link" href="#">Feedback</a>
          </li> --}}
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','phonebook')) }}"
                        href="{{ route('staff.profile.info','phonebook') }}">
                        Phonebook
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ menu_active_by_url(route('staff.profile.info','appointment')) }}"
                        href="{{ route('staff.profile.info','appointment') }}">
                        Appointment
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
            @endif
        </ul>
    </div>
</nav>
