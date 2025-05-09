<?php
require_once '../conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_respostas'])) {

    $id_respostas = $_POST['id_respostas'];
    $codigoRespostas = $_POST['codigoRespostas'];
    $respostaDada = $_POST['respostaDada'];
    $acertou = $_POST['acertou'];
    $nota = $_POST['nota'];
    $id_questao = $_POST['id_questao'];
    $id_prova = $_POST['id_prova'];
    $id_disciplina = $_POST['id_disciplina'];
    $id_professor = $_POST['id_professor'];

    $stmt = $conexao->prepare("UPDATE respostas SET
                                CodigoRespostas = :codigoRespostas,
                                respostaDada = :respostaDada,
                                acertou = :acertou,
                                nota = :nota,
                                Questoes_id_questao = :id_questao,
                                Questoes_Prova_id_prova = :id_prova,
                                Questoes_Prova_Disciplina_id_disciplina = :id_disciplina,
                                Questoes_Prova_Disciplina_Professor_id_professor = :id_professor
                                WHERE id_respostas = :id_respostas");

    $stmt->execute([
        ':codigoRespostas' => $codigoRespostas,
        ':respostaDada' => $respostaDada,
        ':acertou' => $acertou,
        ':nota' => $nota,
        ':id_questao' => $id_questao,
        ':id_prova' => $id_prova,
        ':id_disciplina' => $id_disciplina,
        ':id_professor' => $id_professor,
        ':id_respostas' => $id_respostas
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Resposta com código " . htmlspecialchars($codigoRespostas) . " atualizada com sucesso!";
        header("Location: consulta-respostas.php?message=" . urlencode($message));
        exit(); 
    } else {
        $error = "Erro ao atualizar resposta.";
        $pathToForm = '../../cadastros/cadastro-respostas/form-respostas.php';
        header("Location: " . $pathToForm . "?id_resposta=" . urlencode($id_respostas) . "&erros=" . urlencode($error));
        exit(); 
    }

} else {
    $error = "Requisição inválida para atualização de resposta.";
    header("Location: consultaRespostas.php?erros=" . urlencode($error));
    exit();
}
?>