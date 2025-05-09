<?php
require_once "../conexao.php";

if (isset($_GET['id_aluno']) && !empty($_GET['id_aluno'])) {
    $alunoIdExcluir = $_GET['id_aluno'];

    $stmt = $conexao->prepare("DELETE FROM matricula WHERE Aluno_id_aluno = :id");
    $stmt->bindParam(':id', $alunoIdExcluir, PDO::PARAM_INT); // Assumindo que Aluno_id_aluno é INT

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: consulta-matricula.php?excluido=sucesso");
                exit;
            } else {
                header("Location: consulta-matricula.php?excluido=nenhum");
                exit;
            }
        } else {
            header("Location: consulta-matricula.php?excluido=erro");
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            header("Location: consulta-matricula.php?excluido=dependencia");
            exit;
        } else {
            header("Location: consulta-matricula.php?excluido=erro_sql&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
} else {
    header("Location: consulta-matricula.php?excluido=id_aluno_invalido");
    exit;
}
?>