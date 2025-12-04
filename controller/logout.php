<?php
require_once __DIR__ . '/../config/auth.php';
// redireciona para a raiz do projeto após logout
logoutAndRedirect('/crud-hackaton/');
?>