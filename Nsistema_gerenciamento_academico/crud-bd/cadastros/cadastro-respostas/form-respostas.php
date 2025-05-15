<?php
require_once '../conexao.php';

$disciplinas = $conexao->query("SELECT * FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
$professores = $conexao->query("SELECT * FROM professor")->fetchAll(PDO::FETCH_ASSOC);
$provas = $conexao->query("SELECT * FROM prova")->fetchAll(PDO::FETCH_ASSOC);
$questoes = $conexao->query("SELECT * FROM questoes")->fetchAll(PDO::FETCH_ASSOC);
$alunos = $conexao->query("SELECT * FROM aluno")->fetchAll(PDO::FETCH_ASSOC);

$professorsLookup = [];
foreach ($professores as $professor) {
    $professorsLookup[$professor['id_professor']] = $professor['nome'];
}

$isUpdating = false;
$respostaData = [];
$errors = "";
$descricaoQuestaoAtual = '';
$codigoProvaAtual = '';
$nomeDisciplinaAtual = '';
$nomeProfessorAtual = '';
$nomeAlunoAtual = ''; 

if (isset($_GET['id_resposta']) && !empty($_GET['id_resposta'])) {
    $isUpdating = true;
    $idRespostaToUpdate = filter_input(INPUT_GET, 'id_resposta', FILTER_SANITIZE_NUMBER_INT);

    if ($idRespostaToUpdate === false || $idRespostaToUpdate === null) {
        $errors = "<p style='color:red;'>ID de resposta inválido.</p>";
        $isUpdating = false;
    } else {
        $stmt = $conexao->prepare("SELECT * FROM respostas WHERE id_respostas = :id");
        $stmt->execute([':id' => $idRespostaToUpdate]);
        $respostaData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$respostaData) {
            $errors = "<p style='color:red;'>Resposta com ID " . htmlspecialchars($idRespostaToUpdate) . " não encontrada.</p>";
            $isUpdating = false;
        } else {
             // Busca informações para exibição na tela de atualização
            $questaoStmt = $conexao->prepare("SELECT descricao FROM questoes WHERE id_questao = :id");
            $questaoStmt->execute([':id' => ($respostaData['Questoes_id_questao'] ?? null)]);
            $questao = $questaoStmt->fetch(PDO::FETCH_ASSOC);
            $descricaoQuestaoAtual = htmlspecialchars($questao['descricao'] ?? '');

            $provaStmt = $conexao->prepare("SELECT codigoProva FROM prova WHERE id_prova = :id");
            $provaStmt->execute([':id' => ($respostaData['Questoes_Prova_id_prova'] ?? null)]); 
            $prova = $provaStmt->fetch(PDO::FETCH_ASSOC);
            $codigoProvaAtual = htmlspecialchars($prova['codigoProva'] ?? '');

            $disciplinaStmt = $conexao->prepare("SELECT nome, Professor_id_professor FROM disciplina WHERE id_disciplina = :id"); 
            $disciplinaStmt->execute([':id' => ($respostaData['Questoes_Prova_Disciplina_id_disciplina'] ?? null)]); 
            $disciplinaInfo = $disciplinaStmt->fetch(PDO::FETCH_ASSOC);
            $nomeDisciplinaAtual = htmlspecialchars($disciplinaInfo['nome'] ?? '');
            
            $professorStmt = $conexao->prepare("SELECT nome FROM professor WHERE id_professor = :id");
            $professorStmt->execute([':id' => ($respostaData['Questoes_Prova_Disciplina_Professor_id_professor'] ?? null)]); 
            $professor = $professorStmt->fetch(PDO::FETCH_ASSOC);
            $nomeProfessorAtual = htmlspecialchars($professor['nome'] ?? '');

            $alunoStmt = $conexao->prepare("SELECT nome FROM aluno WHERE id_aluno = :id");
            $alunoStmt->execute([':id' => ($respostaData['Aluno_id_aluno'] ?? null)]); 
            $aluno = $alunoStmt->fetch(PDO::FETCH_ASSOC);
            $nomeAlunoAtual = htmlspecialchars($aluno['nome'] ?? '');

        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Respostas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-respostas/atualizar-respostas.php' : 'valida-inserir-respostas.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Respostas</h2>
            <hr>

            <label for="codigoRespostas">Código Respostas:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="codigoRespostas" id="codigoRespostas" placeholder="" value="<?php echo htmlspecialchars($respostaData['codigoRespostas'] ?? ''); ?>" required>
                <input type="hidden" name="id_respostas" value="<?php echo htmlspecialchars($respostaData['id_respostas'] ?? ''); ?>">
            <?php else: ?>
                <input type="text" name="codigoRespostas" id="codigoRespostas" placeholder="" required>
            <?php endif; ?>
            <hr>

            <label for="respostaDada">Resposta Dada:</label>
            <input type="text" name="respostaDada" id="respostaDada" placeholder="" value="<?php echo htmlspecialchars($respostaData['respostaDada'] ?? ''); ?>" required>
            <hr>

            <label>Acertou?</label>
            <div>
                <input type="radio" id="acertouSim" name="acertou" value="1" <?php echo ($isUpdating && isset($respostaData['acertou']) && $respostaData['acertou'] == 1) ? 'checked' : ''; ?> required>
                <label for="acertouSim">Sim</label>
                <input type="radio" id="acertouNao" name="acertou" value="0" <?php echo ($isUpdating && isset($respostaData['acertou']) && $respostaData['acertou'] == 0) ? 'checked' : ''; ?> required>
                <label for="acertouNao">Não</label>
            </div>
            <hr>

            <label for="nota">Nota:</label>
            <input type="text" name="nota" id="nota" placeholder="" value="<?php echo htmlspecialchars($respostaData['nota'] ?? ''); ?>" required>
            <hr>

            <label for="id_questao">Descrição da Questão:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo $descricaoQuestaoAtual; ?>" readonly required>
                <input type="hidden" name="id_questao" value="<?php echo htmlspecialchars($respostaData['Questoes_id_questao'] ?? ''); ?>">
            <?php else: ?>
                <select name="id_questao" id="id_questao" required>
                    <option value="">Selecione a descrição da questão</option>
                    <?php foreach ($questoes as $questao): ?>
                        <option value="<?= htmlspecialchars($questao['id_questao']) ?>"><?= htmlspecialchars($questao['descricao']) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_prova">Código Prova:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo $codigoProvaAtual; ?>" readonly required>
                <input type="hidden" name="id_prova" value="<?php echo htmlspecialchars($respostaData['Questoes_Prova_id_prova'] ?? ''); ?>">
            <?php else: ?>
                <select name="id_prova" id="id_prova" required>
                    <option value="">Selecione uma prova</option>
                    <?php foreach ($provas as $prova): ?>
                        <option value="<?= htmlspecialchars($prova['id_prova']) ?>"><?= htmlspecialchars($prova['codigoProva']) ?> - <?= htmlspecialchars($prova['professor']) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_disciplina">Disciplina:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo $nomeDisciplinaAtual; /* . (isset($professorDisciplinaAtual) ? ' (' . $professorDisciplinaAtual . ')' : '') */ ?>" readonly required>
                <input type="hidden" name="id_disciplina" value="<?php echo htmlspecialchars($respostaData['Questoes_Prova_Disciplina_id_disciplina'] ?? ''); ?>">
                <hr>
            <?php else: ?>
                <select name="id_disciplina" id="id_disciplina" required>
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
            <?php endif; ?>
            <hr>

            <label for="id_professor">Professor:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo $nomeProfessorAtual; ?>" readonly required>
                <input type="hidden" name="id_professor" value="<?php echo htmlspecialchars($respostaData['Questoes_Prova_Disciplina_Professor_id_professor'] ?? ''); ?>">
                <hr>
            <?php else: ?>
                <select name="id_professor" id="id_professor" required>
                    <option value="">Selecione um professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= htmlspecialchars($professor['id_professor']) ?>">
                             <?php ?>
                            <?= htmlspecialchars($professor['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_aluno">Aluno:</label>
            <?php if ($isUpdating): ?>
                 <input type="text" value="<?php echo $nomeAlunoAtual; ?>" readonly required>
                <input type="hidden" name="id_aluno" value="<?php echo htmlspecialchars($respostaData['Aluno_id_aluno'] ?? ''); ?>">
                <hr>
            <?php else: ?>
                <select name="id_aluno" id="id_aluno" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= htmlspecialchars($aluno['id_aluno']) ?>"><?= htmlspecialchars($aluno['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
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