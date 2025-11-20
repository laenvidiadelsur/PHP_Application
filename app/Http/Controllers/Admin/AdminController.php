<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

abstract class AdminController extends Controller
{
    protected string $pageTitle = '';

    protected function shareMeta(array $data = []): array
    {
        return array_merge([
            'pageTitle' => $this->pageTitle,
        ], $data);
    }
}

