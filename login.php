<?php
session_start();
require 'db.php'; // Inclua seu arquivo de conexão com o banco de dados

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        // Login bem-sucedido
        $_SESSION['user_id'] = $user['id'];

        echo json_encode([
            'success' => true,
            'role' => $user['role'], // 'admin' ou 'student'
            'name' => $user['name'],
            'redirectUrl' => $user['role'] === 'admin' ? 'admin/suporte/dashboard.html' : 'dashboard_estudante.html'
        ]);
    } else {
        // Login falhou
        echo json_encode([
            'success' => false,
            'message' => 'Usuário ou senha inválidos.'
        ]);
    }
}
?>
