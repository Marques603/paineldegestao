<aside class="sidebar">
    <!-- Sidebar Header Starts -->
    <a href="{{ route('dashboard') }}">
        <div class="sidebar-header">
            <div class="sidebar-logo-icon">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </div>

            <div class="sidebar-logo-text">
                <h1 class="flex text-xl">
                    <span class="font-bold text-slate-800 dark:text-slate-200"> Ap </span>
                    <span class="font-semibold text-primary-500">pz</span>
                </h1>

                <p class="whitespace-nowrap text-xs text-slate-400"> ... &amp; ...</p>
            </div>
        </div>
    </a>
    <!-- Sidebar Header Ends -->

    <!-- Sidebar Menu Starts -->
    <ul class="sidebar-content">
        <!-- Dashboard -->

        <li>
            <a href="javascript:void(0);"
                class="sidebar-menu  {{ request()->routeIs('dashboard', '#') ? 'active' : '' }}">
                <span class="sidebar-menu-icon">
                    <i data-feather="home"></i>
                </span>
                <span class="sidebar-menu-text">Home</span>
                <span class="sidebar-menu-arrow">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="sidebar-submenu">
                <li>
                    <a href="#"
                        class="sidebar-submenu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                </li>
               <!--  <li>
                    <a href="#  "
                        class="sidebar-submenu-item {{ request()->routeIs('#') ? 'active' : '' }}">Ecommerce</a>
                </li>-->
            </ul>
        </li>
        <div class="sidebar-menu-header">Aplicação</div>

        <!-- Menu Tecnologia -->
        
        <li>
        @can('view', App\Models\Menu::find(1)) 
            <a href="javascript:void(0);"
                class="sidebar-menu {{ request()->routeIs(['users.index', 'company.index','menus.index','sector.index','menus.index']) ? 'active' : '' }}">

                <span class="sidebar-menu-icon">
                    <i data-feather="cpu"></i>
                </span>
                <span class="sidebar-menu-text">Gestão Tecnologia</span>
                <span class="sidebar-menu-arrow">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="sidebar-submenu ">
                <li>
                    <a href="{{ route('users.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        Usuários</a>            
                </li>
                <li>
                    <a href="{{ route('sector.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('sector.index') ? 'active' : '' }}">
                        Setores</a>
                </li>
                <li>
                    <a href="{{ route('company.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('company.index') ? 'active' : '' }}">
                        Empresa</a>
                </li>
            </ul>
            @endcan
        </li>
               <!-- Menu Qualidade -->
        <li>
        @can('view', App\Models\Menu::find(2)) 
            <a href="javascript:void(0);"
                class="sidebar-menu {{ request()->routeIs(['documents.index', 'macro.index'])
                    ? 'active'
                    : '' }}">
                <span class="sidebar-menu-icon">
                    <i data-feather="archive"></i>
                </span>
                <span class="sidebar-menu-text">Gestão Documentos</span>
                <span class="sidebar-menu-arrow">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="sidebar-submenu">
                <li>
                    <a href="{{ route('documents.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('documents.index') ? 'active' : '' }}">
                        Documentos </a>
                </li>
                <li>
                    <a href="{{ route('macro.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('macro.index') ? 'active' : '' }}">
                        Macros</a>
                </li>
                <li>
                    <a href="{{ route('macro.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('macro.index') ? 'active' : '' }}">
                        RNC</a>
                </li>
            </ul>
            @endcan
        </li>
        <!-- Recursos -->
                 <li>
            @can('view', App\Models\Menu::find(3))    
            <a href="javascript:void(0);"
                class="sidebar-menu {{ request()->routeIs(['cost_center','position.index']) ? 'active' : '' }}">

                <span class="sidebar-menu-icon">
                    <i data-feather="heart"></i>
                </span>
                <span class="sidebar-menu-text">Gestão HCM</span>
                <span class="sidebar-menu-arrow">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="sidebar-submenu ">
                <li>
                    <a href="{{ route('cost_center.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('cost_center.index') ? 'active' : '' }}">
                        Centro de Custo</a>
                </li>
                <li>
                    <a href="{{ route('position.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('position.index') ? 'active' : '' }}">
                        Cargos</a>
                </li>
           </ul>
              @endcan
        </li>
        <li>
            
            @can('view', App\Models\Menu::find(4))    
            <a href="javascript:void(0);"
                class="sidebar-menu {{ request()->routeIs(['compras.create.com.item','compras.index','item.create','item.index']) ? 'active' : '' }}">

                <span class="sidebar-menu-icon">
                    <i data-feather="shopping-cart"></i>
                </span>
                <span class="sidebar-menu-text">Gestão de Compras</span>
                <span class="sidebar-menu-arrow">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="sidebar-submenu ">
                <li>
                    <a href="{{ route('compras.create.com.item') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('compras.create.com.item') ? 'active' : '' }}">
                        Requsição</a>
                </li>
                <li>
                    <a href="{{ route('compras.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('compras.index') ? 'active' : '' }}">
                        Pedidos</a>
                </li>

                <li>
                    <a href="{{ route('item.create') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('item.create') ? 'active' : '' }}">
                        Cadastro de Item</a>
                </li>

                <li>
                    <a href="{{ route('item.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('item.index') ? 'active' : '' }}">
                        Itens</a>
                </li>
           </ul>
              @endcan
               <li>
            @can('view', App\Models\Menu::find(4))    
            <a href="javascript:void(0);"
                class="sidebar-menu {{ request()->routeIs(['vehicles.index', 'vehicles.create', 'vehicles.edit']) ? 'active' : '' }}">

                <span class="sidebar-menu-icon">
                    <i data-feather="clipboard"></i>
                </span>
                <span class="sidebar-menu-text">Veiculos</span>
                <span class="sidebar-menu-arrow">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="sidebar-submenu ">
                <li>
                    <a href="{{ route('vehicles.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('vehicles.index') ? 'active' : '' }}">
                        Veículos</a>
                </li>
                <li>
                    <a href="{{ route('vehicles.create') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('vehicles.create') ? 'active' : '' }}">
                        Adicionar Veículos</a>
                </li>
           </ul>
              @endcan
        </li>
         <!-- Menu Qualidade -->
        <li>
        @can('view', App\Models\Menu::find(2)) 
            <a href="javascript:void(0);"
                class="sidebar-menu {{ request()->routeIs(['concierge.index', 'concierge.create'])
                    ? 'active'
                    : '' }}">
                <span class="sidebar-menu-icon">
                    <i data-feather="home"></i>
                </span>
                <span class="sidebar-menu-text">Gestão da Portaria</span>
                <span class="sidebar-menu-arrow">
                    <i data-feather="chevron-right"></i>
                </span>
            </a>
            <ul class="sidebar-submenu">
                <li>
                    <a href="{{ route('concierge.index') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('concierge.index') ? 'active' : '' }}">
                    Fluxo</a>
                </li>
                <li>
                    <a href="{{ route('concierge.create') }}"
                        class="sidebar-submenu-item {{ request()->routeIs('concierge.create') ? 'active' : '' }}">
                    Controle do Fluxo</a>
                </li>
            </ul>
            @endcan
        </li>
</aside>
