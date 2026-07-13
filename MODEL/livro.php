<?php
namespace MODEL;

class Livro {
    private ?int $id_livro;
    private int $id_usuario;
    private string $titulo;
    private string $autor;
    private ?string $status_leitura; // Ex: 'Não Lido', 'Lendo', 'Lido'
    private ?int $paginas;

    public function __construct(
        ?int $id_livro = null,
        int $id_usuario = 0,
        string $titulo = "",
        string $autor = "",
        ?string $status_leitura = "Não Lido",
        ?int $paginas = 0
    ) {
        $this->id_livro = $id_livro;
        $this->id_usuario = $id_usuario;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->status_leitura = $status_leitura;
        $this->paginas = $paginas;
    }

    // Getters e Setters
    public function getIdLivro(): ?int { return $this->id_livro; }
    public function setIdLivro(?int $id): void { $this->id_livro = $id; }

    public function getIdUsuario(): int { return $this->id_usuario; }
    public function setIdUsuario(int $id_usuario): void { $this->id_usuario = $id_usuario; }

    public function getTitulo(): string { return $this->titulo; }
    public function setTitulo(string $titulo): void { $this->titulo = $titulo; }

    public function getAutor(): string { return $this->autor; }
    public function setAutor(string $autor): void { $this->autor = $autor; }

    public function getStatusLeitura(): ?string { return $this->status_leitura; }
    public function setStatusLeitura(?string $status): void { $this->status_leitura = $status; }

    public function getPaginas(): ?int { return $this->paginas; }
    public function setPaginas(?int $paginas): void { $this->paginas = $paginas; }
}