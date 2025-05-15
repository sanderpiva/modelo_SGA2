<?php
require_once 'conexao.php';

$isUpdating = false;
$professorData = [];
$errors = "";

if (isset($_GET['id_professor']) && !empty($_GET['id_professor'])) {
    $isUpdating = true;
    $idProfessorToUpdate = filter_input(INPUT_GET, 'id_professor', FILTER_SANITIZE_NUMBER_INT);
    if ($idProfessorToUpdate === false || $idProfessorToUpdate === null) {
        $errors = "<p style='color:red;'>ID de professor inválido.</p>";
    } else {
        $stmt = $conexao->prepare("SELECT registroProfessor, nome, email, endereco, telefone FROM professor WHERE id_professor = :id");
        $stmt->execute([':id' => $idProfessorToUpdate]);
        $professorData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$professorData) {
            $errors = "<p style='color:red;'>Professor com ID $idProfessorToUpdate não encontrado.</p>";
            $isUpdating = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $isUpdating ? 'Atualizar Professor' : 'Cadastro Professor'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../crud-bd/consultas/consulta-professor/atualizar-professor.php' : 'valida-inserir-professor.php'; ?>" method="POST">
            <h2><?php echo $isUpdating ? 'Atualizar Professor' : 'Cadastro Professor'; ?></h2>
            <hr>

            <label for="registroProfessor">Registro:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="registroProfessor" id="registroProfessor" placeholder="Digite o registro" value="<?php echo htmlspecialchars($professorData['registroProfessor'] ?? ''); ?>" required>
                <input type="hidden" name="id_professor" value="<?php echo htmlspecialchars($_GET['id_professor'] ?? ''); ?>">
            <?php else: ?>
                <input type="text" name="registroProfessor" id="registroProfessor" placeholder="Digite o registro" required>
            <?php endif; ?>
            <hr>

            <label for="nomeProfessor">Nome:</label>
            <input type="text" name="nomeProfessor" id="nomeProfessor" placeholder="Digite o nome" value="<?php echo htmlspecialchars($professorData['nome'] ?? ''); ?>" required>
            <hr>

            <label for="emailProfessor">Login/Email:</label>
            <input type="email" name="emailProfessor" id="emailProfessor" placeholder="Digite o email" value="<?php echo htmlspecialchars($professorData['email'] ?? ''); ?>" required>
            <hr>

            <label for="enderecoProfessor">Endereço:</label>
            <input type="text" name="enderecoProfessor" id="enderecoProfessor" placeholder="Digite o endereço" value="<?php echo htmlspecialchars($professorData['endereco'] ?? ''); ?>" required>
            <hr>

            <label for="telefoneProfessor">Telefone:</label>
            <input type="text" name="telefoneProfessor" id="telefoneProfessor" placeholder="Digite o telefone" value="<?php echo htmlspecialchars($professorData['telefone'] ?? ''); ?>" required>
            <hr>

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
