<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/categoria.php";

$categoriaDAL = new \DAL\Categoria();

if (!isset($_GET['id'])) {
    header("Location: categorias.php");
    exit();
}

$id = intval($_GET['id']);
$categoriaAtual = $categoriaDAL->SelectById($id);

if ($categoriaAtual == null) {
    echo "Categoria não encontrada!";
    exit();
}

if (isset($_POST['editar'])) {
    $categoriaAtual->setNome($_POST['nome']);
    $resultado = $categoriaDAL->Update($categoriaAtual);

    if ($resultado) {
        header("Location: categorias.php");
        exit();
    } else {
        echo "<p style='color: red;'>Erro ao atualizar a categoria.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria - Browni-e</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>

    <a href="categorias.php"><- Cancelar e Voltar</a>
    <h1>Editar Nome da Categoria</h1>

    <form method="POST">
        Nome da Categoria: <br>
        <input type="text" name="nome" value="<?php echo $categoriaAtual->getNome(); ?>" required> <br><br>
        <button name="editar">Salvar Alterações</button>
    </form>

</body>
</html>