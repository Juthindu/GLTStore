<div class="sidebar">
    <div class="site-width">

        <!-- START: Menu-->
        <ul id="side-menu" class="sidebar-menu">
            <li class="dropdown"><a href="#"><i class="icon-home mr-1"></i> Dashboard</a>
                <ul>
                    <li class="{{ $page_option['sub'] === 'dash' ? 'active' : '' }}"><a href="{{ route('home') }}"><i
                                class="fa fa-rocket"></i> Dashboard</a></li>
                    <li><a href="{{ route('user.profile') }}"><i class="icon-layers"></i> My Account</a></li>
                </ul>
            </li>

            <li class="dropdown"><a href="#"><i class="icon-box mr-1"></i>Inventory</a>
                <ul>
                    <li class="dropdown {{ $page_option['main'] === 'inventory' ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-warehouse"></i>Manage Inventory</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'inventory_create' ? 'active' : '' }}">
                                <a href="{{ route('inventory.create') }}">Add New Stock</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'inventory_manage' ? 'active' : '' }}">
                                <a href="{{ route('inventory.manage') }}">View Stock</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'inventory_adjust' ? 'active' : '' }}">
                                <a href="{{ route('inventory.adjust') }}">Adjust Stock</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="dropdown"><a href="#"><i class="icon-cart mr-1"></i>Orders</a>
                <ul>
                    <li class="dropdown {{ $page_option['main'] === 'orders' ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-shopping-basket"></i>Manage Orders</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'orders_create' ? 'active' : '' }}">
                                <a href="{{ route('orders.create') }}">Create New Order</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'orders_manage' ? 'active' : '' }}">
                                <a href="{{ route('orders.manage') }}">View All Orders</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'orders_status' ? 'active' : '' }}">
                                <a href="{{ route('orders.status') }}">Update Order Status</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="dropdown"><a href="#"><i class="icon-users mr-1"></i>Customers</a>
                <ul>
                    <li class="dropdown {{ $page_option['main'] === 'customers' ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-user"></i>Manage Customers</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'customers_create' ? 'active' : '' }}">
                                <a href="{{ route('customers.create') }}">Add New Customer</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'customers_manage' ? 'active' : '' }}">
                                <a href="{{ route('customers.manage') }}">View Customers</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'customers_update' ? 'active' : '' }}">
                                <a href="{{ route('customers.update') }}">Update Customers</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#"><i class="icon-leaf mr-1"></i>Tea Types</a>
                <ul>
                    <li class="dropdown {{ $page_option['main'] === 'tea_types' ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-mug-hot"></i>Manage Tea Types</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'tea_types_create' ? 'active' : '' }}">
                                <a href="{{ route('tea_types.create') }}">Add New Tea Type</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'tea_types_view' ? 'active' : '' }}">
                                <a href="{{ route('tea_types.view') }}">View Tea Types</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'tea_types_update' ? 'active' : '' }}">
                                <a href="{{ route('tea_types.update') }}">Edit Tea Type</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>


            <li class="dropdown"><a href="#"><i class="icon-organization mr-1"></i>Permissions & Users</a>
                <ul>
                    <li class="dropdown {{ $page_option['main'] === 'permission' ? 'active' : '' }}"><a
                            href="#"><i class="fas fa-sitemap"></i>Roles & Permissions</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'permission_index' ? 'active' : '' }}"><a
                                    href="{{ route('permission.index') }}">Manage</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {{ $page_option['main'] === 'user' ? 'active' : '' }}"><a href="#"><i
                                class="fas fa-user-tie"></i> Users</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'user_create' ? 'active' : '' }}"><a
                                    href="{{ route('user.create') }}">Create New User</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'user_index' ? 'active' : '' }}"><a
                                    href="{{ route('user.index') }}">View All Users</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {{ $page_option['main'] === 'branch' ? 'active' : '' }}"><a href="#"><i
                                class="fas fa-sitemap"></i>Branch Management</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'branch_create' ? 'active' : '' }}"><a
                                    href="{{ route('branch.create') }}">Create New Branch</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'branch_index' ? 'active' : '' }}"><a
                                    href="{{ route('branch.index') }}">View All Branches</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END: Menu-->
        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0 ml-auto">
            <li class="breadcrumb-item"><a href="#">Application</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>
    </div>
</div>
