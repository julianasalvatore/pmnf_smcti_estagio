<?php
include 'db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Prevenir SQL Injection
$email = $conn->real_escape_string($email);
$password = $conn->real_escape_string($password);

// Consultar o banco de dados
$sql = "SELECT * FROM ALUNOS WHERE email_aluno='$email' AND senha_aluno='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login bem-sucedido
    echo "Login bem-sucedido!";
} else {
    // Falha no login
    echo "Email ou senha inválidos.";
}

$conn->close();
?>
