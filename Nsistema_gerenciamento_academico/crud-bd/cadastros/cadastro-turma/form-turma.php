<?php
require_once '../conexao.php';

$isUpdating = false;
$turmaData = [];
$errors = "";

if (isset($_GET['id_turma']) && !empty($_GET['id_turma'])) {
    $isUpdating = true;
    $idTurmaToUpdate = $_GET['id_turma'];

    $stmt = $conexao->prepare("SELECT * FROM turma WHERE id_turma = :id");
    $stmt->execute([':id' => $idTurmaToUpdate]);
    $turmaData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$turmaData) {
        $errors = "<p style='color:red;'>Turma com ID " . htmlspecialchars($idTurmaToUpdate) . " não encontrada.</p>";
        $isUpdating = false; 
    }
} 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Turma</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-turma/atualizar-turma.php' : 'valida-inserir-turma.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Turma</h2>
            <hr>

            <label for="codigoTurma">Código Turma:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="codigoTurma" id="codigoTurma" value="<?php echo htmlspecialchars($turmaData['codigoTurma'] ?? ''); ?>" required>
                <input type="hidden" name="id_turma" value="<?php echo htmlspecialchars($turmaData['id_turma'] ?? ''); ?>">
            <?php else: ?>
                <input type="text" name="codigoTurma" id="codigoTurma" placeholder="" required>
            <?php endif; ?>
            <hr>

            <label for="nomeTurma">Nome da turma (Ex: 6 serie A):</label>
            <input type="text" name="nomeTurma" id="nomeTurma" placeholder="" value="<?php echo htmlspecialchars($turmaData['nomeTurma'] ?? ''); ?>" required>
            <hr>

            <button type="submit"><?php echo $isUpdating ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>

        <?php echo $errors; ?>
        <hr>
    </div>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Servicos</a>
    <hr>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>