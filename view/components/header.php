<?php
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
    <title>ReservaTech - Sistema de Reservas</title>
</head>
<body>
<header class="header">
    <div class="header-container">
        <a href="../../index.php" class="logo">
            ReservaTech
        </a>
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="nav" id="mainNav">
            <ul class="nav-menu">
                <?php if ($is_restaurant_area): ?>
                    <li><a href="cadastro.php">CADASTRAR</a></li>
                    <li><a href="login.php">LOGIN</a></li>
                    <li><a href="dashboard.php">DASHBOARD</a></li>
                    <li><a href="../cliente/home.php">ÁREA DO CLIENTE</a></li>
                <?php else: ?>
                    <li><a href="home.php">INÍCIO</a></li>
                    <li><a href="reservas.php">MINHAS RESERVAS</a></li>
                    <li><a href="../restaurante/cadastro.php" style="color: var(--secondary-orange);">SOU RESTAURANTE</a></li>
                    <li><a href="#" class="btn btn-outline">Entrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

