<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoQuestao = $_POST["codigoQuestaoProva"];
    $descricao_questao_prova = $_POST["descricao_questao"];
    $tipo_prova = $_POST["tipo_prova"];
    $id_prova = $_POST["id_prova"];
    $id_disciplina = $_POST["id_disciplina"];
    $id_professor = $_POST["id_professor"];

    try {
        $sql = "INSERT INTO questoes (codigoQuestao, descricao, tipo_prova, Prova_id_prova, Prova_Disciplina_id_disciplina, Prova_Disciplina_Professor_id_professor) 
                VALUES (:codigo, :descricao, :tipo, :id_prova, :id_disciplina, :id_professor)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigoQuestao,
            ':descricao' => $descricao_questao_prova,
            ':tipo' => $tipo_prova,
            ':id_prova' => $id_prova,
            ':id_disciplina' => $id_disciplina,
            ':id_professor' => $id_professor
        ]);

        echo "<p>Dados inseridos com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';
    } catch (PDOException $e) {
        echo "<p>Erro ao inserir dados: " . $e->getMessage() . "</p>";
        echo '<p><a href="form-questoes-prova.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }
} else {
    echo "<p>Requisição inválida.</p>";
}

?>


