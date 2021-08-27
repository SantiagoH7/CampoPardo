<?php

require ("..\app\Models\Usuarios.php");
use App\Models\Usuarios;
use App\Models\Municipios;

$arrUsuario1=[
    'Nombres' => 'Campo',
    'Apellidos' => 'Pardo',
    'TipoDocumento' => 'CC',
    'NumeroDocumento' => '1245432350',
    'Telefono' => 3132307498,
    'Email' => 'campopardo@gmail.com',
    'Contrasena' => '123456789',
    'Direccion' => 'Av coyote 12-56',
    'Rol' => 'Administrador',
    'Estado' => 'Activo',
    'Municipio_id' => 5001
];

$arrUsuario2=[
    'Nombres' => 'Simon',
    'Apellidos' => 'Tolomeo',
    'TipoDocumento' => 'CC',
    'NumeroDocumento' => '1009887888',
    'Telefono' => 3132098998,
    'Email' => 'lacteo@gmail.com',
    'Direccion' => 'cra 24 n 34',
    'Contrasena' => '123456789',
    'Rol' => 'Administrador',
    'Estado' => 'Activo',
    'Municipio_id' => 5004
];

$arrUsuario3=[
    'Cedula' => '1193094783',
    'Nombres' => 'Bladimir Alejandro',
    'Apellidos' => 'Rojas Pinilla',
    'Telefono' => 3197807498,
    'Direccion' => 'calle 72-56',
    'Email' => 'listopalospoderoso@gmail.com',
    'Contrasena' => 'jehoo373',
    'Rol' => 'Mesero',
    'Estado' => 'Activo',
    'Empresa_id' => 1
];
$arrUsuario4=[
    'Nombres' => 'Carlos',
    'Apellidos' => 'Pirri',
    'TipoDocumento' => 'CC',
    'NumeroDocumento' => '321313212',
    'Telefono' => 2221212123,
    'Email' => 'cssdsd@gmail.com',
    'Direccion' => 'Av coyote 12-56',
    'Contrasena' => '1232456789',
    'Rol' => 'Cliente',
    'Estado' => 'Activo',
    'Municipio_id' => 5001
];

//$objectUsuario1= new Usuarios($arrUsuario1);
//var_dump($objectUsuario1);
//$objectUsuario1->insert();

//$objectUsuario1->setCedula(1193099653);
//$objectUsuario1->setApellidos('Sandoval Pirri');
//var_dump($objectUsuario1);
//$objectUsuario1->update();

$objectUsuario2= new Usuarios($arrUsuario2);
$objectUsuario2->insert();

//$objectUsuario2->insert();
//$objectUsuario4= new Usuarios($arrUsuario4);
//var_dump($objectUsuario1);
//$objectUsuario4->insert();

//$PruebaUpdate=Usuarios::searchForId(2);//Llamamos al usuario que queremos modificar
//$PruebaUpdate->setEstado('Inactivo');
//$PruebaUpdate->update();
//var_dump($arrUsuario2);


//$objectUsuario3= new Usuarios($arrUsuario3);
//var_dump($objectUsuario3);

//$objectUsuario3->insert();

//$arrResult = Usuarios::search("SELECT * FROM usuario WHERE Nombres = 'David Felipe' AND Telefono = 3132307498");
//var_dump($arrResult);

//if (!empty($arrResult)) {
//    /* @var $arrResult Usuarios[] */
//    foreach ($arrResult as $Usuario) {
//        echo 'Usuario: ' . $Usuario->getNombres() . ' Telefono: ' . $Usuario->getTelefono() . "\n";
//    }
//}

//$objUsuario2 = Usuarios::searchForId(2);
//if (!empty($objUsuario2)) {
//    $objUsuario2->setDireccion('Av currucui 12-56');
//    $objUsuario2->update();
//}

//$arrUsuarios = Usuarios::getAll();
//if (!empty($arrUsuarios)) {
//    /* @var $arrUsuarios Usuarios[] */
//    foreach ($arrUsuarios as $Usuario) {
//        echo "Direccion: " . $Usuario->getDireccion() . " Telefono: " . $Usuario->getTelefono() . "\n";
//    }

//}

//$JsonUsuario2 = Usuarios::searchForId(2);
//echo json_encode($JsonUsuario2);

//$PURegistrado=Usuarios::usuarioRegistrado(1193099653, 'David Felipe');
//var_dump($PURegistrado);

//$usuarioGetALL = Usuarios::getAll();
//var_dump($empresaGetALL);

//* @var $usuarioGetALL app\Models\Usuarios[] */
//foreach ($usuarioGetALL as $Usuario)
//{
//    print_r($Usuario->jsonSerialize());
//}



// Cambio de contraseñas
//$Usr1 = Usuarios::searchForId(1);
//$Usr1->setContrasena('123456789');
//$Usr1->update();

//$Usr2 = Usuarios::searchForId(2);
//$Usr2->setContrasena('12345');
//$Usr2->update();

//$Usr3 = Usuarios::searchForId(3);
//$Usr3->setContrasena('00000');
//$Usr3->update();

//$pruebaUsupag = Usuarios::searchForId(2);
//print_r($pruebaUsupag->getPagosTrabajador());

//$pruebaUsupag = Pagos::searchForId(1);
//print_r($pruebaUsupag->getTrabajador());

//$pruebaUsu = Usuarios::searchForId(1);
//print_r($pruebaUsu->getMarcasProveedor());

//$pruebaUsu = Marcas::searchForId(1);
//print_r($pruebaUsu->getProveedor());


