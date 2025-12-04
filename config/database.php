<?php

class Database
{
    private $host = "localhost";
    private $port = "3307";
    private $dbName = "route2eat"; // nome do banco de dados
    private $user = "root";
    private $password = "";

    public function conectar()
    {
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbName;charset=utf8mb4";
        try {
            $conn = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return $conn;
        } catch (PDOException $e) {
            // Lançar exceção para ser capturada pelas camadas superiores e facilitar debug
            throw new Exception('Erro ao conectar ao banco de dados: ' . $e->getMessage());
        }
    }
}
?>