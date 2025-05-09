<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoDisciplina = $_POST["codigoDisciplina"];
    $nomeDisciplina = $_POST["nomeDisciplina"];
    $carga_horaria = $_POST["carga_horaria"];
    $professor = $_POST["professor"];
    $descricaoDisciplina = $_POST["descricaoDisciplina"];
    $semestre_periodo = $_POST["semestre_periodo"];
    $id_professor = $_POST["id_professor"];
    $id_turma = $_POST["id_turma"];

    try {
        $sql = "INSERT INTO disciplina (codigoDisciplina, nome, carga_horaria, professor, descricao, semestre_periodo, Professor_id_professor, Turma_id_turma) 
                VALUES (:codigo, :nome, :carga_horaria, :professor, :descricao, :semestre_periodo, :id_professor, :id_turma)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigoDisciplina,
            ':nome' => $nomeDisciplina,
            ':carga_horaria' => $carga_horaria,
            ':professor' => $professor,
            ':descricao' => $descricaoDisciplina,
            ':semestre_periodo' => $semestre_periodo,
            ':id_professor' => $id_professor,
            ':id_turma' => $id_turma
        ]);

        echo "<p>Dados inseridos com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';
    } catch (PDOException $e) {
        echo "<p>Erro ao inserir dados: " . $e->getMessage() . "</p>";
        echo '<p><a href="form-disciplina.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }
} else {
    echo "<p>Requisição inválida.</p>";
}

?>