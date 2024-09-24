<?php
$servername = "localhost";
$username = "root";
$password = ""; // Altere se necessário
$dbname = "prefeitura";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe os dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cursoNome = $conn->real_escape_string($_POST['cursoNome']);
    
    // Insere o curso na tabela
    $sql = "INSERT INTO cursos (nome) VALUES ('$cursoNome')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Curso cadastrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
