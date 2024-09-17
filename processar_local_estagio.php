<?php
session_start();

// Verificar o token CSRF
if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Token CSRF inválido.');
}

// Conectar ao banco de dados
include 'db_connect.php';

// Função para sanitizar e validar entradas
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Receber e sanitizar dados do formulário
$localNome = sanitizeInput($_POST['localNome']);

// Validar que o campo não está vazio
if (empty($localNome)) {
    die('O nome do local é obrigatório.');
}

// Preparar a consulta SQL
$sql = "INSERT INTO locais_estagio (nome_local) VALUES (?)";

// Preparar a declaração
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Falha na preparação da declaração: ' . $conn->error);
}

// Vincular os parâmetros e executar a declaração
$stmt->bind_param('s', $localNome);

if ($stmt->execute()) {
    header('Location: sucesso.html');
    exit();
} else {
    echo "Erro: " . $stmt->error;
}

// Fechar a declaração e a conexão
$stmt->close();
$conn->close();
?>
