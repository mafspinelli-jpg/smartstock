<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/produto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/categoria.php";

$produtoDAL = new \DAL\Produto();
$categoriaDAL = new \DAL\Categoria();

// LÓGICA DE EXCLUIR PRODUTO
if (isset($_GET['excluir_id'])) {
    $idExcluir = intval($_GET['excluir_id']);
    $resultadoDel = $produtoDAL->Delete($idExcluir);

    if ($resultadoDel) {
        header("Location: produtos.php");
        exit();
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao excluir produto.</div>";
    }
}

// LÓGICA DE CADASTRAR PRODUTO
if (isset($_POST['cadastrar'])) {
    $produto = new \MODEL\Produto();
    $produto->setNome($_POST['nome']);
    $produto->setDescricao($_POST['descricao']);
    $produto->setPreco(floatval($_POST['preco']));
    $produto->setEstoque(intval($_POST['estoque']));
    $produto->setCategoriaId(intval($_POST['categoria_id']));

    $resultado = $produtoDAL->Insert($produto);

    if ($resultado) {
        header("Location: produtos.php");
        exit();
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao cadastrar produto.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Produtos - Browni-e</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>

    <a href="../index.php"><- Voltar para o Painel Principal</a>
    <h1>Gerenciar Produtos (Doces)</h1>

    <h2>Cadastrar Novo Doce</h2>
    <form method="POST">
        Nome do Doce: <br>
        <input type="text" name="nome" placeholder="Ex: Brownie de Nutella" required> <br>

        Descrição: <br>
        <textarea name="descricao" placeholder="Ex: Brownie molhadinho com recheio cremoso..." rows="3"></textarea> <br>

        Preço de Venda (R$): <br>
        <input type="number" step="0.01" name="preco" placeholder="0,00" required> <br>

        Estoque Inicial: <br>
        <input type="number" name="estoque" placeholder="0" required> <br>

        Categoria: <br>
        <select name="categoria_id" required>
            <option value="">-- Selecione uma Categoria --</option>
            <?php
            $todasCategorias = $categoriaDAL->Select();
            foreach ($todasCategorias as $cat) {
                echo "<option value='" . $cat->getId() . "'>" . $cat->getNome() . "</option>";
            }
            ?>
        </select>
        <br><br>

        <button name="cadastrar">Salvar Produto</button>
    </form>

    <hr>

    <h3>Lista de Produtos Cadastrados</h3>
    <?php
    $listaDeProdutos = $produtoDAL->Select();

    if (!empty($listaDeProdutos)) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Categoria ID</th>
                <th>Ações</th>
              </tr>";
        foreach ($listaDeProdutos as $p) {
            echo "<tr>";
            echo "<td>" . $p->getId() . "</td>";
            echo "<td>" . $p->getNome() . "</td>";
            echo "<td>" . $p->getDescricao() . "</td>";
            echo "<td>R$ " . number_format($p->getPreco(), 2, ',', '.') . "</td>";
            echo "<td>" . $p->getEstoque() . " unid.</td>";
            echo "<td>" . $p->getCategoriaId() . "</td>";
            echo "<td>
                    <a href='editar_produto.php?id=" . $p->getId() . "' style='color: blue;'>[Editar]</a> | 
                    <a href='produtos.php?excluir_id=" . $p->getId() . "' onclick=\"return confirm('Deseja mesmo excluir este doce?')\" style='color: red;'>[Excluir]</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum produto cadastrado ainda.</p>";
    }
    ?>

</body>
</html>