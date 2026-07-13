<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/AvaliacaoDAL.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/avaliacao.php";

use DAL\AvaliacaoDAL;
use MODEL\Avaliacao;

class AvaliacaoController {
    private AvaliacaoDAL $dal;

    public function __construct() {
        $this->dal = new AvaliacaoDAL();
    }

    public function salvarAvaliacao(
        int $livro_id, int $historia, int $personagem, int $escrita, int $nota_geral, string $comentario
    ): bool {
        // Valida se as notas estão no intervalo correto (ex: 0 a 5 ou 0 a 10)
        if ($nota_geral < 0 || $nota_geral > 10) {
            return false;
        }

        // Verifica se este livro já tem uma avaliação
        $existente = $this->dal->buscarAvaliacao($livro_id);
        if ($existente !== null) {
            // Se já existir, redireciona o fluxo para editar
            $avaliacao = new Avaliacao($existente->getId(), $livro_id, $historia, $personagem, $escrita, $nota_geral, $comentario);
            return $this->dal->editarAvaliacao($avaliacao);
        }

        $avaliacao = new Avaliacao(null, $livro_id, $historia, $personagem, $escrita, $nota_geral, $comentario);
        return $this->dal->salvarAvaliacao($avaliacao);
    }

    public function listarAvaliacoes(int $usuario_id): array {
        return $this->dal->listarAvaliacoes($usuario_id);
    }

    public function buscarAvaliacao(int $livro_id): ?Avaliacao {
        return $this->dal->buscarAvaliacao($livro_id);
    }

    public function editarAvaliacao(
        int $id, int $livro_id, int $historia, int $personagem, int $escrita, int $nota_geral, string $comentario
    ): bool {
        $avaliacao = new Avaliacao($id, $livro_id, $historia, $personagem, $escrita, $nota_geral, $comentario);
        return $this->dal->editarAvaliacao($avaliacao);
    }

    public function excluirAvaliacao(int $id): bool {
        return $this->dal->excluirAvaliacao($id);
    }

    public function mediaLivro(int $livro_id): float {
        return $this->dal->mediaLivro($livro_id);
    }
}
?>