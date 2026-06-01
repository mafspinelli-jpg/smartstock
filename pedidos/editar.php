<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$id = $_GET['id'];

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

$sql = "

SELECT *

FROM pedidos

WHERE id=$id

";

$resultado =
mysqli_query(
$conexao,
$sql
);

$pedido =
mysqli_fetch_assoc(
$resultado
);

if(isset($_POST['editar'])){

$cliente =
$_POST['cliente'];

$produto =
$_POST['produto'];

$qtd =
$_POST['quantidade'];

$status =
$_POST['status'];

$sqlUpdate = "

UPDATE pedidos

SET

cliente_id='$cliente',

produto_id='$produto',

quantidade='$qtd',

status='$status'

WHERE id=$id

";

mysqli_query(
$conexao,
$sqlUpdate
);

header(
"Location: listar.php"
);

}

?>

<h2>Editar Pedido</h2>

<form method="POST">

Cliente:

<br>

<select name="cliente">

<?php

while(
$c =
mysqli_fetch_assoc(
$clientes
)
){

?>

<option

value="<?= $c['id']; ?>"

<?=

$c['id']==$pedido['cliente_id']

?

"selected"

:

""

?>

>

<?= $c['nome']; ?>

</option>

<?php } ?>

</select>

<br><br>

Produto:

<br>

<select name="produto">

<?php

while(
$p =
mysqli_fetch_assoc(
$produtos
)
){

?>

<option

value="<?= $p['id']; ?>"

<?=

$p['id']==$pedido['produto_id']

?

"selected"

:

""

?>

>

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
value="<?= $pedido['quantidade']; ?>">

<br><br>

Status:

<br>

<select name="status">

<option

<?=

$pedido['status']=="Pendente"

?

"selected"

:

""

?>

>

Pendente

</option>

<option

<?=

$pedido['status']=="Preparando"

?

"selected"

:

""

?>

>

Preparando

</option>

<option

<?=

$pedido['status']=="Enviado"

?

"selected"

:

""

?>

>

Enviado

</option>

</select>

<br><br>

<button name="editar">

Salvar

</button>

</form>