// Máscaras de input

document.getElementById("cpf").addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, "");
  if (value.length <= 11) {
    value = value.replace(/^(\d{3})(\d)/, "$1.$2");
    value = value.replace(/^(\d{3})\.(\d{3})(\d)/, "$1.$2.$3");
    value = value.replace(/\.(\d{3})(\d)/, ".$1-$2");
    e.target.value = value;
  }
});

document.getElementById("zipcode").addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, "");
  if (value.length <= 8) {
    value = value.replace(/^(\d{5})(\d)/, "$1-$2");
    e.target.value = value;
  }
});

document.getElementById("phone").addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, "");
  if (value.length <= 11) {
    value = value.replace(/^(\d{2})(\d)/, "($1) $2");
    value = value.replace(/(\d{5})(\d)/, "$1-$2");
    e.target.value = value;
  }
});

document.getElementById("owner_phone").addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, "");
  if (value.length <= 11) {
    value = value.replace(/^(\d{2})(\d)/, "($1) $2");
    value = value.replace(/(\d{5})(\d)/, "$1-$2");
    e.target.value = value;
  }
});

// Validação de senha
document
  .getElementById("confirm_password")
  .addEventListener("input", function (e) {
    const password = document.getElementById("password").value;
    if (e.target.value !== password) {
      e.target.setCustomValidity("As senhas não coincidem");
    } else {
      e.target.setCustomValidity("");
    }
  });

// Submissão do formulário
document
  .getElementById("restaurantRegistrationForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Validar senhas
    const password = formData.get("password");
    const confirmPassword = formData.get("confirm_password");

    if (password !== confirmPassword) {
      alert("As senhas não coincidem!");
      return;
    }

    // Aqui você faria a requisição AJAX para salvar os dados
    console.log("Dados do formulário:", Object.fromEntries(formData));

    // Simular envio
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = "CADASTRANDO...";
    submitBtn.disabled = true;

    setTimeout(() => {
      alert("Cadastro realizado com sucesso! Aguarde a aprovação.");
      window.location.href = "login.php";
    }, 2000);
  });
