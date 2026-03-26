<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicTable extends Component
{
    public $headers;
    public $rows; // This will be an array of callbacks/closures
    public $items; // Your model collection
    public $mobileConfig;
    public $showId;
    /**
     * Create a new component instance.
     */
    public function __construct($headers, $rows, $items, $mobileConfig = [], $showId = true)
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->items = $items;
        $this->mobileConfig = $mobileConfig;
        $this->showId = $showId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dynamic-table');
    }
}
