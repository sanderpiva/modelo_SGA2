<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoTurma = $_POST['codigoTurma'] ?? '';
    $nomeTurma = $_POST['nomeTurma'] ?? '';

    try {
        $sql = "INSERT INTO turma (codigoTurma, nomeTurma) VALUES (:codigoTurma, :nomeTurma)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':codigoTurma' => $codigoTurma,
            ':nomeTurma' => $nomeTurma,
        ]);

        echo "<p>Turma cadastrada com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
        echo '<p><a href="form-turma.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }
} else {
    echo "<p>Requisição inválida.</p>";
    echo '<p><a href="form-turma.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
}

?>