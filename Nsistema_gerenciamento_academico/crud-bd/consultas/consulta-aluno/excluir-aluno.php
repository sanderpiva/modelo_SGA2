<?php
require_once "../conexao.php";

if (isset($_GET['id_aluno']) && !empty($_GET['id_aluno'])) {
    $id_aluno = $_GET['id_aluno'];

    try {
        
        $stmt_check_matricula = $conexao->prepare("SELECT COUNT(*) FROM matricula WHERE Aluno_id_aluno = :id");
        $stmt_check_matricula->bindParam(':id', $id_aluno, PDO::PARAM_INT);
        $stmt_check_matricula->execute();
        $count_matriculas = $stmt_check_matricula->fetchColumn();

        if ($count_matriculas > 0) {
            echo "<p style='color: red;'>Não é possível excluir este aluno pois ele está matriculado em uma ou mais disciplinas. Por favor, remova as matrículas deste aluno antes de excluí-lo.</p>";
            echo '<p><a href="../../consultas/consulta-matricula/consulta-matricula.php">Verificar Matrículas</a></p>';
        } else {
            
            $stmt_delete_aluno = $conexao->prepare("DELETE FROM aluno WHERE id_aluno = :id");
            $stmt_delete_aluno->bindParam(':id', $id_aluno, PDO::PARAM_INT);

            if ($stmt_delete_aluno->execute()) {
                header("Location: ../../consultas/consulta-aluno/consulta-aluno.php?excluido=sucesso");
                exit;
            } else {
                echo "<p style='color: red;'>Erro ao excluir o aluno.</p>";
                echo '<p><a href="../../consultas/consulta-aluno/consulta-aluno.php">Voltar para a Consulta de Alunos</a></p>';
            }
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erro ao verificar ou excluir o aluno: " . $e->getMessage() . "</p>";
        echo '<p><a href="../../consultas/consulta-aluno/consulta-aluno.php">Voltar para a Consulta de Alunos</a></p>';
    }
} else {
    echo "<p style='color: red;'>ID do aluno não fornecido.</p>";
    echo '<p><a href="../../consultas/consulta-aluno/consulta-aluno.php">Voltar para a Consulta de Alunos</a></p>';
}
?>