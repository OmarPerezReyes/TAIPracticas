<?php

return [

    //Tasa de impuesto predeterminada
    'tax' => 16,


    'database' => [

        'connection' => null,

        'table' => 'shoppingcart',

    ],

    //Destruir el carrito al cerrar sesión

    'destroy_on_logout' => false,

    /*
    |--------------------------------------------------------------------------
    | Formato numérico predeterminado
    |--------------------------------------------------------------------------
    |
    | Estos valores predeterminados se usarán para los números formateados si
    | no los estableces en la llamada al método.
    |
    */

    'format' => [

        'decimals' => 0,

        'decimal_point' => '',

        'thousand_separator' => ''

    ],

];