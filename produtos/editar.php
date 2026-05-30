<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id=$id";

$resultado = mysqli_query($conexao,$sql);

$produto = mysqli_fetch_assoc($resultado);

if(isset($_POST['editar'])){

$nome = $_POST['nome'];

$descricao = $_POST['descricao'];

$preco = $_POST['preco'];

$estoque = $_POST['estoque'];

$sqlUpdate = "

UPDATE produtos

SET

nome='$nome',

descricao='$descricao',

preco='$preco',

estoque='$estoque'

WHERE id=$id

";

mysqli_query($conexao,$sqlUpdate);

header("Location: listar.php");

}

?>

<h2>Editar Produto</h2>

<form method="POST">

Nome:

<br>

<input
type="text"
name="nome"
value="<?= $produto['nome']; ?>">

<br><br>

Descrição:

<br>

<textarea
name="descricao"><?= $produto['descricao']; ?></textarea>

<br><br>

Preço:

<br>

<input
type="number"
step="0.01"
name="preco"
value="<?= $produto['preco']; ?>">

<br><br>

Estoque:

<br>

<input
type="number"
name="estoque"
value="<?= $produto['estoque']; ?>">

<br><br>

<button name="editar">

Salvar

</button>

</form>