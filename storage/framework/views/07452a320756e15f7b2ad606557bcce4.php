<li class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard')); ?>" class="">
        <i class="fa fa-dashboard"></i><span class="nav-text ">Dashboard</span>
    </a>
</li>
<?php if(\Auth::user()->type == 'super admin'): ?>
    <li class="<?php echo e(request()->is('users') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('users.index')); ?>" class="">
            <i class="fa fa-users"></i><span class="nav-text ">Company</span>
        </a>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company'): ?>
    <li
        class="<?php echo e(Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : ''); ?>">
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">Staff</span>
        </a>
        <ul aria-expanded="false">
            
            <li><a href="<?php echo e(route('employee.index')); ?>">Employee</a></li>
            
            
            <li><a href="<?php echo e(route('client.index')); ?>">Client</a></li>
            

        </ul>
    </li>
<?php elseif(\Auth::user()->type == 'employee'): ?>
    <li class="<?php echo e(request()->is('employee') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('employee.show', \Crypt::encrypt(\Auth::user()->id))); ?>" class="">
            <i class="fa fa-sitemap"></i><span class="nav-text ">My Profile</span>
        </a>
    </li>
<?php elseif(\Auth::user()->type == 'client'): ?>
    <li class="<?php echo e(request()->is('client') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('client.show', \Crypt::encrypt(\Auth::user()->id))); ?>" class="">
            <i class="fa fa-sitemap"></i><span class="nav-text ">My Profile</span>
        </a>
    </li>
<?php endif; ?>
<li class="<?php echo e(request()->is('users') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('users.index')); ?>" class="">
        <i class="fa fa-users"></i><span class="nav-text ">Users</span>
    </a>
</li>

<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
    <li
        class="<?php echo e(Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : ''); ?>">
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">HR</span>
        </a>
        <ul aria-expanded="false">
            <?php if(\Auth::user()->type == 'company'): ?>
                <li
                    class="<?php echo e(Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : ''); ?>">
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <span class="nav-text">Attendance</span>
                    </a>
                    <ul aria-expanded="false">

                        
                        <li><a href="<?php echo e(route('attendance.index')); ?>">Attendance</a></li>
                        
                        
                        <li><a href="<?php echo e(route('bulk.attendance')); ?>">Bulk Attendance</a></li>
                        

                    </ul>
                </li>
            <?php elseif(\Auth::user()->type == 'employee'): ?>
                <li class="<?php echo e(request()->is('attendance') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('attendance.index')); ?>" class="">
                        <i class="fa fa-sitemap"></i><span class="nav-text ">Attendance</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <li><a href="<?php echo e(route('holiday.index')); ?>">Holiday</a></li>
            
            
            <li><a href="<?php echo e(route('leave.index')); ?>">Leave</a></li>
            
            <li><a
                    href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('meeting')) ? route(\Auth::user()->getDefualtViewRouteByModule('meeting')) : route('meeting.index')); ?>">Meeting</a>
            </li>
            <li><a href="<?php echo e(route('account-assets.index')); ?>">Asset</a></li>
            <li><a href="<?php echo e(route('document-upload.index')); ?>">Document</a></li>
            <li><a href="<?php echo e(route('company-policy.index')); ?>">Company Policy</a></li>
            <li class="">
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <span class="nav-text">HR Admin</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('award.index')); ?>">Award</a></li>
                    <li><a href="<?php echo e(route('transfer.index')); ?>">Transfer</a></li>
                    <li><a href="<?php echo e(route('resignation.index')); ?>">Resignation</a></li>
                    <li><a href="<?php echo e(route('trip.index')); ?>">Trip</a></li>
                    <li><a href="<?php echo e(route('promotion.index')); ?>">Promotion</a></li>
                    <li><a href="<?php echo e(route('complaint.index')); ?>">Complaints</a></li>
                    <li><a href="<?php echo e(route('warning.index')); ?>">Warning</a></li>
                    <li><a href="<?php echo e(route('termination.index')); ?>">Termination</a></li>
                </ul>
            </li>
            <li class="">
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <span class="nav-text">Performance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('indicator.index')); ?>">Indicator</a></li>
                    <li><a href="<?php echo e(route('appraisal.index')); ?>">Appraisal</a></li>
                    <li><a href="<?php echo e(route('goaltracking.index')); ?>">Goal Tracking</a></li>
                </ul>
            </li>
            <li
                class="<?php echo e(Request::segment(1) == 'training' || Request::segment(1) == 'trainer' ? 'active dash-trigger' : ''); ?>">
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <span class="nav-text">Training</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="<?php echo e(Request::segment(1) == 'training' ? 'active' : ''); ?>"
                            href="<?php echo e(route('training.index')); ?>">Training List</a></li>
                    <li><a class="<?php echo e(Request::segment(1) == 'trainer' ? 'active' : ''); ?>"
                            href="<?php echo e(route('trainer.index')); ?>">Trainer</a></li>
                </ul>
            </li>
        </ul>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client'): ?>
    <li
        class="<?php echo e(Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active dash-trigger' : ''); ?>">
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">PreSale</span>
        </a>
        <ul aria-expanded="false">
            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                <li><a
                        href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('lead')) ? route(\Auth::user()->getDefualtViewRouteByModule('lead')) : route('lead.index')); ?>">Lead</a>
                </li>
            <?php endif; ?>
            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client'): ?>
                <li><a
                        href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('deal')) ? route(\Auth::user()->getDefualtViewRouteByModule('deal')) : route('deal.index')); ?>">Deal</a>
                </li>
                <li><a class="<?php echo e(Request::segment(1) == 'estimate' ? 'active' : ''); ?>"
                        href="<?php echo e(route('estimate.index')); ?>">Estimation</a></li>
            <?php endif; ?>
            <?php if(\Auth::user()->type == 'company'): ?>
                <li><a class="<?php echo e(Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active' : ''); ?>"
                        href="<?php echo e(route('form_builder.index')); ?>">Form Builder</a></li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
    <li
        class="<?php echo e(Request::segment(1) == 'project' || Request::segment(1) == 'allTask' || Request::segment(1) == 'allTimesheet' ? 'active dash-trigger' : ''); ?>">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-list-check"></i><span class="nav-text">Project</span></a>
        <ul aria-expanded="false">
            <li
                class="<?php echo e(Request::segment(1) == 'project' && Request::segment(2) != 'allTask' && Request::segment(2) != 'allTaskKanban' && Request::segment(2) != 'allTimesheet' ? 'active  dash-trigger' : ''); ?>">
                <a class="" href="<?php echo e(route('project.index')); ?>"><?php echo e(__('All Project')); ?></a>
            </li>
            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                <li
                    class="<?php echo e(Request::segment(2) == 'allTask' || Request::segment(2) == 'allTaskKanban' ? 'active' : ''); ?>">
                    <a class=""
                        href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('all task')) ? route(\Auth::user()->getDefualtViewRouteByModule('all task')) : route('project.all.task')); ?>"><?php echo e(__('Task')); ?></a>
                </li>
                <li class="<?php echo e(Request::segment(2) == 'allTimesheet' ? 'active' : ''); ?>">
                    <a class="" href="<?php echo e(route('project.all.timesheet')); ?>"><?php echo e(__('Timesheets')); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
    <li
        class="dash-item <?php echo e(Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : ''); ?>">
        <a href="<?php echo e(route('project_report.index')); ?>" class="has-arrow"><i
                    class="fa fa-chart-line"></i><span class="nav-text"><?php echo e(__('Project Report')); ?></span></a>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company'): ?>
    <li class="dash-item ">
        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('item')) ? route(\Auth::user()->getDefualtViewRouteByModule('item')) : route('item.index')); ?>"
            class="has-arrow"><i class="fa fa-apps"></i><span
                class="nav-text"><?php echo e(__('Items')); ?></span></a>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company'): ?>
    <li class="dash-item">
        <a href="<?php echo e(route('itemstock.index')); ?>" class="has-arrow"><i
                    class="fa fa-clipboard-check"></i><span
                class="nav-text"><?php echo e(__('Item Stock')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client'): ?>
    <li
        class="<?php echo e(Request::segment(1) == 'invoice' || Request::segment(1) == 'payment' || Request::segment(1) == 'creditNote' || Request::segment(1) == 'expense' ? 'active dash-trigger' : ''); ?>">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-stairs-up"></i><span
                class="nav-text"><?php echo e(__('Sale')); ?></span></a>
        <ul aria-expanded="false">
            <li class=" <?php echo e(Request::segment(1) == 'invoice' ? 'active' : ''); ?>">
                <a
                    href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('invoice')) ? route(\Auth::user()->getDefualtViewRouteByModule('invoice')) : route('invoice.index')); ?>"><?php echo e(__('Invoices')); ?></a>
            </li>
            <li class=" <?php echo e(Request::segment(1) == 'payment' ? 'active ' : ''); ?>">
                <a href="<?php echo e(route('payment.index')); ?>"><?php echo e(__('Payment')); ?></a>
            </li>
            <li class=" <?php echo e(Request::segment(1) == 'creditNote' ? 'active' : ''); ?>">
                <a href="<?php echo e(route('creditNote.index')); ?>"><?php echo e(__('Credit Notes')); ?></a>
            </li>
            <?php if(\Auth::user()->type == 'company'): ?>
                <li class=" <?php echo e(Request::segment(1) == 'expense' ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('expense.index')); ?>"><?php echo e(__('Expense')); ?></a>
                </li>
            <?php endif; ?>

        </ul>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company'): ?>
    <li class="dash-item <?php echo e(request()->is('budget*') ? 'active' : ''); ?>">
        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('budget')) ? route(\Auth::user()->getDefualtViewRouteByModule('budget')) : route('budget.index')); ?>"><i class="fa fa-businessplan"></i><span
                class="nav-text"><?php echo e(__('Budget Planner')); ?></span></a>
    </li>

    <li class="dash-item <?php echo e(request()->is('timetracker*') ? 'active' : ''); ?>">
        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('timetracker')) ? route(\Auth::user()->getDefualtViewRouteByModule('timetracker')) : route('timetracker.index')); ?>"><i class="fa fa-alarm"></i><span
                class="nav-text"><?php echo e(__('Tracker')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type != 'super admin'): ?>
    <li class="dash-item <?php echo e(request()->is('zoommeeting*') ? 'active' : ''); ?>">
        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('zoommeeting')) ? route(\Auth::user()->getDefualtViewRouteByModule('zoommeeting')) : route('zoommeeting.index')); ?>"><i class="fa fa-video-plus"></i><span
                class="nav-text"><?php echo e(__('Zoom Metting')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client'): ?>
    <li class="dash-item <?php echo e(request()->is('contract*') ? 'active' : ''); ?>">
        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('contract')) ? route(\Auth::user()->getDefualtViewRouteByModule('contract')) : route('contract.index')); ?>"><i class="fa fa-device-floppy"></i><span
                class="nav-text"><?php echo e(__('Contract')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company'): ?>
    <li
        class="<?php echo e(Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' || Request::segment(2) == 'balance-sheet' || Request::segment(2) == 'trial-balance' ? 'active dash-trigger' : ''); ?>">
        <a href="javascript:void(0);" aria-expanded="false"
            class="has-arrow <?php echo e(Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' || Request::segment(2) == 'balance-sheet' || Request::segment(2) == 'trial-balance' ? 'show' : ''); ?>"><i class="fa fa-forms"></i><span
                class="nav-text"><?php echo e(__('Double Entry')); ?></span></a>
        <ul aria-expanded="false">
            <li class="dash-item <?php echo e(request()->is('chart-of-account*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('chart-of-account.index')); ?>"><?php echo e(__('Chart of Accounts')); ?></a>
            </li>
            <li class="dash-item <?php echo e(request()->is('journal-entry*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('journal-entry.index')); ?>"><?php echo e(__('Journal Account')); ?></a>
            </li>
            <li class="dash-item <?php echo e(request()->is('report.ledger*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('report.ledger')); ?>"><?php echo e(__('Ledger Summary')); ?></a>
            </li>
            <li class="dash-item <?php echo e(request()->is('report.balance.sheet*') ? 'active' : ''); ?> ">
                <a href="<?php echo e(route('report.balance.sheet')); ?>"><?php echo e(__('Balance Sheet')); ?></a>
            </li>
            <li class="dash-item <?php echo e(request()->is('trial.balance*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('trial.balance')); ?>"><?php echo e(__('Trial Balance')); ?></a>
            </li>
        </ul>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client'): ?>
    <li class="dash-item">
        <a href="<?php echo e(url('chats')); ?>" ><i
                    class="fa fa-brand-hipchat"></i><span class="nav-text"><?php echo e(__('Messenger')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
    <li class="dash-item <?php echo e(request()->is('support*') ? 'active' : ''); ?>">
        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('support')) ? route(\Auth::user()->getDefualtViewRouteByModule('support')) : route('support.index')); ?>"
            ><i class="fa fa-headset"></i><span
                class="nav-text"><?php echo e(__('Support')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
    <li class="dash-item">
        <a href="<?php echo e(route('event.index')); ?>" ><i
                    class="fa fa-calendar-event"></i><span class="nav-text"><?php echo e(__('Event')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
    <li class="dash-item">
        <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('notice board')) ? route(\Auth::user()->getDefualtViewRouteByModule('notice board')) : route('noticeBoard.index')); ?>"
            ><i class="fa fa-clipboard-list"></i><span
                class="nav-text"><?php echo e(__('Notice Board')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company'): ?>
    <li class="dash-item">
        <a href="<?php echo e(url('goal')); ?>" ><i
                    class="fa fa-award"></i><span class="nav-text"><?php echo e(__('Goal')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
    <li class="dash-item <?php echo e(request()->is('note*') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('note.index')); ?>" ><i
                    class="fa fa-note"></i><span class="nav-text"><?php echo e(__('Note')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company'): ?>
    <li class="">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow"><i class="fa fa-chart-dots"></i><span
                class="nav-text"><?php echo e(__('Report')); ?></span></a>
        <ul aria-expanded="false">
            <li class="dash-item">
                <a href="<?php echo e(route('report.attendance')); ?>"><?php echo e(__('Attendance')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.task')); ?>"><?php echo e(__('Task')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.income.expense')); ?>"><?php echo e(__('Income Vs Expense')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.timelog')); ?>"><?php echo e(__('Time Log')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.finance')); ?>"><?php echo e(__('Finance')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.leave')); ?>"><?php echo e(__('Leave')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.estimate')); ?>"><?php echo e(__('Estimate')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.invoice')); ?>"><?php echo e(__('Invoice')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.client')); ?>"><?php echo e(__('Client')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('report.lead')); ?>"><?php echo e(__('Lead')); ?></a>
            </li>

            <li class="dash-item">
                <a href="<?php echo e(route('report.deal')); ?>"><?php echo e(__('Deal')); ?></a>
            </li>

            <li class="dash-item">
                <a href="<?php echo e(route('report.product.stock.report')); ?>"><?php echo e(__('Item Stock')); ?></a>
            </li>

        </ul>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company'): ?>
    <li class="dash-item <?php if(str_contains(request()->url(), 'stripe')): ?> active <?php endif; ?>">
        <a href="<?php echo e(route('plan.index')); ?>" ><i
                    class="fa fa-trophy"></i><span class="nav-text"><?php echo e(__('Plan')); ?></span></a>
    </li>
<?php endif; ?>


<?php if(\Auth::user()->type == 'super admin'): ?>
    <li class="dash-item">
        <a href="<?php echo e(route('plan_request.index')); ?>" ><i
                    class="fa fa-git-pull-request"></i><span
                class="nav-text"><?php echo e(__('Plan Request')); ?></span></a>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'super admin'): ?>
    <li class="dash-item <?php echo e(Request::segment(1) == 'referral-program' ? 'active' : ''); ?>">
        <a href="<?php echo e(route('referral.index')); ?>" ><i
                    class="fa fa-trophy"></i><span class="nav-text"><?php echo e(__('Referral Program')); ?></span></a>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'company'): ?>
    <li class="dash-item <?php echo e(Request::segment(1) == 'referral-program' ? 'active' : ''); ?>">
        <a href="<?php echo e(route('guideline.index')); ?>" ><i
                    class="fa fa-trophy"></i><span class="nav-text"><?php echo e(__('Referral Program')); ?></span></a>
    </li>
<?php endif; ?>
<?php if(\Auth::user()->type == 'super admin'): ?>
    <li class="dash-item <?php echo e(Request::segment(1) == 'coupon' ? 'active' : ''); ?>">
        <a href="<?php echo e(route('coupon.index')); ?>" ><i
                    class="fa fa-clipboard-check"></i><span class="nav-text"><?php echo e(__('Coupon')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company'): ?>
    <li class="dash-item">
        <a href="<?php echo e(route('order.index')); ?>" ><i
                    class="fa fa-shopping-cart"></i><span class="nav-text"><?php echo e(__('Order')); ?></span></a>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'super admin'): ?>
    <li
        class="dash-item <?php echo e(request()->is('email_template*') || request()->is('emailtemplate_lang*') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('manage.email.language', [$emailTemplate->id, \Auth::user()->lang])); ?>"
            ><i class="fa fa-template"></i><span
                class="nav-text"><?php echo e(__('Email Template')); ?></span></a>
    </li>
<?php endif; ?>


<?php if(\Auth::user()->type == 'company'): ?>
    <li class="">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow"><i class="fa fa-circle-square"></i><span
                class="nav-text"><?php echo e(__('Constant')); ?></span></a>
        <ul aria-expanded="false">
            <li class="">
                <a class="has-arrow" href="#"><?php echo e(__('HR')); ?></a>
                <ul aria-expanded="false">
                    <li class="dash-item">
                        <a  href="<?php echo e(route('department.index')); ?>"><?php echo e(__('Department')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a  href="<?php echo e(route('designation.index')); ?>"><?php echo e(__('Designation')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a  href="<?php echo e(route('salaryType.index')); ?>"><?php echo e(__('Salary Type')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a  href="<?php echo e(route('leaveType.index')); ?>"><?php echo e(__('Leave Type')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a  href="<?php echo e(route('award-type.index')); ?>"><?php echo e(__('Award Type')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a
                            href="<?php echo e(route('termination-type.index')); ?>"><?php echo e(__('Termination Type')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a
                            href="<?php echo e(route('training-type.index')); ?>"><?php echo e(__('Training Type')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a
                            href="<?php echo e(route('performanceType.index')); ?>"><?php echo e(__('Performance Type')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a  href="<?php echo e(route('competencies.index')); ?>"><?php echo e(__('Competencies')); ?></a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a class="has-arrow" href="#"><?php echo e(__('PreSale')); ?></a>
                <ul aria-expanded="false">
                    <li class="dash-item">
                        <a href="<?php echo e(route('pipeline.index')); ?>"><?php echo e(__('Pipeline')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a href="<?php echo e(route('leadStage.index')); ?>"><?php echo e(__('Lead Stage')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a href="<?php echo e(route('dealStage.index')); ?>"><?php echo e(__('Deal Stage')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a href="<?php echo e(route('source.index')); ?>"><?php echo e(__('Source')); ?></a>
                    </li>
                    <li class="dash-item">
                        <a href="<?php echo e(route('label.index')); ?>"><?php echo e(__('Label')); ?></a>
                    </li>
                </ul>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('projectStage.index')); ?>"><?php echo e(__('Project Task Stage')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('taxRate.index')); ?>"><?php echo e(__('Tax Rate')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('unit.index')); ?>"><?php echo e(__('Unit')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('category.index')); ?>"><?php echo e(__('Category')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('paymentMethod.index')); ?>"><?php echo e(__('Payment Method')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('contractType.index')); ?>"><?php echo e(__('Contract Type')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('branch.index')); ?>"><?php echo e(__('Branch')); ?></a>
            </li>
            <li class="dash-item">
                <a href="<?php echo e(route('goaltype.index')); ?>"><?php echo e(__('Goal Type')); ?></a>
            </li>
        </ul>
    </li>
<?php endif; ?>

<?php if(\Auth::user()->type == 'company'): ?>
    <li class="dash-item <?php if(str_contains(request()->url(), 'notification-templates')): ?> active <?php endif; ?>">
        <a href="<?php echo e(url('notification-templates')); ?>" class="">
            <span class="nav-text">
                <i class="fa fa-bell"></i>
            </span>
            <span class="nav-text"><?php echo e(__('Notification Templates')); ?></span></a>
    </li>
<?php endif; ?>


<?php if(\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company'): ?>
    <li class="dash-item">
        <a href="<?php echo e(route('settings')); ?>" class=""><i
                    class="fa fa-settings"></i><span class="nav-text"><?php echo e(__('Settings')); ?></span></a>
    </li>
<?php endif; ?>
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
    <li
        class="<?php echo e(Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index' ? ' active mm-active' : ''); ?>">
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
            
            <li
                class="<?php echo e(Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index' ? ' active mm-active' : ''); ?>">
                <a href="<?php echo e(route('labels.index')); ?>"
                    class="<?php echo e(Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index' ? 'mm-active' : ''); ?>">Deal/Lead
                    Setting</a>
            </li>
            
        </ul>
    </li>
<?php endif; ?>
<li
    class="<?php echo e(Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'department.index' || Request::route()->getName() == 'designation.index' ? ' active mm-active' : ''); ?>">
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
            <li>~~<a href="<?php echo e(route('department.index')); ?>">Department</a></li>
        <?php endif; ?>
    </ul>
</li>

<?php /**PATH C:\xampp\htdocs\new_crm\resources\views/partials/admin/sidebar.blade.php ENDPATH**/ ?>