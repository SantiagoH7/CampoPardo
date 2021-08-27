<?php

require ("..\app\Models\Ventas.php");
use App\Models\Ventas;
use App\Models\Usuarios;

$arrVenta1 = [

    'Numero' => 1,
    'Fecha' => '2021-05-12',
    'IVA' => 0.19,
    'MedioPago' => 'Efectivo',
    'Mesero_id' => 1,
    'Estado' => 'Pendiente',
    'TipoPedido' => 'Mesa',

];
$arrVenta2 = [

    'Numero' => 2,
    'Fecha' => '2020-11-03',
    'IVA' => 0.19,
    'MedioPago' => 'Ahorro a la mano',
    'Mesero_id' => 3,
    'Estado' => 'Cancelada',
    'TipoPedido' => 'Domicilio',

];
$arrVenta3 = [

    'Numero' => 3,
    'Fecha' => '2019-07-23',
    'IVA' => 0.19,
    'MedioPago' => 'Daviplata',
    'Mesero_id' => 1,
    'Estado' => 'Paga',
    'TipoPedido' => 'Domicilio',

];
$arrFactura4 = [

    'Numero' => 4,
    'Fecha' => '2021-07-22',
    'IVA' => 0.19,
    'MedioPago' => 'Datafono',
    'Mesero_id' => 3,
    'Estado' => 'Paga',
    'TipoPedido' => 'Mesa',

];

$objFactura1= new Facturas($arrFactura1);
$objFactura1->insert();
//var_dump($objFactura1);

$objFactura2= new Facturas($arrFactura2);
$objFactura2->insert();
//var_dump($objFactura1);

$objFactura3 = new Facturas($arrFactura3);
$objFactura3->insert();
//var_dump($objFactura3);

$objFactura4= new Facturas($arrFactura4);
$objFactura4->insert();
//var_dump($objFactura4);

//Prueba update
//$pruebaUpdate = Facturas::searchForId(1);//Buscamos la factura que queremos modificar
//$pruebaUpdate->setMedioPago('Nequi');
//$pruebaUpdate->setTipoPedido('Domicilio');
//$pruebaUpdate->update();

//$pruebFacRegist= Facturas::facturaRegistrada(2,2);// Comprobamos que ya exista un fatura con esas caracteristicas
//var_dump($pruebFacRegist);


//$pruebSearch1Fac= Facturas::search("SELECT * FROM factura WHERE Estado = 'Paga'");// Prueba metodo search
///* @var $pruebSearch1Fac App\Models\Facturas[] */
//foreach ($pruebSearch1Fac as $factura)
//{
//    print_r($factura->jsonSerialize());
//}

//$pruebSearch2Fac= Facturas::searchForId(3);// Prueba metodo searchForId
//var_dump($pruebSearch2Fac);
//print_r($pruebSearch2Fac->jsonSerialize());

//$facturaGetAll= Facturas::getAll();// Prueba metodo getAll
//var_dump($facturaGetAll);
///* @var $facturaGetAll App\Models\Facturas[] */
//foreach ($facturaGetAll as $factura)
//{
//   print_r($factura->jsonSerialize());
//}

//Prueba relaciones factura
//Prueba usuario factura
//$pruebUsu = Usuarios::searchForId(3);
//print_r($pruebUsu->getFacturasMesero());

//$pruebFacUsua = Facturas::searchForId(1);
//print_r($pruebFacUsua->getMesero());

