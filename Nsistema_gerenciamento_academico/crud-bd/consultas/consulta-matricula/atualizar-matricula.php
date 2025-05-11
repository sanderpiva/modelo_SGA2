<?php
require_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $original_aluno_id = $_POST['original_aluno_id'];
    $original_disciplina_id = $_POST['original_disciplina_id'];
    $novo_aluno_id = $_POST['aluno_id']; 
    $nova_disciplina_id = $_POST['disciplina_id'];

    if ($original_aluno_id === false || $original_aluno_id === null ||
        $original_disciplina_id === false || $original_disciplina_id === null ||
        $novo_aluno_id === false || $novo_aluno_id === null ||
        $nova_disciplina_id === false || $nova_disciplina_id === null) {

        $error = "Dados de atualização inválidos ou incompletos.";
        header("Location: form-matricula.php?id_aluno=" . urlencode($original_aluno_id ?? '') . "&id_disciplina=" . urlencode($original_disciplina_id ?? '') . "&error=" . urlencode($error));
        exit();
    }

    try {
        $checkStmt = $conexao->prepare("SELECT COUNT(*) FROM matricula
                                        WHERE Aluno_id_aluno = :novo_aluno_id
                                        AND Disciplina_id_disciplina = :nova_disciplina_id
                                        AND NOT (Aluno_id_aluno = :original_aluno_id AND Disciplina_id_disciplina = :original_disciplina_id)");
        $checkStmt->execute([
            ':novo_aluno_id' => $novo_aluno_id,
            ':nova_disciplina_id' => $nova_disciplina_id,
            ':original_aluno_id' => $original_aluno_id,
            ':original_disciplina_id' => $original_disciplina_id
        ]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            $error = "Não foi possível atualizar a matrícula. Esta combinação Aluno/Disciplina já existe.";
            header("Location: form-matricula.php?id_aluno=" . urlencode($original_aluno_id) . "&id_disciplina=" . urlencode($original_disciplina_id) . "&error=" . urlencode($error));
            exit();
        }

        $stmt = $conexao->prepare("UPDATE matricula SET
            Aluno_id_aluno = :novo_aluno_id,
            Disciplina_id_disciplina = :nova_disciplina_id
            WHERE Aluno_id_aluno = :original_aluno_id
            AND Disciplina_id_disciplina = :original_disciplina_id");

        $stmt->execute([
            ':novo_aluno_id' => $novo_aluno_id,
            ':nova_disciplina_id' => $nova_disciplina_id,
            ':original_aluno_id' => $original_aluno_id,
            ':original_disciplina_id' => $original_disciplina_id
        ]);

        if ($stmt->rowCount() > 0) {
            header("Location: ../../consultas/consulta-matricula/consulta-matricula.php?message=" . urlencode($message));
            exit();
        } else {
            $error = "Nenhuma matrícula encontrada para atualizar com os IDs originais fornecidos, ou os novos dados são idênticos aos antigos.";
            header("Location: form-matricula.php?id_aluno=" . urlencode($original_aluno_id) . "&id_disciplina=" . urlencode($original_disciplina_id) . "&error=" . urlencode($error));
            exit();
        }

    } catch (PDOException $e) {
        $error = "Erro no banco de dados ao atualizar matrícula: " . $e->getMessage();
        header("Location: form-matricula.php?id_aluno=" . urlencode($original_aluno_id) . "&id_disciplina=" . urlencode($original_disciplina_id) . "&error=" . urlencode($error));
        exit();
    }

} else {
    $error = "Requisição inválida para atualização de matrícula.";
    header("Location: ../../consultas/consulta-matricula/consulta-matricula.php?error=" . urlencode($error));
    exit();
}
?>