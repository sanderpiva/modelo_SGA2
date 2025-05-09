<?php
require_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['id_disciplina']) || empty($_POST['id_disciplina'])) {
        $error = "ID da disciplina não fornecido para atualização.";
        header("Location: ../../cadastros/cadastroDisciplina/formDisciplina.php?erros=" . urlencode($error));
        exit();
    }

    $id_disciplina = $_POST['id_disciplina'];
    $codigoDisciplina = $_POST['codigoDisciplina'];
    $nomeDisciplina = $_POST['nomeDisciplina'];
    $carga_horaria = $_POST['carga_horaria'];
    $professor = $_POST['professor'];
    $descricaoDisciplina = $_POST['descricaoDisciplina'];
    $semestre_periodo = $_POST['semestre_periodo'];
    $Professor_id_professor = $_POST['Professor_id_professor'];
    $id_turma = $_POST['id_turma'];

    $stmt = $conexao->prepare("UPDATE disciplina SET
        codigoDisciplina = :codigoDisciplina,
        nome = :nomeDisciplina,
        carga_horaria = :carga_horaria,
        professor = :professor,
        descricao = :descricaoDisciplina,
        semestre_periodo = :semestre_periodo,
        Professor_id_professor = :Professor_id_professor,
        Turma_id_turma = :id_turma
        WHERE id_disciplina = :id");

    $stmt->execute([
        ':codigoDisciplina' => $codigoDisciplina,
        ':nomeDisciplina' => $nomeDisciplina,
        ':carga_horaria' => $carga_horaria,
        ':professor' => $professor,
        ':descricaoDisciplina' => $descricaoDisciplina,
        ':semestre_periodo' => $semestre_periodo,
        ':Professor_id_professor' => $Professor_id_professor,
        ':id_turma' => $id_turma,
        ':id' => $id_disciplina
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Disciplina com ID $id_disciplina atualizada com sucesso!";
        header("Location: ../../consultas/consulta-disciplina/consulta-disciplina.php?message=" . urlencode($message));
        exit();
    } else {
        $error = "Erro ao atualizar a disciplina com ID $id_disciplina.";
        header("Location: ../../cadastros/cadastroDisciplina/form-disciplina.php?id_disciplina=" . urlencode($id_disciplina) . "&erros=" . urlencode($error));
        exit();
    }
} else {
    $error = "Requisição inválida para atualização de disciplina.";
    header("Location: ../../consultas/consulta-disciplina/consulta-disciplina.php?erros=" . urlencode($error));
    exit();
}
?>