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

// LÓGICA DE EXCLUIR PEDIDO (COM RETORNO DE ESTOQUE)
if (isset($_GET['excluir_id'])) {
    $idExcluir = intval($_GET['excluir_id']);
    $resultadoDel = $pedidoDAL->Delete($idExcluir);

    if ($resultadoDel) {
        header("Location: pedidos.php");
        exit();
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao deletar o pedido.</div>";
    }
}

// LÓGICA DE CADASTRAR PEDIDO
if (isset($_POST['cadastrar'])) {
    $pedido = new \MODEL\Pedido();
    $pedido->setClienteId(intval($_POST['cliente_id']));
    $pedido->setProdutoId(intval($_POST['produto_id']));
    $pedido->setQuantidadeVendida(intval($_POST['quantidade_vendida']));

    $resultado = $pedidoDAL->Insert($pedido);

    if ($resultado === "estoque_insuficiente") {
        echo "<div class='alerta alerta-aviso'><b>Aviso:</b> Estoque insuficiente para realizar este pedido!</div>";
    } elseif ($resultado) {
        header("Location: pedidos.php");
        exit();
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao registrar pedido.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Pedidos - Browni-e</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>

    <a href="../index.php"><- Voltar para o Painel Principal</a>
    <h1>Novo Pedido / Venda da Doceria</h1>

    <h2>Registrar Nova Venda</h2>
    <form method="POST">
        Cliente: <br>
        <select name="cliente_id" required>
            <option value="">-- Selecione o Cliente --</option>
            <?php
            $clientes = $clienteDAL->Select();
            foreach ($clientes as $c) {
                echo "<option value='" . $c->getId() . "'>" . $c->getNome() . "</option>";
            }
            ?>
        </select>
        <br>

        Doce / Produto: <br>
        <select name="produto_id" required>
            <option value="">-- Selecione o Doce --</option>
            <?php
            $produtos = $produtoDAL->Select();
            foreach ($produtos as $p) {
                echo "<option value='" . $p->getId() . "'>" . $p->getNome() . " (Estoque: " . $p->getEstoque() . ")</option>";
            }
            ?>
        </select>
        <br>

        Quantidade Vendida: <br>
        <input type="number" name="quantidade_vendida" min="1" placeholder="0" required> <br><br>

        <button name="cadastrar">Confirmar Pedido (Venda)</button>
    </form>

    <hr>

    <h3>Histórico de Pedidos / Vendas Realizadas</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Doce / Produto</th>
            <th>Qtd Vendida</th>
            <th>Valor Total</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        <?php
        $historico = $pedidoDAL->Select();
        foreach ($historico as $ped) {
            echo "<tr>";
            echo "<td>" . $ped['id'] . "</td>";
            echo "<td>" . $ped['nome_cliente'] . "</td>";
            echo "<td>" . $ped['nome_produto'] . "</td>";
            echo "<td>" . $ped['quantidade_vendida'] . "</td>";
            echo "<td>R$ " . number_format($ped['valor_total'], 2, ',', '.') . "</td>";
            echo "<td>" . $ped['data_pedido'] . "</td>";
            echo "<td>
                    <a href='editar_pedido.php?id=" . $ped['id'] . "' style='color: blue;'>[Editar]</a> | 
                    <a href='pedidos.php?excluir_id=" . $ped['id'] . "' onclick=\"return confirm('Deseja cancelar esse pedido e estornar o estoque?')\" style='color: red;'>[Excluir]</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>