<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../DAL/LivroDAL.php';

$nomeUsuario = $_SESSION['usuario_nome'];
$usuario_id = $_SESSION['usuario_id'];

// Busca os livros reais do usuário no banco de dados para listar
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

// Cálculo da Meta Concluída (evitando divisão por zero se a estante estiver vazia)
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
            <a href="#" class="brand-logo left valign-wrapper" style="gap: 10px; height: 100%;">
                <i class="material-icons indigo-text text-lighten-2" style="font-size: 2rem; margin: 0;">auto_stories</i> 
                <span>Book<span class="indigo-text text-lighten-2">Flow</span></span>
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
                        <h4>Seu Painel de Leituras 📚</h4>
                        <p>Gerencie sua estante e acompanhe sua evolução literária.</p>
                    </div>
                    <a class="waves-effect waves-light btn-large indigo accent-4 modal-trigger" href="#modal-cadastro" style="border-radius: 10px; font-weight: 600; text-transform: none; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);">
                        <i class="material-icons left">add</i>Adicionar Livro
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
    <div class="col s12">
        <div class="stat-card pomodoro-card">
            <div class="pomodoro-header" style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 5px;">
                <i class="material-icons icon-indigo" id="pomodoro-icon">timer</i>
                <span id="pomodoro-status" style="font-weight: 700; letter-spacing: 1px; color: #a855f7; text-transform: uppercase; font-size: 0.9rem;">Modo Foco</span>
            </div>
            
            <h5 style="font-size: 3rem !important; font-family: monospace; font-weight: 800; margin: 10px 0 !important; color: #ffffff;">
                <span id="pomodoro-minutes">25</span>:<span id="pomodoro-seconds">00</span>
            </h5>
            
            <p style="color: #9ca3af; margin: 0; font-size: 0.9rem;">Mantenha o foco na sua leitura ativa!</p>
            
            <div class="pomodoro-controls">
                <button id="btn-pomodoro-start" title="Iniciar">
                    <i class="material-icons green-text">play_arrow</i>
                </button>
                <button id="btn-pomodoro-pause" title="Pausar" style="display: none;">
                    <i class="material-icons orange-text">pause</i>
                </button>
                <button id="btn-pomodoro-reset" title="Reiniciar">
                    <i class="material-icons red-text">replay</i>
                </button>
            </div>
        </div>
    </div>
</div>

        <div class="row">
            <div class="col s12 m4">
                <div class="stat-card">
                    <i class="material-icons icon-indigo">bookmark_border</i>
                    <h5><?php echo $totalLivros; ?></h5>
                    <p>Livros na Estante</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="stat-card">
                    <i class="material-icons icon-orange">chrome_reader_mode</i>
                    <h5><?php echo $lendoAtualmente; ?></h5>
                    <p>Lendo Atualmente</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="stat-card">
                    <i class="material-icons icon-green">stars</i>
                    <h5><?php echo $metaConcluida; ?>%</h5>
                    <p>Meta Concluída</p>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="col s12">
                <h5 class="estante-titulo">Minha Estante</h5>
                
                <?php if (empty($meusLivros)): ?>
                    <div class="empty-shelf">
                        <i class="material-icons">library_books</i>
                        <p>Sua estante está vazia. Cadastre o seu primeiro livro acima!</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($meusLivros as $livro): ?>
                            <?php if (!$livro instanceof Livro) continue; ?>
                            <div class="col s12 m4">
                                <div class="book-card" style="position: relative;">
                                    
                                    <form action="../CONTROLLER/DeleteLivroController.php" method="POST" style="position: absolute; top: 15px; right: 15px; z-index: 5;" onsubmit="return confirm('Deseja mesmo remover este livro da sua estante?');">
                                        <input type="hidden" name="livro_id" value="<?php echo $livro->getId(); ?>">
                                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                                            <i class="material-icons" style="color: #ef4444; font-size: 1.3rem; transition: color 0.2s;" onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='#ef4444'">delete</i>
                                        </button>
                                    </form>

                                    <div class="card-content">
                                        <span class="card-title" style="padding-right: 25px;"><?php echo htmlspecialchars($livro->getTitulo()); ?></span>
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
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="modal-cadastro" class="modal">
        <form action="../CONTROLLER/LivroController.php" method="POST">
            <div class="modal-content">
                <h4>Adicionar Novo Livro</h4>
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
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect btn-flat red-text text-lighten-2" style="font-weight: 600;">Cancelar</a>
                <button type="submit" class="btn waves-effect waves-light indigo accent-4" style="border-radius: 8px; font-weight: 600;">Salvar Livro</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../public/js/dashboard.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    let timer;
    let minutesDisplay = document.getElementById('pomodoro-minutes');
    let secondsDisplay = document.getElementById('pomodoro-seconds');
    let statusDisplay = document.getElementById('pomodoro-status');
    let iconDisplay = document.getElementById('pomodoro-icon');
    
    let btnStart = document.getElementById('btn-pomodoro-start');
    let btnPause = document.getElementById('btn-pomodoro-pause');
    let btnReset = document.getElementById('btn-pomodoro-reset');
    
    let isWorkSession = true; // Alterna entre Foco (true) e Pausa (false)
    let isRunning = false;
    let timeLeft = 25 * 60; // 25 minutos em segundos por padrão

    function updateDisplay() {
        let mins = Math.floor(timeLeft / 60);
        let secs = timeLeft % 60;
        minutesDisplay.textContent = String(mins).padStart(2, '0');
        secondsDisplay.textContent = String(secs).padStart(2, '0');
    }

    function switchSession() {
        if (isWorkSession) {
            // Ir para Pausa
            isWorkSession = false;
            timeLeft = 5 * 60; // 5 minutos
            statusDisplay.textContent = "Modo Pausa";
            statusDisplay.style.color = "#4ade80"; // Verde neon
            iconDisplay.textContent = "coffee";
            iconDisplay.className = "material-icons icon-green";
            alert("Muito bem! Hora de uma pausa de 5 minutos.");
        } else {
            // Ir para Foco
            isWorkSession = true;
            timeLeft = 25 * 60; // 25 minutos
            statusDisplay.textContent = "Modo Foco";
            statusDisplay.style.color = "#a855f7"; // Roxo neon
            iconDisplay.textContent = "timer";
            iconDisplay.className = "material-icons icon-indigo";
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
                startTimer(); // Inicia automaticamente o próximo ciclo
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
        timeLeft = 25 * 60;
        statusDisplay.textContent = "Modo Foco";
        statusDisplay.style.color = "#a855f7";
        iconDisplay.textContent = "timer";
        iconDisplay.className = "material-icons icon-indigo";
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