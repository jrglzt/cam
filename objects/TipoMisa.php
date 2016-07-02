<?php
class TipoMisa{
    // database connection and table name
    private $conn;
    private $table_name = "tipomisa";

    // object properties
    public $codtipomisa;
    public $descripcion;
    public $valorsugerido;
    public $valorminimo;
    public $usuario;
    public $fh;
    public $fhm;
    public $usuariom;
    public $limite;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // create tipo misa
    function create(){

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    descripcion=:descripcion, valorsugerido=:valorsugerido, valorminimo=:valorminimo, fh=:fh, usuario=:usuario";

        // prepare query
        $stmt = $this->conn->prepare($query);

        $this->usuario="NOUSER";
        // posted values
        $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
        $this->valorsugerido=htmlspecialchars(strip_tags($this->valorsugerido));
        $this->valorminimo=htmlspecialchars(strip_tags($this->valorminimo));
        $this->usuario=htmlspecialchars(strip_tags($this->usuario));

        // bind values
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":valorsugerido", $this->valorsugerido);
        $stmt->bindParam(":valorminimo", $this->valorminimo);
        $stmt->bindParam(":fh", $this->fh);
        $stmt->bindParam(":usuario", $this->usuario);

        // execute query
        if($stmt->execute()){
            return true;
        }else{
            echo "<pre>";
                print_r($stmt->errorInfo());
            echo "</pre>";

            return false;
        }
    }
    // read products
function readAll(){

	// select all query
	$query = "SELECT
				codtipomisa, descripcion, valorsugerido, valorminimo, fh
			FROM
				" . $this->table_name . "
			ORDER BY
				codtipomisa DESC";

	// prepare query statement
	$stmt = $this->conn->prepare( $query );

	// execute query
	$stmt->execute();

	return $stmt;
}
// used when filling up the update tipomisaform
function readOne(){

    // query to read single record
    $query = "SELECT
                descripcion, valorsugerido, valorminimo
            FROM
                " . $this->table_name . "
            WHERE
                codtipomisa = ?
            LIMIT
                0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->codtipomisa);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->descripcion = $row['descripcion'];
    $this->valorsugerido = $row['valorsugerido'];
    $this->valorminimo = $row['valorminimo'];
}
// update the TipoMisa
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                descripcion = :descripcion,
                valorsugerido = :valorsugerido,
                valorminimo = :valorminimo
            WHERE
                codtipomisa = :codtipomisa";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // posted values
    $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
    $this->valorsugerido=htmlspecialchars(strip_tags($this->valorsugerido));
    $this->valorminimo=htmlspecialchars(strip_tags($this->valorminimo));

    // bind new values
    $stmt->bindParam(':descripcion', $this->descripcion);
    $stmt->bindParam(':valorsugerido', $this->valorsugerido);
    $stmt->bindParam(':valorminimo', $this->valorminimo);
    $stmt->bindParam(':codtipomisa', $this->codtipomisa);

    // execute the query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}
// delete the product
function delete(){

    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE codtipomisa = ?";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // bind id of record to delete
    $stmt->bindParam(1, $this->codtipomisa);

    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}
}
?>
