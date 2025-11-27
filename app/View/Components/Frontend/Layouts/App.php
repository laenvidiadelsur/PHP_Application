<?php

namespace App\View\Components\Frontend\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class App extends Component
{
    public function __construct(
        public string $pageTitle = 'Alas Chiquitanas',
    ) {
    }

    public function render(): View
    {
        return view('frontend.layouts.app');
    }
}

