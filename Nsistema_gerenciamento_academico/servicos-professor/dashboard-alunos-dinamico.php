<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gerenciamento_academico_completo";
$pdo = null;
$erro_conexao = null;
$conteudos = [];

if (isset($_SESSION['turma_selecionada']) && isset($_SESSION['disciplina_selecionada'])) {
    $turma_selecionada = $_SESSION['turma_selecionada'];
    $disciplina_selecionada = $_SESSION['disciplina_selecionada'];

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql_conteudos = "SELECT
                                c.titulo,
                                c.descricao
                            FROM
                                conteudo c
                            INNER JOIN
                                disciplina d ON c.Disciplina_id_disciplina = d.id_disciplina
                            INNER JOIN
                                turma t ON d.Turma_id_turma = t.id_turma
                            WHERE
                                LOWER(t.nomeTurma) LIKE LOWER(:turma_pattern)
                                AND LOWER(d.nome) = LOWER(:disciplina)";

        $stmt_conteudos = $pdo->prepare($sql_conteudos);
        $turma_pattern = $turma_selecionada . '%';
        $stmt_conteudos->bindParam(':turma_pattern', $turma_pattern, PDO::PARAM_STR);
        $stmt_conteudos->bindParam(':disciplina', $disciplina_selecionada, PDO::PARAM_STR);
        $stmt_conteudos->execute();
        $conteudos = $stmt_conteudos->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $erro_conexao = "<p style='color:red;'>Erro na conexão com o banco de dados ou na consulta: " . $e->getMessage() . "</p>";
    } finally {
        $pdo = null;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Atividades Dinamicas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="servicos_forms">
    <h1>Atividades Dinamicas</h1>

    <?php
    if ($erro_conexao) {
        echo $erro_conexao;
    } elseif (isset($_SESSION['turma_selecionada']) && isset($_SESSION['disciplina_selecionada'])) {
        echo "<p>Turma selecionada: " . htmlspecialchars($_SESSION['turma_selecionada']) . "</p>";
        echo "<p>Disciplina selecionada: " . htmlspecialchars($_SESSION['disciplina_selecionada']) . "</p>";

        if (!empty($conteudos)) {
            echo "<h2>Conteúdos para a disciplina '" . htmlspecialchars($_SESSION['disciplina_selecionada']) . "' em turmas como '" . htmlspecialchars($_SESSION['turma_selecionada']) . "':</h2>";
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<thead><tr><th>Título</th><th>Descrição</th></tr></thead>";
            echo "<tbody>";
            foreach ($conteudos as $conteudo) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($conteudo["titulo"]) . "</td>";
                echo "<td>" . htmlspecialchars($conteudo["descricao"]) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Nenhum conteúdo encontrado para a disciplina '" . htmlspecialchars($_SESSION['disciplina_selecionada']) . "' em turmas como '" . htmlspecialchars($_SESSION['turma_selecionada']) . "'.</p>";
        }
    } else {
        echo "<p style='color:red;'>Nenhuma turma e disciplina selecionadas.</p>";
    }
    ?>

</body>
</html>