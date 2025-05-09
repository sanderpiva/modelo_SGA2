<?php
require_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    if (!isset($_POST['id_conteudo']) || empty($_POST['id_conteudo'])) {
        $error = "ID do conteúdo não fornecido para atualização.";
        header("Location: ../../cadastros/cadastroConteudo/formConteudo.php?erros=" . urlencode($error));
        exit();
    }

    $id_conteudo = $_POST['id_conteudo'];
    $codigoConteudo = $_POST['codigoConteudo'];
    $tituloConteudo = $_POST['tituloConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $data_postagem = $_POST['data_postagem'];
    $professor = $_POST['professor'];
    $disciplina = $_POST['disciplina'];
    $tipo_conteudo = $_POST['tipo_conteudo'];
    $id_disciplina = $_POST['id_disciplina'];

    $stmt = $conexao->prepare("UPDATE conteudo SET
        codigoConteudo = :codigoConteudo,
        titulo = :titulo,
        descricao = :descricao,
        data_postagem = :data_postagem,
        professor = :professor,
        disciplina = :disciplina,
        tipo_conteudo = :tipo_conteudo,
        Disciplina_id_disciplina = :id_disciplina
        WHERE id_conteudo = :id");

    $stmt->execute([
        ':codigoConteudo' => $codigoConteudo,
        ':titulo' => $tituloConteudo,
        ':descricao' => $descricaoConteudo,
        ':data_postagem' => $data_postagem,
        ':professor' => $professor,
        ':disciplina' => $disciplina,
        ':tipo_conteudo' => $tipo_conteudo,
        ':id_disciplina' => $id_disciplina,
        ':id' => $id_conteudo
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Conteúdo com ID $id_conteudo atualizado com sucesso!";
        header("Location: ../../consultas/consulta-conteudo/consulta-conteudo.php?message=" . urlencode($message));
        exit();
    } else {
        $error = "Erro ao atualizar o conteúdo com ID $id_conteudo.";
        header("Location: ../../cadastros/cadastro-conteudo/form-conteudo.php?id_conteudo=" . urlencode($id_conteudo) . "&erros=" . urlencode($error));
        exit();
    }
} else {
    $error = "Requisição inválida para atualização de conteúdo.";
    header("Location: ../../consultas/consulta-conteudo/consulta-conteudo.php?erros=" . urlencode($error));
    exit();
}
?>