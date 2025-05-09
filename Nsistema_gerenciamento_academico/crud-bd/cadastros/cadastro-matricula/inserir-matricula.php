<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_matricula = $_POST["aluno_id"];
    $id_disciplina = $_POST["disciplina_id"];

    try {
        $sql = "INSERT INTO matricula (Aluno_id_aluno, Disciplina_id_disciplina)
                VALUES (:aluno_matricula, :id_disciplina)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':aluno_matricula' => $aluno_matricula,
            ':id_disciplina' => $id_disciplina
        ]);

        echo "<p>Matrícula realizada com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';

    } catch (PDOException $e) {
        $erro = $e->getMessage();
        echo "<p>Erro ao realizar a matrícula: " . htmlspecialchars($erro) . "</p>";

        if (strpos($erro, 'foreign key constraint fails') !== false) {
            echo "<p style='color: red;'>Erro: Problema com vínculos de chave estrangeira. Verifique se a matrícula do aluno e o ID da disciplina existem.</p>";
        } elseif (strpos($erro, "Column count doesn't match value count") !== false) {
            echo "<p style='color: orange;'>Erro: Verifique se todos os campos necessários foram informados.</p>";
        } else {
            echo "<p>Erro ao inserir dados: " . htmlspecialchars($erro) . "</p>";
        }
        echo '<p><a href="form-matricula.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }

} else {
    echo "<p>Requisição inválida.</p>";
}

?>