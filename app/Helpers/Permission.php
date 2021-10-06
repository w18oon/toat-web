<?php

    function canEnter($menuUrl)
    {
        $menu = \App\Models\Menu::where('url', $menuUrl)->first();
        if (is_null($menu)) {
            return false;
        }

        $permisionCode = $menu->permission_code;
        return Gate::check($permisionCode. '_ENTER');
    }

    function canView($menuUrl)
    {
        $menu = \App\Models\Menu::where('url', $menuUrl)->first();
        if (is_null($menu)) {
            return false;
        }

        $permisionCode = $menu->permission_code;
        return Gate::check($permisionCode. '_VIEW');
    }