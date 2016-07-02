 app2.controller('tipomisaCtrl', function($scope, $http) {
    // more angular JS codes will be here
    $scope.showCreateForm = function(){
    // clear form
    $scope.clearForm();

    // change modal title
    $('#modal-product-title').text("Crear Tipo de Misa");
    // document.getElementById("modal-product-title").style.text="Crear Tipo de Misa";

    // hide update product button
    $('#btn-update-product').hide();
    //document.getElementById("btn-update-product").hide();

    // show create product button
    $('#btn-create-product').show();

}
// clear variable / form values
$scope.clearForm = function(){
    $scope.codtipomisa = "";
    $scope.descripcion = "";
    $scope.valorsugerido = "";
    $scope.valorminimo = "";
}
// create new product
$scope.create_tipomisa = function(){

    // fields in key-value pairs

        $http.post('create_tipomisa.php', {
                'descripcion' : $scope.descripcion,
                'valorsugerido' : $scope.valorsugerido,
                'valorminimo' : $scope.valorminimo
            }
        ).success(function (data, status, headers, config) {
            console.log(data);
            // tell the user new product was created
            Materialize.toast(data, 4000);

            // close modal
            $('#modal-product-form').closeModal();

            // clear modal content
            $scope.clearForm();

            // refresh the list
            $scope.getAll();
        });


}
// read products
$scope.getAll = function(){
	$http.get("read_tipomisa.php").success(function(response){
		$scope.names = response.records;
	});
}
// retrieve record to fill out the form
$scope.readOne = function(codtipomisa){

    // change modal title
    $('#modal-product-title').text("Editar Tipo Misa");

    // show udpate product button
    $('#btn-update-product').show();

    // show create product button
    $('#btn-create-product').hide();

    // post id of product to be edited
    $http.post('read_one_tipomisa.php', {
        'codtipomisa' : codtipomisa
    })
    .success(function(data, status, headers, config){

        // put the values in form
        $scope.codtipomisa = data[0]["codtipomisa"];
        $scope.descripcion = data[0]["descripcion"];
        $scope.valorsugerido = data[0]["valorsugerido"];
        $scope.valorminimo = data[0]["valorminimo"];

        // show modal
        $('#modal-product-form').openModal();
    })
    .error(function(data, status, headers, config){
        Materialize.toast('Unable to retrieve record.', 4000);
    });
}
// update tipomisa record / save changes
$scope.update_tipomisa= function(){
    $http.post('update_tipomisa.php', {
        'codtipomisa' : $scope.codtipomisa,
        'descripcion' : $scope.descripcion,
        'valorsugerido' : $scope.valorsugerido,
        'valorminimo' : $scope.valorminimo
    })
    .success(function (data, status, headers, config){
        // tell the user product record was updated
        Materialize.toast(data, 4000);

        // close modal
        $('#modal-product-form').closeModal();

        // clear modal content
        $scope.clearForm();

        // refresh the product list
        $scope.getAll();
    });
}
// delete tipomisa
$scope.deleteTipoMisa = function(codtipomisa){

    // ask the user if he is sure to delete the record
    if(confirm("Esta seguro que desea borrar ?")){
        // post the id of product to be deleted
        $http.post('delete_tipomisa.php', {
            'codtipomisa' : codtipomisa
        }).success(function (data, status, headers, config){

            // tell the user product was deleted
            Materialize.toast(data, 4000);

            // refresh the list
            $scope.getAll();
        });
    }
}
 });
