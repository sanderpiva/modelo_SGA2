<?php
require_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_prova'])) {

    $id_prova = $_POST['id_prova'];
    $codigoProva = $_POST['codigoProva'];
    $tipo_prova = $_POST['tipo_prova'];
    $disciplina = $_POST['disciplina'];
    $conteudo = $_POST['conteudo'];
    $data_prova = $_POST['data_prova'];
    $professor = $_POST['nome_professor'];

    $stmt = $conexao->prepare("UPDATE prova SET
                                codigoProva = :codigoProva,
                                tipo_prova = :tipo_prova,
                                disciplina = :disciplina,
                                conteudo = :conteudo,
                                data_prova = :data_prova,
                                professor = :professor
                                WHERE id_prova = :id_prova");

    $stmt->execute([
        ':codigoProva' => $codigoProva,
        ':tipo_prova' => $tipo_prova,
        ':disciplina' => $disciplina,
        ':conteudo' => $conteudo,
        ':data_prova' => $data_prova,
        ':professor' => $professor,
        ':id_prova' => $id_prova
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Prova com código " . htmlspecialchars($codigoProva) . " atualizada com sucesso!";
        header("Location: consulta-prova.php?message=" . urlencode($message));
        exit(); 
    } else {
        $error = "Erro ao atualizar prova.";
        $pathToForm = '../../cadastros/cadastro-prova/form-prova.php';
        header("Location: " . $pathToForm . "?id_prova=" . urlencode($id_prova) . "&erros=" . urlencode($error));
        exit(); 
    }

} else {
    $error = "Requisição inválida para atualização de prova.";
    header("Location: consulta-prova.php?erros=" . urlencode($error));
    exit();
}
?>