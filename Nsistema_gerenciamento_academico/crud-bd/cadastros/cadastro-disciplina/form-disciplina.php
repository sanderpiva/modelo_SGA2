<?php
require_once '../conexao.php';

$professores = $conexao->query("SELECT id_professor, registroProfessor, nome FROM professor")->fetchAll(PDO::FETCH_ASSOC);
$turmas = $conexao->query("SELECT id_turma, nomeTurma FROM turma")->fetchAll(PDO::FETCH_ASSOC);

$isUpdating = false;
$disciplinaData = [];
$errors = "";
$registroProfessorAtual = '';
$nomeTurmaAtual = '';

if (isset($_GET['id_disciplina'])) {
    $idDisciplinaToUpdate = filter_input(INPUT_GET, 'id_disciplina', FILTER_SANITIZE_NUMBER_INT);
    if ($idDisciplinaToUpdate === false || $idDisciplinaToUpdate === null) {
        $errors = "<p style='color:red;'>ID de disciplina inválido.</p>";
    } else {
        $stmt = $conexao->prepare("SELECT * FROM disciplina WHERE id_disciplina = :id");
        $stmt->execute([':id' => $idDisciplinaToUpdate]);
        $disciplinaData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$disciplinaData) {
            $errors = "<p style='color:red;'>Disciplina com ID $idDisciplinaToUpdate não encontrada.</p>";
            $isUpdating = false;
        } else {
            $isUpdating = true;
            
            foreach ($professores as $professor) {
                if ($professor['id_professor'] == $disciplinaData['Professor_id_professor']) {
                    $registroProfessorAtual = $professor['registroProfessor'];
                    break;
                }
            }
            
            foreach ($turmas as $turma) {
                if ($turma['id_turma'] == $disciplinaData['Turma_id_turma']) {
                    $nomeTurmaAtual = $turma['nomeTurma'];
                    break;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Disciplina</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-disciplina/atualizar-disciplina.php' : 'valida-inserir-disciplina.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Disciplina</h2>
            <hr>

            <label for="codigoDisciplina">Código da disciplina:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="codigoDisciplina" id="codigoDisciplina" placeholder="Digite o código" value="<?php echo htmlspecialchars(isset($disciplinaData['codigoDisciplina']) ? $disciplinaData['codigoDisciplina'] : ''); ?>" required>
                <input type="hidden" name="id_disciplina" value="<?php echo htmlspecialchars(isset($disciplinaData['id_disciplina']) ? $disciplinaData['id_disciplina'] : ''); ?>">
            <?php else: ?>
                <input type="text" name="codigoDisciplina" id="codigoDisciplina" placeholder="Digite o código" required>
            <?php endif; ?>
            <hr>

            <label for="nomeDisciplina">Nome da disciplina:</label>
            <input type="text" name="nomeDisciplina" id="nomeDisciplina" placeholder="Digite o nome" value="<?php echo htmlspecialchars(isset($disciplinaData['nome']) ? $disciplinaData['nome'] : ''); ?>" required>
            <hr>

            <label for="carga_horaria">Carga horária:</label>
            <input type="number" min="10" name="carga_horaria" id="carga_horaria" placeholder="Digite a carga horária" value="<?php echo htmlspecialchars(isset($disciplinaData['carga_horaria']) ? $disciplinaData['carga_horaria'] : ''); ?>" required>
            <hr>

            <label for="professor">Professor:</label>
            <input type="text" name="professor" id="professor" placeholder="Digite o professor" value="<?php echo htmlspecialchars(isset($disciplinaData['professor']) ? $disciplinaData['professor'] : ''); ?>" required>
            <hr>

            <label for="descricaoDisciplina">Descrição da disciplina:</label>
            <input type="text" name="descricaoDisciplina" id="descricaoDisciplina" placeholder="Digite a descrição" value="<?php echo htmlspecialchars(isset($disciplinaData['descricao']) ? $disciplinaData['descricao'] : ''); ?>" required>
            <hr>

            <label for="semestre_periodo">Semestre/Período:</label>
            <input type="text" name="semestre_periodo" id="semestre_periodo" placeholder="Digite o semestre/período" value="<?php echo htmlspecialchars(isset($disciplinaData['semestre_periodo']) ? $disciplinaData['semestre_periodo'] : ''); ?>" required>
            <hr>

            <?php if ($isUpdating): ?>
                <label for="Professor_id_professor">Registro do Professor:</label>
                <input type="text" value="<?php echo htmlspecialchars($registroProfessorAtual); ?>" readonly required>
                <input type="hidden" name="Professor_id_professor" value="<?php echo htmlspecialchars(isset($disciplinaData['Professor_id_professor']) ? $disciplinaData['Professor_id_professor'] : ''); ?>">
                <hr>

                <label for="Turma_id_turma">Nome da turma:</label>
                <input type="text" value="<?php echo htmlspecialchars($nomeTurmaAtual); ?>" readonly required>
                <input type="hidden" name="id_turma" value="<?php echo htmlspecialchars(isset($disciplinaData['Turma_id_turma']) ? $disciplinaData['Turma_id_turma'] : ''); ?>">
                <hr>
                
            <?php else: ?>
                <label for="id_professor">Registro do professor:</label>
                <select name="id_professor" required>
                    <option value="">Selecione um registro de professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= $professor['id_professor'] ?>"><?= htmlspecialchars($professor['registroProfessor']) ?> - <?= htmlspecialchars($professor['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
                <hr>

                <label for="Turma_id_turma">Nome da turma:</label>
                <select name="id_turma" required>
                    <option value="">Selecione um nome de turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= $turma['id_turma'] ?>"><?= htmlspecialchars($turma['nomeTurma']) ?></option>
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