<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        @role('admin')
            
            <li class="nav-item">
                <a href="{{ route('admin.supplier.index') }}"
                    class="nav-link {{ Route::is('admin.supplier.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cart-plus"></i>
                    <p>Suppliers</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.department.index') }}"
                    class="nav-link {{ Route::is('admin.department.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-university"></i>
                    <p>Departments</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.customer.index') }}"
                    class="nav-link {{ Route::is('admin.customer.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Customers</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.item.index') }}"
                    class="nav-link {{ Route::is('admin.item.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Item Management</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.bundle.index') }}"
                    class="nav-link {{ Route::is('admin.bundle.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Bundle Management
                        <!-- <span class="badge badge-secondary right">{{ $SubCategoryCount }}</span> -->
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('admin/quotation') }}"
                    class="nav-link {{ Route::is('admin.quotation.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-gavel"></i>
                    <p>Quotation Management</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.collection.index') }}"
                    class="nav-link {{ Route::is('admin.collection.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-print"></i>
                    <p>Reports</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.role.index') }}"
                    class="nav-link {{ Route::is('admin.config.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>User Management
                    <i class="right fas fa-angle-down"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item {{ Route::is('admin.user.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.user.index') }}" class="nav-link" id="level2item">
                            <i class="nav-icon fas fa-circle-o"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('admin.role.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.role.index') }}" class="nav-link" id="level2item">
                            <i class="nav-icon fas fa-circle-o"></i>
                            <p>Role</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('admin.permission.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.permission.index') }}" class="nav-link" id="level2item">
                            <i class="nav-icon fas fa-circle-o"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.role.index') }}"
                    class="nav-link {{ Route::is('admin.config.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>Configurations
                    <i class="right fas fa-angle-down"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.location.index') }}" class="nav-link" id="level2item">
                            <i class="nav-icon fas fa-circle-o"></i>
                            <p>Locations</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.vat.index') }}" class="nav-link" id="level2item">
                            <i class="nav-icon fas fa-circle-o"></i>
                            <p>VAT</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endrole

        @role('user')

        <li class="nav-item">
                <a href="{{ route('admin.product.index') }}"
                    class="nav-link {{ Route::is('admin.supplier.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cart-plus"></i>
                    <p>Suppliers</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.product.index') }}"
                    class="nav-link {{ Route::is('admin.department.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-university"></i>
                    <p>Departments</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.product.index') }}"
                    class="nav-link {{ Route::is('admin.product.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Item Management</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.quotation.index') }}"
                    class="nav-link {{ Route::is('admin.quotation.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-gavel"></i>
                    <p>Quotation Management</p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.role.index') }}"
                    class="nav-link {{ Route::is('admin.config.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>User Management
                    <i class="right fas fa-angle-down"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item {{ Route::is('admin.user.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.user.index') }}" class="nav-link" id="level2item">
                            <i class="nav-icon fas fa-circle-o"></i>
                            <p>Users</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endrole
    </ul>
</nav>
