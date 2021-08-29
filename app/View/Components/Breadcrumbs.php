<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $breadcrumb;
    public function __construct($name , $breadcrumb)
    {
        $this->name = $name;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.breadcrumbs-component');
    }
}
