<?php
// Inclui os arquivos do PHPMailer (ajuste o caminho se necessário)
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configurações do banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "meu_banco";

// Cria conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebe dados do formulário
$nome = $_POST["nome"];
$email = $_POST["email"];

// Prepara inserção
$stmt = $conn->prepare("INSERT INTO Usuario (nome, email) VALUES (?, ?)");
$stmt->bind_param("ss", $nome, $email);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Resultado</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <h1>Resposta da equipe</h1>
</header>
<main>
    <?php
    if ($stmt->execute()) {
        echo "<p>Usuário <strong>$nome</strong> cadastrado com sucesso!</p>";

        // Enviar e-mail usando MailHog
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = '127.0.0.1';      // MailHog local
            $mail->Port = 1025;             // Porta padrão MailHog
            $mail->SMTPAuth = false;        // Sem autenticação

            $mail->setFrom('no-reply@seusite.com', 'Equipe de Cadastro');
            $mail->addAddress($email, $nome);

            $mail->isHTML(true);
            $mail->Subject = 'Cadastro Concluído';
            $mail->Body    = "Olá <strong>$nome</strong>,<br><br>Seu cadastro foi concluído com sucesso!";
            $mail->AltBody = "Olá $nome,\n\nSeu cadastro foi concluído com sucesso!";

            $mail->send();
            echo "<p>E-mail de confirmação enviado para <strong>$email</strong> (MailHog).</p>";
        } catch (Exception $e) {
            echo "<p>Erro ao enviar e-mail: {$mail->ErrorInfo}</p>";
        }

    } else {
        echo "<p>Erro ao cadastrar usuário: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <p><a href="javascript:history.go(-1)">Voltar para página anterior</a></p>
    <p><a href="index.html">Voltar para a página inicial</a></p>
</main>
</body>
</html>

