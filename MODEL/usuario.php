<?php
namespace MODEL;

class Usuario {
    private ?int $id_usuario; 
    private string $nome;
    private string $email;
    private string $senha;
    private string $criado_em; 

    
    public function __construct(
        ?int $id_usuario = null, 
        string $nome = "", 
        string $email = "", 
        string $senha = "", 
        string $criado_em = "" 
    ) {
        $this->id_usuario = $id_usuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->criado_em = $criado_em;
    }

    public function getIdUsuario(): ?int { 
        return $this->id_usuario; 
    }
    public function setIdUsuario(?int $id): void { 
        $this->id_usuario = $id; 
    }

    public function getNome(): string { 
        return $this->nome; 
    }
    public function setNome(string $nome): void { 
        $this->nome = $nome; 
    }

    public function getEmail(): string { 
        return $this->email; 
    }
    public function setEmail(string $email): void { 
        $this->email = $email; 
    }

    public function getSenha(): string { 
        return $this->senha; 
    }
    public function setSenha(string $senha): void { 
        $this->senha = $senha; 
    }

   
    public function getCriadoEm(): string { 
        return $this->criado_em; 
    }
    public function setCriadoEm(string $criado_em): void { 
        $this->criado_em = $criado_em; 
    }
}
?>