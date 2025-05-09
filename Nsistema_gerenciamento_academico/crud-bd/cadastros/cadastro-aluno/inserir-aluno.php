<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = $_POST["matricula"];
    $nomeAluno = $_POST["nomeAluno"];
    $cpf = $_POST["cpf"];
    $emailAluno = $_POST["emailAluno"];
    $data_nascimento = $_POST["data_nascimento"];
    $enderecoAluno = $_POST["enderecoAluno"];
    $cidadeAluno = $_POST["cidadeAluno"];
    $telefoneAluno = $_POST["telefoneAluno"];
    $id_turma = $_POST["id_turma"];

    try {
        $sql = "INSERT INTO aluno (matricula, nome, cpf, email, data_nascimento, endereco, cidade, telefone, Turma_id_turma) 
                VALUES (:matricula, :nome, :cpf, :email, :data_nascimento, :endereco, :cidade, :telefone, :id_turma)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':matricula' => $matricula,
            ':nome' => $nomeAluno,
            ':cpf' => $cpf,
            ':email' => $emailAluno,
            ':data_nascimento' => $data_nascimento,
            ':endereco' => $enderecoAluno,
            ':cidade' => $cidadeAluno,
            ':telefone' => $telefoneAluno,
            ':id_turma' => $id_turma
        ]);

        echo "<p>Dados inseridos com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';
    } catch (PDOException $e) {
        echo "<p>Erro ao inserir dados: " . $e->getMessage() . "</p>";
        echo '<p><a href="form-aluno.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }
} else {
    echo "<p>Requisição inválida.</p>";
}

?>