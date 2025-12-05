let currentTab = 'pratos';
const controllerUrl = "/crud-hackaton/controller/cardapioController.php";
const menuItems = JSON.parse(document.getElementById('menuItemsData').textContent || '[]');

const modal = document.getElementById('itemModal');
const form = document.getElementById('itemForm');
const submitBtn = form.querySelector('button[type="submit"]');
const categorySelect = document.getElementById('item_category_select');
const hiddenCategory = document.getElementById('item_category');
const restauranteIdInput = document.getElementById('restaurante_id');

function switchTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.menu-content').forEach(c => c.classList.remove('active'));
    
    document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
    document.getElementById(tab).classList.add('active');
}

function openAddItemModal() {
    document.getElementById('itemModalTitle').textContent = 'Adicionar Novo Item';
    form.reset();
    document.getElementById('item_id').value = '';
    hiddenCategory.value = currentTab;
    categorySelect.value = currentTab;
    modal.style.display = 'flex';
}

function closeItemModal() {
    modal.style.display = 'none';
}

function fillForm(item) {
    document.getElementById('item_name').value = item.nome;
    document.getElementById('item_description').value = item.descricao;
    document.getElementById('item_price').value = item.preco;
    categorySelect.value = item.categoria;
    hiddenCategory.value = item.categoria;
    document.getElementById('item_id').value = item.id;
    const availableCheckbox = form.querySelector('input[name="available"]');
    availableCheckbox.checked = Number(item.disponivel) === 1;
}

function editMenuItem(id) {
    const item = menuItems.find(i => Number(i.id) === Number(id));
    if (!item) {
        alert('Item não encontrado.');
        return;
    }
    document.getElementById('itemModalTitle').textContent = 'Editar Item';
    fillForm(item);
    modal.style.display = 'flex';
}

async function deleteMenuItem(id) {
    if (!confirm('Tem certeza que deseja excluir este item?')) {
        return;
    }

    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('item_id', id);
    formData.append('restaurante_id', restauranteIdInput.value);

    try {
        submitBtn.disabled = true;
        const response = await fetch(controllerUrl, { method: 'POST', body: formData });
        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.error || 'Não foi possível excluir o item.');
        }

        alert(result.message);
        window.location.reload();
    } catch (error) {
        alert(error.message);
    } finally {
        submitBtn.disabled = false;
    }
}

window.onclick = function(event) {
    if (event.target === modal) {
        closeItemModal();
    }
}

categorySelect.addEventListener('change', (event) => {
    hiddenCategory.value = event.target.value;
});

form.addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(form);
    const itemId = formData.get('item_id');
    formData.append('restaurante_id', restauranteIdInput.value);

    formData.append('action', itemId ? 'update' : 'create');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Salvando...';

    try {
        const response = await fetch(controllerUrl, { method: 'POST', body: formData });
        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.error || 'Não foi possível salvar o item.');
        }

        alert(result.message);
        window.location.reload();
    } catch (error) {
        alert(error.message);
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Salvar Item';
    }
});