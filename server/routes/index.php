<?php

// Get the request method (Ex: Get)
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Parse the request URI and split it into an array
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Example: movie_booking_project_team2/api/v1/movies
$uriSegments = array_filter(explode("/", $uri));

// Define the controller mappings
$controllerMappings = array(
    'movies' => 'MoviesController',
    'users' => 'UsersController',
    'chairs' => 'ChairsController',
    'formats' => 'FormatsController',
    'labels' => 'LabelsController',
    'genres' => 'GenresController',
    'nations' => 'NationsController',
);

if (count($uriSegments) >= 4 && !empty($uriSegments) && isset($controllerMappings[$uriSegments[4]])) {
    // Tên của controller: ex MoviesController
    $controllerName = $controllerMappings[$uriSegments[4]];
    // Đường dẫn của file controller 
    $controllerFile = './controllers/' . $controllerName . '.php';
    // Check controller file is exist 
    if (file_exists($controllerFile)) {
        // Ex: include "./controllers/MoviesController"
        include ($controllerFile);
        // Ex: $instance = new MoviesController('GET')
        $controllerInstance = new $controllerName($requestMethod);
        echo isset($controllerInstance);
        // http://localhost:800/movie_booking_project_team2/api/v1/movies/e2368c36-734a-11ee-a0a4-f8b46aa29aed
        $id = null;
        if (isset($uriSegments[5])) {
            $id = $uriSegments[5];
        }

        // call controller 
        // $instance.processRequest($id)
        $controllerInstance->processRequest($id);
    } else {
        // return 404(not found) if api not found or controller not exist 
        http_response_code(404);
        echo json_encode(array("message" => "API not found"));
    }
} else {
    http_response_code(404); // Not Found
    echo json_encode(array("message" => "API not found"));
}