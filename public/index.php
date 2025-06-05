<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the application path
define('APP_PATH', dirname(__DIR__) . '/app');

// Include necessary files
require_once APP_PATH . '/config/config.php';
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/helpers/url_helper.php';
require_once APP_PATH . '/helpers/session_helper.php';
require_once APP_PATH . '/helpers/cart_helper.php';

// Autoload Core Libraries and Models
spl_autoload_register(function($className) {
    // First try core directory
    $corePath = APP_PATH . '/core/' . $className . '.php';
    if (file_exists($corePath)) {
        require_once $corePath;
        return;
    }
    
    // Then try models directory
    $modelPath = APP_PATH . '/models/' . $className . '.php';
    if (file_exists($modelPath)) {
        require_once $modelPath;
        return;
    }
});

// Initialize the router
$router = new Router();

// Define routes
$router->get('', 'HomeController@index');
$router->get('home', 'HomeController@index');
$router->get('products', 'ProductController@index');
$router->get('products/show/{id}', 'ProductController@show');
$router->get('products/search', 'ProductController@search');
$router->get('product/{id}', 'ProductController@show');
$router->get('cart', 'CartController@index');
$router->get('cart/add/{id}', 'CartController@add');
$router->get('cart/remove/{id}', 'CartController@remove');
$router->post('cart/update', 'CartController@update');
$router->get('cart/clear', 'CartController@clear');

// Category routes
$router->get('categories', 'CategoryController@index');
$router->get('categories/show/{id}', 'CategoryController@show');
$router->get('category/{id}', 'CategoryController@show'); // Legacy URL support

// Auth routes
$router->get('auth/login', 'AuthController@login');
$router->post('auth/login', 'AuthController@login');
$router->get('auth/register', 'AuthController@register');
$router->post('auth/register', 'AuthController@register');
$router->get('auth/logout', 'AuthController@logout');

// User routes
$router->get('users/profile', 'UsersController@profile');
$router->post('users/updateProfile', 'UsersController@updateProfile');

// Checkout routes
$router->get('checkout', 'CheckoutController@index');
$router->post('checkout/processOrder', 'CheckoutController@processOrder');
$router->get('checkout/thank-you', 'CheckoutController@thankYou');

// Debug output
error_log("Routes defined: " . print_r($router, true));

// Dispatch the request
$router->dispatch(); 