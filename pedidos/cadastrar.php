<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$clientes =
mysqli_query(
$conexao,
"SELECT * FROM clientes"
);

$produtos =
mysqli_query(
$conexao,
"SELECT * FROM produtos"
);

if(isset($_POST['cadastrar'])){

$cliente =
$_POST['cliente'];

$produto =
$_POST['produto'];

$qtd =
$_POST['quantidade'];

$status =
$_POST['status'];

$sql = "

INSERT INTO pedidos

(cliente_id,
produto_id,
quantidade,
status)

VALUES

('$cliente',
'$produto',
'$qtd',
'$status')

";

if(mysqli_query($conexao,$sql)){

echo "Pedido cadastrado";

}else{

echo "Erro";

}

}

?>

<h2> Novo Pedido</h2>

<form method="POST">

Cliente:

<br>

<select name="cliente">

<?php

while($c =
mysqli_fetch_assoc($clientes)){

?>

<option value="<?= $c['id']; ?>">

<?= $c['nome']; ?>

</option>

<?php } ?>

</select>

<br><br>

Doce:

<br>

<select name="produto">

<?php

while($p =
mysqli_fetch_assoc($produtos)){

?>

<option value="<?= $p['id']; ?>">

<?= $p['nome']; ?>

</option>

<?php } ?>

</select>

<br><br>

Quantidade:

<br>

<input
type="number"
name="quantidade"
required>

<br><br>

Status:

<br>

<select name="status">

<option>

Pendente

</option>

<option>

Preparando

</option>

<option>

Enviado

</option>

</select>

<br><br>

<button name="cadastrar">

Cadastrar Pedido

</button>

</form>