<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GetProgramCode extends Component
{
    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $menu = \App\Models\Menu::where('url', $this->url)->first();
        return view('components.get-program-code', compact('menu'));
    }
}
