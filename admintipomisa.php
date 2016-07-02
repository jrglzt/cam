<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administrar Tipo de Misa</title>

    <!-- include material design CSS -->
    <link rel="stylesheet" href="/cam/libs/css/materialize/css/materialize.min.css" />

    <!-- include material design icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- custom CSS -->
<style>
.width-30-pct{
    width:30%;
}

.text-align-center{
    text-align:center;
}

.margin-bottom-1em{
    margin-bottom:1em;
}
</style>

</head>
<body>
  <div class="container" ng-app="myApp2" ng-controller="tipomisaCtrl">
      <div class="row">
          <div class="col s12">
              <h4>Tipos de Misa</h4>

              <!-- used for searching the current list -->
              <input type="text" ng-model="search" class="form-control" placeholder="Buscar Tipo Misa..." />

              <!-- table that shows product record list -->
              <table class="hoverable bordered">

              	<thead>
              		<tr>
              			<th class="text-align-center">ID</th>
              			<th class="width-30-pct">descripcion</th>
              			<th class="width-30-pct">valorsugerido</th>
              			<th class="text-align-center">valorminimo</th>
              			<th class="text-align-center">Action</th>
              		</tr>
              	</thead>

              	<tbody ng-init="getAll()">
              		<tr ng-repeat="d in names | filter:search">
              			<td class="text-align-center">{{ d.id }}</td>
              			<td>{{ d.descripcion }}</td>
              			<td>{{ d.valorsugerido }}</td>
              			<td class="text-align-center">{{ d.valorminimo }}</td>
              			<td>
              				<a ng-click="readOne(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">edit</i>Edit</a>
              				<a ng-click="deleteTipoMisa(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">delete</i>Delete</a>
              			</td>
              		</tr>
              	</tbody>
              </table>


              <!-- modal for for creating new product -->
            <div id="modal-product-form" class="modal">
                <div class="modal-content">
                    <h4 id="modal-product-title">Crear Nuevo Tipo de Misa</h4>
                    <div class="row">
                        <div class="input-field col s12">
                            <input ng-model="descripcion" type="text" class="validate" id="form-descripcion" placeholder="Ingrese descripcion..." required />
                            <label for="descripcion">descripcion</label>
                            <span ng-show="descripcion.$touched &&  descripcion.$invalid">La descripcion es requerida.</span>
                        </div>

                        <div class="input-field col s12">
                            <input ng-model="valorsugerido" type="text" class="validate" id="form-valorsugerido" placeholder="Ingrese valorsugerido..."  />
                            <label for="valorsugerido">valor sugerido</label>
                        </div>


                        <div class="input-field col s12">
                            <input ng-model="valorminimo" type="text" class="validate" id="form-valorminimo" placeholder="Ingrese valorminimo..."  />
                            <label for="valorminimo">valor minimo</label>
                        </div>



                        <div class="input-field col s12">
                            <a id="btn-create-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="create_tipomisa()"><i class="material-icons left">add</i>Create</a>

                            <a id="btn-update-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="update_tipomisa()"><i class="material-icons left">edit</i>Save Changes</a>

                            <a class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">close</i>Close</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- floating button for creating product -->
            <div class="fixed-action-btn" style="bottom:45px; right:24px;">
                <a class="waves-effect waves-light btn modal-trigger btn-floating btn-large red" href="#modal-product-form" ng-click="showCreateForm()"><i class="large material-icons">add</i></a>
            </div>
          </div> <!-- end col s12 -->
      </div> <!-- end row -->
  </div> <!-- end container -->
<!-- page content and controls will be here -->

<!-- include jquery -->
<script type="text/javascript" src="/cam/libs/js/jquery-2.2.4.min.js"></script>

<!-- material design js -->
<script src="/cam/libs/css/materialize/js/materialize.min.js"></script>


<!-- include angular js -->
<script src="/cam/libs/js/angular.min.js"></script>
<script>

// angular js codes will be here
var app2 = angular.module('myApp2', []);
/*app.controller('tipomisaCtrl2', function($scope, $http) {
    // more angular JS codes will be here
    $scope.showCreateForm = function(){
    // clear form
    $scope.clearForm();

    // change modal title
    $('#modal-product-title').text("Crear Tipo de Misa");

    // hide update product button
    $('#btn-update-product').hide();

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
});*/
</script>
<script src="app/tipomisaCtrl.js"></script>
<script>
// jquery codes will be here
$(document).ready(function(){
    // initialize modal
    $('.modal-trigger').leanModal();
});
</script>
</body>
</html>
