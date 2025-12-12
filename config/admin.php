<?php

return [
    'brand' => env('ADMIN_BRAND', 'Admin LTA'),

    'menu' => [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        [
            'label' => 'Reportes',
            'route' => 'admin.reportes.index',
            'icon' => 'fas fa-chart-bar',
        ],
        [
            'label' => 'Categorías',
            'route' => 'admin.categories.index',
            'icon' => 'fas fa-tags',
        ],
        [
            'label' => 'Fundaciones',
            'route' => 'admin.fundaciones.index',
            'icon' => 'fas fa-building',
        ],
        [
            'label' => 'Proveedores',
            'route' => 'admin.proveedores.index',
            'icon' => 'fas fa-handshake',
        ],
        [
            'label' => 'Productos',
            'route' => 'admin.productos.index',
            'icon' => 'fas fa-boxes',
        ],
        [
            'label' => 'Usuarios',
            'route' => 'admin.usuarios.index',
            'icon' => 'fas fa-users',
        ],
        [
            'label' => 'Carritos',
            'route' => 'admin.carritos.index',
            'icon' => 'fas fa-shopping-cart',
        ],
        [
            'label' => 'Órdenes',
            'route' => 'admin.ordenes.index',
            'icon' => 'fas fa-file-invoice',
        ],
        [
            'label' => 'Pagos',
            'route' => 'admin.payments.index',
            'icon' => 'fas fa-money-bill-wave',
        ],
    ],
];

