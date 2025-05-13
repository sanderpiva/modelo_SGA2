<?php

require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $matricula = $_POST['matricula'] ?? '';
    $nome   = $_POST['nomeAluno'] ?? '';
    $cpf    = $_POST['cpf'] ?? '';
    $email  = $_POST['emailAluno'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $endereco = $_POST['enderecoAluno'] ?? '';
    $cidade = $_POST['cidadeAluno'] ?? '';  
    $telefone = $_POST['telefoneAluno'] ?? '';
    $id_turma  = $_POST['id_turma'] ?? ''; 
    $senha  = $_POST['senha'] ?? '';
    $hashSenha = password_hash($senha, PASSWORD_DEFAULT);

    try{
        $sql = "INSERT INTO aluno (matricula, nome, cpf, email, data_nascimento, endereco, cidade, telefone, Turma_id_turma, senha) VALUES (:matricula, :nome, :cpf, :email, :data_nascimento, :endereco, :cidade, :telefone, :id_turma, :senha)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':matricula' => $matricula,
            ':nome'   => $nome,
            ':cpf'      => $cpf,
            ':email'    => $email,
            ':data_nascimento' => $data_nascimento,
            ':endereco' => $endereco,
            ':cidade'   => $cidade,
            ':telefone' => $telefone,
            ':id_turma' => $id_turma,
            ':senha'  => $hashSenha
        ]);

        echo "<p>Aluno cadastrado com sucesso!</p>";
        echo '<button onclick="window.location.href=\'menu-aluno.html\'">Voltar para o Menu</button>';

    } catch (PDOException $e) {
    echo "Erro ao cadastrar: " . $e->getMessage();
    }
}

else {
    echo "<p>Requisição inválida.</p>";
}

?>