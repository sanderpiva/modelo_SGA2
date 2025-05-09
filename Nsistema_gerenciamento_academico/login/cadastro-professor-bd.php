<?php

require_once "conexao-bd.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nome   = $_POST['nome'] ?? '';
    $login   = $_POST['login'] ?? '';
    $senha  = $_POST['senha'] ?? '';
    $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
    try{
        $sql = "INSERT INTO professor (nome, login, senha) VALUES (:nome, :login, :senha)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':nome'   => $nome,
            ':login'   => $login,
            ':senha'  => $hashSenha
        ]);

        echo "<p>Professor cadastrado com sucesso!</p>";
        echo '<button onclick="window.location.href=\'menu-professor.html\'">Voltar para o Menu</button>';

    } catch (PDOException $e) {
    echo "Erro ao cadastrar: " . $e->getMessage();
    }
}

else {
    echo "<p>Requisição inválida.</p>";
}

?>