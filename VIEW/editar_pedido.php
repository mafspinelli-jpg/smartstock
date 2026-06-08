<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/pedido.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/pedido.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/produto.php";

$pedidoDAL = new \DAL\Pedido();
$clienteDAL = new \DAL\Cliente();
$produtoDAL = new \DAL\Produto();

if (!isset($_GET['id'])) {
    header("Location: pedidos.php");
    exit();
}

$id = intval($_GET['id']);
$pedidoAtual = $pedidoDAL->SelectById($id);

if ($pedidoAtual == null) {
    echo "Pedido não encontrado!";
    exit();
}

if (isset($_POST['editar'])) {
    $pedidoAtual->setClienteId(intval($_POST['cliente_id']));
    $pedidoAtual->setProdutoId(intval($_POST['produto_id']));
    $pedidoAtual->setQuantidadeVendida(intval($_POST['quantidade_vendida']));

    $resultado = $pedidoDAL->Update($pedidoAtual);

    if ($resultado === "estoque_insuficiente") {
        echo "<p style='color: orange;'><b>Erro:</b> Quantidade aumentada excede o estoque disponível!</p>";
    } elseif ($resultado) {
        header("Location: pedidos.php");
        exit();
    } else {
        echo "<p style='color: red;'>Erro ao atualizar o pedido.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pedido - Browni-e</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>

    <a href="pedidos.php"><- Cancelar e Voltar</a>
    <h1>Editar Pedido / Venda Nº <?php echo $pedidoAtual->getId(); ?></h1>

    <p>Valor Atual do Pedido: <b>R$ <?php echo number_format($pedidoAtual->getValorTotal(), 2, ',', '.'); ?></b></p>

    <form method="POST">
        Cliente: <br>
        <select name="cliente_id" required>
            <?php
            $clientes = $clienteDAL->Select();
            foreach ($clientes as $c) {
                $sel = ($c->getId() == $pedidoAtual->getClienteId()) ? "selected" : "";
                echo "<option value='" . $c->getId() . "' $sel>" . $c->getNome() . "</option>";
            }
            ?>
        </select>
        <br><br>

        Doce / Produto: <br>
        <select name="produto_id" required>
            <?php
            $produtos = $produtoDAL->Select();
            foreach ($produtos as $p) {
                $sel = ($p->getId() == $pedidoAtual->getProdutoId()) ? "selected" : "";
                echo "<option value='" . $p->getId() . "' $sel>" . $p->getNome() . " (Estoque: " . $p->getEstoque() . ")</option>";
            }
            ?>
        </select>
        <br><br>

        Quantidade Vendida: <br>
        <input type="number" name="quantidade_vendida" value="<?php echo $pedidoAtual->getQuantidadeVendida(); ?>" min="1" required> <br><br>

        <button name="editar">Salvar Alterações</button>
    </form>

</body>
</html>