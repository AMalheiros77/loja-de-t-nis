<?php
// Parâmetros de conexão
$servidor = "localhost";
$usuario = "root";
$senha = ""; // em XAMPP normalmente é vazio
$banco = "meu_banco"; // nome do seu banco

// Criando a conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificando se houve erro
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
} else {
    echo "Conexão realizada com sucesso!";
}
?>
