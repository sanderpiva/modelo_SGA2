<?php
require_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    if (!isset($_POST['original_id_aluno']) || empty($_POST['original_id_aluno']) ||
        !isset($_POST['original_id_disciplina']) || empty($_POST['original_id_disciplina']) ||
        !isset($_POST['aluno_matricula']) || empty($_POST['aluno_matricula']) ||
        !isset($_POST['disciplina_id']) || empty($_POST['disciplina_id'])) {
        $error = "Dados incompletos para atualizar a matrícula.";
        header("Location: ../../consultas/consultaMatricula/formMatricula.php?id_aluno=" . urlencode(isset($_POST['original_id_aluno']) ? $_POST['original_id_aluno'] : '') . "&id_disciplina=" . urlencode(isset($_POST['original_id_disciplina']) ? $_POST['original_id_disciplina'] : '') . "&erros=" . urlencode($error));
        exit();
    }

    $original_id_aluno = $_POST['original_id_aluno'];
    $original_id_disciplina = $_POST['original_id_disciplina'];
    $modificado_id_aluno = $_POST['aluno_matricula'];
    $modificado_id_disciplina = $_POST['disciplina_id'];

    $stmt = $conexao->prepare("UPDATE matricula SET
        Aluno_id_aluno = :modificado_aluno_id,
        Disciplina_id_disciplina = :modificado_disciplina_id
        WHERE Aluno_id_aluno = :original_aluno_id
        AND Disciplina_id_disciplina = :original_disciplina_id");

    $stmt->execute([
        ':modificado_aluno_id' => $modificado_id_aluno,
        ':modificado_disciplina_id' => $modificado_id_disciplina,
        ':original_aluno_id' => $original_id_aluno,
        ':original_disciplina_id' => $original_id_disciplina
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Matrícula do Aluno ID " . htmlspecialchars($modificado_id_aluno) .
                   " na Disciplina ID " . htmlspecialchars($modificado_id_disciplina) . " atualizada com sucesso!";
        header("Location: ../../consultas/consultaMatricula/consultaMatricula.php?message=" . urlencode($message));
        exit();
    } else {
        $error = "Erro ao atualizar a matrícula. Verifique os IDs.";
        header("Location: ../../cadastros/cadastroMatricula/formMatricula.php?id_aluno=" . urlencode($original_id_aluno) . "&id_disciplina=" . urlencode($original_id_disciplina) . "&erros=" . urlencode($error));
        exit();
    }

} else {
    $error = "Requisição inválida para atualização de matrícula.";
    header("Location: ../../consultas/consultaMatricula/consultaMatricula.php?erros=" . urlencode($error));
    exit();
}
?>