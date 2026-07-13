<?php
namespace MODEL;

class Livro {
    // Atributos da classe (com tipos corrigidos)
    private ?int $id;
    private int $usuario_id;
    private string $titulo;
    private string $autor;
    private string $editora;
    private string $genero;
    private int $paginas;
    private int $pag_atual;
    private string $status;
    private float $nota;      
    private string $capa;
    private string $sinopse;  
   
    public function __construct(
        ?int $id = null,
        int $usuario_id = 0,
        string $titulo = "",
        string $autor = "",
        string $editora = "",
        string $genero = "",
        int $paginas = 0,
        int $pag_atual = 0,
        string $status = "Quero Ler", 
        float $nota = 0.0,
        string $capa = "",
        string $sinopse = ""
    ) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->editora = $editora;
        $this->genero = $genero;
        $this->paginas = $paginas;
        $this->pag_atual = $pag_atual;
        $this->status = $status;
        $this->nota = $nota;
        $this->capa = $capa;
        $this->sinopse = $sinopse;
    }

   
    public function getId(): ?int {
        return $this->id;
    }
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getUsuarioId(): int {
        return $this->usuario_id;
    }
    public function setUsuarioId(int $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }
    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getAutor(): string {
        return $this->autor;
    }
    public function setAutor(string $autor): void {
        $this->autor = $autor;
    }

    public function getEditora(): string {
        return $this->editora;
    }
    public function setEditora(string $editora): void {
        $this->editora = $editora;
    }

    public function getGenero(): string {
        return $this->genero;
    }
    public function setGenero(string $genero): void {
        $this->genero = $genero;
    }

    public function getPaginas(): int {
        return $this->paginas;
    }
    public function setPaginas(int $paginas): void {
        $this->paginas = $paginas;
    }

    public function getPagAtual(): int {
        return $this->pag_atual;
    }
    public function setPagAtual(int $pag_atual): void {
        $this->pag_atual = $pag_atual;
    }

    public function getStatus(): string {
        return $this->status;
    }
    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getNota(): float {
        return $this->nota;
    }
    public function setNota(float $nota): void {
        $this->nota = $nota;
    }

    public function getCapa(): string {
        return $this->capa;
    }
    public function setCapa(string $capa): void {
        $this->capa = $capa;
    }

    public function getSinopse(): string {
        return $this->sinopse;
    }
    public function setSinopse(string $sinopse): void {
        $this->sinopse = $sinopse;
    }
}
?>