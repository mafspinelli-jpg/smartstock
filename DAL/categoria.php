<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/categoria.php";

class Categoria {

    public function Insert(\MODEL\Categoria $categoria) {
        $sql = "INSERT INTO categorias (nome) VALUES ('{$categoria->getNome()}');";
        
        $con = Conexao::conectar();
        $result = $con->query($sql);
        $con = Conexao::desconectar();

        return $result;
    }

    public function Select() {
        $sql = "SELECT * FROM categorias;";
        $con = Conexao::conectar();
        $registros = $con->query($sql);
        $con = Conexao::desconectar();

        $lstCategorias = [];
        foreach ($registros as $linha) {
            $categoria = new \MODEL\Categoria();
            $categoria->setId($linha['id']);
            $categoria->setNome($linha['nome']);

            $lstCategorias[] = $categoria;
        }
        return $lstCategorias;
    }

    public function Delete(int $id) {
        $sql = "DELETE FROM categorias WHERE id = ?;";
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $result = $query->execute(array($id));
        $con = Conexao::desconectar();

        return $result;
    }

    public function Update(\MODEL\Categoria $categoria) {
        $sql = "UPDATE categorias SET nome = ? WHERE id = ?;";
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $result = $query->execute(array($categoria->getNome(), $categoria->getId()));
        $con = Conexao::desconectar();

        return $result;
    }

    public function SelectById(int $id) {
        $sql = "SELECT * FROM categorias WHERE id = ?;";
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $query->execute(array($id));
        $linha = $query->fetch(\PDO::FETCH_ASSOC);
        $con = Conexao::desconectar();

        if ($linha) {
            $categoria = new \MODEL\Categoria();
            $categoria->setId($linha['id']);
            $categoria->setNome($linha['nome']);
            return $categoria;
        }
        return null;
    }
}
?>