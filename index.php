<?php

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
// define('BASE_URL', '/bscdtools');
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

define('BASE_URL', $base === '/' ? '' : $base);

require __DIR__ . '/vendor/autoload.php';

require_once("src/lib/database.php");
require_once("src/lib/utils.php");
require_once("src/model/user.php");

session_start();

if ($_GET['action']) {
    $params = explode('/', $_GET['action']);

    if ($params[0] != "") {
        $controller = $params[0];
        $action = "";

        if (isset($params[1])) {
            $action = $params[1];
        }

        require_once(ROOT . 'src/controller/' . $controller . '.php');

        $controller_name = 'C_' . ucfirst($controller);
        $controller_object = new $controller_name();

        if (method_exists($controller_object::class, $action)) {
            if (isset($params[2]) && isset($params[3]) && isset($params[4])) {
                $controller_object->$action($params[2], $params[3], $params[4]);
            } elseif (isset($params[2]) && isset($params[3])) {
                $controller_object->$action($params[2], $params[3]);
            } elseif (isset($params[2])) {
                $controller_object->$action($params[2]);
            } else {
                $controller_object->$action();
                // $controller_object->default();
                // var_dump($controller_object->$action);
            }
        } else {
            $controller_object->default();
        }
    }
} else {
    require('template/connexion.php');;
}

    // session_start();
    
    // $PORTAL_PATH = "http://localhost/portal/";
    
    // if(!empty($_SESSION['userid']))
    // {

    //     $error = "Vous devez vous connecter au portail pour acceder à cette application";
    //     require('template/error.php');
    // }
    // else
    // {
    //     $error = "Vous devez vous connecter pour acceder à cette application";
    //     require('template/error.php');
    // }