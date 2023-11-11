<?php

    $action = isset($_GET['action']) ? $_GET['action'] : '';

    switch($action) {
        case "getMovie":
            require("movies/getMovie.php");
            break;
        case "addMovie":
            require("movies/addMovie.php");
            break;
        case "updateMovie":
            require("movies/updateMovie.php");
            break;

        default:
            echo "Action is invalid!";
            break;
        
    }
?>