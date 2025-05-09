<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoProva = $_POST["codigoProva"];
    $tipoProva = $_POST["tipo_prova"];
    $disciplina = $_POST["disciplina"];
    $conteudo = $_POST["conteudo"];
    $dataProva = $_POST["data_prova"];
    $professor = $_POST["nome_professor"];
    $idDisciplina = $_POST["id_disciplina"];
    $idProfessor = $_POST["id_professor"];

    try {
        $sql = "INSERT INTO prova (codigoProva, tipo_prova, disciplina, conteudo, data_prova, professor, Disciplina_id_disciplina, Disciplina_Professor_id_professor)
                VALUES (:codigo, :tipo, :disciplina, :conteudo, :data, :professor_nome, :id_disciplina, :id_professor)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigoProva,
            ':tipo' => $tipoProva,
            ':disciplina' => $disciplina,
            ':conteudo' => $conteudo,
            ':data' => $dataProva,
            ':professor_nome' => $professor,
            ':id_disciplina' => $idDisciplina,
            ':id_professor' => $idProfessor
        ]);

        echo "<p>Dados inseridos com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';
    } catch (PDOException $e) {
        echo "<p>Erro ao inserir dados: " . $e->getMessage() . "</p>";
        echo '<p><a href="form-prova.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }
} else {
    echo "<p>Requisição inválida.</p>";
}

?>