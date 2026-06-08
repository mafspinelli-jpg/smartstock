<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/cliente.php";

class Cliente {
    
    public function Insert(\MODEL\Cliente $cliente) {

        $sql = "INSERT INTO clientes (nome, email, telefone, cidade, estado) 
                VALUES ('{$cliente->getNome()}', '{$cliente->getEmail()}', '{$cliente->getTelefone()}', '{$cliente->getCidade()}', '{$cliente->getEstado()}');";
                
        $con = Conexao::conectar();
        $result = $con->query($sql);
        $con = Conexao::desconectar();

        return $result;
    }

    public function Select() {
        $sql = "SELECT * FROM clientes;";
        $con = Conexao::conectar();
        $registros = $con->query($sql);
        $con = Conexao::desconectar();

        $lstClientes = [];
        foreach ($registros as $linha) {
            $cliente = new \MODEL\Cliente();
            $cliente->setId($linha['id']);
            $cliente->setNome($linha['nome']);
            $cliente->setEmail($linha['email']);
            $cliente->setTelefone($linha['telefone']);
            $cliente->setCidade($linha['cidade']); 
            $cliente->setEstado($linha['estado']); 

            $lstClientes[] = $cliente;
        }
        return $lstClientes;
    }

    public function Delete(int $id) {
        $sql = "DELETE FROM clientes WHERE id = ?;";
        
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $result = $query->execute(array($id));
        $con = Conexao::desconectar();

        return $result;
    }

    public function Update(\MODEL\Cliente $cliente) {
        $sql = "UPDATE clientes SET 
                nome = ?, 
                email = ?, 
                telefone = ?, 
                cidade = ?, 
                estado = ? 
                WHERE id = ?;";
                
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $result = $query->execute(array(
            $cliente->getNome(),
            $cliente->getEmail(),
            $cliente->getTelefone(),
            $cliente->getCidade(),
            $cliente->getEstado(),
            $cliente->getId()
        ));
        $con = Conexao::desconectar();

        return $result;
    }

    public function SelectById(int $id) {
        $sql = "SELECT * FROM clientes WHERE id = ?;";
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $query->execute(array($id));
        $linha = $query->fetch(\PDO::FETCH_ASSOC);
        $con = Conexao::desconectar();

        if ($linha) {
            $cliente = new \MODEL\Cliente();
            $cliente->setId($linha['id']);
            $cliente->setNome($linha['nome']);
            $cliente->setEmail($linha['email']);
            $cliente->setTelefone($linha['telefone']);
            $cliente->setCidade($linha['cidade']);
            $cliente->setEstado($linha['estado']);
            return $cliente;
        }
        return null;
    }
}
?>