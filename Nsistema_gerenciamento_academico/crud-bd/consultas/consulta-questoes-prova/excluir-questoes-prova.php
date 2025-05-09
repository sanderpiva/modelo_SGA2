<?php
require_once "../conexao.php";

if (isset($_GET['id_questaoProva']) && !empty($_GET['id_questaoProva'])) {
    $idQuestaoProvaExcluir = $_GET['id_questaoProva'];

    $stmt = $conexao->prepare("DELETE FROM questoes WHERE id_questao = :id");
    $stmt->bindParam(':id', $idQuestaoProvaExcluir, PDO::PARAM_INT); // Assumindo que id_questao é um inteiro

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: consulta-questoes-prova.php?excluido=sucesso");
                exit;
            } else {
                header("Location: consulta-questoes-prova.php?excluido=nenhum");
                exit;
            }
        } else {
            header("Location: consulta-questoes-prova.php?excluido=erro");
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            header("Location: consulta-questoes-prova.php?excluido=dependencia");
            exit;
        } else {
            header("Location: consulta-questoes-prova.php?excluido=erro_sql&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
} else {
    header("Location: consulta-questoes-prova.php?excluido=id_invalido");
    exit;
}
?>