<?php
require_once '../conexao.php';

$isUpdating = false;
$professorData = [];
$errors = "";

if (isset($_GET['id_professor']) && !empty($_GET['id_professor'])) {
    $isUpdating = true;
    $idProfessorToUpdate = $_GET['id_professor'];

    $stmt = $conexao->prepare("SELECT * FROM professor WHERE id_professor = :id");
    $stmt->execute([':id' => $idProfessorToUpdate]);
    $professorData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$professorData) {
        $errors = "<p style='color:red;'>Professor com ID " . htmlspecialchars($idProfessorToUpdate) . " não encontrado.</p>";
        $isUpdating = false;
    }
} 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Professor</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-professor/atualizar-professor.php' : 'valida-inserir-professor.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Professor</h2>
            <hr>

            <label for="registroProfessor">Registro:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="registroProfessor" id="registroProfessor" placeholder="Digite o registro" value="<?php echo htmlspecialchars($professorData['registroProfessor'] ?? ''); ?>" required>
                <input type="hidden" name="id_professor" value="<?php echo htmlspecialchars($professorData['id_professor'] ?? ''); ?>">
            <?php else: ?>
                <input type="text" name="registroProfessor" id="registroProfessor" placeholder="Digite o registro" required>
            <?php endif; ?>
            <hr>

            <label for="nomeProfessor">Nome:</label>
            <input type="text" name="nomeProfessor" id="nomeProfessor" placeholder="Digite o nome" value="<?php echo htmlspecialchars($professorData['nome'] ?? ''); ?>" required>
            <hr>

            <label for="emailProfessor">Email:</label>
            <input type="email" name="emailProfessor" id="emailProfessor" placeholder="Digite o email" value="<?php echo htmlspecialchars($professorData['email'] ?? ''); ?>" required>
            <hr>

            <label for="enderecoProfessor">Endereço:</label>
            <input type="text" name="enderecoProfessor" id="enderecoProfessor" placeholder="Digite o endereço" value="<?php echo htmlspecialchars($professorData['endereco'] ?? ''); ?>" required>
            <hr>

            <label for="telefoneProfessor">Telefone:</label>
            <input type="text" name="telefoneProfessor" id="telefoneProfessor" placeholder="Digite o telefone" value="<?php echo htmlspecialchars($professorData['telefone'] ?? ''); ?>" required>
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