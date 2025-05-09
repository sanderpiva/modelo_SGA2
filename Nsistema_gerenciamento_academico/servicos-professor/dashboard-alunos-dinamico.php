<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php
    session_start();
    ?>
    <title>Atividades Dinamicas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="servicos_forms">
    <h1>Atividades Dinamicas</h1>

    <?php
    if (isset($_SESSION['turma_selecionada']) && isset($_SESSION['disciplina_selecionada'])) {
        $turma_selecionada = $_SESSION['turma_selecionada'];
        $disciplina_selecionada = $_SESSION['disciplina_selecionada'];

        echo "<p>Turma selecionada: " . htmlspecialchars($turma_selecionada) . "</p>";
        echo "<p>Disciplina selecionada: " . htmlspecialchars($disciplina_selecionada) . "</p>";

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gerenciamento_academico_completo";

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT
                        c.titulo,
                        c.descricao
                    FROM
                        disciplina d
                    JOIN
                        conteudo c ON d.id_disciplina = c.Disciplina_id_disciplina
                    WHERE
                        LOWER(d.nome) = LOWER(:disciplina)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':disciplina', $disciplina_selecionada, PDO::PARAM_STR);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($resultados) {
                echo "<h2>Conteúdos Relacionados à Disciplina:</h2>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<thead><tr><th>Título</th><th>Descrição</th></tr></thead>";
                echo "<tbody>";
                foreach ($resultados as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["titulo"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["descricao"]) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>Nenhum conteúdo encontrado para a disciplina selecionada.</p>";
            }

        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro na conexão com o banco de dados ou na consulta: " . $e->getMessage() . "</p>";
        } finally {
            $pdo = null;
        }

    } else {
        echo "<p style='color:red;'>Dados da turma e disciplina não encontrados na sessão.</p>";
    }
    ?>

</body>
</html>