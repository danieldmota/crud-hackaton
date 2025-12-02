<?php include_once __DIR__ . '/../../components/header.php'; ?>

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
                <div class="menu-item-card">
                    <div class="menu-item-image" style="background-image: url('https://images.unsplash.com/photo-1551183053-bf91a1d81141?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="menu-item-info">
                        <h4 class="menu-item-name">Spaghetti Carbonara</h4>
                        <p class="menu-item-description">Massa artesanal com bacon, ovos, queijo parmesão e pimenta preta</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">R$ 45,90</span>
                            <div class="menu-item-actions">
                                <button class="btn-icon" onclick="editMenuItem(1, 'pratos')" title="Editar">✏️</button>
                                <button class="btn-icon" onclick="deleteMenuItem(1)" title="Excluir">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="menu-item-card">
                    <div class="menu-item-image" style="background-image: url('https://images.unsplash.com/photo-1574894709920-11b28e7367e3?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="menu-item-info">
                        <h4 class="menu-item-name">Risotto de Camarão</h4>
                        <p class="menu-item-description">Arroz arbóreo cremoso com camarões frescos e ervas</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">R$ 58,90</span>
                            <div class="menu-item-actions">
                                <button class="btn-icon" onclick="editMenuItem(2, 'pratos')" title="Editar">✏️</button>
                                <button class="btn-icon" onclick="deleteMenuItem(2)" title="Excluir">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="menu-item-card">
                    <div class="menu-item-image" style="background-image: url('https://images.unsplash.com/photo-1574071318508-1cdbab80d002?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="menu-item-info">
                        <h4 class="menu-item-name">Pizza Margherita</h4>
                        <p class="menu-item-description">Massa fina, molho de tomate, mussarela de búfala e manjericão</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">R$ 42,90</span>
                            <div class="menu-item-actions">
                                <button class="btn-icon" onclick="editMenuItem(3, 'pratos')" title="Editar">✏️</button>
                                <button class="btn-icon" onclick="deleteMenuItem(3)" title="Excluir">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="menu-item-card">
                    <div class="menu-item-image" style="background-image: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="menu-item-info">
                        <h4 class="menu-item-name">Lasagna à Bolonhesa</h4>
                        <p class="menu-item-description">Camadas de massa, molho bolonhesa, queijo e bechamel</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">R$ 52,90</span>
                            <div class="menu-item-actions">
                                <button class="btn-icon" onclick="editMenuItem(4, 'pratos')" title="Editar">✏️</button>
                                <button class="btn-icon" onclick="deleteMenuItem(4)" title="Excluir">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bebidas -->
        <div id="bebidas" class="menu-content">
            <div class="menu-items-grid">
                <div class="menu-item-card">
                    <div class="menu-item-image" style="background-image: url('https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="menu-item-info">
                        <h4 class="menu-item-name">Vinho Tinto Reserva</h4>
                        <p class="menu-item-description">Vinho tinto nacional, garrafa 750ml</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">R$ 89,90</span>
                            <div class="menu-item-actions">
                                <button class="btn-icon" onclick="editMenuItem(5, 'bebidas')" title="Editar">✏️</button>
                                <button class="btn-icon" onclick="deleteMenuItem(5)" title="Excluir">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sobremesas -->
        <div id="sobremesas" class="menu-content">
            <div class="menu-items-grid">
                <div class="menu-item-card">
                    <div class="menu-item-image" style="background-image: url('https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80');"></div>
                    <div class="menu-item-info">
                        <h4 class="menu-item-name">Tiramisu</h4>
                        <p class="menu-item-description">Sobremesa tradicional italiana com café e mascarpone</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">R$ 24,90</span>
                            <div class="menu-item-actions">
                                <button class="btn-icon" onclick="editMenuItem(6, 'sobremesas')" title="Editar">✏️</button>
                                <button class="btn-icon" onclick="deleteMenuItem(6)" title="Excluir">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
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
<script>
let currentTab = 'pratos';

function switchTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.menu-content').forEach(c => c.classList.remove('active'));
    
    document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
    document.getElementById(tab).classList.add('active');
}

function openAddItemModal() {
    document.getElementById('itemModalTitle').textContent = 'Adicionar Novo Item';
    document.getElementById('itemForm').reset();
    document.getElementById('item_id').value = '';
    document.getElementById('item_category').value = currentTab;
    document.getElementById('item_category_select').value = currentTab;
    document.getElementById('itemModal').style.display = 'flex';
}

function closeItemModal() {
    document.getElementById('itemModal').style.display = 'none';
}

function editMenuItem(id, category) {
    document.getElementById('itemModalTitle').textContent = 'Editar Item';
    document.getElementById('item_id').value = id;
    document.getElementById('item_category').value = category;
    document.getElementById('item_category_select').value = category;
    // Aqui você buscaria os dados do item
    document.getElementById('itemModal').style.display = 'flex';
}

function deleteMenuItem(id) {
    if (confirm('Tem certeza que deseja excluir este item?')) {
        alert('Item excluído com sucesso!');
        location.reload();
    }
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modal = document.getElementById('itemModal');
    if (event.target == modal) {
        closeItemModal();
    }
}

// Submissão do formulário
document.getElementById('itemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const itemId = document.getElementById('item_id').value;
    const isEdit = itemId !== '';
    
    alert(isEdit ? 'Item atualizado com sucesso!' : 'Item adicionado com sucesso!');
    closeItemModal();
    location.reload();
});
</script>

