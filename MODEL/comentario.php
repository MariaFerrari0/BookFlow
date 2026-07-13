<?php
namespace MODEL;

class Comentario {
    private ?int $id;
    private ?int $livro_id;
    private string $comentario;
    private int $pagina;
    private string $data;

    public function __construct(
        ?int $id = null,
        ?int $livro_id = null,
        string $comentario = "",
        int $pagina = 0,
        string $data = ""
    ) {
        $this->id = $id;
        $this->livro_id = $livro_id;
        $this->comentario = $comentario;
        $this->pagina = $pagina;
        $this->data = $data;
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

    public function getComentario(): string {
        return $this->comentario;
    }
    public function setComentario(string $comentario): void {
        $this->comentario = $comentario;
    }

    public function getPagina(): int {
        return $this->pagina;
    }
    public function setPagina(int $pagina): void {
        $this->pagina = $pagina;
    }

    public function getData(): string {
        return $this->data;
    }
    public function setData(string $data): void {
        $this->data = $data;
    }
}
?>