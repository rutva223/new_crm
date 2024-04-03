<li class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="">
        <i class="fa fa-dashboard"></i><span class="nav-text ">Dashboard</span>
    </a>
</li>

<li class="{{ request()->is('users') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}" class="">
        <i class="fa fa-users"></i><span class="nav-text ">Users</span>
    </a>
</li>
@can('manage roles')
    <li class="{{ request()->is('roles') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}" class="">
            <i class="fa fa-sitemap"></i><span class="nav-text ">Roles</span>
        </a>
    </li>
@endcan
@can('manage contacts')
<li class="{{ request()->is('contacts') ? 'active' : '' }}">
    <a href="{{ route('contacts.index') }}" class="">
        <i class="fa fa-address-card"></i><span class="nav-text">Contacts</span>
    </a>
</li>
@endcan
@can('manage product')
    <li class="{{ request()->is('products') ? 'active' : '' }}">
        <a href="{{ route('products.index') }}" class="">
            <i class="fa fa-list-check"></i><span class="nav-text ">Product & Service</span>
        </a>
    </li>
@endcan
@can('manage deal')
    <li class="{{ (Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index') ? ' active mm-active' : '' }}" >
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">Sales</span>
        </a>
        <ul aria-expanded="false">
            @can('manage deal')
                <li><a href="{{ route('deals.index') }}">Deal</a></li>
            @endcan
            @can('manage leads')
                <li><a href="{{ route('leads.index') }}">Lead</a></li>
            @endcan
            {{-- @can('manage leads') --}}
                <li class="{{ (Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index') ? ' active mm-active' : '' }}">
                    <a href="{{ route('labels.index') }}" class="{{ (Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index') ? 'mm-active' : '' }}">Deal/Lead Setting</a>
                </li>
            {{-- @endcan --}}
        </ul>
    </li>
@endif
<li class="{{ (Request::route()->getName() == 'branch.index' ||Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'department.index' || Request::route()->getName() == 'designation.index') ? ' active mm-active' : '' }}" >
    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
        <i class="fa fa-store"></i>
        <span class="nav-text">HRM</span>
    </a>
    <ul aria-expanded="false">
        @can('manage branch')
            <li><a href="{{ route('branch.index') }}">Employee</a></li>
        @endcan
        @can('manage branch')
            <li><a href="{{ route('branch.index') }}">Branch</a></li>
        @endcan
        @can('manage department')
            <li><a href="{{ route('department.index') }}">Department</a></li>
        @endcan
        @can('manage department')
            <li><a href="{{ route('department.index') }}">Department</a></li>
        @endcan
    </ul>
</li>
{{-- @if(Auth::user()->type == 'super admin')
    @can('manage coupon')
        <li class="{{ request()->is('coupons') ? 'active' : '' }}">
            <a href="{{ route('coupons.index') }}" class="">
                <i class="fa fa-users"></i><span class="nav-text ">Coupon</span>
            </a>
        </li>
    @endcan
@endif --}}
