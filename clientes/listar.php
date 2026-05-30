<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$sql = "SELECT * FROM clientes";

$resultado = mysqli_query($conexao,$sql);

?>

<h2>Lista de Clientes</h2>

<a href="cadastrar.php">

Cadastrar Cliente

</a>

<br><br>

<table border="1">

<tr>

<th>ID</th>

<th>Nome</th>

<th>Email</th>

<th>Telefone</th>

<th>Cidade</th>

<th>Ações</th>

</tr>

<?php

while($cliente = mysqli_fetch_assoc($resultado)){

?>

<tr>

<td>

<?= $cliente['id']; ?>

</td>

<td>

<?= $cliente['nome']; ?>

</td>

<td>

<?= $cliente['email']; ?>

</td>

<td>

<?= $cliente['telefone']; ?>

</td>

<td>

<?= $cliente['cidade']; ?>

</td>

<td>

<a href="editar.php?id=<?= $cliente['id']; ?>">

Editar

</a>

|

<a href="excluir.php?id=<?= $cliente['id']; ?>">

Excluir

</a>

</td>

</tr>

<?php

}

?>