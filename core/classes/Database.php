<?php

class Database {

    public static $e;
    public static $pdo;

    public static function connect() {

        try {

            self::$pdo = new PDO('mysql:host=' . DBHOST . ';dbname' . DBNAME . ';', DBUSER, DBPASS);
            self::$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $e = self::$e;

            // echo "Connection successful";

        }
        catch(Exception $e) {

            echo $e -> getMessage();

        }
        return self::$pdo;

    }

}