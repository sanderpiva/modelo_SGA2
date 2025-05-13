<?php

require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $registro = $_POST['registroProfessor'] ?? '';
    $nome   = $_POST['nomeProfessor'] ?? '';
    $login   = $_POST['emailProfessor'] ?? '';
    $endereco = $_POST['enderecoProfessor'] ?? '';
    $telefone = $_POST['telefoneProfessor'] ?? '';
    $senha  = $_POST['senha'] ?? '';
    $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
    try{
        $sql = "INSERT INTO professor (registroProfessor, nome, email, endereco, telefone, senha) VALUES (:registroProfessor, :nome, :email, :endereco, :telefone, :senha)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':registroProfessor' => $registro,
            ':nome'   => $nome,
            ':email'   => $login,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
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