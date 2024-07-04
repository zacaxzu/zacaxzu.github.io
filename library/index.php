<?php

if (!isset($_GET['rt'])) {
    $controllerName = 'loginController';
    $action = 'index';
} else {
    $rt = $_GET['rt'];
    $parts = explode('/', $rt);
    $controllerName = $parts[0] . 'Controller';
    $action = isset($parts[1]) ? $parts[1] : 'index';
}

if( !file_exists( __DIR__ . '/controller/' . $controllerName . '.class.php' ) )
    error_404();

if($controllerName==='loginController' && $action==='index' && isset($_COOKIE['username'])){
  $action='provjera';
}

if(!isset($_COOKIE['username']) && !isset($_POST['uname'])){
  $controllerName = 'loginController';
}

require_once __DIR__ . '/controller/' . $controllerName . '.class.php';

$c = new $controllerName;

if( !method_exists( $c, $action ) )
    error_404();

$c->$action();


function error_404()
{
    require_once __DIR__ . '/controller/_404Controller.class.php';
    $c = new _404Controller();
    $c->index();
    exit(0);
}

?>
