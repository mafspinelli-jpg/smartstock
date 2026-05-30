<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$id = $_GET['id'];

$sql = "DELETE FROM clientes WHERE id=$id";

mysqli_query($conexao,$sql);

header("Location: listar.php");

?>