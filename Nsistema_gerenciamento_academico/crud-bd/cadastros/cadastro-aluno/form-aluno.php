<?php
require_once '../conexao.php';

$turmas = $conexao->query("SELECT * FROM turma")->fetchAll(PDO::FETCH_ASSOC);

$isUpdating = false;
$alunoData = [];
$errors = "";
$nomeTurmaAtual = '';

if (isset($_GET['id_aluno'])) {
    $idAlunoToUpdate = $_GET['id_aluno'];

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
        $isUpdating = true;
        $nomeTurmaAtual = htmlspecialchars($alunoData['nomeTurma']);
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Aluno</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-aluno/atualizar-aluno.php' : 'valida-inserir-aluno.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Aluno</h2>
            <hr>

            <label for="matricula">Matrícula:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="matricula" id="matricula" placeholder="Digite a matrícula" value="<?php echo htmlspecialchars($alunoData['matricula']); ?>" required>
                <input type="hidden" name="id_aluno" value="<?php echo htmlspecialchars($alunoData['id_aluno']); ?>">
            <?php else: ?>
                <input type="text" name="matricula" id="matricula" placeholder="Digite a matrícula" required>
            <?php endif; ?>
            <hr>

            <label for="nomeAluno">Nome:</label>
            <input type="text" name="nomeAluno" id="nomeAluno" placeholder="Digite o nome" value="<?php echo $isUpdating ? htmlspecialchars($alunoData['nome']) : ''; ?>" required>
            <hr>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" placeholder="Digite o CPF" value="<?php echo $isUpdating ? htmlspecialchars($alunoData['cpf']) : ''; ?>" required>
            <hr>

            <label for="emailAluno">Email:</label>
            <input type="email" name="emailAluno" id="emailAluno" placeholder="Digite o email" value="<?php echo $isUpdating ? htmlspecialchars($alunoData['email']) : ''; ?>" required>
            <hr>

            <label for="data_nascimento">Data nascimento:</label>
             <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo $isUpdating ? htmlspecialchars($alunoData['data_nascimento']) : ''; ?>" required>
            <hr>

            <label for="enderecoAluno">Endereço:</label>
            <input type="text" name="enderecoAluno" id="enderecoAluno" placeholder="Digite o endereço" value="<?php echo $isUpdating ? htmlspecialchars($alunoData['endereco']) : ''; ?>" required>
            <hr>

            <label for="cidadeAluno">Cidade:</label>
            <input type="text" name="cidadeAluno" id="cidadeAluno" placeholder="Digite a cidade" value="<?php echo $isUpdating ? htmlspecialchars($alunoData['cidade']) : ''; ?>" required>
            <hr>

            <label for="telefoneAluno">Telefone:</label>
            <input type="text" name="telefoneAluno" id="telefoneAluno" placeholder="Digite o telefone" value="<?php echo $isUpdating ? htmlspecialchars($alunoData['telefone']) : ''; ?>" required>
            <hr>

            <label for="id_turma">Nome da turma:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo $nomeTurmaAtual; ?>" readonly required>
                <input type="hidden" name="id_turma" value="<?php echo htmlspecialchars($alunoData['Turma_id_turma']); ?>">
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

            <button type="submit"><?php echo $isUpdating ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>

        <?php
            echo $errors;
        ?>
        <hr>
    </div>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Servicos</a>
    <hr>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>