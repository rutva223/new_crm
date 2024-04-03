<li class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard')); ?>" class="">
        <i class="fa fa-dashboard"></i><span class="nav-text ">Dashboard</span>
    </a>
</li>

<li class="<?php echo e(request()->is('users') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('users.index')); ?>" class="">
        <i class="fa fa-users"></i><span class="nav-text ">Users</span>
    </a>
</li>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage roles')): ?>
    <li class="<?php echo e(request()->is('roles') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('roles.index')); ?>" class="">
            <i class="fa fa-sitemap"></i><span class="nav-text ">Roles</span>
        </a>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage contacts')): ?>
<li class="<?php echo e(request()->is('contacts') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('contacts.index')); ?>" class="">
        <i class="fa fa-address-card"></i><span class="nav-text">Contacts</span>
    </a>
</li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage product')): ?>
    <li class="<?php echo e(request()->is('products') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('products.index')); ?>" class="">
            <i class="fa fa-list-check"></i><span class="nav-text ">Product & Service</span>
        </a>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage deal')): ?>
    <li class="<?php echo e((Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index') ? ' active mm-active' : ''); ?>" >
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">Sales</span>
        </a>
        <ul aria-expanded="false">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage deal')): ?>
                <li><a href="<?php echo e(route('deals.index')); ?>">Deal</a></li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage leads')): ?>
                <li><a href="<?php echo e(route('leads.index')); ?>">Lead</a></li>
            <?php endif; ?>
            
                <li class="<?php echo e((Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index') ? ' active mm-active' : ''); ?>">
                    <a href="<?php echo e(route('labels.index')); ?>" class="<?php echo e((Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index') ? 'mm-active' : ''); ?>">Deal/Lead Setting</a>
                </li>
            
        </ul>
    </li>
<?php endif; ?>
<li class="<?php echo e((Request::route()->getName() == 'branch.index' ||Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'department.index' || Request::route()->getName() == 'designation.index') ? ' active mm-active' : ''); ?>" >
    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
        <i class="fa fa-store"></i>
        <span class="nav-text">HRM</span>
    </a>
    <ul aria-expanded="false">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage branch')): ?>
            <li><a href="<?php echo e(route('branch.index')); ?>">Employee</a></li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage branch')): ?>
            <li><a href="<?php echo e(route('branch.index')); ?>">Branch</a></li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage department')): ?>
            <li><a href="<?php echo e(route('department.index')); ?>">Department</a></li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage department')): ?>
            <li><a href="<?php echo e(route('department.index')); ?>">Department</a></li>
        <?php endif; ?>
    </ul>
</li>

<?php /**PATH C:\xampp\htdocs\new_crm\resources\views/partials/admin/sidebar.blade.php ENDPATH**/ ?>