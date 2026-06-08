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

if (!isset($_GET['id'])) {
    header("Location: produtos.php");
    exit();
}

$id = intval($_GET['id']);
$produtoAtual = $produtoDAL->SelectById($id);

if ($produtoAtual == null) {
    echo "Produto não encontrado!";
    exit();
}

if (isset($_POST['editar'])) {
    $produtoAtual->setNome($_POST['nome']);
    $produtoAtual->setDescricao($_POST['descricao']);
    $produtoAtual->setPreco(floatval($_POST['preco']));
    $produtoAtual->setEstoque(intval($_POST['estoque']));
    $produtoAtual->setCategoriaId(intval($_POST['categoria_id']));

    $resultado = $produtoDAL->Update($produtoAtual);

    if ($resultado) {
        header("Location: produtos.php");
        exit();
    } else {
        echo "<p style='color: red;'>Erro ao atualizar o produto.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto - Browni-e</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>

    <a href="produtos.php"><- Cancelar e Voltar</a>
    <h1>Editar Cadastro do Doce</h1>

    <form method="POST">
        Nome do Doce: <br>
        <input type="text" name="nome" value="<?php echo $produtoAtual->getNome(); ?>" required> <br><br>

        Descrição: <br>
        <textarea name="descricao"><?php echo $produtoAtual->getDescricao(); ?></textarea> <br><br>

        Preço: <br>
        <input type="number" step="0.01" name="preco" value="<?php echo $produtoAtual->getPreco(); ?>" required> <br><br>

        Estoque: <br>
        <input type="number" name="estoque" value="<?php echo $produtoAtual->getEstoque(); ?>" required> <br><br>

        Categoria: <br>
        <select name="categoria_id" required>
            <?php
            $todasCategorias = $categoriaDAL->Select();
            foreach ($todasCategorias as $cat) {
                $selected = ($cat->getId() == $produtoAtual->getCategoriaId()) ? "selected" : "";
                echo "<option value='" . $cat->getId() . "' $selected>" . $cat->getNome() . "</option>";
            }
            ?>
        </select>
        <br><br>

        <button name="editar">Salvar Alterações</button>
    </form>

</body>
</html>