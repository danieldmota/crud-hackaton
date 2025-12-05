// Máscaras de input
document.getElementById("cnpj").addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, "");
  if (value.length <= 14) {
    value = value.replace(/^(\d{2})(\d)/, "$1.$2");
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
    value = value.replace(/(\d{4})(\d)/, "$1-$2");
    e.target.value = value;
  }
});

// owner_cpf não presente no formulário atual — só anexar listener se existir
const ownerCpfEl = document.getElementById("owner_cpf");
if (ownerCpfEl) {
  ownerCpfEl.addEventListener("input", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.length <= 11) {
      value = value.replace(/^(\d{3})(\d)/, "$1.$2");
      value = value.replace(/^(\d{3})\.(\d{3})(\d)/, "$1.$2.$3");
      value = value.replace(/\.(\d{3})(\d)/, ".$1-$2");
      e.target.value = value;
    }
  });
}

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

// owner_phone não presente no formulário atual — só anexar listener se existir
const ownerPhoneEl = document.getElementById("owner_phone");
if (ownerPhoneEl) {
  ownerPhoneEl.addEventListener("input", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.length <= 11) {
      value = value.replace(/^(\d{2})(\d)/, "($1) $2");
      value = value.replace(/(\d{5})(\d)/, "$1-$2");
      e.target.value = value;
    }
  });
}

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

// Submissão do formulário: fazer validação básica no cliente e permitir POST normal
document
  .getElementById("restaurantRegistrationForm")
  .addEventListener("submit", function (e) {
    // Validação de senhas no cliente — se falhar, impedir envio
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirm_password").value;
    if (password !== confirmPassword) {
      e.preventDefault();
      alert("As senhas não coincidem!");
      return;
    }

    // Permitir envio normal ao controller; o controller retornará mensagens via sessão/redirect
  });
