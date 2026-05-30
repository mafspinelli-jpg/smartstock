<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include("../config/conexao.php");

if(isset($_POST['cadastrar'])){

$nome = $_POST['nome'];

$descricao = $_POST['descricao'];

$preco = $_POST['preco'];

$estoque = $_POST['estoque'];

$sql = "INSERT INTO produtos
(nome,descricao,preco,estoque)

VALUES

('$nome','$descricao','$preco','$estoque')";

if(mysqli_query($conexao,$sql)){

echo "Produto cadastrado!";

}else{

echo "Erro";

}

}

?>

<h2>Cadastrar Produto</h2>

<form method="POST">

Nome:

<br>

<input
type="text"
name="nome"
required>

<br><br>

Descrição:

<br>

<textarea
name="descricao">

</textarea>

<br><br>

Preço:

<br>

<input
type="number"
step="0.01"
name="preco"
required>

<br><br>

Estoque:

<br>

<input
type="number"
name="estoque"
required>

<br><br>

<button name="cadastrar">

Cadastrar

</button>

</form>