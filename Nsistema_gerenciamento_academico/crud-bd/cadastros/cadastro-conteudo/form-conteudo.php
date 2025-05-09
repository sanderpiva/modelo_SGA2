<?php
require_once '../conexao.php';

$disciplinas = $conexao->query("SELECT * FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);

$isUpdating = false;
$conteudoData = [];
$errors = "";
$nomeDisciplinaAtual = '';

if (isset($_GET['id_conteudo'])) {
    $idConteudoToUpdate = $_GET['id_conteudo'];

    $stmt = $conexao->prepare("SELECT c.*, d.nome AS nomeDisciplina
                               FROM conteudo c
                               JOIN disciplina d ON c.Disciplina_id_disciplina = d.id_disciplina
                               WHERE c.id_conteudo = :id");
    $stmt->execute([':id' => $idConteudoToUpdate]);
    $conteudoData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$conteudoData) {
        $errors = "<p style='color:red;'>Conteúdo com ID $idConteudoToUpdate não encontrado.</p>";
        $isUpdating = false;
    } else {
        $isUpdating = true;
        $nomeDisciplinaAtual = htmlspecialchars($conteudoData['nomeDisciplina']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Conteúdo</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? '../../consultas/consulta-conteudo/atualizar-conteudo.php' : 'valida-inserir-conteudo.php'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Conteúdo</h2>
            <hr>

            <label for="codigoConteudo">Código do conteúdo:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="codigoConteudo" id="codigoConteudo" placeholder="Digite o código" value="<?php echo htmlspecialchars(isset($conteudoData['codigoConteudo']) ? $conteudoData['codigoConteudo'] : ''); ?>" required readonly>
                <input type="hidden" name="id_conteudo" value="<?php echo htmlspecialchars(isset($conteudoData['id_conteudo']) ? $conteudoData['id_conteudo'] : ''); ?>">
            <?php else: ?>
                <input type="text" name="codigoConteudo" id="codigoConteudo" placeholder="Digite o código" required>
            <?php endif; ?>
            <hr>

            <label for="tituloConteudo">Título:</label>
            <input type="text" name="tituloConteudo" id="tituloConteudo" placeholder="Digite o título" value="<?php echo htmlspecialchars(isset($conteudoData['titulo']) ? $conteudoData['titulo'] : ''); ?>" required>
            <hr>

            <label for="descricaoConteudo">Descrição:</label>
            <input type="text" name="descricaoConteudo" id="descricaoConteudo" placeholder="Digite a descrição" value="<?php echo htmlspecialchars(isset($conteudoData['descricao']) ? $conteudoData['descricao'] : ''); ?>" required>
            <hr>

            <label for="data_postagem">Data de postagem:</label>
            <input type="date" name="data_postagem" id="data_postagem" value="<?php echo htmlspecialchars(isset($conteudoData['data_postagem']) ? $conteudoData['data_postagem'] : ''); ?>" required>
            <hr>

            <label for="professor">Professor:</label>
            <input type="text" name="professor" id="professor" placeholder="Digite o autor" value="<?php echo htmlspecialchars(isset($conteudoData['professor']) ? $conteudoData['professor'] : ''); ?>" required>
            <hr>

            <label for="disciplina">Disciplina:</label>
            <input type="text" name="disciplina" id="disciplina" placeholder="Digite a disciplina" value="<?php echo htmlspecialchars(isset($conteudoData['disciplina']) ? $conteudoData['disciplina'] : ''); ?>" required>
            <hr>

            <label for="tipo_conteudo">Tipo de conteúdo:</label>
            <input type="text" name="tipo_conteudo" id="tipo_conteudo" placeholder="Digite o tipo" value="<?php echo htmlspecialchars(isset($conteudoData['tipo_conteudo']) ? $conteudoData['tipo_conteudo'] : ''); ?>" required>
            <hr>

            <label for="id_disciplina">Nome da disciplina:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo $nomeDisciplinaAtual; ?>" readonly required>
                <input type="hidden" name="id_disciplina" value="<?php echo htmlspecialchars(isset($conteudoData['Disciplina_id_disciplina']) ? $conteudoData['Disciplina_id_disciplina'] : ''); ?>">
                <hr>
            <?php else: ?>
                <select name="id_disciplina" required>
                    <option value="">Selecione um nome de disciplina</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?= $disciplina['id_disciplina'] ?>"><?= htmlspecialchars($disciplina['nome']) ?></option>
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