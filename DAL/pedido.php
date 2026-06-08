<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/DAL/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/brownie/MODEL/pedido.php";

class Pedido {

    public function Insert(\MODEL\Pedido $pedido) {
        $con = Conexao::conectar();
        
        $sqlProd = "SELECT quantidade_estoque, preco_venda FROM produtos WHERE id = ?;";
        $queryProd = $con->prepare($sqlProd);
        $queryProd->execute(array($pedido->getProdutoId()));
        $produto = $queryProd->fetch(\PDO::FETCH_ASSOC);

        if (!$produto || $produto['quantidade_estoque'] < $pedido->getQuantidadeVendida()) {
            Conexao::desconectar();
            return "estoque_insuficiente"; 
        }

        $valorTotalCalculado = floatval($produto['preco_venda']) * $pedido->getQuantidadeVendida();
        $pedido->setValorTotal($valorTotalCalculado);

        $sqlBaixa = "UPDATE produtos SET quantidade_estoque = quantidade_estoque - ? WHERE id = ?;";
        $queryBaixa = $con->prepare($sqlBaixa);
        $queryBaixa->execute(array($pedido->getQuantidadeVendida(), $pedido->getProdutoId()));

        $sqlPedido = "INSERT INTO pedidos (cliente_id, produto_id, quantidade_vendida, valor_total) VALUES (?, ?, ?, ?);";
        $queryPedido = $con->prepare($sqlPedido);
        $result = $queryPedido->execute(array(
            $pedido->getClienteId(),
            $pedido->getProdutoId(),
            $pedido->getQuantidadeVendida(),
            $pedido->getValorTotal()
        ));

        Conexao::desconectar();
        return $result;
    }

    public function Select() {
        $sql = "SELECT pedidos.*, clientes.nome AS nome_cliente, produtos.nome AS nome_produto 
                FROM pedidos 
                INNER JOIN clientes ON pedidos.cliente_id = clientes.id 
                INNER JOIN produtos ON pedidos.produto_id = produtos.id
                ORDER BY pedidos.id DESC;";
                
        $con = Conexao::conectar();
        $registros = $con->query($sql);
        Conexao::desconectar();

        return $registros->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function SelectById(int $id) {
        $sql = "SELECT * FROM pedidos WHERE id = ?;";
        $con = Conexao::conectar();
        $query = $con->prepare($sql);
        $query->execute(array($id));
        $linha = $query->fetch(\PDO::FETCH_ASSOC);
        Conexao::desconectar();

        if ($linha) {
            $pedido = new \MODEL\Pedido();
            $pedido->setId($linha['id']);
            $pedido->setClienteId($linha['cliente_id']);
            $pedido->setProdutoId($linha['produto_id']);
            $pedido->setQuantidadeVendida($linha['quantidade_vendida']);
            $pedido->setValorTotal(floatval($linha['valor_total']));
            $pedido->setDataPedido($linha['data_pedido']);
            return $pedido;
        }
        return null;
    }

    public function Delete(int $id) {
        $con = Conexao::conectar();

        $sqlBusca = "SELECT produto_id, quantidade_vendida FROM pedidos WHERE id = ?;";
        $queryBusca = $con->prepare($sqlBusca);
        $queryBusca->execute(array($id));
        $pedidoAntigo = $queryBusca->fetch(\PDO::FETCH_ASSOC);

        if ($pedidoAntigo) {
            $sqlEstorno = "UPDATE produtos SET quantidade_estoque = quantidade_estoque + ? WHERE id = ?;";
            $queryEstorno = $con->prepare($sqlEstorno);
            $queryEstorno->execute(array($pedidoAntigo['quantidade_vendida'], $pedidoAntigo['produto_id']));
        }

        $sqlDel = "DELETE FROM pedidos WHERE id = ?;";
        $queryDel = $con->prepare($sqlDel);
        $result = $queryDel->execute(array($id));

        Conexao::desconectar();
        return $result;
    }

    public function Update(\MODEL\Pedido $pedidoNovo) {
        $con = Conexao::conectar();

        $sqlOriginal = "SELECT quantidade_vendida, produto_id FROM pedidos WHERE id = ?;";
        $queryOriginal = $con->prepare($sqlOriginal);
        $queryOriginal->execute(array($pedidoNovo->getId()));
        $pedidoOriginal = $queryOriginal->fetch(\PDO::FETCH_ASSOC);

        $sqlProd = "SELECT preco_venda, quantidade_estoque FROM produtos WHERE id = ?;";
        $queryProd = $con->prepare($sqlProd);
        $queryProd->execute(array($pedidoNovo->getProdutoId()));
        $produto = $queryProd->fetch(\PDO::FETCH_ASSOC);

        $qtdAntiga = intval($pedidoOriginal['quantidade_vendida']);
        $qtdNova = $pedidoNovo->getQuantidadeVendida();

        $diferenca = $qtdNova - $qtdAntiga;

        if ($diferenca > 0 && $produto['quantidade_estoque'] < $diferenca) {
            Conexao::desconectar();
            return "estoque_insuficiente";
        }

        $sqlAjusteEstoque = "UPDATE produtos SET quantidade_estoque = quantidade_estoque - ? WHERE id = ?;";
        $queryAjuste = $con->prepare($sqlAjusteEstoque);
        $queryAjuste->execute(array($diferenca, $pedidoNovo->getProdutoId()));

        $novoValorTotal = floatval($produto['preco_venda']) * $qtdNova;

        $sqlUpd = "UPDATE pedidos SET 
                   cliente_id = ?, 
                   produto_id = ?, 
                   quantidade_vendida = ?, 
                   valor_total = ? 
                   WHERE id = ?;";
        $queryUpd = $con->prepare($sqlUpd);
        $result = $queryUpd->execute(array(
            $pedidoNovo->getClienteId(),
            $pedidoNovo->getProdutoId(),
            $qtdNova,
            $novoValorTotal,
            $pedidoNovo->getId()
        ));

        Conexao::desconectar();
        return $result;
    }
}
?>