<?php
namespace MODEL;

class Produto {
    private ?int $id = null;
    private ?string $nome = null;
    private ?string $descricao = null;
    private ?float $preco = null;
    private ?int $estoque = null;
    private ?int $categoria_id = null; 

    public function __construct() {}

    public function getId() { return $this->id; }
    public function setId(int $id) { $this->id = $id; }

    public function getNome() { return $this->nome; }
    public function setNome(string $nome) { $this->nome = $nome; }

    public function getDescricao() { return $this->descricao; }
    public function setDescricao(?string $descricao) { $this->descricao = $descricao; }

    public function getPreco() { return $this->preco; }
    public function setPreco(float $preco) { $this->preco = $preco; }

    public function getEstoque() { return $this->estoque; }
    public function setEstoque(int $estoque) { $this->estoque = $estoque; }

    public function getCategoriaId() { return $this->categoria_id; }
    public function setCategoriaId(int $categoria_id) { $this->categoria_id = $categoria_id; }
}
?>