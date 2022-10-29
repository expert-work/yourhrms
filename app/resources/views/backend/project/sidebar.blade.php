@if (hasPermission('project_menu'))
    <li class="nav-item has-submenu {{ set_menu([route('project.index')]) }}">
        <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
            <div class="icon-badge-circle">
                <i class="nav-icon bi bi-file-earmark-medical"></i>
            </div>
            <span class="nav-link-text ml-3 font-purple">
                {{ _trans('project.Projects') }}
                <i class="down fas fa-angle-down"></i>
            </span>
        </a>
        <ul class="submenu collapse {{ set_active(['admin/project*']) }}">

            @if (hasPermission('project_create'))
                <li class="nav-item {{ menu_active_by_route(['project.create']) }}">
                    <a href="{{ route('project.create') }}" class="nav-link">
                        <span> {{ _trans('project.Project Create') }}</span>
                    </a>
                </li>
            @endif

            @if (hasPermission('project_list'))
                <li class="nav-item {{ menu_active_by_route(['project.index']) }}">
                    <a href="{{ route('project.index') }}" class="nav-link">
                        <span> {{ _trans('project.Project List') }}</span>
                    </a>
                </li>
            @endif



        </ul>
    </li>
@endif
