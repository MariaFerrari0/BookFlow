function confirmarExclusao(idLivro) {
  if (
    confirm(
      "Tem certeza absoluta de que deseja excluir este livro? Esta ação não pode ser desfeita.",
    )
  ) {
    // Redireciona para o arquivo de remoção enviando o ID pela URL
    window.location.href = "excluir.php?id=" + idLivro;
  }
}
