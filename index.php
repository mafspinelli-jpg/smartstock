<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Principal - Browni-e</title>
    <link rel="stylesheet" href="CSS/estilo.css">
</head>
<body>

    <h1>Bem-vindo ao Painel da Doceria Browni-e!</h1>
    <p>Usuário conectado: <b><?php echo $_SESSION['usuario']; ?></b></p>

    <hr>
    <h3>Menu de Navegação</h3>
    <ul>
        <li><a href="index.php">Início / Painel</a></li>
        <li><a href="VIEW/clientes.php">Gerenciar Clientes</a></li>
        <li><a href="VIEW/categorias.php">Gerenciar Categorias</a></li>
        <li><a href="VIEW/produtos.php">Gerenciar Produtos</a></li>
        <li><a href="VIEW/pedidos.php">Gerenciar Pedidos / Vendas</a></li>
    </ul>
    <a href="logout.php"><b>[ SAIR DO SISTEMA ]</b></a>

</body>
</html>