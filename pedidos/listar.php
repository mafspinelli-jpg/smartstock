<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$sql = "

SELECT

pedidos.id,

clientes.nome AS cliente,

produtos.nome AS produto,

pedidos.quantidade,

pedidos.status,

pedidos.data_pedido

FROM pedidos

INNER JOIN clientes

ON pedidos.cliente_id = clientes.id

INNER JOIN produtos

ON pedidos.produto_id = produtos.id

";

$resultado =
mysqli_query(
$conexao,
$sql
);

?>

<h2> Lista de Pedidos</h2>

<a href="cadastrar.php">

Novo Pedido

</a>

<br><br>

<table border="1">

<tr>

<th>ID</th>

<th>Cliente</th>

<th>Doce</th>

<th>Quantidade</th>

<th>Status</th>

<th>Data</th>

<th>Ações</th>

</tr>

<?php

while(
$pedido =
mysqli_fetch_assoc($resultado)
){

?>

<tr>

<td>

<?= $pedido['id']; ?>

</td>

<td>

<?= $pedido['cliente']; ?>

</td>

<td>

<?= $pedido['produto']; ?>

</td>

<td>

<?= $pedido['quantidade']; ?>

</td>

<td>

<?= $pedido['status']; ?>

</td>

<td>

<?= $pedido['data_pedido']; ?>

</td>

<td>

<a href="editar.php?id=<?= $pedido['id']; ?>">
Editar

</a>
|
<a href="excluir.php?id=<?= $pedido['id']; ?>">

Excluir

</a>
</td>

</tr>

<?php

}

?>

</table>