<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/cliente.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/cliente.php";

$clienteDAL = new \DAL\Cliente();

// LÓGICA DE EXCLUSÃO
if (isset($_GET['excluir_id'])) {
    $idExcluir = intval($_GET['excluir_id']);
    $resultadoDel = $clienteDAL->Delete($idExcluir);

    if ($resultadoDel) {
        header("Location: clientes.php");
        exit();
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao excluir o cliente.</div>";
    }
}

// LÓGICA DE CADASTRO
if (isset($_POST['cadastrar'])) {
    $cliente = new \MODEL\Cliente();
    $cliente->setNome($_POST['nome']);
    $cliente->setEmail($_POST['email']);
    $cliente->setTelefone($_POST['telefone']);
    $cliente->setCidade($_POST['cidade']);
    $cliente->setEstado($_POST['estado']);

    $resultado = $clienteDAL->Insert($cliente);

    if ($resultado) {
        echo "<div class='alerta alerta-sucesso'><b>Sucesso:</b> Cliente cadastrado com orgulho!</div>";
    } else {
        echo "<div class='alerta alerta-erro'><b>Erro:</b> Falha ao cadastrar o cliente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Clientes - Browni-e</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>

    <a href="../index.php"><- Voltar para o Painel Principal</a>
    <h1>Gerenciar Clientes da Doceria</h1>

    <h2>Cadastrar Novo Cliente</h2>
    <form method="POST">
        Nome: <br> <input type="text" name="nome" required> <br>
        Email: <br> <input type="email" name="email" required> <br>
        Telefone: <br> <input type="text" name="telefone" required> <br>
        Cidade: <br> <input type="text" name="cidade" required> <br>
        Estado: <br> <input type="text" name="estado" maxlength="2" placeholder="Ex: SP" required> <br><br>
        <button name="cadastrar">Salvar Cliente</button>
    </form>

    <hr>

    <h3>Clientes Cadastrados</h3>
    <?php
    $listaDeClientes = $clienteDAL->Select();

    if (!empty($listaDeClientes)) {
        // Mudamos para Tabela! Muito mais profissional
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Localização</th>
                <th>Ações</th>
              </tr>";
              
        foreach ($listaDeClientes as $c) {
            echo "<tr>";
            echo "<td>" . $c->getId() . "</td>";
            echo "<td>" . $c->getNome() . "</td>";
            echo "<td>" . $c->getEmail() . "</td>";
            echo "<td>" . $c->getTelefone() . "</td>";
            echo "<td>" . $c->getCidade() . " - " . $c->getEstado() . "</td>";
            
            // Botões de ação com cores organizadas no CSS
            echo "<td>
                    <a href='editar_cliente.php?id=" . $c->getId() . "' style='color: blue;'>[Editar]</a> | 
                    <a href='clientes.php?excluir_id=" . $c->getId() . "' onclick=\"return confirm('Tem certeza que deseja excluir?')\" style='color: red;'>[Excluir]</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum cliente cadastrado ainda.</p>";
    }
    ?>

</body>
</html>