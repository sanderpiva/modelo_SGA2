<?php
require_once '../conexao.php';

$alunos = $conexao->query("SELECT id_aluno, matricula, nome FROM aluno")->fetchAll(PDO::FETCH_ASSOC);
$disciplinas = $conexao->query("SELECT id_disciplina, nome, Professor_id_professor FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
$professores = $conexao->query("SELECT id_professor, nome FROM professor")->fetchAll(PDO::FETCH_ASSOC);

$professorsLookup = [];
foreach ($professores as $professor) {
    $professorsLookup[$professor['id_professor']] = $professor['nome'];
}

$isUpdating = false;
$matriculaData = [];
$errors = "";
$nomeAlunoAtual = '';
$matriculaAlunoAtual = '';
$nomeDisciplinaAtual = '';
$professorDisciplinaAtual = '';

$alunoIdToUpdate = null;
$disciplinaIdToUpdate = null;

if (isset($_GET['id_aluno']) && !empty($_GET['id_aluno']) &&
    isset($_GET['id_disciplina']) && !empty($_GET['id_disciplina'])) {

    $isUpdating = true;
    $alunoIdToUpdate = filter_input(INPUT_GET, 'id_aluno', FILTER_SANITIZE_NUMBER_INT);
    $disciplinaIdToUpdate = filter_input(INPUT_GET, 'id_disciplina', FILTER_SANITIZE_NUMBER_INT);

    if ($alunoIdToUpdate === false || $alunoIdToUpdate === null ||
        $disciplinaIdToUpdate === false || $disciplinaIdToUpdate === null) {
        $errors = "<p style='color:red;'>IDs de aluno ou disciplina inválidos.</p>";
        $isUpdating = false;
    } else {
        $stmt = $conexao->prepare("SELECT Aluno_id_aluno, Disciplina_id_disciplina FROM matricula
                                   WHERE Aluno_id_aluno = :aluno_id
                                   AND Disciplina_id_disciplina = :disciplina_id");
        $stmt->execute([':aluno_id' => $alunoIdToUpdate, ':disciplina_id' => $disciplinaIdToUpdate]);
        $matriculaData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$matriculaData) {
            $errors = "<p style='color:red;'>Registro de matrícula não encontrado para os IDs fornecidos.</p>";
            $isUpdating = false;
        } else {
            $alunoStmt = $conexao->prepare("SELECT nome, matricula FROM aluno WHERE id_aluno = :id");
            $alunoStmt->execute([':id' => $alunoIdToUpdate]);
            $alunoInfo = $alunoStmt->fetch(PDO::FETCH_ASSOC);
            $nomeAlunoAtual = htmlspecialchars($alunoInfo['nome'] ?? '');
            $matriculaAlunoAtual = htmlspecialchars($alunoInfo['matricula'] ?? '');

            $disciplinaStmt = $conexao->prepare("SELECT nome, Professor_id_professor FROM disciplina WHERE id_disciplina = :id");
            $disciplinaStmt->execute([':id' => $disciplinaIdToUpdate]);
            $disciplinaInfo = $disciplinaStmt->fetch(PDO::FETCH_ASSOC);
            $nomeDisciplinaAtual = htmlspecialchars($disciplinaInfo['nome'] ?? '');
            $professorIdAtual = $disciplinaInfo['Professor_id_professor'] ?? null;
            $professorDisciplinaAtual = $professorsLookup[$professorIdAtual] ?? 'Professor Desconhecido';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Matrícula</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-matricula/atualizar-matricula.php' : 'valida-inserir-matricula.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Matrícula</h2>
            <hr>

            <?php if ($isUpdating): ?>
                
                <label for="aluno_id">Aluno:</label>
                <select name="aluno_id" id="aluno_id" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= htmlspecialchars($aluno['id_aluno']) ?>"
                            <?php if ($aluno['id_aluno'] == $alunoIdToUpdate) echo 'selected'; ?>>
                            <?= htmlspecialchars($aluno['nome']) ?> (<?= htmlspecialchars($aluno['matricula']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>

                <label for="disciplina_id">Disciplina:</label>
                <select name="disciplina_id" id="disciplina_id" required>
                    <option value="">Selecione uma disciplina (Professor)</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <?php
                            $professorId = $disciplina['Professor_id_professor'] ?? null;
                            $professorNome = $professorsLookup[$professorId] ?? 'Professor Desconhecido';
                        ?>
                        <option value="<?= htmlspecialchars($disciplina['id_disciplina']) ?>"
                            <?php if ($disciplina['id_disciplina'] == $disciplinaIdToUpdate) echo 'selected'; ?>>
                            <?= htmlspecialchars($disciplina['nome']) . ' (' . htmlspecialchars($professorNome) . ')' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>
                <input type="hidden" name="original_aluno_id" value="<?php echo htmlspecialchars($alunoIdToUpdate); ?>">
                <input type="hidden" name="original_disciplina_id" value="<?php echo htmlspecialchars($disciplinaIdToUpdate); ?>">

            <?php else: ?>
                <label for="aluno_id">Aluno:</label>
                <select name="aluno_id" id="aluno_id" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= htmlspecialchars($aluno['id_aluno']) ?>">
                            <?= htmlspecialchars($aluno['nome']) ?> (<?= htmlspecialchars($aluno['matricula']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>

                <label for="disciplina_id">Disciplina:</label>
                <select name="disciplina_id" id="disciplina_id" required>
                    <option value="">Selecione uma disciplina (Professor)</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <?php
                            $professorId = $disciplina['Professor_id_professor'] ?? null;
                            $professorNome = $professorsLookup[$professorId] ?? 'Professor Desconhecido';
                        ?>
                        <option value="<?= htmlspecialchars($disciplina['id_disciplina']) ?>">
                            <?= htmlspecialchars($disciplina['nome']) . ' (' . htmlspecialchars($professorNome) . ')' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>
            <?php endif; ?>

            <button type="submit"><?php echo $isUpdating ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>

        <?php echo $errors; ?>
        <?php
            if (isset($_GET['message'])) {
                echo "<p style='color:green;'>" . htmlspecialchars($_GET['message']) . "</p>";
            }
            if (isset($_GET['error'])) {
                echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
        ?>

        <hr>
    </div>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Serviços</a>
    <hr>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>