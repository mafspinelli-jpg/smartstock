<?php
namespace DAL;

use PDO;
use PDOException;

class Conexao {
    private static $dbNome = 'doceria_browni-e'; 
    private static $dbHost = 'localhost';
    private static $dbPort = '3307'; 
    private static $dbUsuario = 'root';
    private static $dbSenha = '';
    
    private static $cont = null;

    public function __construct() {
        die('A função Init não é permitida!');
    }

    public static function conectar() {
        if (null == self::$cont) {
            try {
                self::$cont = new PDO(
                    "mysql:host=" . self::$dbHost . ";port=" . self::$dbPort . ";dbname=" . self::$dbNome, 
                    self::$dbUsuario, 
                    self::$dbSenha
                );
                self::$cont->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Falha na conexão: " . $e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function desconectar() {
        self::$cont = null;
    }
}
?>