function filterReservations(status) {
  // Atualizar chips ativos
  document.querySelectorAll(".filter-chip").forEach((chip) => {
    chip.classList.remove("active");
  });
  document.querySelector(`[data-filter="${status}"]`).classList.add("active");

  // Filtrar cards
  const cards = document.querySelectorAll(".reservation-card");
  cards.forEach((card) => {
    if (status === "all") {
      card.style.display = "block";
      card.style.opacity = card.dataset.status === "cancelada" ? "0.7" : "1";
    } else {
      if (card.dataset.status === status) {
        card.style.display = "block";
        card.style.opacity = "1";
      } else {
        card.style.display = "none";
      }
    }
  });
}

function confirmReservation(id) {
  if (confirm("Confirmar esta reserva?")) {
    // Aqui você faria uma requisição AJAX para confirmar no backend
    alert("Reserva confirmada com sucesso!");
    location.reload();
  }
}

function cancelReservation(id) {
  if (confirm("Tem certeza que deseja cancelar esta reserva?")) {
    // Aqui você faria uma requisição AJAX para cancelar no backend
    alert("Reserva cancelada com sucesso!");
    location.reload();
  }
}

function contactCustomer(id) {
  alert("Abrindo opções de contato para o cliente da reserva #" + id);
}
function updateReservationStatus(id, action) {
  const formData = new FormData();
  formData.append("reserva_id", id);
  formData.append("action", action);

  fetch("/crud-hackaton/controller/reservaStatusController.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        showNotification(data.message, "success");
        setTimeout(() => {
          location.reload();
        }, 1000);
      } else {
        showNotification("Erro: " + data.message, "error");
      }
    })
    .catch((error) => {
      console.error("Erro:", error);
      showNotification("Erro ao atualizar reserva", "error");
    });
}

function confirmReservation(id) {
  if (confirm("Confirmar esta reserva?")) {
    updateReservationStatus(id, "confirm");
  }
}

function cancelReservation(id) {
  if (confirm("Tem certeza que deseja cancelar esta reserva?")) {
    updateReservationStatus(id, "cancel");
  }
}

function contactCustomer() {
  alert("Abrindo opções de contato para o cliente da reserva");
}
