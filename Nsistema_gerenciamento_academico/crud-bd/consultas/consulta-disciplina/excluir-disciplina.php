<?php
require_once "../conexao.php";

if (isset($_GET['id_disciplina']) && !empty($_GET['id_disciplina'])) {
    $idDisciplinaExcluir = $_GET['id_disciplina'];

    $stmt = $conexao->prepare("DELETE FROM disciplina WHERE id_disciplina = :id");
    $stmt->bindParam(':id', $idDisciplinaExcluir, PDO::PARAM_INT); // Assumindo que id_disciplina é um inteiro

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: consulta-disciplina.php?excluido=sucesso");
                exit;
            } else {
                header("Location: consulta-disciplina.php?excluido=nenhum");
                exit;
            }
        } else {
            header("Location: consulta-disciplina.php?excluido=erro");
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            header("Location: consulta-disciplina.php?excluido=dependencia");
            exit;
        } else {
            header("Location: consulta-disciplina.php?excluido=erro_sql&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
} else {
    header("Location: consulta-disciplina.php?excluido=id_invalido");
    exit;
}
?>