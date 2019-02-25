<?php
/**
 * Created by PhpStorm.
 * User: Rubens
 * Date: 03/09/2018
 * Time: 15:07
 */

namespace Source\Database;

use \PDO;
use \PDOException;

class Connect
{
    private const HOST = "localhost";
    private const USER = "root";
    private const DBNAME = "rb_test";
    private const PASSWD = "";

    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static $instance;

    /**
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=". self::HOST .";dbname=". self::DBNAME,
                    self::USER,
                    self::PASSWD,
                    self::OPTIONS
                );
            } catch (PDOException $exception) {
                die("<h1>Erro ao conectar com o banco de dados!</h1>");
            }
        }

        return self::$instance;
    }


    final private function __construct()
    {
    }

    final private function __clone()
    {
    }
}