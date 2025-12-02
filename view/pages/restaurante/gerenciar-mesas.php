<?php include_once __DIR__ . '/../../components/header.php'; ?>

<link rel="stylesheet" href="../../assets/css/style.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Gerenciar Mesas</h1>
        <p style="font-size: 1.3rem;">Configure e gerencie as mesas do seu restaurante</p>
    </div>
</section>

<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <div class="dashboard-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 class="section-title-form" style="margin: 0;">Mesas Disponíveis</h3>
            <button class="btn btn-primary" onclick="openAddTableModal()">Adicionar Mesa</button>
        </div>

        <!-- Grid de Mesas -->
        <div class="tables-grid" id="tablesGrid">
            <div class="table-card available" data-table="1">
                <div class="table-number">Mesa 1</div>
                <div class="table-capacity">4 pessoas</div>
                <div class="table-status available">Disponível</div>
                <div class="table-actions">
                    <button class="btn btn-secondary btn-small" onclick="editTable(1)">Editar</button>
                    <button class="btn btn-primary btn-small" onclick="viewTableDetails(1)">Detalhes</button>
                </div>
            </div>

            <div class="table-card occupied" data-table="2">
                <div class="table-number">Mesa 2</div>
                <div class="table-capacity">2 pessoas</div>
                <div class="table-status occupied">Ocupada</div>
                <div class="table-info-occupied">
                    <small>Reserva: João Silva</small>
                    <small>19:30 - Hoje</small>
                </div>
                <div class="table-actions">
                    <button class="btn btn-secondary btn-small" onclick="viewReservation(2)">Ver Reserva</button>
                </div>
            </div>

            <div class="table-card reserved" data-table="3">
                <div class="table-number">Mesa 3</div>
                <div class="table-capacity">6 pessoas</div>
                <div class="table-status reserved">Reservada</div>
                <div class="table-info-occupied">
                    <small>Reserva: Maria Santos</small>
                    <small>20:00 - Hoje</small>
                </div>
                <div class="table-actions">
                    <button class="btn btn-secondary btn-small" onclick="viewReservation(3)">Ver Reserva</button>
                </div>
            </div>

            <div class="table-card unavailable" data-table="4">
                <div class="table-number">Mesa 4</div>
                <div class="table-capacity">4 pessoas</div>
                <div class="table-status unavailable">Indisponível</div>
                <div class="table-info-occupied">
                    <small>Manutenção</small>
                </div>
                <div class="table-actions">
                    <button class="btn btn-secondary btn-small" onclick="editTable(4)">Editar</button>
                </div>
            </div>

            <div class="table-card available" data-table="5">
                <div class="table-number">Mesa 5</div>
                <div class="table-capacity">2 pessoas</div>
                <div class="table-status available">Disponível</div>
                <div class="table-actions">
                    <button class="btn btn-secondary btn-small" onclick="editTable(5)">Editar</button>
                    <button class="btn btn-primary btn-small" onclick="viewTableDetails(5)">Detalhes</button>
                </div>
            </div>

            <div class="table-card available" data-table="6">
                <div class="table-number">Mesa 6</div>
                <div class="table-capacity">8 pessoas</div>
                <div class="table-status available">Disponível</div>
                <div class="table-actions">
                    <button class="btn btn-secondary btn-small" onclick="editTable(6)">Editar</button>
                    <button class="btn btn-primary btn-small" onclick="viewTableDetails(6)">Detalhes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar/Editar Mesa -->
<div id="tableModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Adicionar Nova Mesa</h3>
            <span class="close-modal" onclick="closeTableModal()">&times;</span>
        </div>
        <form id="tableForm" class="modal-form">
            <input type="hidden" id="table_id" name="table_id">
            
            <div class="form-group">
                <label for="table_number">Número da Mesa *</label>
                <input type="text" id="table_number" name="table_number" required placeholder="Ex: Mesa 7">
            </div>

            <div class="form-group">
                <label for="table_capacity">Capacidade (pessoas) *</label>
                <input type="number" id="table_capacity" name="table_capacity" required min="1" max="20" placeholder="Ex: 4">
            </div>

            <div class="form-group">
                <label for="table_location">Localização</label>
                <select id="table_location" name="table_location">
                    <option value="indoor">Área Interna</option>
                    <option value="outdoor">Área Externa</option>
                    <option value="vip">Área VIP</option>
                    <option value="window">Perto da Janela</option>
                </select>
            </div>

            <div class="form-group">
                <label for="table_status">Status *</label>
                <select id="table_status" name="table_status" required>
                    <option value="available">Disponível</option>
                    <option value="unavailable">Indisponível</option>
                    <option value="maintenance">Manutenção</option>
                </select>
            </div>

            <div class="form-group">
                <label for="table_notes">Observações</label>
                <textarea id="table_notes" name="table_notes" rows="3" placeholder="Observações sobre a mesa..."></textarea>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Salvar Mesa</button>
                <button type="button" class="btn btn-secondary" onclick="closeTableModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>
<script>
// Modal functions
function openAddTableModal() {
    document.getElementById('modalTitle').textContent = 'Adicionar Nova Mesa';
    document.getElementById('tableForm').reset();
    document.getElementById('table_id').value = '';
    document.getElementById('tableModal').style.display = 'flex';
}

function closeTableModal() {
    document.getElementById('tableModal').style.display = 'none';
}

function editTable(tableId) {
    document.getElementById('modalTitle').textContent = 'Editar Mesa ' + tableId;
    // Aqui você buscaria os dados da mesa
    document.getElementById('table_id').value = tableId;
    document.getElementById('table_number').value = 'Mesa ' + tableId;
    document.getElementById('table_capacity').value = tableId === 6 ? 8 : tableId === 1 ? 4 : 2;
    document.getElementById('tableModal').style.display = 'flex';
}

function viewTableDetails(tableId) {
    alert('Detalhes da Mesa ' + tableId);
}

function viewReservation(tableId) {
    alert('Ver reserva da Mesa ' + tableId);
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modal = document.getElementById('tableModal');
    if (event.target == modal) {
        closeTableModal();
    }
}

// Submissão do formulário
document.getElementById('tableForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const tableId = document.getElementById('table_id').value;
    const isEdit = tableId !== '';
    
    alert(isEdit ? 'Mesa atualizada com sucesso!' : 'Mesa adicionada com sucesso!');
    closeTableModal();
    location.reload();
});
</script>

