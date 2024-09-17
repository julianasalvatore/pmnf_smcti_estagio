<?php
session_start();

// Função para sanitizar dados
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Verificar token CSRF
if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Erro: Token CSRF inválido.");
}

// Conectar ao banco de dados
include 'db_connect.php';

// Receber dados do formulário e sanitizar
$nome = sanitizeInput($_POST['nome']);
$dataNascimento = sanitizeInput($_POST['dataNascimento']);
$telefone = sanitizeInput($_POST['telefone']);
$email = sanitizeInput($_POST['email']);
$senha = sanitizeInput($_POST['senha']);
$instituicao = sanitizeInput($_POST['instituicao']);
$curso = sanitizeInput($_POST['curso']);
$periodo = sanitizeInput($_POST['periodo']);
$local1 = sanitizeInput($_POST['local1']);
$local2 = sanitizeInput($_POST['local2']);
$local3 = sanitizeInput($_POST['local3']);

// Criptografar a senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Preparar e executar a consulta
$stmt = $conn->prepare("INSERT INTO ALUNOS (nome_aluno, data_nascimento_aluno, telefone_aluno, email_aluno, senha_aluno, perfil_aluno, acompanhamento_status, instituicao, curso, periodo, local1, local2, local3) VALUES (?, ?, ?, ?, ?, 'estagiario', 'pendente', ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssss", $nome, $dataNascimento, $telefone, $email, $senhaHash, $instituicao, $curso, $periodo, $local1, $local2, $local3);

if ($stmt->execute()) {
    // Armazenar ID do aluno na sessão para usar no perfil
    $_SESSION['user_id'] = $conn->insert_id;
    header("Location: painel_candidato.php");
    exit();
} else {
    error_log("Erro: " . $stmt->error); // Log de erro
    echo "Erro ao processar o cadastro. Tente novamente mais tarde.";
}

// Fechar a declaração e a conexão
$stmt->close();
$conn->close();
?>
