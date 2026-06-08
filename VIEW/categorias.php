<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/categoria.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/categoria.php";

$categoriaDAL = new \DAL\Categoria();

// LÓGICA DE EXCLUIR
if (isset($_GET['excluir_id'])) {
    $idExcluir = intval($_GET['excluir_id']);
    $resultadoDel = $categoriaDAL->Delete($idExcluir);

    if ($resultadoDel) {
        header("Location: categorias.php");
        exit();
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao excluir a categoria.</div>";
    }
}

// LÓGICA DE CADASTRAR
if (isset($_POST['cadastrar'])) {
    $categoria = new \MODEL\Categoria();
    $categoria->setNome($_POST['nome']);

    $resultado = $categoriaDAL->Insert($categoria);

    if ($resultado) {
        header("Location: categorias.php");
        exit();
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao cadastrar a categoria.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Categorias - Browni-e</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>

    <a href="../index.php"><- Voltar para o Painel Principal</a>
    <h1>Gerenciar Categorias de Doces</h1>

    <h2>Cadastrar Nova Categoria</h2>
    <form method="POST">
        Nome da Categoria: <br>
        <input type="text" name="nome" placeholder="Ex: Brownies, Bolos, Brigadeiros" required> <br><br>
        <button name="cadastrar">Salvar Categoria</button>
    </form>

    <hr>

    <h3>Categorias Cadastradas</h3>
    <?php
    $listaDeCategorias = $categoriaDAL->Select();

    if (!empty($listaDeCategorias)) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Nome da Categoria</th>
                <th>Ações</th>
              </tr>";

        foreach ($listaDeCategorias as $cat) {
            echo "<tr>";
            echo "<td>" . $cat->getId() . "</td>";
            echo "<td>" . $cat->getNome() . "</td>";
            echo "<td>
                    <a href='editar_categoria.php?id=" . $cat->getId() . "' style='color: blue;'>[Editar]</a> | 
                    <a href='categorias.php?excluir_id=" . $cat->getId() . "' onclick=\"return confirm('Tem certeza que deseja excluir esta categoria?')\" style='color: red;'>[Excluir]</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma categoria cadastrada ainda.</p>";
    }
    ?>

</body>
</html>