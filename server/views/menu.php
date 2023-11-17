<?php

    $action = isset($_GET['action']) ? $_GET['action'] : '';

    switch($action) {
        // Movie Management
        case "getMovie":
            require("movies/getMovie.php");
            break;
        case "addMovie":
            require("movies/addMovie.php");
            break;
        case "updateMovie":
            require("movies/updateMovie.php");
            break;
        case "deleteMovie":
            require("movies/deleteMovie.php");
            break;

        // Format Management
        case "getFormat":
            require("formats/getFormat.php");
            break;
        case "addFormat":
            require("formats/addFormat.php");
            break;
        case "updateFormat":
            require("formats/updateFormat.php");
            break;
        case "deleteFormat":
            require("formats/deleteFormat.php");
            break;

        // Type Management
        case "getType":
            require("types/getType.php");
            break;
        case "addType":
            require("types/addType.php");
            break;
        case "updateType":
            require("types/updateType.php");
            break;
        case "deleteType":
            require("types/deleteType.php");
            break;

        // Nation Management
        case "getNation":
            require("nations/getNation.php");
            break;
        case "addNation":
            require("nations/addNation.php");
            break;
        case "updateNation":
            require("nations/updateNation.php");
            break;
        case "deleteNation":
            require("nations/deleteNation.php");
            break;
            
        // Label Management
        case "getLabel":
            require("labels/getLabel.php");
            break;
        case "addLabel":
            require("labels/addLabel.php");
            break;
        case "updateLabel":
            require("labels/updateLabel.php");
            break;
        case "deleteLabel":
            require("labels/deleteLabel.php");
            break;

        // Room Management
        case "getRoom":
            require("rooms/getRoom.php");
            break;
        case "addRoom":
            require("rooms/addRoom.php");
            break;
        case "updateRoom":
            require("rooms/updateRoom.php");
            break;
        case "deleteRoom":
            require("rooms/deleteRoom.php");
            break;

        // ChairType Management
        case "getChairType":
            require("chairType/getChairType.php");
            break;

        // ChairType Management
        case "getChair":
            require("chairs/getChair.php");
            break;

        // ChairNum Management
        case "getChairNum":
            require("chairNum/getChairNum.php");
            break;

        // Ticket Management
        case "getTicket":
            require("tickets/getTicket.php");
            break;
        case "addTicket":
            require("tickets/addTicket.php");
            break;

        case "getKtg":
            require("showTime/getKtg.php");
            break;

        case "getCalendar":
            require("showTime/getCalendar.php");
            break;

        default:
            require("chart.php");
            break;
        
    }
?>