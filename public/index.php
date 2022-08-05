<?php

require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'logout']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);

$router->add('sendpic', ['controller' => 'sendpic', 'action' => 'send']);
$router->add('{controller}/{action}');

//$router->add('',['controller'=>'Home','action'=>'index','namespace'=>'Home']);
//$router->add("{controller}/{action}",['namespace'=>'Home']);
$router->add("admin/{controller}/{action}",['namespace'=>'Admin']);


$router->dispatch($_SERVER["QUERY_STRING"]);
