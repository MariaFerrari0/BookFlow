<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/DashboardDAL.php";

use DAL\DashboardDAL;

class DashboardController {
    private DashboardDAL $dal;

    public function __construct() {
        $this->dal = new DashboardDAL();
    }

    /**
     * Retorna um array associativo completo contendo todos os dados prontos para a tela inicial
     */
    public function obterEstatisticasCompletas(int $usuario_id): array {
        return [
            'total_livros'      => $this->dal->totalLivros($usuario_id),
            'total_lidos'       => $this->dal->totalLidos($usuario_id),
            'total_lendo'       => $this->dal->totalLendo($usuario_id),
            'total_quero_ler'   => $this->dal->totalQueroLer($usuario_id),
            'tempo_leitura'     => $this->dal->tempoLeitura($usuario_id), // em minutos
            'paginas_lidas'     => $this->dal->paginasLidas($usuario_id),
            'livro_mais_lido'   => $this->dal->livroMaisLido($usuario_id) ?? 'Nenhum registrado ainda',
            'media_avaliacoes'  => round($this->dal->mediaAvaliacoes($usuario_id), 1)
        ];
    }
}
?>