<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registroProfessor = $_POST['registroProfessor'] ?? '';
    $nomeProfessor = $_POST['nomeProfessor'] ?? '';
    $emailProfessor = $_POST['emailProfessor'] ?? '';
    $enderecoProfessor = $_POST['enderecoProfessor'] ?? '';
    $telefoneProfessor = $_POST['telefoneProfessor'] ?? '';

    try {
        $sql = "INSERT INTO professor (registroProfessor, nome, email, endereco, telefone) VALUES (:registro, :nome, :email, :endereco, :telefone)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':registro' => $registroProfessor,
            ':nome' => $nomeProfessor,
            ':email' => $emailProfessor,
            ':endereco' => $enderecoProfessor,
            ':telefone' => $telefoneProfessor,
        ]);

        echo "<p>Professor(a) cadastrado com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
        echo '<p><a href="form-professor.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }
} else {
    echo "<p>Requisição inválida.</p>";
    echo '<p><a href="form-professor.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
}

?>