<?php
class Database
{
    private $dsn = 'mysql:dbname=test;host=localhost;charset=utf8mb4';
    private $username = 'root';
    private $password = '';
    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $message = $e->getMessage();
            return $message;
        }
    }
}
