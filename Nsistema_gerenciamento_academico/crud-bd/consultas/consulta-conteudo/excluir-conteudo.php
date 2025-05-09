<?php
require_once "../conexao.php";

if (isset($_GET['id_conteudo']) && !empty($_GET['id_conteudo'])) {
    $idConteudoExcluir = $_GET['id_conteudo'];

    $stmt = $conexao->prepare("DELETE FROM conteudo WHERE id_conteudo = :id");
    $stmt->bindParam(':id', $idConteudoExcluir, PDO::PARAM_INT); // Assumindo que id_conteudo é um inteiro

    if ($stmt->execute()) {
        header("Location: consulta-conteudo.php?excluido=sucesso");
        exit;
    } else {
        echo "Erro ao excluir o conteúdo.";
    }
} else {
    echo "ID do conteúdo não fornecido.";
}
?>