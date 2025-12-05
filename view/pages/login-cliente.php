<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!empty($_SESSION['erro'])) {
    echo '<div class="alert alert-error" style="margin:1rem 2rem; padding:1rem; background:#ffe6e6; color:#800;">' . htmlspecialchars($_SESSION['erro']) . '</div>';
    unset($_SESSION['erro']);
}
if (!empty($_SESSION['sucesso'])) {
    echo '<div class="alert alert-success" style="margin:1rem 2rem; padding:1rem; background:#e6ffed; color:#064;">' . htmlspecialchars($_SESSION['sucesso']) . '</div>';
    unset($_SESSION['sucesso']);
}
?>

<link rel="stylesheet" href="../assets/css/shared.css">
<link rel="stylesheet" href="../assets/css/pages/forms.css">
<link rel="stylesheet" href="../assets/css/pages/login.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Área do Cliente</h1>
        <p style="font-size: 1.3rem;">Acesse sua conta e realize reservas</p>
    </div>
</section>

<div class="container">
    <div class="login-container">
        <div class="login-card">
            <h2 style="font-size: 2rem; margin-bottom: 0.5rem; text-align: center;">Login</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 2rem;">Entre com suas
                credenciais
            </p>

            <form action="../../controller/LoginController.php" method="POST" id="loginForm"
                class="login-form">
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? ''); ?>">
                <div class="form-group">
                    <label for="login_email">E-mail</label>
                    <input type="email" id="login_email" name="login" required placeholder="seu@email.com">
                    <input type="hidden" name="tipo" value="cliente">
                </div>

                <div class="form-group">
                    <label for="login_password">Senha</label>
                    <input type="password" id="login_password" name="senha" required placeholder="Digite sua senha">
                    <a href="#"
                        style="color: var(--primary-neon); font-size: 0.9rem; float: right; margin-top: 0.5rem;">Esqueceu
                        a senha?</a>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem;">
                    Entrar
                </button>

                <p style="text-align: center; margin-top: 2rem; color: var(--text-secondary);">
                    Não possui cadastro? <a href="cadastro-cliente.php"
                        style="color: var(--primary-neon); font-weight: 600;">Cadastre-se</a>
                </p>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script src="../assets/js/main.js"></script>
<!-- <script>
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const email = formData.get('email');
        const password = formData.get('password');

        // Aqui você faria a requisição AJAX para autenticar
        console.log('Login:', { email, password });

        // Simular login
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'ENTRANDO...';
        submitBtn.disabled = true;

        setTimeout(() => {
            alert('Login realizado com sucesso!');
            window.location.href = 'dashboard.php';
        }, 1500);
    });
</script> -->