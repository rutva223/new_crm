<li class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="">
        <i class="fa fa-dashboard"></i><span class="nav-text ">Dashboard</span>
    </a>
</li>
@if (\Auth::user()->type == 'super admin')
    <li class="{{ request()->is('users') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="">
            <i class="fa fa-users"></i><span class="nav-text ">Company</span>
        </a>
    </li>
@endif
@if (\Auth::user()->type == 'company')
    <li
        class="{{ Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : '' }}">
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">Staff</span>
        </a>
        <ul aria-expanded="false">
            {{-- @can('manage deal') --}}
            <li><a href="{{ route('employee.index') }}">Employee</a></li>
            {{-- @endcan --}}
            {{-- @can('manage leads') --}}
            <li><a href="{{ route('client.index') }}">Client</a></li>
            {{-- @endcan --}}

        </ul>
    </li>
@elseif(\Auth::user()->type == 'employee')
    <li class="{{ request()->is('employee') ? 'active' : '' }}">
        <a href="{{ route('employee.show', \Crypt::encrypt(\Auth::user()->id)) }}" class="">
            <i class="fa fa-sitemap"></i><span class="nav-text ">My Profile</span>
        </a>
    </li>
@elseif(\Auth::user()->type == 'client')
    <li class="{{ request()->is('client') ? 'active' : '' }}">
        <a href="{{ route('client.show', \Crypt::encrypt(\Auth::user()->id)) }}" class="">
            <i class="fa fa-sitemap"></i><span class="nav-text ">My Profile</span>
        </a>
    </li>
@endif
<li class="{{ request()->is('users') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}" class="">
        <i class="fa fa-users"></i><span class="nav-text ">Users</span>
    </a>
</li>

@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
    <li
        class="{{ Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : '' }}">
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">HR</span>
        </a>
        <ul aria-expanded="false">
            @if (\Auth::user()->type == 'company')
                <li
                    class="{{ Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : '' }}">
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <span class="nav-text">Attendance</span>
                    </a>
                    <ul aria-expanded="false">

                        {{-- @can('manage deal') --}}
                        <li><a href="{{ route('attendance.index') }}">Attendance</a></li>
                        {{-- @endcan --}}
                        {{-- @can('manage leads') --}}
                        <li><a href="{{ route('bulk.attendance') }}">Bulk Attendance</a></li>
                        {{-- @endcan --}}

                    </ul>
                </li>
            @elseif(\Auth::user()->type == 'employee')
                <li class="{{ request()->is('attendance') ? 'active' : '' }}">
                    <a href="{{ route('attendance.index') }}" class="">
                        <i class="fa fa-sitemap"></i><span class="nav-text ">Attendance</span>
                    </a>
                </li>
            @endif
            {{-- @can('manage deal') --}}
            <li><a href="{{ route('holiday.index') }}">Holiday</a></li>
            {{-- @endcan --}}
            {{-- @can('manage leads') --}}
            <li><a href="{{ route('leave.index') }}">Leave</a></li>
            {{-- @endcan --}}
            <li><a
                    href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('meeting')) ? route(\Auth::user()->getDefualtViewRouteByModule('meeting')) : route('meeting.index') }}">Meeting</a>
            </li>
            <li><a href="{{ route('account-assets.index') }}">Asset</a></li>
            <li><a href="{{ route('document-upload.index') }}">Document</a></li>
            <li><a href="{{ route('company-policy.index') }}">Company Policy</a></li>
            <li class="">
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <span class="nav-text">HR Admin</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('award.index') }}">Award</a></li>
                    <li><a href="{{ route('transfer.index') }}">Transfer</a></li>
                    <li><a href="{{ route('resignation.index') }}">Resignation</a></li>
                    <li><a href="{{ route('trip.index') }}">Trip</a></li>
                    <li><a href="{{ route('promotion.index') }}">Promotion</a></li>
                    <li><a href="{{ route('complaint.index') }}">Complaints</a></li>
                    <li><a href="{{ route('warning.index') }}">Warning</a></li>
                    <li><a href="{{ route('termination.index') }}">Termination</a></li>
                </ul>
            </li>
            <li class="">
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <span class="nav-text">Performance</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('indicator.index') }}">Indicator</a></li>
                    <li><a href="{{ route('appraisal.index') }}">Appraisal</a></li>
                    <li><a href="{{ route('goaltracking.index') }}">Goal Tracking</a></li>
                </ul>
            </li>
            <li
                class="{{ Request::segment(1) == 'training' || Request::segment(1) == 'trainer' ? 'active dash-trigger' : '' }}">
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <span class="nav-text">Training</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="{{ Request::segment(1) == 'training' ? 'active' : '' }}"
                            href="{{ route('training.index') }}">Training List</a></li>
                    <li><a class="{{ Request::segment(1) == 'trainer' ? 'active' : '' }}"
                            href="{{ route('trainer.index') }}">Trainer</a></li>
                </ul>
            </li>
        </ul>
    </li>
@endif
@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client')
    <li
        class="{{ Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active dash-trigger' : '' }}">
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="fa fa-store"></i>
            <span class="nav-text">PreSale</span>
        </a>
        <ul aria-expanded="false">
            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
                <li><a
                        href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('lead')) ? route(\Auth::user()->getDefualtViewRouteByModule('lead')) : route('lead.index') }}">Lead</a>
                </li>
            @endif
            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
                <li><a
                        href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('deal')) ? route(\Auth::user()->getDefualtViewRouteByModule('deal')) : route('deal.index') }}">Deal</a>
                </li>
                <li><a class="{{ Request::segment(1) == 'estimate' ? 'active' : '' }}"
                        href="{{ route('estimate.index') }}">Estimation</a></li>
            @endif
            @if (\Auth::user()->type == 'company')
                <li><a class="{{ Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active' : '' }}"
                        href="{{ route('form_builder.index') }}">Form Builder</a></li>
            @endif
        </ul>
    </li>
@endif
@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
    <li
        class="{{ Request::segment(1) == 'project' || Request::segment(1) == 'allTask' || Request::segment(1) == 'allTimesheet' ? 'active dash-trigger' : '' }}">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-list-check"></i><span class="nav-text">Project</span></a>
        <ul aria-expanded="false">
            <li
                class="{{ Request::segment(1) == 'project' && Request::segment(2) != 'allTask' && Request::segment(2) != 'allTaskKanban' && Request::segment(2) != 'allTimesheet' ? 'active  dash-trigger' : '' }}">
                <a class="" href="{{ route('project.index') }}">{{ __('All Project') }}</a>
            </li>
            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
                <li
                    class="{{ Request::segment(2) == 'allTask' || Request::segment(2) == 'allTaskKanban' ? 'active' : '' }}">
                    <a class=""
                        href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('all task')) ? route(\Auth::user()->getDefualtViewRouteByModule('all task')) : route('project.all.task') }}">{{ __('Task') }}</a>
                </li>
                <li class="{{ Request::segment(2) == 'allTimesheet' ? 'active' : '' }}">
                    <a class="" href="{{ route('project.all.timesheet') }}">{{ __('Timesheets') }}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
    <li
        class="dash-item {{ Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : '' }}">
        <a href="{{ route('project_report.index') }}" class="has-arrow"><i
                    class="fa fa-chart-line"></i><span class="nav-text">{{ __('Project Report') }}</span></a>
    </li>
@endif
@if (\Auth::user()->type == 'company')
    <li class="dash-item ">
        <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('item')) ? route(\Auth::user()->getDefualtViewRouteByModule('item')) : route('item.index') }}"
            class="has-arrow"><i class="fa fa-apps"></i><span
                class="nav-text">{{ __('Items') }}</span></a>
    </li>
@endif
@if (\Auth::user()->type == 'company')
    <li class="dash-item">
        <a href="{{ route('itemstock.index') }}" class="has-arrow"><i
                    class="fa fa-clipboard-check"></i><span
                class="nav-text">{{ __('Item Stock') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
    <li
        class="{{ Request::segment(1) == 'invoice' || Request::segment(1) == 'payment' || Request::segment(1) == 'creditNote' || Request::segment(1) == 'expense' ? 'active dash-trigger' : '' }}">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-stairs-up"></i><span
                class="nav-text">{{ __('Sale') }}</span></a>
        <ul aria-expanded="false">
            <li class=" {{ Request::segment(1) == 'invoice' ? 'active' : '' }}">
                <a
                    href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('invoice')) ? route(\Auth::user()->getDefualtViewRouteByModule('invoice')) : route('invoice.index') }}">{{ __('Invoices') }}</a>
            </li>
            <li class=" {{ Request::segment(1) == 'payment' ? 'active ' : '' }}">
                <a href="{{ route('payment.index') }}">{{ __('Payment') }}</a>
            </li>
            <li class=" {{ Request::segment(1) == 'creditNote' ? 'active' : '' }}">
                <a href="{{ route('creditNote.index') }}">{{ __('Credit Notes') }}</a>
            </li>
            @if (\Auth::user()->type == 'company')
                <li class=" {{ Request::segment(1) == 'expense' ? 'active' : '' }}">
                    <a href="{{ route('expense.index') }}">{{ __('Expense') }}</a>
                </li>
            @endif

        </ul>
    </li>
@endif

@if (\Auth::user()->type == 'company')
    <li class="dash-item {{ request()->is('budget*') ? 'active' : '' }}">
        <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('budget')) ? route(\Auth::user()->getDefualtViewRouteByModule('budget')) : route('budget.index') }}"><i class="fa fa-businessplan"></i><span
                class="nav-text">{{ __('Budget Planner') }}</span></a>
    </li>

    <li class="dash-item {{ request()->is('timetracker*') ? 'active' : '' }}">
        <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('timetracker')) ? route(\Auth::user()->getDefualtViewRouteByModule('timetracker')) : route('timetracker.index') }}"><i class="fa fa-alarm"></i><span
                class="nav-text">{{ __('Tracker') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type != 'super admin')
    <li class="dash-item {{ request()->is('zoommeeting*') ? 'active' : '' }}">
        <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('zoommeeting')) ? route(\Auth::user()->getDefualtViewRouteByModule('zoommeeting')) : route('zoommeeting.index') }}"><i class="fa fa-video-plus"></i><span
                class="nav-text">{{ __('Zoom Metting') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client')
    <li class="dash-item {{ request()->is('contract*') ? 'active' : '' }}">
        <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('contract')) ? route(\Auth::user()->getDefualtViewRouteByModule('contract')) : route('contract.index') }}"><i class="fa fa-device-floppy"></i><span
                class="nav-text">{{ __('Contract') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company')
    <li
        class="{{ Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' || Request::segment(2) == 'balance-sheet' || Request::segment(2) == 'trial-balance' ? 'active dash-trigger' : '' }}">
        <a href="javascript:void(0);" aria-expanded="false"
            class="has-arrow {{ Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' || Request::segment(2) == 'balance-sheet' || Request::segment(2) == 'trial-balance' ? 'show' : '' }}"><i class="fa fa-forms"></i><span
                class="nav-text">{{ __('Double Entry') }}</span></a>
        <ul aria-expanded="false">
            <li class="dash-item {{ request()->is('chart-of-account*') ? 'active' : '' }}">
                <a href="{{ route('chart-of-account.index') }}">{{ __('Chart of Accounts') }}</a>
            </li>
            <li class="dash-item {{ request()->is('journal-entry*') ? 'active' : '' }}">
                <a href="{{ route('journal-entry.index') }}">{{ __('Journal Account') }}</a>
            </li>
            <li class="dash-item {{ request()->is('report.ledger*') ? 'active' : '' }}">
                <a href="{{ route('report.ledger') }}">{{ __('Ledger Summary') }}</a>
            </li>
            <li class="dash-item {{ request()->is('report.balance.sheet*') ? 'active' : '' }} ">
                <a href="{{ route('report.balance.sheet') }}">{{ __('Balance Sheet') }}</a>
            </li>
            <li class="dash-item {{ request()->is('trial.balance*') ? 'active' : '' }}">
                <a href="{{ route('trial.balance') }}">{{ __('Trial Balance') }}</a>
            </li>
        </ul>
    </li>
@endif
@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client')
    <li class="dash-item">
        <a href="{{ url('chats') }}" ><i
                    class="fa fa-brand-hipchat"></i><span class="nav-text">{{ __('Messenger') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
    <li class="dash-item {{ request()->is('support*') ? 'active' : '' }}">
        <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('support')) ? route(\Auth::user()->getDefualtViewRouteByModule('support')) : route('support.index') }}"
            ><i class="fa fa-headset"></i><span
                class="nav-text">{{ __('Support') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
    <li class="dash-item">
        <a href="{{ route('event.index') }}" ><i
                    class="fa fa-calendar-event"></i><span class="nav-text">{{ __('Event') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
    <li class="dash-item">
        <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('notice board')) ? route(\Auth::user()->getDefualtViewRouteByModule('notice board')) : route('noticeBoard.index') }}"
            ><i class="fa fa-clipboard-list"></i><span
                class="nav-text">{{ __('Notice Board') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company')
    <li class="dash-item">
        <a href="{{ url('goal') }}" ><i
                    class="fa fa-award"></i><span class="nav-text">{{ __('Goal') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
    <li class="dash-item {{ request()->is('note*') ? 'active' : '' }}">
        <a href="{{ route('note.index') }}" ><i
                    class="fa fa-note"></i><span class="nav-text">{{ __('Note') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'company')
    <li class="">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow"><i class="fa fa-chart-dots"></i><span
                class="nav-text">{{ __('Report') }}</span></a>
        <ul aria-expanded="false">
            <li class="dash-item">
                <a href="{{ route('report.attendance') }}">{{ __('Attendance') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.task') }}">{{ __('Task') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.income.expense') }}">{{ __('Income Vs Expense') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.timelog') }}">{{ __('Time Log') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.finance') }}">{{ __('Finance') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.leave') }}">{{ __('Leave') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.estimate') }}">{{ __('Estimate') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.invoice') }}">{{ __('Invoice') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.client') }}">{{ __('Client') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('report.lead') }}">{{ __('Lead') }}</a>
            </li>

            <li class="dash-item">
                <a href="{{ route('report.deal') }}">{{ __('Deal') }}</a>
            </li>

            <li class="dash-item">
                <a href="{{ route('report.product.stock.report') }}">{{ __('Item Stock') }}</a>
            </li>

        </ul>
    </li>
@endif

@if (\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company')
    <li class="dash-item @if (str_contains(request()->url(), 'stripe')) active @endif">
        <a href="{{ route('plan.index') }}" ><i
                    class="fa fa-trophy"></i><span class="nav-text">{{ __('Plan') }}</span></a>
    </li>
@endif


@if (\Auth::user()->type == 'super admin')
    <li class="dash-item">
        <a href="{{ route('plan_request.index') }}" ><i
                    class="fa fa-git-pull-request"></i><span
                class="nav-text">{{ __('Plan Request') }}</span></a>
    </li>
@endif
@if (\Auth::user()->type == 'super admin')
    <li class="dash-item {{ Request::segment(1) == 'referral-program' ? 'active' : '' }}">
        <a href="{{ route('referral.index') }}" ><i
                    class="fa fa-trophy"></i><span class="nav-text">{{ __('Referral Program') }}</span></a>
    </li>
@endif
@if (\Auth::user()->type == 'company')
    <li class="dash-item {{ Request::segment(1) == 'referral-program' ? 'active' : '' }}">
        <a href="{{ route('guideline.index') }}" ><i
                    class="fa fa-trophy"></i><span class="nav-text">{{ __('Referral Program') }}</span></a>
    </li>
@endif
@if (\Auth::user()->type == 'super admin')
    <li class="dash-item {{ Request::segment(1) == 'coupon' ? 'active' : '' }}">
        <a href="{{ route('coupon.index') }}" ><i
                    class="fa fa-clipboard-check"></i><span class="nav-text">{{ __('Coupon') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company')
    <li class="dash-item">
        <a href="{{ route('order.index') }}" ><i
                    class="fa fa-shopping-cart"></i><span class="nav-text">{{ __('Order') }}</span></a>
    </li>
@endif

@if (\Auth::user()->type == 'super admin')
    <li
        class="dash-item {{ request()->is('email_template*') || request()->is('emailtemplate_lang*') ? 'active' : '' }}">
        <a href="{{ route('manage.email.language', [$emailTemplate->id, \Auth::user()->lang]) }}"
            ><i class="fa fa-template"></i><span
                class="nav-text">{{ __('Email Template') }}</span></a>
    </li>
@endif


@if (\Auth::user()->type == 'company')
    <li class="">
        <a href="javascript:void(0);" aria-expanded="false" class="has-arrow"><i class="fa fa-circle-square"></i><span
                class="nav-text">{{ __('Constant') }}</span></a>
        <ul aria-expanded="false">
            <li class="">
                <a class="has-arrow" href="#">{{ __('HR') }}</a>
                <ul aria-expanded="false">
                    <li class="dash-item">
                        <a  href="{{ route('department.index') }}">{{ __('Department') }}</a>
                    </li>
                    <li class="dash-item">
                        <a  href="{{ route('designation.index') }}">{{ __('Designation') }}</a>
                    </li>
                    <li class="dash-item">
                        <a  href="{{ route('salaryType.index') }}">{{ __('Salary Type') }}</a>
                    </li>
                    <li class="dash-item">
                        <a  href="{{ route('leaveType.index') }}">{{ __('Leave Type') }}</a>
                    </li>
                    <li class="dash-item">
                        <a  href="{{ route('award-type.index') }}">{{ __('Award Type') }}</a>
                    </li>
                    <li class="dash-item">
                        <a
                            href="{{ route('termination-type.index') }}">{{ __('Termination Type') }}</a>
                    </li>
                    <li class="dash-item">
                        <a
                            href="{{ route('training-type.index') }}">{{ __('Training Type') }}</a>
                    </li>
                    <li class="dash-item">
                        <a
                            href="{{ route('performanceType.index') }}">{{ __('Performance Type') }}</a>
                    </li>
                    <li class="dash-item">
                        <a  href="{{ route('competencies.index') }}">{{ __('Competencies') }}</a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a class="has-arrow" href="#">{{ __('PreSale') }}</a>
                <ul aria-expanded="false">
                    <li class="dash-item">
                        <a href="{{ route('pipeline.index') }}">{{ __('Pipeline') }}</a>
                    </li>
                    <li class="dash-item">
                        <a href="{{ route('leadStage.index') }}">{{ __('Lead Stage') }}</a>
                    </li>
                    <li class="dash-item">
                        <a href="{{ route('dealStage.index') }}">{{ __('Deal Stage') }}</a>
                    </li>
                    <li class="dash-item">
                        <a href="{{ route('source.index') }}">{{ __('Source') }}</a>
                    </li>
                    <li class="dash-item">
                        <a href="{{ route('label.index') }}">{{ __('Label') }}</a>
                    </li>
                </ul>
            </li>
            <li class="dash-item">
                <a href="{{ route('projectStage.index') }}">{{ __('Project Task Stage') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('taxRate.index') }}">{{ __('Tax Rate') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('unit.index') }}">{{ __('Unit') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('category.index') }}">{{ __('Category') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('paymentMethod.index') }}">{{ __('Payment Method') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('contractType.index') }}">{{ __('Contract Type') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('branch.index') }}">{{ __('Branch') }}</a>
            </li>
            <li class="dash-item">
                <a href="{{ route('goaltype.index') }}">{{ __('Goal Type') }}</a>
            </li>
        </ul>
    </li>
@endif

@if (\Auth::user()->type == 'company')
    <li class="dash-item @if (str_contains(request()->url(), 'notification-templates')) active @endif">
        <a href="{{ url('notification-templates') }}" class="">
            <span class="nav-text">
                <i class="fa fa-bell"></i>
            </span>
            <span class="nav-text">{{ __('Notification Templates') }}</span></a>
    </li>
@endif


@if (\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company')
    <li class="dash-item">
        <a href="{{ route('settings') }}" class=""><i
                    class="fa fa-settings"></i><span class="nav-text">{{ __('Settings') }}</span></a>
    </li>
@endif
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
    <li
        class="{{ Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index' ? ' active mm-active' : '' }}">
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
            <li
                class="{{ Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index' ? ' active mm-active' : '' }}">
                <a href="{{ route('labels.index') }}"
                    class="{{ Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'dealtypes.index' || Request::route()->getName() == 'pipelines.index' ? 'mm-active' : '' }}">Deal/Lead
                    Setting</a>
            </li>
            {{-- @endcan --}}
        </ul>
    </li>
@endcan
<li
    class="{{ Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'department.index' || Request::route()->getName() == 'designation.index' ? ' active mm-active' : '' }}">
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
            <li>~~<a href="{{ route('department.index') }}">Department</a></li>
        @endcan
    </ul>
</li>
{{-- @if (Auth::user()->type == 'super admin')
    @can('manage coupon')
        <li class="{{ request()->is('coupons') ? 'active' : '' }}">
            <a href="{{ route('coupons.index') }}" class="">
                <i class="fa fa-users"></i><span class="nav-text ">Coupon</span>
            </a>
        </li>
    @endcan
@endif --}}
