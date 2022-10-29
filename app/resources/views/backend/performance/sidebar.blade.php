@if (hasPermission('performance_menu'))
    <li class="nav-item has-submenu">
        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
            <div class="icon-badge-circle">
                <i class="nav-icon bi bi-file-earmark-medical"></i>
            </div>
            <span class="nav-link-text ml-3 font-purple">
                {{ _trans('performance.Performance') }}
                <i class="down fas fa-angle-down"></i>
            </span>
        </a>
        <ul class="submenu collapse {{ set_active(['admin/performance*']) }}">

            @if (hasPermission('performance_indicator_menu'))
                <li class="nav-item {{ menu_active_by_route(['performance.indicator.index']) }}">
                    <a href="{{ route('performance.indicator.index') }}" class="nav-link">
                        <span> {{ _trans('performance.Indicator') }}</span>
                    </a>
                </li>
            @endif

            @if (hasPermission('performance_appraisal_menu'))
                <li class="nav-item {{ menu_active_by_route(['performance.appraisal.index']) }}">
                    <a href="{{ route('performance.appraisal.index') }}" class="nav-link">
                        <span> {{ _trans('performance.Appraisal') }}</span>
                    </a>
                </li>
            @endif

            @if (hasPermission('performance_goal_menu'))
                <li class="nav-item {{ menu_active_by_route(['performance.goal.index']) }}">
                    <a href="{{ route('performance.goal.index') }}" class="nav-link">
                        <span> {{ _trans('performance.Goal') }}</span>
                    </a>
                </li>
            @endif
            @if (hasPermission('performance_settings'))
                <li class="nav-item has-submenu ">
                    <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
                        <span class="nav-link-text font-purple">
                            {{ _trans('common.Settings') }}
                            <i class="down fas fa-angle-down mt--3"></i>
                        </span>
                    </a>
                    <ul
                        class="submenu collapse {{ set_active(['admin/performance/settings*']) }} pl-20">


                        @if (hasPermission('performance_competence_type_menu'))
                            <li class="nav-item {{ menu_active_by_route(['performance.competence.type.index']) }}">
                                <a href="{{ route('performance.competence.type.index') }}" class="nav-link">
                                    <span> {{ _trans('performance.Competence Type') }}</span>
                                </a>
                            </li>
                        @endif
                        @if (hasPermission('performance_competence_menu'))
                            <li class="nav-item {{ menu_active_by_route(['performance.competence.index']) }}">
                                <a href="{{ route('performance.competence.index') }}" class="nav-link">
                                    <span> {{ _trans('performance.Competencies') }}</span>
                                </a>
                            </li>
                        @endif

                        @if (hasPermission('performance_goal_type_list'))
                            <li class="nav-item {{ menu_active_by_route(['performance.goal_type.index']) }}">
                                <a href="{{ route('performance.goal_type.index') }}" class="nav-link">
                                    <span> {{ _trans('performance.Goal Type') }}</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif
            {{-- Competencies --}}



        </ul>
    </li>
@endif
