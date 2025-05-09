<?php
require_once "../conexao.php";

if (isset($_GET['id_prova']) && !empty($_GET['id_prova'])) {
    $idProvaExcluir = $_GET['id_prova'];

    $stmt = $conexao->prepare("DELETE FROM prova WHERE id_prova = :id");
    $stmt->bindParam(':id', $idProvaExcluir, PDO::PARAM_INT); // Assumindo que id_prova é um inteiro

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: consulta-prova.php?excluido=sucesso");
                exit;
            } else {
                header("Location: consulta-prova.php?excluido=nenhum");
                exit;
            }
        } else {
            header("Location: consulta-prova.php?excluido=erro");
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            header("Location: consulta-prova.php?excluido=dependencia");
            exit;
        } else {
            header("Location: consulta-prova.php?excluido=erro_sql&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
} else {
    header("Location: consulta-prova.php?excluido=id_invalido");
    exit;
}
?>