<?php
namespace MODEL;

class Pedido {
    private ?int $id = null;
    private ?int $cliente_id = null;
    private ?int $produto_id = null;
    private ?int $quantidade_vendida = null;
    private ?float $valor_total = null;
    private ?string $data_pedido = null;

    public function __construct() {}

    public function getId() { return $this->id; }
    public function setId(int $id) { $this->id = $id; }

    public function getClienteId() { return $this->cliente_id; }
    public function setClienteId(int $cliente_id) { $this->cliente_id = $cliente_id; }

    public function getProdutoId() { return $this->produto_id; }
    public function setProdutoId(int $produto_id) { $this->produto_id = $produto_id; }

    public function getQuantidadeVendida() { return $this->quantidade_vendida; }
    public function setQuantidadeVendida(int $quantidade_vendida) { $this->quantidade_vendida = $quantidade_vendida; }

    public function getValorTotal() { return $this->valor_total; }
    public function setValorTotal(float $valor_total) { $this->valor_total = $valor_total; }

    public function getDataPedido() { return $this->data_pedido; }
    public function setDataPedido(string $data_pedido) { $this->data_pedido = $data_pedido; }
}
?>