<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/TipoMisa.php';

// get database connection
$database = new database();
$db = $database->getConnection();

// prepare product object
$tipomisa = new TipoMisa($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$tipomisa->codtipomisa = $data->codtipomisa;

// read the details of product to be edited
$tipomisa->readOne();

// create array
$tipomisa_arr[] = array(
    "codtipomisa" =>  $tipomisa->codtipomisa,
    "descripcion" => $tipomisa->descripcion,
    "valorsugerido" => $tipomisa->valorsugerido,
    "valorminimo" => $tipomisa->valorminimo
);

// make it json format
print_r(json_encode($tipomisa_arr));
?>
