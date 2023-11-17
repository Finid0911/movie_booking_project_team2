<?php
    include("../views/base.php");
    $movieID = $_GET['id'];
    
    $sql_delete = "DELETE FROM phim WHERE MaPhim = '$movieID'";
    if(queryDB($sql_delete) === TRUE){
        echo "<script> window.location.href='http://localhost/movie_booking_project_team2/server/views/?action=getMovie' </script>";
    } else{
        echo "Cannot delete!";
    }
    
?>