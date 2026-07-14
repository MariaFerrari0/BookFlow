<?php

class Livro {
    private ?int $id;
    private int $usuario_id;
    private string $titulo;
    private string $autor;
    private int $paginas_total;
    private string $status;
    private int $paginasLidas;
    private ?string $comentarios; // <-- ADICIONADO: Propriedade para guardar o diário de leitura

    public function __construct(
        ?int $id, 
        int $usuario_id, 
        string $titulo, 
        string $autor, 
        int $paginas_total, 
        string $status = 'Quero ler',
        int $paginasLidas = 0,
        ?string $comentarios = '' // <-- ADICIONADO: Parâmetro opcional no construtor
    ) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->paginas_total = $paginas_total;
        $this->status = $status;
        $this->paginasLidas = $paginasLidas;
        $this->comentarios = $comentarios; // <-- ADICIONADO: Inicializa os comentários
    }

    // Getters e Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function getUsuarioId(): int {
        return $this->usuario_id;
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

    public function getPaginasTotal(): int {
        return $this->paginas_total;
    }

    public function setPaginasTotal(int $paginas_total): void {
        $this->paginas_total = $paginas_total;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getPaginasLidas(): int {
        return $this->paginasLidas;
    }

    public function setPaginasLidas(int $paginasLidas): void {
        $this->paginasLidas = $paginasLidas;
    }

    // <-- ADICIONADOS: Getter e Setter para o Diário de Leitura
    public function getComentarios(): ?string {
        return $this->comentarios;
    }

    public function setComentarios(?string $comentarios): void {
        $this->comentarios = $comentarios;
    }

    // Método para calcular a porcentagem de leitura do livro
    public function calcularPorcentagem(): int {
        if ($this->paginas_total <= 0) {
            return 0;
        }
        $porcentagem = ($this->paginasLidas / $this->paginas_total) * 100;
        return (int) min(100, max(0, $porcentagem)); // Garante que fique entre 0 e 100
    }
}