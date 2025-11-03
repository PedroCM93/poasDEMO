<?php
class Database{
    public  static function connect(): PDO {
        $host = "127.0.0.1";
        $user = "root";
        $pass = "";
        $dbName = "poas";
        $charset = "utf8";

        $options = [
            PDO:: ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC
        ];

        $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";

        $pdo = new PDO( $dsn, $user, $pass, $options );
        // Optional: Set error mode to exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}


?>