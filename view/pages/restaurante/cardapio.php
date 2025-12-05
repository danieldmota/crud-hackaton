<?php
include_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../../model/CardapioModel.php';

$restauranteId = isset($_SESSION['id'])
    ? (int) $_SESSION['id']
    : (int) ($_GET['restaurante_id'] ?? 1);
$cardapioModel = new CardapioModel();
$itensCardapio = $cardapioModel->listarPorRestaurante($restauranteId);

$categorias = [
    'pratos' => [],
    'bebidas' => [],
    'sobremesas' => []
];

foreach ($itensCardapio as $item) {
    if (isset($categorias[$item['categoria']])) {
        $categorias[$item['categoria']][] = $item;
    }
}

$imagensPadrao = [
    'pratos' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=500&q=80',
    'bebidas' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?auto=format&fit=crop&w=500&q=80',
    'sobremesas' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?auto=format&fit=crop&w=500&q=80'
];
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Gerenciar Cardápio</h1>
        <p style="font-size: 1.3rem;">Adicione e edite os itens do seu cardápio</p>
    </div>
</section>

<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <div class="dashboard-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div class="tabs" style="margin: 0; border-bottom: none;">
                <button class="tab active" data-tab="pratos" onclick="switchTab('pratos')">Pratos</button>
                <button class="tab" data-tab="bebidas" onclick="switchTab('bebidas')">Bebidas</button>
                <button class="tab" data-tab="sobremesas" onclick="switchTab('sobremesas')">Sobremesas</button>
            </div>
            <button class="btn btn-primary" onclick="openAddItemModal()">Adicionar Item</button>
        </div>

        <!-- Pratos -->
        <div id="pratos" class="menu-content active">
            <div class="menu-items-grid">
                <?php if (!empty($categorias['pratos'])): ?>
                    <?php foreach ($categorias['pratos'] as $item): ?>
                        <div class="menu-item-card">
                            <div class="menu-item-image"
                                style="background-image: url('<?php echo $item['imagem'] ? '../../' . htmlspecialchars($item['imagem']) : $imagensPadrao['pratos']; ?>');">
                            </div>
                            <div class="menu-item-info">
                                <h4 class="menu-item-name">
                                    <?php echo htmlspecialchars($item['nome']); ?>
                                    <?php if ((int) $item['disponivel'] === 0): ?>
                                        <span class="badge" style="background: #ff4444; color:#fff; font-size:0.75rem; padding:0.1rem 0.4rem; border-radius:6px;">Indisponível</span>
                                    <?php endif; ?>
                                </h4>
                                <p class="menu-item-description"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                <div class="menu-item-footer">
                                    <span class="menu-item-price">R$ <?php echo number_format((float) $item['preco'], 2, ',', '.'); ?></span>
                                    <div class="menu-item-actions">
                                        <button class="btn-icon" onclick="editMenuItem(<?php echo $item['id']; ?>)" title="Editar">✏️</button>
                                        <button class="btn-icon" onclick="deleteMenuItem(<?php echo $item['id']; ?>)" title="Excluir">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-secondary);">Nenhum prato cadastrado ainda.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bebidas -->
        <div id="bebidas" class="menu-content">
            <div class="menu-items-grid">
                <?php if (!empty($categorias['bebidas'])): ?>
                    <?php foreach ($categorias['bebidas'] as $item): ?>
                        <div class="menu-item-card">
                            <div class="menu-item-image"
                                style="background-image: url('<?php echo $item['imagem'] ? '../../' . htmlspecialchars($item['imagem']) : $imagensPadrao['bebidas']; ?>');">
                            </div>
                            <div class="menu-item-info">
                                <h4 class="menu-item-name">
                                    <?php echo htmlspecialchars($item['nome']); ?>
                                    <?php if ((int) $item['disponivel'] === 0): ?>
                                        <span class="badge" style="background: #ff4444; color:#fff; font-size:0.75rem; padding:0.1rem 0.4rem; border-radius:6px;">Indisponível</span>
                                    <?php endif; ?>
                                </h4>
                                <p class="menu-item-description"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                <div class="menu-item-footer">
                                    <span class="menu-item-price">R$ <?php echo number_format((float) $item['preco'], 2, ',', '.'); ?></span>
                                    <div class="menu-item-actions">
                                        <button class="btn-icon" onclick="editMenuItem(<?php echo $item['id']; ?>)" title="Editar">✏️</button>
                                        <button class="btn-icon" onclick="deleteMenuItem(<?php echo $item['id']; ?>)" title="Excluir">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-secondary);">Nenhuma bebida cadastrada ainda.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sobremesas -->
        <div id="sobremesas" class="menu-content">
            <div class="menu-items-grid">
                <?php if (!empty($categorias['sobremesas'])): ?>
                    <?php foreach ($categorias['sobremesas'] as $item): ?>
                        <div class="menu-item-card">
                            <div class="menu-item-image"
                                style="background-image: url('<?php echo $item['imagem'] ? '../../' . htmlspecialchars($item['imagem']) : $imagensPadrao['sobremesas']; ?>');">
                            </div>
                            <div class="menu-item-info">
                                <h4 class="menu-item-name">
                                    <?php echo htmlspecialchars($item['nome']); ?>
                                    <?php if ((int) $item['disponivel'] === 0): ?>
                                        <span class="badge" style="background: #ff4444; color:#fff; font-size:0.75rem; padding:0.1rem 0.4rem; border-radius:6px;">Indisponível</span>
                                    <?php endif; ?>
                                </h4>
                                <p class="menu-item-description"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                <div class="menu-item-footer">
                                    <span class="menu-item-price">R$ <?php echo number_format((float) $item['preco'], 2, ',', '.'); ?></span>
                                    <div class="menu-item-actions">
                                        <button class="btn-icon" onclick="editMenuItem(<?php echo $item['id']; ?>)" title="Editar">✏️</button>
                                        <button class="btn-icon" onclick="deleteMenuItem(<?php echo $item['id']; ?>)" title="Excluir">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-secondary);">Nenhuma sobremesa cadastrada ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar/Editar Item -->
<div id="itemModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 id="itemModalTitle">Adicionar Novo Item</h3>
            <span class="close-modal" onclick="closeItemModal()">&times;</span>
        </div>
        <form id="itemForm" class="modal-form" enctype="multipart/form-data">
            <input type="hidden" id="item_id" name="item_id">
            <input type="hidden" id="item_category" name="category">
            <input type="hidden" id="restaurante_id" name="restaurante_id" value="<?php echo $restauranteId; ?>">
            
            <div class="form-group">
                <label for="item_name">Nome do Item *</label>
                <input type="text" id="item_name" name="item_name" required placeholder="Ex: Spaghetti Carbonara">
            </div>

            <div class="form-group">
                <label for="item_description">Descrição *</label>
                <textarea id="item_description" name="description" required rows="3" placeholder="Descreva o item..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="item_price">Preço (R$) *</label>
                    <input type="number" id="item_price" name="price" required step="0.01" min="0" placeholder="45.90">
                </div>

                <div class="form-group">
                    <label for="item_category_select">Categoria *</label>
                    <select id="item_category_select" name="category_select" required>
                        <option value="pratos">Pratos</option>
                        <option value="bebidas">Bebidas</option>
                        <option value="sobremesas">Sobremesas</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="item_image">Foto do Item</label>
                <input type="file" id="item_image" name="item_image" accept="image/*" class="file-input">
                <small style="color: var(--text-secondary); font-size: 0.9rem;">Formatos aceitos: JPG, PNG (máx. 5MB)</small>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="available" checked> Item disponível no cardápio
                </label>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Salvar Item</button>
                <button type="button" class="btn btn-secondary" onclick="closeItemModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>
<script id="menuItemsData" type="application/json">
<?php echo json_encode($itensCardapio, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>
</script>
<script src="../../assets/js/pages/restaurante/cardapio.js"></script>