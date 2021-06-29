<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class City extends Component
{
    public $cities;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cities = \App\Models\City::where('state_id', Auth::user()->address->city_id)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.city');
    }
}
