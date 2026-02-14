<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private $db_host = "localhost";
    private $db_name = "journal_db";
    private $db_user = "root";
    private $db_pass = "";

    public function __construct()
    {

        try {
            $this->pdo = new PDO(
                "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8mb4",
                $this->db_user,
                $this->db_pass
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    //Singleton pattern - only one db connection
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    // Prevent cloning
    private function __clone()
    {
    }
}
