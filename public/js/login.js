document.addEventListener("DOMContentLoaded", () => {
  M.AutoInit();

  const form = document.querySelector("form");
  const emailInput = document.getElementById("email");
  const senhaInput = document.getElementById("senha");

  form.addEventListener("submit", (event) => {
    let erros = [];

    if (!emailInput.value.includes("@")) {
      erros.push("Por favor, insira um e-mail válido.");
    }

    if (senhaInput.value.length < 6) {
      erros.push("A senha deve ter pelo menos 6 caracteres.");
    }

    if (erros.length > 0) {
      event.preventDefault();
      erros.forEach((erro) => {
        M.toast({ html: erro, classes: "rounded red darken-2" });
      });
    }
  });
});
