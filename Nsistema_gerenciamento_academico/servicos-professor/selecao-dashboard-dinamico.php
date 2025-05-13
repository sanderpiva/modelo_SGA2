<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gerenciamento_academico_completo";
$pdo = null;
$erro_conexao = null;
$turmas = [];
$disciplinas = [];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Carregar as turmas disponíveis
    $stmt_turmas = $pdo->query("SELECT id_turma, nomeTurma FROM turma ORDER BY nomeTurma");
    $turmas = $stmt_turmas->fetchAll(PDO::FETCH_ASSOC);

    // Carregar as disciplinas disponíveis, incluindo o nome do professor
    $stmt_disciplinas = $pdo->query("SELECT id_disciplina, nome, professor FROM disciplina ORDER BY nome");
    $disciplinas = $stmt_disciplinas->fetchAll(PDO::FETCH_ASSOC);

    // Processar o formulário quando submetido
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['turma_selecionada']) && !empty($_POST['turma_selecionada']) &&
            isset($_POST['disciplina_selecionada']) && !empty($_POST['disciplina_selecionada'])) {

            $_SESSION['turma_selecionada'] = $_POST['turma_selecionada'];
            $_SESSION['disciplina_selecionada'] = $_POST['disciplina_selecionada'];

            header("Location: dashboard-alunos-dinamico.php"); // Redireciona para a página que exibe o conteúdo
            exit();
        } else {
            echo "<p style='color:red;'>Por favor, selecione uma turma e uma disciplina.</p>";
        }
    }

} catch (PDOException $e) {
    $erro_conexao = "<p style='color:red;'>Erro na conexão com o banco de dados: " . $e->getMessage() . "</p>";
} finally {
    $pdo = null;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Seleção de Atividades</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="servicos_forms">
    <div class="form_container">
        <form class="form" method="post" action="">
            <h2>Selecione a Turma e a Disciplina</h2>

            <?php if ($erro_conexao): ?>
                <?php echo $erro_conexao; ?>
            <?php else: ?>
                <label for="turma_selecionada">Selecione a Turma:</label>
                <select id="turma_selecionada" name="turma_selecionada" required>
                    <option value="">Selecione a Turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= htmlspecialchars($turma['nomeTurma']) ?>">
                            <?= htmlspecialchars($turma['nomeTurma']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <label for="disciplina_selecionada">Selecione a Disciplina:</label>
                <select id="disciplina_selecionada" name="disciplina_selecionada" required>
                    <option value="">Selecione a Disciplina</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?= htmlspecialchars($disciplina['nome']) ?>">
                            <?= htmlspecialchars($disciplina['nome']) ?> (Professor: <?= htmlspecialchars($disciplina['professor']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <button type="submit">Continuar</button>
            <?php endif; ?>
        </form>
    </div>
    <a href="../index.php">Home Page</a>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>