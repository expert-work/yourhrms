@if (hasPermission('task_menu'))
<li class="nav-item has-submenu {{ set_menu([route('task.index')]) }}">
    <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
        <div class="icon-badge-circle">
            <i class="nav-icon bi bi-file-earmark-medical"></i>
        </div>
        <span class="nav-link-text ml-3 font-purple">
            {{ _trans('task.Tasks') }}
            <i class="down fas fa-angle-down"></i>
        </span>
    </a>
    <ul class="submenu collapse {{ set_active(['admin/task*']) }}">

        @if (hasPermission('task_create'))
            <li class="nav-item {{ menu_active_by_route(['task.create']) }}">
                <a href="{{ route('task.create') }}" class="nav-link">
                    <span> {{ _trans('task.Task Create') }}</span>
                </a>
            </li>
        @endif

        @if (hasPermission('task_list'))
            <li class="nav-item {{ menu_active_by_route(['task.index']) }}">
                <a href="{{ route('task.index') }}" class="nav-link">
                    <span> {{ _trans('task.Task List') }}</span>
                </a>
            </li>
        @endif



    </ul>
</li>
@endif