<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Admin extends Component
{
    public function __construct(
        public string $pageTitle = 'Panel Admin',
        public ?string $breadcrumbs = null,
    ) {
    }

    public function render(): View
    {
        return view('admin.layouts.app');
    }
}

