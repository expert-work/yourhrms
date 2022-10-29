     {{-- project management start --}}
     @if (hasPermission('client_menu'))
     <li class="nav-item has-submenu {{ set_menu([route('project.index')]) }}">
         <a href="javascript:void(0)" class="nav-link d-flex align-items-center">
             <div class="icon-badge-circle">
                 <i class="nav-icon bi bi bi-people"></i>
                 
             </div>
             <span class="nav-link-text ml-3 font-purple">
                 {{ _trans('client.Clients') }}
                 <i class="down fas fa-angle-down"></i>
             </span>
         </a>
         <ul class="submenu collapse {{ set_active(['admin/client*']) }}">

            @if (hasPermission('client_list'))
                 <li class="nav-item {{ menu_active_by_route(['client.index']) }}">
                     <a href="{{ route('client.index') }}" class="nav-link">
                         <span> {{ _trans('common.List') }}</span>
                     </a>
                 </li>
             @endif
             @if (hasPermission('client_create'))
                 <li class="nav-item {{ menu_active_by_route(['client.create']) }}">
                     <a href="{{ route('client.create') }}" class="nav-link">
                         <span> {{ _trans('common.Create') }}</span>
                     </a>
                 </li>
             @endif


         </ul>
     </li>
 @endif