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
        // Configurações do banco
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "avaliacoes";

        // Conexão
        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("<p>Erro de conexão: " . $conn->connect_error . "</p>");
        }

        // Coletar os dados
        $nome = $_POST["nome"];
        $nota = $_POST["nota"];

        // Validar a nota
        if (!is_numeric($nota) || $nota < 0 || $nota > 10) {
            echo "<p>Nota inválida! Insira um valor de 0 a 10.</p>";
        } else {
            // Inserir no banco
            $stmt = $conn->prepare("INSERT INTO Notas (nome, nota) VALUES (?, ?)");
            $stmt->bind_param("sd", $nome, $nota);

            if ($stmt->execute()) {
                echo "<p>Olá, <strong>$nome</strong>!</p>";
                if ($nota > 7) {
                    echo "<p>Obrigado pela avaliação, continuaremos nos esforçando!</p>";
                } else {
                    echo "<p>Desculpe pelo transtorno, vamos melhorar nossa experiência.</p>";
                }
            } else {
                echo "<p>Erro ao salvar a nota: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>

        <p><a href="javascript:history.go(-1)">Voltar para página anterior</a></p>
        <p><a href="index.html">Voltar para a página inicial</a></p>
    </main>
</body>
</html>
