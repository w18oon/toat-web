@php
    $menu = new \App\Models\Menu;
    $menuList = $menu->tree(1, optional(auth()->user())->user_id);
@endphp
@foreach ($menuList as $menu)
    @if (count($menu->children) == 0)
        <li>
            <a href="{{ $menu->url }}"><i class="fa fa-diamond"></i> <span class="nav-label">{{ $menu->menu_title }}</span></a>
    @else
        <li>
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">{{ $menu->menu_title }}</span> <span class="fa arrow"></span></a>
    @endif

    @if (count($menu->children) > 0)
        <ul class="nav nav-second-level collapse">
        @foreach($menu->children as $secondMenu)
            @if (count($secondMenu->children) == 0)
                <li><a href="{{ $secondMenu->url }}">{{ $secondMenu->menu_title }}</a></li>
            @else
                <li>
                    <a href="#">{{ $secondMenu->menu_title }} <span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                    @foreach ($secondMenu->children as $thirdMenu)
                        <li>
                            <a href="{{ $thirdMenu->url }}">{{ $thirdMenu->menu_title }}</a>
                        </li>
                    @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
        </ul>
    @endif
@endforeach