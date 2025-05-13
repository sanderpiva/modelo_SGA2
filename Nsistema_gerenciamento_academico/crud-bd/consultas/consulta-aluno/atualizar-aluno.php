<?php
require_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_aluno = $_POST['id_aluno'];
    $matricula = $_POST['matricula'];
    $nomeAluno = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $emailAluno = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $enderecoAluno = $_POST['endereco'];
    $cidadeAluno = $_POST['cidade'];
    $telefoneAluno = $_POST['telefone'];

    $stmt = $conexao->prepare("UPDATE aluno SET
        matricula = :matricula,
        nome = :nome,
        cpf = :cpf,
        email = :email,
        data_nascimento = :data_nascimento,
        endereco = :endereco,
        cidade = :cidade,
        telefone = :telefone
        WHERE id_aluno = :id");

    $stmt->execute([
        ':matricula' => $matricula,
        ':nome' => $nomeAluno,
        ':cpf' => $cpf,
        ':email' => $emailAluno,
        ':data_nascimento' => $data_nascimento,
        ':endereco' => $enderecoAluno,
        ':cidade' => $cidadeAluno,
        ':telefone' => $telefoneAluno,
        ':id' => $id_aluno
    ]);

    header("Location: ../../consultas/consulta-aluno/consulta-aluno.php?atualizado=sucesso");
    exit;
}
?>