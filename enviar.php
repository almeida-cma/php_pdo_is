<?php

// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conexão ao banco de dados
    try {
        $conn = new PDO("mysql:host=localhost;port=7306;dbname=banco_de_dados", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Falha ao conectar: ' . $e->getMessage();
        exit(); // Encerrar o script em caso de falha na conexão
    }

    // Obter dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $mensagem = $_POST["mensagem"];

    // Criar a query SQL
    $sql = "INSERT INTO contatos (nome, email, mensagem) VALUES (?, ?, ?)";

    // Preparar a query
    $stmt = $conn->prepare($sql);

    // Executar a query, vinculando os parâmetros
    try {
        $stmt->execute([$nome, $email, $mensagem]);
        header("Location: listar_contatos.php"); // Redirecionar para a página de listagem
        exit(); // Encerrar o script após o redirecionamento
    } catch (PDOException $e) {
        echo "Erro ao enviar mensagem: " . $e->getMessage();
    }

    // Fechar a conexão
    $conn = null;
} else {
    echo "Método inválido para acessar esta página.";
}
?>
