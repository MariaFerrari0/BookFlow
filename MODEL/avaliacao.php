<?php
namespace MODEL;

class Avaliacao {
    private ?int $id;
    private ?int $livro_id;
    private int $historia;
    private int $personagem;
    private int $escrita;
    private int $nota_geral;
    private string $comentario;

    public function __construct(
        ?int $id = null,
        ?int $livro_id = null,
        int $historia = 0,
        int $personagem = 0,
        int $escrita = 0,
        int $nota_geral = 0,
        string $comentario = ""
    ) {
        $this->id = $id;
        $this->livro_id = $livro_id;
        $this->historia = $historia;
        $this->personagem = $personagem;
        $this->escrita = $escrita;
        $this->nota_geral = $nota_geral;
        $this->comentario = $comentario;
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

    public function getHistoria(): int {
        return $this->historia;
    }
    public function setHistoria(int $historia): void {
        $this->historia = $historia;
    }

    public function getPersonagem(): int {
        return $this->personagem;
    }
    public function setPersonagem(int $personagem): void {
        $this->personagem = $personagem;
    }

    public function getEscrita(): int {
        return $this->escrita;
    }
    public function setEscrita(int $escrita): void {
        $this->escrita = $escrita;
    }

    public function getNotaGeral(): int {
        return $this->nota_geral;
    }
    public function setNotaGeral(int $nota_geral): void {
        $this->nota_geral = $nota_geral;
    }

    public function getComentario(): string {
        return $this->comentario;
    }
    public function setComentario(string $comentario): void {
        $this->comentario = $comentario;
    }
}
?>
