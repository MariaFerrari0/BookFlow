<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../DAL/LivroDAL.php';
require_once __DIR__ . '/../MODEL/Diario.php';

$nomeUsuario = $_SESSION['usuario_nome'];
$usuario_id = $_SESSION['usuario_id'];


$livroDAL = new LivroDAL();
$meusLivros = $livroDAL->listarPorUsuario($usuario_id);
$totalLivros = count($meusLivros);

// Contagem dinâmica dos livros
$lendoAtualmente = 0;
$finalizados = 0;

foreach ($meusLivros as $livro) {
    if ($livro instanceof Livro) {
        if ($livro->getStatus() === 'Lendo') {
            $lendoAtualmente++;
        }
        if ($livro->getStatus() === 'Finalizado') {
            $finalizados++;
        }
    }
}

$metaConcluida = 0;
if ($totalLivros > 0) {
    $metaConcluida = (int)(($finalizados / $totalLivros) * 100);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFlow - Dashboard</title>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo left valign-wrapper logo-neon" style="gap: 10px; height: 100%;">
                <i class="material-icons" style="color: #782a8c; margin: 0; font-size: 2rem;">auto_stories</i> 
                <span class="logo-neon-text">
                    <span class="brand-book">Book</span><span class="brand-flow">Flow</span>
                </span>
            </a>
            <ul id="nav-mobile" class="right">
                <li><span class="grey-text text-lighten-2 hide-on-small-only" style="font-size: 1rem;">Olá, <b><?php echo htmlspecialchars($nomeUsuario); ?></b></span></li>
                <li>
                    <a href="../CONTROLLER/LogoutController.php" class="waves-effect waves-light btn-flat red-text text-lighten-2 valign-wrapper" style="margin-left: 15px; font-weight: 600;">
                        <i class="material-icons left" style="margin-right: 5px;">logout</i>Sair
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 40px; padding-bottom: 50px;">
        
        <div class="row">
            <div class="col s12">
                <div class="welcome-panel valign-wrapper" style="justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <h4 class="text-neon-purple"> Bem vindo ao BookFlow</h4>
                        <p class="text-neon-subtle">Gerencie sua estante e acompanhe sua evolução literária com foco.</p>
                    </div>
                    <a class="waves-effect waves-light btn-large btn-neon-purple modal-trigger" href="#modal-cadastro">
                        <i class="material-icons left">add</i>Adicionar Livro
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="stat-card pomodoro-card">
                    <div class="pomodoro-header" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="material-icons icon-indigo" id="pomodoro-icon" style="color: #a855f7 !important;">timer</i>
                        <span id="pomodoro-status" style="font-weight: 700; letter-spacing: 1px; color: #a855f7; text-transform: uppercase; font-size: 0.95rem;">Modo Foco</span>
                    </div>
                    
                    <h5 class="pomodoro-time">
                        <span id="pomodoro-minutes">60</span>:<span id="pomodoro-seconds">00</span>
                    </h5>
                    
                    <p style="color: #9ca3af; margin: 0; font-size: 0.95rem;">Mantenha o foco absoluto na sua leitura!</p>
                    
                    <div class="pomodoro-controls">
                        <button id="btn-pomodoro-start" title="Iniciar">
                            <i class="material-icons" style="color: #a855f7 !important;">play_arrow</i>
                        </button>
                        <button id="btn-pomodoro-pause" title="Pausar" style="display: none;">
                            <i class="material-icons" style="color: #c084fc !important;">pause</i>
                        </button>
                        <button id="btn-pomodoro-reset" title="Reiniciar">
                            <i class="material-icons" style="color: #64748b !important;">replay</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m4">
                <div class="stat-card">
                    <i class="material-icons icon-indigo" style="color: #a855f7 !important;">bookmark_border</i>
                    <h5><?php echo $totalLivros; ?></h5>
                    <p>Livros na Estante</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="stat-card">
                    <i class="material-icons icon-orange" style="color: #a855f7 !important;">chrome_reader_mode</i>
                    <h5><?php echo $lendoAtualmente; ?></h5>
                    <p>Lendo Atualmente</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="stat-card">
                    <i class="material-icons icon-green" style="color: #a855f7 !important;">stars</i>
                    <h5><?php echo $metaConcluida; ?>%</h5>
                    <p>Meta Concluída</p>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="col s12">
                <h5 class="estante-titulo text-neon-purple">Minha Estante</h5>
                
                <?php if (empty($meusLivros)): ?>
                    <div class="empty-shelf">
                        <i class="material-icons text-neon-subtle">library_books</i>
                        <p class="text-neon-subtle">Sua estante está vazia. Cadastre o seu primeiro livro acima!</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($meusLivros as $livro): ?>
                            <?php if (!$livro instanceof Livro) continue; ?>
                            <div class="col s12 m4">
                                <div class="book-card" style="position: relative;">
                                    
                                    <div style="position: absolute; top: 15px; right: 15px; z-index: 5; display: flex; gap: 10px; align-items: center;">
                                        <a href="#modal-diario-<?php echo $livro->getId(); ?>" class="modal-trigger" style="background: none; border: none; cursor: pointer; padding: 0;" title="Diário de Leitura">
                                            <i class="material-icons" style="color: #3b82f6; font-size: 1.3rem; transition: color 0.2s;" onmouseover="this.style.color='#60a5fa'" onmouseout="this.style.color='#3b82f6'">edit_note</i>
                                        </a>

                                        <form action="../CONTROLLER/DeleteLivroController.php" method="POST" style="margin: 0;" onsubmit="return confirm('Deseja mesmo remover este livro da sua estante?');">
                                            <input type="hidden" name="livro_id" value="<?php echo $livro->getId(); ?>">
                                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Remover Livro">
                                                <i class="material-icons" style="color: #ef4444; font-size: 1.3rem; transition: color 0.2s;" onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='#ef4444'">delete</i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="card-content">
                                        <span class="card-title" style="padding-right: 50px;"><?php echo htmlspecialchars($livro->getTitulo()); ?></span>
                                        <p><i class="material-icons">person</i> Autor: <?php echo htmlspecialchars($livro->getAutor()); ?></p>
                                        <p><i class="material-icons">import_contacts</i> Total: <?php echo $livro->getPaginasTotal(); ?> págs</p>
                                        
                                        <div style="margin-top: 15px; display: flex; justify-content: space-between; font-size: 0.85rem; color: #9ca3af;">
                                            <span>Lido: <?php echo $livro->getPaginasLidas(); ?> págs</span>
                                            <span style="font-weight: 700; color: #c084fc;"><?php echo $livro->calcularPorcentagem(); ?>%</span>
                                        </div>

                                        <div class="progress-container">
                                            <div class="progress-bar" style="width: <?php echo $livro->calcularPorcentagem(); ?>%;"></div>
                                        </div>

                                        <form action="../CONTROLLER/UpdateProgressoController.php" method="POST" class="progress-form">
                                            <input type="hidden" name="livro_id" value="<?php echo $livro->getId(); ?>">
                                            <span style="font-size: 0.8rem; color: #9ca3af;">Estou na pág:</span>
                                            <input type="number" name="paginas_lidas" value="<?php echo $livro->getPaginasLidas(); ?>" min="0" max="<?php echo $livro->getPaginasTotal(); ?>" required>
                                            <button type="submit" title="Salvar progresso">
                                                <i class="material-icons" style="font-size: 1.3rem;">check_circle</i>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="card-action">
                                        <form action="../CONTROLLER/UpdateStatusController.php" method="POST">
                                            <input type="hidden" name="livro_id" value="<?php echo $livro->getId(); ?>">
                                            
                                            <label class="grey-text text-lighten-2" style="font-size: 0.8rem; font-weight: 600; display: block; margin-bottom: 4px;">STATUS DA LEITURA</label>
                                            <select name="status" class="browser-default status-select" onchange="this.form.submit()">
                                                <option value="Quero comprar" <?php echo $livro->getStatus() === 'Quero comprar' ? 'selected' : ''; ?>>🛍️ Quero comprar</option>
                                                <option value="Quero ler" <?php echo $livro->getStatus() === 'Quero ler' ? 'selected' : ''; ?>>📌 Quero ler</option>
                                                <option value="Lendo" <?php echo $livro->getStatus() === 'Lendo' ? 'selected' : ''; ?>>📖 Lendo</option>
                                                <option value="Finalizado" <?php echo $livro->getStatus() === 'Finalizado' ? 'selected' : ''; ?>>✅ Finalizado</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="modal-diario-<?php echo $livro->getId(); ?>" class="modal modal-diario" style="max-width: 650px; background-color: #1f2937; color: #f3f4f6; border-radius: 12px; max-height: 85%;">
                                <form action="../CONTROLLER/UpdateDiarioController.php" method="POST">
                                    <div class="modal-content" style="padding-bottom: 10px;">
                                        <h4 class="text-neon-purple" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                            <i class="material-icons" style="font-size: 2.2rem; color: #a855f7;">edit_note</i>
                                            Diário de Leitura
                                        </h4>
                                        <p style="color: #9ca3af; margin-bottom: 20px;">
                                            O que você está achando de <b><?php echo htmlspecialchars($livro->getTitulo()); ?></b>? 
                                        </p>
                                        
                                        <input type="hidden" name="livro_id" value="<?php echo $livro->getId(); ?>">
                                        
                                        <div class="input-field" style="margin-top: 15px;">
                                            <textarea id="anotacao-text-<?php echo $livro->getId(); ?>" name="anotacao" class="materialize-textarea" style="color: #f3f4f6; border-bottom: 1px solid #4b5563; min-height: 60px;" placeholder="Qual a sua reflexão de hoje?" required></textarea>
                                            <label for="anotacao-text-<?php echo $livro->getId(); ?>">Sua Anotação</label>
                                        </div>
                                        
                                        <button type="submit" class="btn waves-effect waves-light" style="background-color: #a855f7 !important; width: 100%; margin-top: 10px; border-radius: 6px;">
                                            Adicionar ao Diário 📓
                                        </button>

                                        <hr style="border: 0; border-top: 1px solid #374151; margin: 25px 0 15px 0;">

                                        <h6 style="color: #c084fc; font-weight: 600; margin-bottom: 15px; display: flex; align-items: center; gap: 5px;">
                                            <i class="material-icons" style="font-size: 1.2rem;">history</i> Minhas Anotações
                                        </h6>
                                        
                                        <div class="historico-anotacoes" style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                                            <?php 
                                            // Instancia novamente para garantir escopo limpo do loop e busca dados da tabela correto
                                            $livroDAL_diario = new LivroDAL();
                                            $historico = $livroDAL_diario->listarDiarioDoLivro($livro->getId());
                                            
                                            if (empty($historico)): 
                                            ?>
                                                <p style="color: #64748b; font-style: italic; font-size: 0.95rem; text-align: center; margin-top: 20px;">
                                                    Seu diário para este livro está vazio. Escreva sua primeira anotação acima!
                                                </p>
                                            <?php else: ?>
                                                <?php foreach ($historico as $item): ?>
                                                    <?php if ($item instanceof Diario): ?>
                                                        <div class="comentario-item" style="background-color: #111827; border-left: 4px solid #a855f7; padding: 12px; margin-bottom: 12px; border-radius: 4px;">
                                                            <span style="font-size: 0.75rem; color: #9ca3af; display: block; margin-bottom: 5px; font-weight: 600;">
                                                                📅 Escrito em: <?php echo $item->getDataFormatada(); ?>
                                                            </span>
                                                            <p style="margin: 0; color: #e5e7eb; font-size: 0.92rem; white-space: pre-wrap; line-height: 1.4;"><?php echo htmlspecialchars(trim($item->getAnotacao() ?? '')); ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="background-color: #111827; border-top: 1px solid #374151;">
                                        <a href="#!" class="modal-close waves-effect btn-flat red-text text-lighten-2" style="font-weight: 600;">Fechar</a>
                                    </div>
                                </form>
                            </div>

                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="modal-cadastro" class="modal">
        <form action="../CONTROLLER/LivroController.php" method="POST">
            <div class="modal-content">
                <h4 class="text-neon-purple">Adicionar Novo Livro</h4>
                <p>Preencha as informações para colocar o livro na sua estante.</p>
                
                <div class="input-field" style="margin-top: 20px;">
                    <input type="text" id="titulo" name="titulo" required class="validate">
                    <label for="titulo">Título do Livro</label>
                </div>

                <div class="input-field" style="margin-top: 25px;">
                    <input type="text" id="autor" name="autor" required class="validate">
                    <label for="autor">Autor</label>
                </div>

                <div class="input-field" style="margin-top: 25px;">
                    <input type="number" id="paginas_total" name="paginas_total" required min="1" class="validate">
                    <label for="paginas_total">Total de Páginas</label>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #111827;">
                <a href="#!" class="modal-close waves-effect btn-flat red-text text-lighten-2" style="font-weight: 600;">Cancelar</a>
                <button type="submit" class="btn waves-effect waves-light btn-modal-save">Salvar Livro</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../public/js/dashboard.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa todos os Modais
        var modals = document.querySelectorAll('.modal');
        M.Modal.init(modals);

        let timer;
        let minutesDisplay = document.getElementById('pomodoro-minutes');
        let secondsDisplay = document.getElementById('pomodoro-seconds');
        let statusDisplay = document.getElementById('pomodoro-status');
        let iconDisplay = document.getElementById('pomodoro-icon');
        
        let btnStart = document.getElementById('btn-pomodoro-start');
        let btnPause = document.getElementById('btn-pomodoro-pause');
        let btnReset = document.getElementById('btn-pomodoro-reset');
        
        let isWorkSession = true; 
        let isRunning = false;
        let timeLeft = 60 * 60; 

        function updateDisplay() {
            let mins = Math.floor(timeLeft / 60);
            let secs = timeLeft % 60;
            minutesDisplay.textContent = String(mins).padStart(2, '0');
            secondsDisplay.textContent = String(secs).padStart(2, '0');
        }

        function switchSession() {
            if (isWorkSession) {
                isWorkSession = false;
                timeLeft = 15 * 60; 
                statusDisplay.textContent = "Modo Pausa";
                statusDisplay.style.color = "#4ade80"; 
                statusDisplay.style.textShadow = "0 0 8px rgba(74, 222, 128, 0.6)";
                iconDisplay.textContent = "coffee";
                iconDisplay.style.color = "#4ade80";
                alert("Muito bem! Hora de uma pausa de 15 minutos.");
            } else {
                isWorkSession = true;
                timeLeft = 60 * 60; 
                statusDisplay.textContent = "Modo Foco";
                statusDisplay.style.color = "#a855f7"; 
                statusDisplay.style.textShadow = "0 0 8px rgba(168, 85, 247, 0.6)";
                iconDisplay.textContent = "timer";
                iconDisplay.style.color = "#a855f7";
                alert("Pausa concluída! De volta ao foco da leitura.");
            }
            updateDisplay();
        }

        function startTimer() {
            if (isRunning) return;
            isRunning = true;
            btnStart.style.display = 'none';
            btnPause.style.display = 'inline-flex';
            
            timer = setInterval(() => {
                if (timeLeft > 0) {
                    timeLeft--;
                    updateDisplay();
                } else {
                    clearInterval(timer);
                    isRunning = false;
                    switchSession();
                    startTimer(); 
                }
            }, 1000);
        }

        function pauseTimer() {
            clearInterval(timer);
            isRunning = false;
            btnPause.style.display = 'none';
            btnStart.style.display = 'inline-flex';
        }

        function resetTimer() {
            clearInterval(timer);
            isRunning = false;
            isWorkSession = true;
            timeLeft = 60 * 60;
            statusDisplay.textContent = "Modo Foco";
            statusDisplay.style.color = "#a855f7";
            statusDisplay.style.textShadow = "0 0 8px rgba(168, 85, 247, 0.6)";
            iconDisplay.textContent = "timer";
            iconDisplay.style.color = "#a855f7";
            updateDisplay();
            btnPause.style.display = 'none';
            btnStart.style.display = 'inline-flex';
        }

        btnStart.addEventListener('click', startTimer);
        btnPause.addEventListener('click', pauseTimer);
        btnReset.addEventListener('click', resetTimer);
    });
    </script>
</body>
</html>