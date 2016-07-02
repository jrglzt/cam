<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/TipoMisa.php';

// get database connection
$database = new database();
$db = $database->getConnection();

// prepare tipomisa object
$tipomisa = new TipoMisa($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$tipomisa->codtipomisa = $data->codtipomisa;

// set product property values
$tipomisa->descripcion = $data->descripcion;
$tipomisa->valorsugerido = $data->valorsugerido;
$tipomisa->valorminimo = $data->valorminimo;

// update the product
if($tipomisa->update()){
    echo "Tipo Misa was updated.";
}

// if unable to update the product, tell the user
else{
    echo "Unable to update Tipo Misa.";
}
?>
