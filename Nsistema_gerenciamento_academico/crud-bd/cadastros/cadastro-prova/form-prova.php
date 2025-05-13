<?php
require_once '../conexao.php';

$professores = $conexao->query("SELECT * FROM professor")->fetchAll(PDO::FETCH_ASSOC);
$disciplinas = $conexao->query("SELECT * FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);

$isUpdating = false;
$provaData = [];
$errors = "";
$nomeProfessorAtual = '';
$codigoDisciplinaAtual = '';

if (isset($_GET['id_prova']) && !empty($_GET['id_prova'])) {
    $isUpdating = true;
    $idProvaToUpdate = filter_input(INPUT_GET, 'id_prova', FILTER_SANITIZE_NUMBER_INT);

    if ($idProvaToUpdate === false || $idProvaToUpdate === null) {
        $errors = "<p style='color:red;'>ID da prova inválido.</p>";
        $isUpdating = false;
    } else {
        $stmt = $conexao->prepare("SELECT * FROM prova WHERE id_prova = :id");
        $stmt->execute([':id' => $idProvaToUpdate]);
        $provaData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$provaData) {
            $errors = "<p style='color:red;'>Prova com ID " . htmlspecialchars($idProvaToUpdate) . " não encontrada.</p>";
            $isUpdating = false;
        } else {
            
            foreach ($professores as $professor) {
                if ($professor['id_professor'] == $provaData['Disciplina_Professor_id_professor']) {
                    $nomeProfessorAtual = $professor['registroProfessor'] . ' - ' . $professor['nome'];
                    break;
                }
            }
            
            foreach ($disciplinas as $disciplina) {
                if ($disciplina['id_disciplina'] == $provaData['Disciplina_id_disciplina']) {
                    $codigoDisciplinaAtual = $disciplina['codigoDisciplina'];
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
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Prova</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-prova/atualizar-prova.php' : 'valida-inserir-prova.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Prova</h2>
            <hr>

            <label for="codigoProva">Código da prova:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="codigoProva" id="codigoProva" placeholder="Digite codigo" value="<?php echo htmlspecialchars($provaData['codigoProva'] ?? ''); ?>" required>
                <input type="hidden" name="id_prova" value="<?php echo htmlspecialchars($provaData['id_prova'] ?? ''); ?>">
            <?php else: ?>
                <input type="text" name="codigoProva" id="codigoProva" placeholder="Digite codigo" required>
            <?php endif; ?>
            <hr>

            <label for="tipo_prova">Tipo de prova:</label>
            <input type="text" name="tipo_prova" id="tipo_prova" placeholder="Digite tipo de prova" value="<?php echo htmlspecialchars($provaData['tipo_prova'] ?? ''); ?>" required>
            <hr>

            <label for="disciplina">Nome disciplina:</label>
            <input type="text" name="disciplina" id="disciplina" placeholder="Digite tipo de prova" value="<?php echo htmlspecialchars($provaData['disciplina'] ?? ''); ?>" required>
            <hr>

            <label for="conteudo">Conteúdo de prova:</label>
            <input type="text" name="conteudo" id="conteudo" placeholder="Digite conteudo" value="<?php echo htmlspecialchars($provaData['conteudo'] ?? ''); ?>" required>
            <hr>

            <label for="data_prova">Data da prova:</label>
            <input type="date" name="data_prova" id="data_prova" placeholder="Digite a data" value="<?php echo htmlspecialchars($provaData['data_prova'] ?? ''); ?>" required>
            <hr>

            <label for="nome_professor">Nome professor:</label>
            <input type="text" name="nome_professor" id="nome_professor" placeholder="Digite nome professor" value="<?php echo htmlspecialchars($provaData['professor'] ?? ''); ?>" required>
            <hr>

            <label for="id_disciplina">Código disciplina:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo htmlspecialchars($codigoDisciplinaAtual); ?>" readonly required>
                <input type="hidden" name="id_disciplina" value="<?php echo htmlspecialchars($provaData['Disciplina_id_disciplina'] ?? ''); ?>">
            <?php else: ?>
                <select name="id_disciplina" required>
                    <option value="">Selecione codigo disciplina</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?= $disciplina['id_disciplina'] ?>"><?= htmlspecialchars($disciplina['codigoDisciplina']) ?> - <?= htmlspecialchars($disciplina['professor']) ?></option>
                     
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_professor">Registro do Professor:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo htmlspecialchars($nomeProfessorAtual); ?>" readonly required>
                <input type="hidden" name="id_professor" value="<?php echo htmlspecialchars($provaData['Professor_id_professor'] ?? ''); ?>">
            <?php else: ?>
                <select name="id_professor" required>
                    <option value="">Selecione um professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= $professor['id_professor'] ?>"><?= htmlspecialchars($professor['registroProfessor']) ?> - <?= htmlspecialchars($professor['nome']) ?></option>
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