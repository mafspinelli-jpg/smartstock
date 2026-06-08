<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/produto.php";

class Produto {

    public function Insert(\MODEL\Produto $produto) {
        $sql = "INSERT INTO produtos (nome, descricao, preco_venda, quantidade_estoque, categoria_id) 
                VALUES ('{$produto->getNome()}', '{$produto->getDescricao()}', {$produto->getPreco()}, {$produto->getEstoque()}, {$produto->getCategoriaId()});";
                
        $con = Conexao::conectar();
        $result = $con->query($sql);
        $con = Conexao::desconectar();

        return $result;
    }

    public function Select() {
        $sql = "SELECT * FROM produtos;";
        $con = Conexao::conectar();
        $registros = $con->query($sql);
        $con = Conexao::desconectar();

        $lstProdutos = [];
        foreach ($registros as $linha) {
            $produto = new \MODEL\Produto();
            $produto->setId($linha['id']);
            $produto->setNome($linha['nome']);
            
            $produto->setDescricao($linha['descricao']); 
            
            $produto->setPreco(floatval($linha['preco_venda']));
            $produto->setEstoque(intval($linha['quantidade_estoque']));
            $produto->setCategoriaId(intval($linha['categoria_id']));

            $lstProdutos[] = $produto;
        }
        return $lstProdutos;
    }

    public function Delete(int $id) {
        $sql = "DELETE FROM produtos WHERE id = ?;";
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $result = $query->execute(array($id));
        $con = Conexao::desconectar();

        return $result;
    }

    public function Update(\MODEL\Produto $produto) {
        $sql = "UPDATE produtos SET 
                nome = ?, 
                descricao = ?, 
                preco_venda = ?, 
                quantidade_estoque = ?, 
                categoria_id = ? 
                WHERE id = ?;";
                
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $result = $query->execute(array(
            $produto->getNome(),
            $produto->getDescricao(),
            $produto->getPreco(),
            $produto->getEstoque(),
            $produto->getCategoriaId(),
            $produto->getId()
        ));
        $con = Conexao::desconectar();

        return $result;
    }

    public function SelectById(int $id) {
        $sql = "SELECT * FROM produtos WHERE id = ?;";
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $query->execute(array($id));
        $linha = $query->fetch(\PDO::FETCH_ASSOC);
        $con = Conexao::desconectar();

        if ($linha) {
            $produto = new \MODEL\Produto();
            $produto->setId($linha['id']);
            $produto->setNome($linha['nome']);
            $produto->setDescricao($linha['descricao']);
            $produto->setPreco(floatval($linha['preco_venda']));
            $produto->setEstoque(intval($linha['quantidade_estoque']));
            $produto->setCategoriaId(intval($linha['categoria_id']));
            return $produto;
        }
        return null;
    }
}
?>