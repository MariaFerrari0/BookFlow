document.addEventListener("DOMContentLoaded", function () {
  const formCadastro = document.getElementById("formCadastro");
  const formLogin = document.getElementById("formLogin");

  // --- VALIDAÇÃO DA TELA DE CADASTRO ---
  if (formCadastro) {
    formCadastro.addEventListener("submit", function (event) {
      let isValid = true;

      const nome = document.getElementById("nome");
      const email = document.getElementById("email");
      const senha = document.getElementById("senha");

      const errorNome = document.getElementById("error-nome");
      const errorEmail = document.getElementById("error-email");
      const errorSenha = document.getElementById("error-senha");

      errorNome.textContent = "";
      errorEmail.textContent = "";
      errorSenha.textContent = "";

      if (nome.value.trim().length < 3) {
        errorNome.textContent = "O nome deve ter no mínimo 3 caracteres.";
        isValid = false;
      }

      if (!email.value.includes("@") || !email.value.includes(".")) {
        errorEmail.textContent = "Por favor, insira um e-mail válido.";
        isValid = false;
      }

      if (senha.value.length < 6) {
        errorSenha.textContent =
          "A palavra-passe deve ter pelo menos 6 caracteres.";
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }

  // --- VALIDAÇÃO DA TELA DE LOGIN ---
  if (formLogin) {
    formLogin.addEventListener("submit", function (event) {
      let isValid = true;

      const email = document.getElementById("email");
      const senha = document.getElementById("senha");

      const errorEmail = document.getElementById("error-email");
      const errorSenha = document.getElementById("error-senha");

      errorEmail.textContent = "";
      errorSenha.textContent = "";

      if (!email.value.includes("@") || !email.value.includes(".")) {
        errorEmail.textContent = "Por favor, insira um e-mail válido.";
        isValid = false;
      }

      if (senha.value.length < 1) {
        errorSenha.textContent = "A palavra-passe não pode estar em branco.";
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }
});
