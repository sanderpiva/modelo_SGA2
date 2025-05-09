<?php
require_once "../conexao.php";

if (isset($_GET['id_turma']) && !empty($_GET['id_turma'])) {
    $idTurmaExcluir = $_GET['id_turma'];

    $stmt = $conexao->prepare("DELETE FROM turma WHERE id_turma = :id");
    $stmt->bindParam(':id', $idTurmaExcluir, PDO::PARAM_INT); // Assumindo que id_turma é um inteiro

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: consulta-turma.php?excluido=sucesso");
                exit;
            } else {
                header("Location: consulta-turma.php?excluido=nenhum");
                exit;
            }
        } else {
            header("Location: consulta-turma.php?excluido=erro");
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            header("Location: consulta-turma.php?excluido=dependencia");
            exit;
        } else {
            header("Location: consulta-turma.php?excluido=erro_sql&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
} else {
    header("Location: consulta-turma.php?excluido=id_invalido");
    exit;
}
?>