<?php
$controller = $_GET['controller'] ?? 'poa';
$method = $_GET['method'] ?? 'index';


$controllerPathFile = __DIR__ . "/../app/controllers/" . ucfirst( $controller ) . "Controller.php";

if ( !file_exists( $controllerPathFile) )
    die("Controller file $controllerPathFile doesn't exist!");

include_once( $controllerPathFile );

$class = ucfirst( $controller ) . "Controller";

if( !class_exists( $class ) )
    die("Class $class doesn't exist!");

$instance = new $class();

if( !method_exists( $instance, $method ) )
    die("The method $method doesn't exist!");

$instance->$method();



?>