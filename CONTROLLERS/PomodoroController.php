<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/PomodoroDAL.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/pomodoro.php";

use DAL\PomodoroDAL;
use MODEL\Pomodoro;

class PomodoroController {
    private PomodoroDAL $dal;

    public function __construct() {
        $this->dal = new PomodoroDAL();
    }

    public function iniciarSessao(int $livro_id): bool {
        $pomodoro = new Pomodoro(null, $livro_id, date('Y-m-d H:i:s'));
        return $this->dal->iniciarSessao($pomodoro);
    }

    public function encerrarSessao(int $id, int $minutos): bool {
        if ($minutos < 0) {
            return false;
        }
        $fim = date('Y-m-d H:i:s');
        return $this->dal->encerrarSessao($id, $fim, $minutos);
    }

    public function listarSessoes(int $livro_id): array {
        return $this->dal->listarSessoes($livro_id);
    }

    public function tempoTotal(int $usuario_id): int {
        return $this->dal->tempoTotal($usuario_id);
    }

    public function tempoHoje(int $usuario_id): int {
        return $this->dal->tempoHoje($usuario_id);
    }

    public function tempoSemana(int $usuario_id): int {
        return $this->dal->tempoSemana($usuario_id);
    }

    public function tempoMes(int $usuario_id): int {
        return $this->dal->tempoMes($usuario_id);
    }
}
?>