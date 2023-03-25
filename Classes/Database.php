<?php
class Database
{
    private $server;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($server, $username, $password, $database)
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connection = mysqli_connect($server, $username, $password, $database);
        if (!$this->connection) {
            die("connection to this database failed due to" . mysqli_connect_error());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConnection()
    {
        $this->connection->close();
    }
}
?>