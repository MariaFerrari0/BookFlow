document.addEventListener("DOMContentLoaded", function () {
  // Seleciona todos os botões de excluir livros da tabela
  const botoesExcluir = document.querySelectorAll(".btn-excluir");

  botoesExcluir.forEach((botao) => {
    botao.addEventListener("click", function (event) {
      // Interrompe o clique padrão do link <a>
      event.preventDefault();

      // Pega o destino do link (excluir_livro.php?id=...)
      const urlDestino = this.getAttribute("href");

      // Exibe uma caixa de diálogo personalizada de confirmação
      const confirmar = confirm(
        "Deseja mesmo remover este livro da sua estante virtual? Essa ação não pode ser desfeita.",
      );

      if (confirmar) {
        // Se o utilizador confirmar, redireciona para a URL de exclusão
        window.location.href = urlDestino;
      }
    });
  });
});
