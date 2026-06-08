<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/usuario.php";

class Usuario {

    public function Login(string $email, string $senha) {
        $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?;";
        
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $query->execute(array($email, $senha));
        $linha = $query->fetch(\PDO::FETCH_ASSOC);
        $con = Conexao::desconectar();

        if ($linha) {
            $usuario = new \MODEL\Usuario();
            $usuario->setId($linha['id']);
            $usuario->setEmail($linha['email']);
            $usuario->setSenha($linha['senha']);
            return $usuario;
        }

        return null; 
    }
}
?>