<?php
$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["login"] = $session['login'];
    $response["tipo"] = $session['tipo'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('login', 'clave'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $clave = $r->customer->clave;
    $login = $r->customer->login;
    $user = $db->getOneRecord("select uid,login,clave,tipo from usuario where login='$login'");
    if ($user != NULL)
    {
        //if(passwordHash::check_password($user['clave'],$clave))
        if(strcmp(trim($user['clave']), trim($clave)) == 0)
        {
          $response['status'] = "success";
          $response['message'] = 'Logged in successfully.';
          $response['tipo'] = $user['tipo'];
          $response['uid'] = $user['uid'];
          $response['login'] = $user['login'];
          //$response['createdAt'] = $user['created'];
          if (!isset($_SESSION))
          {
              session_start();
          }
          $_SESSION['uid'] = $user['uid'];
          $_SESSION['login'] = $login;
          $_SESSION['tipo'] = $user['tipo'];
        }
        else
        {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }
    else
    {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
    }
    echoResponse(200, $response);
});
$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('login', 'tipo', 'clave'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    //$phone = $r->customer->phone;
    $tipo = $r->customer->tipo;
    $login = $r->customer->login;
    //$address = $r->customer->address;
    $clave = $r->cuestomer->clave;
    $isUserExists = $db->getOneRecord("select 1 from usuario where login='$login'");
    if(!$isUserExists){
        $r->customer->clave = passwordHash::hash($clave);
        $tabble_name = "usuario";
        $column_names = array('login', 'tipo', 'clave');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['tipo'] = $tipo;
            $_SESSION['login'] = $login;
            //$_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            echoResponse(201, $response);
        }
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});
$app->get('/logout', function() {
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>
