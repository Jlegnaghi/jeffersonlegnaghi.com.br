<?php
// Configurações do banco de dados localhost
/*$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "dbteste";*/

// Configurações do banco de dados servidor
$host = "dbjefferson.mysql.uhserver.com";
$usuario = "jeffersonadm";
$senha = "d5*UbCYALZ";
$banco = "dbjefferson";

// Cria a conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    // Valida os dados do formulário
    $errors = [];
    if (empty($nome)) {
        $errors[] = "Nome é obrigatório.";
    }
    if (empty($email)) {
        $errors[] = "E-mail é obrigatório.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "E-mail inválido.";
    }
    if (empty($mensagem)) {
        $errors[] = "Mensagem é obrigatória.";
    }

    // Se houver erros, exibe-os na tela
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        // Insere os dados do formulário no banco de dados
        $sql = "INSERT INTO contato (nome, email, mensagem) VALUES ('$nome', '$email', '$mensagem')";

        if ($conn->query($sql) === TRUE) {
            echo "Obrigado por entrar em contato!";
        } else {
            echo "Erro ao inserir os dados no banco de dados: " . $conn->error;
        }
    }

    mail (
        "jeffersonlegnaghi07@gmail.com", //Endereço que vai receber a mensagem
        "Nome: $nome
        Email: $email
        Mensagem: $mensagem", "Ola Jefferson, você tem uma nova menssagem de:$nome<$email> \r\nMensagem: $mensagem");

    /*$to = "$email";
    $subject = $mensagem;
    $txt = "$mensagem";
    $headers = "From: jeffersonlegnaghi07@gmail.com" . "\r\n";
    
    mail($to,$subject,$txt,$headers);*/


    // Fecha a conexão com o banco de dados
    $conn->close();
}

    header("Location: index.html"); 

?>