<?php
require_once '../conexao.php';

$alunos = $conexao->query("SELECT id_aluno, matricula, nome FROM aluno")->fetchAll(PDO::FETCH_ASSOC);
$disciplinas = $conexao->query("SELECT id_disciplina, nome, Professor_id_professor FROM disciplina")->fetchAll(PDO::FETCH_ASSOC); // *** MODIFICAÇÃO: Buscar também o ID do professor da disciplina ***
$professores = $conexao->query("SELECT id_professor, nome FROM professor")->fetchAll(PDO::FETCH_ASSOC); // *** ADIÇÃO: Carregar os dados dos professores ***

$professorsLookup = [];
foreach ($professores as $professor) {
    $professorsLookup[$professor['id_professor']] = $professor['nome'];
}


$isUpdating = false;
$matriculaData = [];
$errors = "";
$nomeAlunoAtual = '';
$nomeDisciplinaAtual = '';
$matriculaAlunoAtual = '';

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

            // Busca a informação do aluno na atualização
            $alunoStmt = $conexao->prepare("SELECT nome, matricula FROM aluno WHERE id_aluno = :id");
            $alunoStmt->execute([':id' => ($matriculaData['Aluno_id_aluno'] ?? null)]); // Usando ?? null para segurança
            $alunoInfo = $alunoStmt->fetch(PDO::FETCH_ASSOC);
            $nomeAlunoAtual = htmlspecialchars($alunoInfo['nome'] ?? '');
            $matriculaAlunoAtual = htmlspecialchars($alunoInfo['matricula'] ?? '');

            $disciplinaStmt = $conexao->prepare("SELECT nome, Professor_id_professor FROM disciplina WHERE id_disciplina = :id"); // *** MODIFICAÇÃO: Buscar o ID do professor na atualização ***
            $disciplinaStmt->execute([':id' => ($matriculaData['Disciplina_id_disciplina'] ?? null)]); // Usando ?? null para segurança
            $disciplinaInfo = $disciplinaStmt->fetch(PDO::FETCH_ASSOC);
            $nomeDisciplinaAtual = htmlspecialchars($disciplinaInfo['nome'] ?? '');

       
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
        <form class="form" action="<?php echo $isUpdating ? '#' : 'valida-inserir-matricula.php'; ?>" method="post" <?php if ($isUpdating) echo 'onsubmit="return false;"'; ?>>
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Matrícula</h2>
            <hr>

            <?php if ($isUpdating): ?>
                 <p style="color: orange;">Esta funcionalidade de atualização ainda está em desenvolvimento.</p>
                <label for="aluno_id">Aluno:</label>
                 <input type="text" value="<?php echo $nomeAlunoAtual; ?> (<?php echo $matriculaAlunoAtual; ?>)" readonly>
                <hr>
                <label for="disciplina_id">Disciplina:</label>
                <input type="text" value="<?php echo $nomeDisciplinaAtual; /* . (isset($professorDisciplinaAtual) ? ' (' . $professorDisciplinaAtual . ')' : '') */ ?>" readonly>
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
                            <?= htmlspecialchars($disciplina['nome']) . ' (' . htmlspecialchars($professorNome) . ')' // *** CONCATENAÇÃO NA LINHA DA OPÇÃO *** ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>
            <?php endif; ?>

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