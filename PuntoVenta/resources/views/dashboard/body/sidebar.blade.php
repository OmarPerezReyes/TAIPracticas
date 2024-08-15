
<div class="iq-sidebar sidebar-default" style="background: #F7FDFF">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid rounded-normal light-logo" alt="logo"><h5 class="logo-title light-logo ml-3"></h5>
        </a>
        <div class="iq-menu-bt-sidebar ml-0">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="svg-icon">
                        <svg  class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Inicio</span>
                    </a>
                </li>

                @if (auth()->user()->can('pos.menu'))
                <li class="{{ Request::is('pos*') ? 'active' : '' }}">
                    <a href="{{ route('pos.index') }}" class="svg-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="ml-3">Venta</span>
                    </a>
                </li>
                @endif
                            
                @if (auth()->user()->can('stock.manage'))
                    <li class="{{ Request::is('stocks*') ? 'active' : '' }}">
                        <a href="{{ route('stocks.index') }}" class="svg-icon">
                            <i class="fa-solid fa-box"></i>
                            <span class="ml-3">Stock</span>
                        </a>
                    </li>
                @endif
               
                @if (auth()->user()->can('stock.manage'))
                    <li class="{{ Request::is('compra*') ? 'active' : '' }}">
                        <a href="{{ route('compra.index') }}" class="svg-icon">
                            <i class="fa-solid fa-box"></i>
                            <span class="ml-3">Compra</span>
                        </a>
                    </li>
                @endif
                <hr>

                @if (auth()->user()->can('employee.menu'))
                    <li class="{{ Request::is(['products']) ? 'active' : '' }}">
                        <a href="{{ route('products.index') }}" class="svg-icon">
                            <i class="fa-solid fa-box"></i><span>Productos</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('employee.menu'))
                    <li class="{{ Request::is(['categories*']) ? 'active' : '' }}">
                        <a href="{{ route('categories.index') }}" class="svg-icon">
                            <i class="fa-solid fa-tags"></i><span>Categorias</span>
                        </a>
                    </li>
                @endif

                <hr>
                @if (auth()->user()->can('employee.menu'))
                    <li class="{{ Request::is(['payment-methods*']) ? 'active' : '' }}">
                        <a href="{{ route('payment_methods.index') }}" class="svg-icon">
                            <i class="fa-solid fa-credit-card"></i><span>Métodos de Pago</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('employee.menu'))
                    <li class="{{ Request::is(['crudorders*']) ? 'active' : '' }}">
                        <a href="{{ route('crudorders.index') }}" class="svg-icon">
                            <i class="fa-solid fa-box"></i><span>Órdenes</span>
                        </a>
                    </li>
                @endif

                <hr>


                @if (auth()->user()->can('employee.menu'))
                    <li class="{{ Request::is('employees*') ? 'active' : '' }}">
                        <a href="{{ route('employees.index') }}" class="svg-icon">
                            <i class="fa-solid fa-users"></i>
                            <span class="ml-3">Vendedores</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->can('customer.menu'))
                <li class="{{ Request::is('customers*') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Clientes</span>
                    </a>
                </li>
                @endif

                @if (auth()->user()->can('supplier.menu'))
                <li class="{{ Request::is('suppliers*') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Proveedores</span>
                    </a>
                </li>
                @endif

               <!-- <hr>
               

                @if (auth()->user()->can('user.menu'))
                <li class="{{ Request::is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Usuarios</span>
                    </a>
                </li>
                @endif-->

            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
