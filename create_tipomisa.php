<?php
// get database connection
include_once 'config/database.php';
$database = new database();
$db = $database->getConnection();

// instantiate product object
include_once 'objects/TipoMisa.php';
$tipomisa = new TipoMisa($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$tipomisa->descripcion = $data->descripcion;
$tipomisa->valorsugerido = $data->valorsugerido;
$tipomisa->valorminimo = $data->valorminimo;
$tipomisa->fh = date('Y-m-d H:i:s');

// create the product
if($tipomisa->create()){
    echo "Tipo de misa was created.";
}

// if unable to create the product, tell the user
else{
    echo "Unable to create Tipo Misa.";
}
?>
