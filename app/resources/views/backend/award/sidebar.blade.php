@if (hasPermission('award_menu'))
    <li class="nav-item has-submenu {{ set_menu([route('award.index')]) }}">
        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
            <div class="icon-badge-circle">
                <i class="nav-icon bi bi-file-earmark-medical"></i>
            </div>
            <span class="nav-link-text ml-3 font-purple">
                {{ _trans('award.Awards') }}
                <i class="down fas fa-angle-down"></i>
            </span>
        </a>
        <ul class="submenu collapse {{ set_active(['admin/award*']) }}">

            @if (hasPermission('award_type_menu'))
                <li class="nav-item {{ menu_active_by_route(['award_type.index']) }}">
                    <a href="{{ route('award_type.index') }}" class="nav-link">
                        <span> {{ _trans('award.Award Type List') }}</span>
                    </a>
                </li>
            @endif

            @if (hasPermission('award_list'))
                <li class="nav-item {{ menu_active_by_route(['award.index']) }}">
                    <a href="{{ route('award.index') }}" class="nav-link">
                        <span> {{ _trans('award.Award List') }}</span>
                    </a>
                </li>
            @endif



        </ul>
    </li>
@endif
