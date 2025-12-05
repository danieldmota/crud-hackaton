<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Detectar em qual área estamos
$current_path = $_SERVER['PHP_SELF'];
$is_restaurant_area = strpos($current_path, '/restaurante/') !== false;
$is_client_area = strpos($current_path, '/cliente/') !== false;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#ff6b35">
    <title>Route2Eat - Sistema de Reservas</title>
</head>

<body>
    <header class="header">
        <div class="header-container">
            <a href="../../index.php" class="logo">
                Route2Eat
            </a>
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="nav" id="mainNav">
                <ul class="nav-menu">
                    <?php if ($is_restaurant_area): ?>
                        <li><a href="dashboard.php">DASHBOARD</a></li>
                        <?php if (!empty($_SESSION['restaurante_nome'])): ?>
                            <li><span class="nav-user">Olá, <?php echo htmlspecialchars($_SESSION['restaurante_nome']); ?></span></li>
                            <li><a href="/crud-hackaton/controller/logout.php" class="btn btn-outline">Sair</a></li>
                        <?php else: ?>
                            <li><a href="../login-restaurante.php" class="btn btn-outline">Entrar</a></li>
                        <?php endif; ?>
                    <?php elseif ($is_client_area): ?>
                        <li><a href="home.php">INÍCIO</a></li>
                        <li><a href="reservas.php">MINHAS RESERVAS</a></li>
                        <?php if (!empty($_SESSION['cliente_nome'])): ?>
                            <li><span class="nav-user">Olá, <?php echo htmlspecialchars($_SESSION['cliente_nome']); ?></span></li>
                            <li><a href="/crud-hackaton/controller/logout.php" class="btn btn-outline">Sair</a></li>
                        <?php else: ?>
                            <li><a href="login-cliente.php" class="btn btn-outline">Entrar</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="home.php">INÍCIO</a></li>
                        <li><a href="login-restaurante.php" style="color: var(--secondary-orange);">SOU
                                RESTAURANTE</a></li>
                        <?php if (!empty($_SESSION['cliente_nome'])): ?>
                            <li><span class="nav-user">Olá, <?php echo htmlspecialchars($_SESSION['cliente_nome']); ?></span></li>
                            <li><a href="/crud-hackaton/controller/logout.php" class="btn btn-outline">Sair</a></li>
                        <?php else: ?>
                            <li><a href="login-cliente.php" class="btn btn-outline">Entrar</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>