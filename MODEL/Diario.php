<?php

class Diario {
    private int $id;
    private int $livro_id;
    private string $data_registro;
    private int $paginas_lidas;
    private int $pagina_atual;
    private ?string $anotacao;

    public function __construct(
        int $id, 
        int $livro_id, 
        string $data_registro, 
        int $paginas_lidas, 
        int $pagina_atual, 
        ?string $anotacao
    ) {
        $this->id = $id;
        $this->livro_id = $livro_id;
        $this->data_registro = $data_registro;
        $this->paginas_lidas = $paginas_lidas;
        $this->pagina_atual = $pagina_atual;
        $this->anotacao = $anotacao;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getLivroId(): int {
        return $this->livro_id;
    }

    public function getDataRegistro(): string {
        return $this->data_registro;
    }

    public function getPaginasLidas(): int {
        return $this->paginas_lidas;
    }

    public function getPaginaAtual(): int {
        return $this->pagina_atual;
    }

    public function getAnotacao(): ?string {
        return $this->anotacao;
    }

   
    public function getDataFormatada(): string {
        $timestamp = strtotime($this->data_registro);
        return date('d/m/Y', $timestamp);
    }
}