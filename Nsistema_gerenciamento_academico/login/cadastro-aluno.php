<?php
require_once 'conexao.php';

$turmas = $conexao->query("SELECT * FROM turma")->fetchAll(PDO::FETCH_ASSOC);

$isUpdating = false;
$alunoData = [];
$errors = "";
$nomeTurmaAtual = '';

if (isset($_GET['id_aluno']) && !empty($_GET['id_aluno'])) {
    $isUpdating = true;
    $idAlunoToUpdate = filter_input(INPUT_GET, 'id_aluno', FILTER_SANITIZE_NUMBER_INT);
    if ($idAlunoToUpdate === false || $idAlunoToUpdate === null) {
        $errors = "<p style='color:red;'>ID de aluno inválido.</p>";
    } else {
        $stmt = $conexao->prepare("SELECT a.*, t.nomeTurma
                                    FROM aluno a
                                    JOIN turma t ON a.Turma_id_turma = t.id_turma
                                    WHERE a.id_aluno = :id");
        $stmt->execute([':id' => $idAlunoToUpdate]);
        $alunoData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$alunoData) {
            $errors = "<p style='color:red;'>Aluno com ID $idAlunoToUpdate não encontrado.</p>";
            $isUpdating = false;
        } else {
            $nomeTurmaAtual = htmlspecialchars($alunoData['nomeTurma']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $isUpdating ? 'Atualizar Aluno' : 'Cadastro Aluno'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../crud-bd/consultas/consulta-aluno/atualizar-aluno.php' : 'valida-inserir-aluno.php'; ?>" method="POST">
            <h2><?php echo $isUpdating ? 'Atualizar Aluno' : 'Cadastro Aluno'; ?></h2>
            <hr>

            <label for="matricula">Matrícula:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="matricula" id="matricula" placeholder="Digite a matrícula" value="<?php echo htmlspecialchars($alunoData['matricula'] ?? ''); ?>" required>
                <input type="hidden" name="id_aluno" value="<?php echo htmlspecialchars($_GET['id_aluno'] ?? ''); ?>">
            <?php else: ?>
                <input type="text" name="matricula" id="matricula" placeholder="Digite a matrícula" required>
            <?php endif; ?>
            <hr>

            <label for="nome">Nome:</label>
            <input type="text" name="nomeAluno" id="nomeAluno" placeholder="Digite o nome" value="<?php echo htmlspecialchars($alunoData['nome'] ?? ''); ?>" required>
            <hr>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" placeholder="Digite o CPF" value="<?php echo htmlspecialchars($alunoData['cpf'] ?? ''); ?>" required>
            <hr>

            <label for="email">Email:</label>
            <input type="email" name="emailAluno" id="emailAluno" placeholder="Digite o email" value="<?php echo htmlspecialchars($alunoData['email'] ?? ''); ?>" required>
            <hr>

            <label for="data_nascimento">Data nascimento:</label>
             <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo htmlspecialchars($alunoData['data_nascimento'] ?? ''); ?>" required>
            <hr>

            <label for="endereco">Endereço:</label>
            <input type="text" name="enderecoAluno" id="enderecoAluno" placeholder="Digite o endereço" value="<?php echo htmlspecialchars($alunoData['endereco'] ?? ''); ?>" required>
            <hr>

            <label for="cidade">Cidade:</label>
            <input type="text" name="cidadeAluno" id="cidadeAluno" placeholder="Digite a cidade" value="<?php echo htmlspecialchars($alunoData['cidade'] ?? ''); ?>" required>
            <hr>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefoneAluno" id="telefoneAluno" placeholder="Digite o telefone" value="<?php echo htmlspecialchars($alunoData['telefone'] ?? ''); ?>" required>
            <hr>

            <label for="id_turma">Nome da turma:</label>
            <?php if ($isUpdating): ?>
                                
                <select name="id_turma" required>
                    <option value="">Selecione um nome de turma</option>
                     <?php foreach ($turmas as $turma): ?>
                        <option value="<?= $turma['id_turma'] ?>" <?php if ($alunoData['Turma_id_turma'] == $turma['id_turma']) echo 'selected'; ?>><?= htmlspecialchars($turma['nomeTurma']) ?></option>
                    <?php endforeach; ?>
                </select>
                <hr>

            <?php else: ?>
                <select name="id_turma" required>
                    <option value="">Selecione um nome de turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= $turma['id_turma'] ?>"><?= htmlspecialchars($turma['nomeTurma']) ?></option>
                    <?php endforeach; ?>
                </select>
                <hr>
            <?php endif; ?>

            <?php if ($isUpdating): ?>
                <label for="novaSenha">Nova Senha:</label>
                <input type="password" id="novaSenha" name="novaSenha" placeholder="Digite a nova senha (opcional)">
                <br><br>
                <input type="hidden" name="acao" value="atualizar">
            <?php else: ?>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Digite a senha" required><br><br>
                <input type="hidden" name="acao" value="cadastrar">
            <?php endif; ?>

            <button type="submit"><?php echo $isUpdating ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>
        <?php if (!empty($errors)): ?>
            <?php echo $errors; ?>
        <?php endif; ?>
    </div>
    <a href="<?php echo $isUpdating ? '../servicos-professor/pagina-servicos-professor.php' : '../index.php'; ?>"><?php echo $isUpdating ? 'Serviços' : 'Home Page'; ?></a>
</body>
</html>