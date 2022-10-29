@if (hasPermission('travel_menu'))
    <li class="nav-item has-submenu {{ set_menu([route('travel.index')]) }}">
        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
            <div class="icon-badge-circle">
                <i class="nav-icon bi bi-file-earmark-medical"></i>
            </div>
            <span class="nav-link-text ml-3 font-purple">
                {{ _trans('travel.Travels') }}
                <i class="down fas fa-angle-down"></i>
            </span>
        </a>
        <ul class="submenu collapse {{ set_active(['admin/travel*']) }}">

            @if (hasPermission('travel_type_menu'))
                <li class="nav-item {{ menu_active_by_route(['travel_type.index']) }}">
                    <a href="{{ route('travel_type.index') }}" class="nav-link">
                        <span> {{ _trans('travel.Type') }}</span>
                    </a>
                </li>
            @endif

            @if (hasPermission('travel_list'))
                <li class="nav-item {{ menu_active_by_route(['travel.index']) }}">
                    <a href="{{ route('travel.index') }}" class="nav-link">
                        <span> {{ _trans('travel.Travel List') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif