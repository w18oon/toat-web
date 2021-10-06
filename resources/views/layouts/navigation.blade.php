<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        {{-- <ul class="navbar-nav mr-auto">
            @php
                $menu = new \App\Models\Menu;
                $menuList = $menu->tree();
            @endphp
            @each('layouts.navigations._db', $menuList, 'menu', 'empty')
        </ul> --}}
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ optional(auth()->user())->name }}</strong>
                            </span> <span class="text-muted text-xs block">Example menu <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    TOAT
                </div>
            </li>
            {{-- <li class="{{ isActiveRoute('main') }}"> --}}
            {{-- <li class="">
                <a href="{{ url('/') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
            </li> --}}
            {{-- <li class="{{ isActiveRoute('minor') }}"> --}}
            {{-- <li class="">
                <a href="{{ url('/minor') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Minor view</span> </a>
            </li> --}}

            <li class="special_link" >
                <a href="#" class="pt-1 pb-1"> <span class="nav-label">Ready for Test</span></a>
            </li>
            @include('layouts.navigations._db')
            <li class="special_link" >
                <a href="#" style="background: #f8ac59;" class="pt-1 pb-1"> <span class="nav-label">Develop</span></a>
            </li>
            @include('layouts.navigations._example')
            @include('layouts.navigations._pd')
            @include('layouts.navigations._eam')
            @include('layouts.navigations._om')
            @include('layouts.navigations._ecom')
            {{-- @include('layouts.navigations._ie') --}}
        </ul>

    </div>
</nav>
