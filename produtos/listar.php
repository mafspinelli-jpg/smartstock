<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$sql = "SELECT * FROM produtos";

$resultado = mysqli_query($conexao,$sql);

?>

<h2>Lista de Produtos</h2>

<a href="cadastrar.php">

Cadastrar Novo Produto

</a>

<br><br>

<table border="1">

<tr>

<th>ID</th>

<th>Nome</th>

<th>Descrição</th>

<th>Preço</th>

<th>Estoque</th>

<th>Ações</th>

</tr>

<?php

while($produto = mysqli_fetch_assoc($resultado)){

?>

<tr>

<td>

<?= $produto['id']; ?>

</td>

<td>

<?= $produto['nome']; ?>

</td>

<td>

<?= $produto['descricao']; ?>

</td>

<td>

<?= $produto['preco']; ?>

</td>

<td>

<?= $produto['estoque']; ?>

</td>

<td>

<a href="editar.php?id=<?= $produto['id']; ?>">

Editar

</a>

|

<a href="excluir.php?id=<?= $produto['id']; ?>">

Excluir

</a>

</td>

</tr>

<?php

}

?>

</table>