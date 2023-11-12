<?php
class Connector
{
    private static $instance = null;
    private $connection;

    private $servername = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "qlyrap";
    private $port = "3390";

    private function __construct()
    {
        $this->connection = new mysqli($this->servername, $this->user, $this->pass, $this->dbname, $this->port);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connect failed!" . $this->connection->connect_error);

        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function __clone()
    {
        // Prevent cloning of the instance
    }

    public function __wakeup()
    {
        // Prevent unserializing the instance
    }
}


?>