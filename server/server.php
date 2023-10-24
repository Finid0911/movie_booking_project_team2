<?php 

// Set CORS headers to allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Get the request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Parse the request URI and split it into an array
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

echo implode(" ", $uri);

// Define the resource name for the API (e.g., 'movies')
$apiResourceName = 'api';
$apiVersion = 'v1';


// Include and initialize the controller for the specified API endpoint

include './controllers/movies/movieControllers.php'; // Include your MovieController file
$controller = new MovieController($requestMethod);
$controller->processRequest(); 

?>