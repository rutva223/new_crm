<div class="header-content">
    <nav class="navbar navbar-expand">
        <div class="collapse navbar-collapse justify-content-between">
            <div class="header-left">

            </div>
            <ul class="navbar-nav header-right">

                <li class="nav-item dropdown notification_dropdown">
                    <a class="nav-link  menu-wallet" href="javascript:void(0);">
                        <i class="material-icons"> widgets </i>
                    </a>
                </li>
                <li class="nav-item dropdown notification_dropdown" id="theme_changes" style="cursor: pointer">
                    <a class="nav-link ">
                        <i id="icon-light" class="fas fa-sun {{ $theme == 'light' ? 'd-none' : '' }} "></i>
                        <i id="icon-dark" class="fas fa-moon {{ $theme == 'dark' ? 'd-none' : '' }} "></i>
                    </a>
                </li>
                <li class="nav-item dropdown notification_dropdown">
                    <a class="nav-link bell-link" href="{{ route('plan.index') }}">
                        <img src="https://cdn-icons-png.freepik.com/256/8975/8975982.png?ga=GA1.1.898392996.1708158571&semt=ais"
                            alt="" style="height: 22px;">
                    </a>
                </li>
                <li class="nav-item dropdown notification_dropdown">
                    <a class="nav-link bell-link" href="{{ route('note.index') }}">
                        <i class="fas fa-sticky-note"></i>
                    </a>
                </li>
                <li class="nav-item dropdown notification_dropdown">
                    <a class="nav-link " href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                        <svg width="23" height="23" viewBox="0 0 26 26" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.75 10.8334C22.7469 9.8751 22.4263 8.94488 21.8382 8.18826C21.2501 7.43163 20.4279 6.89126 19.5 6.6517V4.33337C19.4997 4.15871 19.4572 3.98672 19.3761 3.83204C19.295 3.67736 19.1777 3.54459 19.0342 3.44503C18.8922 3.34623 18.7286 3.28286 18.5571 3.26024C18.3856 3.23763 18.2111 3.25641 18.0484 3.31503L8.59086 6.7492L4.39835 6.50003C4.25011 6.49047 4.10147 6.51151 3.9617 6.56183C3.82192 6.61215 3.69399 6.69068 3.58585 6.79253C3.4789 6.89448 3.39394 7.01723 3.33619 7.15323C3.27843 7.28924 3.24911 7.43561 3.25002 7.58337V15.1667C3.25022 15.3205 3.28316 15.4725 3.34667 15.6126C3.41018 15.7527 3.5028 15.8777 3.61835 15.9792C3.733 16.0795 3.86752 16.1545 4.01312 16.1993C4.15873 16.2441 4.31214 16.2577 4.46335 16.2392L5.88252 16.0659L6.90085 21.8509C6.94471 22.1052 7.07794 22.3356 7.27655 22.5004C7.47516 22.6653 7.7261 22.7538 7.98419 22.75H11.9167C12.0748 22.7521 12.2314 22.7195 12.3756 22.6545C12.5197 22.5896 12.648 22.4939 12.7512 22.3741C12.8544 22.2544 12.9302 22.1135 12.9732 21.9613C13.0162 21.8092 13.0253 21.6494 13 21.4934L12.1984 16.7267L18.1242 18.4167C18.2211 18.4325 18.3198 18.4325 18.4167 18.4167C18.704 18.4167 18.9796 18.3026 19.1827 18.0994C19.3859 17.8962 19.5 17.6207 19.5 17.3334V15.015C20.4279 14.7755 21.2501 14.2351 21.8382 13.4785C22.4263 12.7218 22.7469 11.7916 22.75 10.8334ZM5.41669 8.7317L7.58335 8.85087V13.6717L5.41669 13.9425V8.7317ZM10.6384 20.5834H8.88336L8.03836 15.795L8.59086 15.73L9.89086 16.0875L10.6384 20.5834ZM17.3334 15.9034L11.4292 14.2675C11.2529 14.1491 11.0457 14.085 10.8334 14.0834L9.75002 13.78V8.6667L17.3334 5.91503V15.9034ZM19.5 12.6534V8.97003C19.8233 9.16188 20.0912 9.43455 20.2772 9.76124C20.4632 10.0879 20.5611 10.4574 20.5611 10.8334C20.5611 11.2093 20.4632 11.5788 20.2772 11.9055C20.0912 12.2322 19.8233 12.5049 19.5 12.6967V12.6534Z"
                                fill="#666666" />
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end of-visible">
                        <div class="dropdown-header">
                            <h4 class="title mb-0">Notification</h4>
                            <a href="javascript:void(0);" class="d-none"><i class="flaticon-381-settings-6"></i></a>
                        </div>
                        <div id="DZ_W_Notification1" class="widget-media dlab-scroll p-3" style="height:380px;">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2">
                                            <img alt="image" width="50"
                                                src="{{ asset('assets/images/avatar/1.png') }}">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-info">
                                            KG
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Resport created successfully</h6>
                                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-success">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2">
                                            <img alt="image" width="50"
                                                src="{{ asset('assets/images/avatar/1.png') }}">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-danger">
                                            KG
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Resport created successfully</h6>
                                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-primary">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <a class="all-notification" href="javascript:void(0);">See all notifications <i
                                class="ti-arrow-end"></i></a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown header-profile2">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="header-info2 d-flex align-items-center">
                                <div class="d-flex align-items-center sidebar-info">
                                    <div class="d-none d-md-block">
                                        <h5 class="mb-0">{{ __('Welcome') }}</h5>
                                        <p class="mb-0 text-end">{{ \Auth::user()->name ?? '' }}</p>
                                    </div>
                                </div>
                                @if (\Auth::user()->avatar != null)
                                    <img src="{{ asset('/avatars/' . \Auth::user()->avatar) }}">
                                @else
                                    <img src="{{ asset('/assets/images/avatar/1.png') }}">
                                @endif
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item ai-icon ">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    class="svg-main-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24" />
                                        <path
                                            d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                            fill="var(--primary)" fill-rule="nonzero" opacity="0.3" />
                                        <path
                                            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                            fill="var(--primary)" fill-rule="nonzero" />
                                    </g>
                                </svg>
                                <span class="ms-2">{{ __('Profile') }}</span>
                            </a>
                            @can('manage setting')
                                <a href="{{ route('setting.index') }}" class="dropdown-item ai-icon ">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        class="svg-main-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z"
                                                fill="var(--primary)" fill-rule="nonzero" opacity="0.3" />
                                            <path
                                                d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                fill="var(--primary)" />
                                        </g>
                                    </svg>
                                    <span class="ms-2">{{ __('Settings')}}</span>
                                </a>
                            @endcan
                            <form method="POST" action="{{ route('logout') }}" id="form_logout">
                                <a href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="#fd5353" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    @csrf
                                    <span class="ms-2 text-danger">{{ __('LogOut') }} </span>
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
