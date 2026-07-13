<?php
namespace MODEL;

class Pomodoro {
    private ?int $id;
    private ?int $livro_id;
    private string $inicio;
    private string $fim; 
    private string $minutos;

    
    public function __construct(
        ?int $id = null,
        ?int $livro_id = null,
        string $inicio = "",
        string $fim = "",
        string $minutos = ""
    ) {
        $this->id = $id;
        $this->livro_id = $livro_id;
        $this->inicio = $inicio;
        $this->fim = $fim;
        $this->minutos = $minutos;
    }

   

    public function getId(): ?int {
        return $this->id;
    }
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getLivroId(): ?int {
        return $this->livro_id;
    }
    public function setLivroId(?int $livro_id): void {
        $this->livro_id = $livro_id;
    }

    public function getInicio(): string {
        return $this->inicio;
    }
    public function setInicio(string $inicio): void {
        $this->inicio = $inicio;
    }

    public function getFim(): string {
        return $this->fim;
    }
    public function setFim(string $fim): void {
        $this->fim = $fim;
    }

    public function getMinutos(): string {
        return $this->minutos;
    }
    public function setMinutos(string $minutos): void {
        $this->minutos = $minutos;
    }
}
?>