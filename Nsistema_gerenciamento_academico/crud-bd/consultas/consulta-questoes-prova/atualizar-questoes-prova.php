<?php
require_once '../conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_questao'])) {

    $id_questaoProva = $_POST['id_questao'];
    $codigoQuestaoProva = $_POST['codigoQuestaoProva']; 
    $descricao_questao_prova = $_POST['descricao_questao']; 
    $tipo_prova = $_POST['tipo_prova']; 
    $id_prova = $_POST['id_prova']; 
    $id_disciplina = $_POST['id_disciplina'];
    $id_professor = $_POST['id_professor'];

    $stmt = $conexao->prepare("UPDATE questoes SET
                                codigoQuestao = :codigoQuestao,
                                descricao = :descricao,
                                tipo_prova = :tipo_prova,
                                Prova_id_prova = :id_prova,
                                Prova_Disciplina_id_disciplina = :id_disciplina,
                                Prova_Disciplina_Professor_id_professor = :id_professor
                                WHERE id_questao = :id_questao");

    $stmt->execute([
        ':codigoQuestao' => $codigoQuestaoProva,
        ':descricao' => $descricao_questao_prova,
        ':tipo_prova' => $tipo_prova,
        ':id_prova' => $id_prova,
        ':id_disciplina' => $id_disciplina,
        ':id_professor' => $id_professor,
        ':id_questao' => $id_questaoProva
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Questão prova com código " . htmlspecialchars($codigoQuestaoProva) . " atualizada com sucesso!";
        header("Location: consulta-questoes-prova.php?message=" . urlencode($message));
        exit(); 
    } else {
        $error = "Erro ao atualizar questão prova.";
        $pathToForm = '../../cadastros/cadastro-questoes-prova/formQuestoesProva.php';
        header("Location: " . $pathToForm . "?id_questaoProva=" . urlencode($id_questaoProva) . "&erros=" . urlencode($error));
        exit(); 
    }

} else {
    $error = "Requisição inválida para atualização de questão prova.";
    header("Location: consulta-questoes-prova.php?erros=" . urlencode($error));
    exit();
}
?>