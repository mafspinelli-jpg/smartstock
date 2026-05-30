<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "smartstock";

$conexao = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro na conexão com o banco de dados");
}

?>