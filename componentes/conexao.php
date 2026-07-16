<?php

// defined('BASEPATH') or exit('Acesso não permitido');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Config
{
    private static $local = "localhost";
    private static $porta = "3306";
    private static $banco = "controle_estoque_db";
    private static $usuario = "root";
    private static $senha = "";

    public static function connect()
    {
        $dsn = "mysql:host=" . self::$local .
               ";port=" . self::$porta .
               ";dbname=" . self::$banco .
               ";charset=utf8mb4";

        try {
            $con = new PDO(
                $dsn,
                self::$usuario,
                self::$senha,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

            return $con;

        } catch (PDOException $e) {
            exit("Erro no banco de dados: " . $e->getMessage());
        }
    }

    private static function handleError($msg)
    {
        $paginaAtual = self::getCurrentPage();

        echo "<script>
            alert('" . addslashes($msg) . "');
            window.location.href='" . $paginaAtual . "';
        </script>";

        exit();
    }

    public static function getCurrentPage()
    {
        $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

        $raizSite = $protocolo . $_SERVER['HTTP_HOST'];
        $paginaAtual = $raizSite . $_SERVER['REQUEST_URI'];

        return $paginaAtual;
    }
}
