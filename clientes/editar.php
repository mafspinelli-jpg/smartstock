<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM clientes WHERE id=$id";

$resultado = mysqli_query($conexao,$sql);

$cliente = mysqli_fetch_assoc($resultado);

if(isset($_POST['editar'])){

$nome = $_POST['nome'];

$email = $_POST['email'];

$telefone = $_POST['telefone'];

$cidade = $_POST['cidade'];

$sqlUpdate = "

UPDATE clientes

SET

nome='$nome',

email='$email',

telefone='$telefone',

cidade='$cidade'

WHERE id=$id

";

mysqli_query($conexao,$sqlUpdate);

header("Location: listar.php");

}

?>

<h2>Editar Cliente</h2>

<form method="POST">

Nome:

<br>

<input
type="text"
name="nome"
value="<?= $cliente['nome']; ?>">

<br><br>

Email:

<br>

<input
type="email"
name="email"
value="<?= $cliente['email']; ?>">

<br><br>

Telefone:

<br>

<input
type="text"
name="telefone"
value="<?= $cliente['telefone']; ?>">

<br><br>

Cidade:

<br>

<input
type="text"
name="cidade"
value="<?= $cliente['cidade']; ?>">

<br><br>

<button name="editar">

Salvar

</button>

</form>