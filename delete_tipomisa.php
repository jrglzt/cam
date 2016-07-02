<?php
// include database and object file
include_once 'config/database.php';
include_once 'objects/TipoMisa.php';

// get database connection
$database = new database();
$db = $database->getConnection();

// prepare product object
$tipomisa = new TipoMisa($db);

// get product id
$data = json_decode(file_get_contents("php://input"));

// set product id to be deleted
$tipomisa->codtipomisa = $data->codtipomisa;

// delete the product
if($tipomisa->delete()){
    echo "Tipo ha sido borrado.";
}

// if unable to delete the product
else{
    echo "Unable to delete object.";
}
?>
