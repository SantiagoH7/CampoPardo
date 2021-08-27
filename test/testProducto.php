<?php

require ('..\app\Models\Productos.php');

use App\Models\Productos;

$arrProd1 = [
    'Nombre' => 'Queso pera',
    'Tamano' => 233,
    'Clasificacion' => 'Oz',
    'Referencia' => '001',
    'PrecioProduccion' => 2000,
    'PrecioVenta' => 3000,
    'Presentacion' => 'Envase vidrio',
    'Cantidad' => 32,
    'Descripcion' => 'Este es un producto lacteo',
    'Estado' => 'Activo',
    'Proveedor_id' => 2
];

$prod1 = new Productos($arrProd1);
$prod1->insert();

