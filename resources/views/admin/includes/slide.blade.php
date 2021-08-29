<div class="vertical-menu">

    <div data-simplebar="" class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        {{-- <span class="badge badge-pill badge-info float-right">03</span> --}}
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                    
                </li>
                @if(Auth::user()->can('edit post') || Auth::user()->can('view post') || Auth::user()->can('delete post'))
                <li>
                    <a href="{{ route('admin.article') }}" class=" waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>{{ __('Post') }}</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->can('edit tag') || Auth::user()->can('view tag') || Auth::user()->can('delete tag'))

                <li>
                    <a href="{{ route('admin.tag') }}" class=" waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>{{ __('Tag') }}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can('edit category') || Auth::user()->can('view category') || Auth::user()->can('delete category'))
                <li>
                    <a href="{{ route('admin.category') }}" class=" waves-effect">
                        <i class="bx bx-layout"></i>
                        {{-- <span class="badge badge-pill badge-success float-right">New</span> --}}
                        <span>{{ __('Category') }}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can('edit user') || Auth::user()->can('view user') || Auth::user()->can('delete user'))

                <li>
                    <a href="{{route('admin.users')}}" class=" waves-effect">
                        <i class="bx bx-user"></i>
                        <span>{{ __('User') }}</span>
                    </a>
                </li>
                @endif
                @can('user grant')

                <li>
                    <a href="{{ route('admin.role') }}" class=" waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>{{ __('Role') }}</span>
                    </a>
                    
                </li>

                <li>
                    <a href="{{ route('admin.permissions') }}" class=" waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>{{ __('Permission') }}</span>
                    </a>
                    
                </li>
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>