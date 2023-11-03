<?php 

include('view/header.php');
include('config/config.php');


session_start(); 
//declare(strict_types=1); 
error_reporting(-1);
ini_set('display_errors', 'true'); 

$_SESSION['logged_in'] = false;

$request = $_SERVER['REQUEST_URI'];

switch ($request) 
{
    case '':
    case '/':    
    case '/view/login.php':
        if (!$_SESSION['logged_in'])
            require '/view/login.php';
        else
            require '/view/home.php';
        break;

    case '/view/reset_password.php':
        require 'view/reset_password.php';
        break;

    case '/view/register.php':
        break;

    default:        
        http_response_code(404);
        echo '<title>404 Error</title>';
        require 'view/404.php';
        break;
    
}

?>



<?php include('view/footer.php') ?>