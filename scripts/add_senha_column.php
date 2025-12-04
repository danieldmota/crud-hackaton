<?php
require_once __DIR__ . '/../config/database.php';

try {
    $db = new Database();
    $pdo = $db->conectar();

    // Checar se coluna 'senha' já existe
    // Descobrir o nome do banco usado na conexão
    $currentDb = $pdo->query('SELECT DATABASE()')->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :db AND TABLE_NAME = 'restaurantes' AND COLUMN_NAME = 'senha'");
    $stmt->execute([':db' => $currentDb]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && intval($row['cnt']) === 0) {
        echo "Coluna 'senha' não encontrada. Criando...\n";
        $pdo->exec("ALTER TABLE restaurantes ADD COLUMN senha VARCHAR(255) DEFAULT NULL");
        echo "Coluna 'senha' adicionada com sucesso.\n";
    } else {
        echo "Coluna 'senha' já existe. Nada a fazer.\n";
    }

} catch (Exception $e) {
    echo "Erro ao executar migration: " . $e->getMessage() . "\n";
}

?>