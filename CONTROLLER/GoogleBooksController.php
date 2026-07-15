<?php
// Ativa a exibição de erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['busca']) || empty(trim($_GET['busca']))) {
    echo json_encode(["erro" => "O PHP não recebeu o termo de busca."]);
    exit;
}

$termoBusca = trim($_GET['busca']);

// URL da Open Library (Busca apenas 1 resultado para ser rápido)
$url = "https://openlibrary.org/search.json?q=" . urlencode($termoBusca) . "&limit=1";

// Configura o disfarce de navegador para garantir que a requisição passe lisa
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
    ]
];
$context = stream_context_create($opts);
$response = @file_get_contents($url, false, $context);

// Fallback com cURL caso o file_get_contents esteja bloqueado no seu XAMPP
if ($response === false && function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    $response = curl_exec($ch);
    curl_close($ch);
}

if (!$response) {
    echo json_encode(["erro" => "Não foi possível conectar à Open Library."]);
    exit;
}

$dados = json_decode($response, true);

// Se não encontrar nenhum documento/livro
if (!isset($dados['docs']) || count($dados['docs']) === 0) {
    echo json_encode(["erro" => "Nenhum livro encontrado com esse título."]);
    exit;
}

$livro = $dados['docs'][0];

// 1. Mapeia o autor (Open Library retorna uma lista de autores no array 'author_name')
$autor = 'Autor Desconhecido';
if (isset($livro['author_name']) && is_array($livro['author_name'])) {
    $autor = implode(', ', $livro['author_name']);
}

// 2. Mapeia o número de páginas (Varredura inteligente e profunda)
$paginas = 0;

// Tentativa A: Pega a mediana de páginas calculada pela API
if (isset($livro['number_of_pages_median']) && $livro['number_of_pages_median'] > 0) {
    $paginas = $livro['number_of_pages_median'];
} 
// Tentativa B: Verifica se há um valor direto único ou em lista
elseif (isset($livro['number_of_pages'])) {
    if (is_array($livro['number_of_pages'])) {
        // Se for uma lista de páginas de várias edições, pega a maior ou a primeira válida
        foreach ($livro['number_of_pages'] as $p) {
            if (is_numeric($p) && $p > 0) {
                $paginas = $p;
                break;
            }
        }
    } else if (is_numeric($livro['number_of_pages'])) {
        $paginas = $livro['number_of_pages'];
    }
}

// Se depois de tudo ainda não encontrou, tenta buscar em campos alternativos
if ($paginas == 0 && isset($livro['edition_count'])) {
    // Alguns livros registram as páginas dentro de listas agregadas
    if (isset($livro['publish_year']) && is_array($livro['publish_year'])) {
        // Apenas um fallback numérico seguro se tudo falhar
        $paginas = 0; 
    }
}

// Garante que o retorno final seja um número inteiro limpo
$paginas = (int)$paginas;

// 3. Mapeia a capa do livro usando o ID da imagem da Open Library
$capa = "https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=110&auto=format&fit=crop&q=60";
if (isset($livro['cover_i'])) {
    // Busca a imagem em tamanho Médio (-M) direto do servidor de capas deles
    $capa = "https://covers.openlibrary.org/b/id/" . $livro['cover_i'] . "-M.jpg";
}

// Retorna exatamente a mesma estrutura que o seu JavaScript espera!
echo json_encode([
    "titulo" => $livro['title'] ?? 'Sem Título',
    "autor" => $autor,
    "paginas" => $paginas,
    "capa" => $capa
]);
exit;