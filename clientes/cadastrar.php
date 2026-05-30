<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

if(isset($_POST['cadastrar'])){

$nome = $_POST['nome'];

$email = $_POST['email'];

$telefone = $_POST['telefone'];

$cidade = $_POST['cidade'];

$sql = "

INSERT INTO clientes

(nome,email,telefone,cidade)

VALUES

('$nome','$email','$telefone','$cidade')

";

if(mysqli_query($conexao,$sql)){

echo "Cliente cadastrado!";

}else{

echo "Erro";

}

}

?>

<h2>Cadastrar Cliente</h2>

<form method="POST">

Nome:

<br>

<input
type="text"
name="nome"
required>

<br><br>

Email:

<br>

<input
type="email"
name="email"
required>

<br><br>

Telefone:

<br>

<input
type="text"
name="telefone"
required>

<br><br>

Cidade:

<br>

<input
type="text"
name="cidade"
required>

<br><br>

<button name="cadastrar">

Cadastrar

</button>

</form>