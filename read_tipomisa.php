<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once 'config/database.php';
include_once 'objects/TipoMisa.php';

// instantiate database and product object
$database = new database();
$db = $database->getConnection();

// initialize object
$tipomisa = new TipoMisa($db);

// query products
$stmt = $tipomisa->readAll();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){

    $data="";
    $x=1;

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $data .= '{';
            $data .= '"id":"'  . $codtipomisa . '",';
            $data .= '"descripcion":"' . html_entity_decode($descripcion) . '",';
            $data .= '"valorsugerido":"' . $valorsugerido . '",';
            $data .= '"valorminimo":"' . $valorminimo . '"';
        $data .= '}';

        $data .= $x<$num ? ',' : ''; $x++; }
}

// json format output
echo '{"records":[' . $data . ']}';
?>
