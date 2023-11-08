<?php

    function queryDB($sql){
        $servername = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "qlyrap";
        $connect = new mysqli($servername, $user, $pass, $dbname);

        if ($connect->connect_error) {
            die("Connection failed!". $connect->connect_error);
        }
        else{
            $query = $connect->query($sql);
            $connect->close();
            return $query;
        }
    }
?>