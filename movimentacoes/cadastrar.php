<?php

session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../login.php");

exit();

}

include(__DIR__ . "/../config/conexao.php");

$produtos = mysqli_query(
$conexao,
"SELECT * FROM produtos"
);

if(isset($_POST['movimentar'])){

$produto_id = $_POST['produto'];

$tipo = $_POST['tipo'];

$qtd = $_POST['quantidade'];

if($tipo == "entrada"){

mysqli_query(

$conexao,

"UPDATE produtos

SET estoque = estoque + $qtd

WHERE id=$produto_id"

);

mysqli_query(

$conexao,

"INSERT INTO movimentacoes
(produto_id,tipo,quantidade)

VALUES

('$produto_id',
'$tipo',
'$qtd')"

);

echo "Produção registrada";

}else{

$consulta = mysqli_query(

$conexao,

"SELECT estoque

FROM produtos

WHERE id=$produto_id"

);

$produto = mysqli_fetch_assoc($consulta);

if($produto['estoque'] >= $qtd){

mysqli_query(

$conexao,

"UPDATE produtos

SET estoque = estoque - $qtd

WHERE id=$produto_id"

);

mysqli_query(

$conexao,

"INSERT INTO movimentacoes
(produto_id,tipo,quantidade)

VALUES

('$produto_id',
'$tipo',
'$qtd')"

);

echo "Venda registrada";

}else{

echo "Estoque insuficiente";

}

}

}

?>

<h2> Movimentar Estoque</h2>

<form method="POST">

Produto:

<br>

<select name="produto">

<?php

while($p = mysqli_fetch_assoc($produtos)){

?>

<option value="<?= $p['id']; ?>">

<?= $p['nome']; ?>

</option>

<?php

}

?>

</select>

<br><br>

Tipo:

<br>

<select name="tipo">

<option value="entrada">

Produção

</option>

<option value="saida">

Venda

</option>

</select>

<br><br>

Quantidade:

<br>

<input
type="number"
name="quantidade"
required>

<br><br>

<button name="movimentar">

Registrar

</button>

</form>

<br>

<a href="../index.php">

Voltar

</a>