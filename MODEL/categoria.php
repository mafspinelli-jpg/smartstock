<?php
namespace MODEL;

class Categoria {
    private ?int $id = null;
    private ?string $nome = null;

    public function __construct() {}

    public function getId() { return $this->id; }
    public function setId(int $id) { $this->id = $id; }

    public function getNome() { return $this->nome; }
    public function setNome(string $nome) { $this->nome = $nome; }
}
?>