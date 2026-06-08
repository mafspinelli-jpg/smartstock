<?php
namespace MODEL;

class Usuario {
    private ?int $id = null;
    private ?string $email = null;
    private ?string $senha = null;

    public function __construct() {}

    public function getId() { return $this->id; }
    public function setId(int $id) { $this->id = $id; }

    public function getEmail() { return $this->email; }
    public function setEmail(string $email) { $this->email = $email; }

    public function getSenha() { return $this->senha; }
    public function setSenha(string $senha) { $this->senha = $senha; }
}
?>