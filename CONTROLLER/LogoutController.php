<?php
session_start();

// Destrói todas as variáveis de sessão cadastradas
session_unset();
session_destroy();

// Manda de volta para a tela de login
header("Location: ../VIEW/login.php");
exit;