<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Disciplina</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Consulta Disciplina</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Código disciplina</th>
                <th>Nome</th>
                <th>Carga Horária</th>
                <th>Professor (ID)</th>
                <th>Descrição</th>
                <th>Semestre/Período</th>
                <th>Nome Professor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "../conexao.php";

            try {
                $stmt = $conexao->query("
                    SELECT
                        d.id_disciplina,
                        d.codigoDisciplina,
                        d.nome,
                        d.carga_horaria,
                        d.professor AS professor_digitado,
                        d.descricao,
                        d.semestre_periodo,
                        d.Professor_id_professor,
                        p.nome AS nome_professor
                    FROM
                        disciplina d
                    JOIN
                        professor p ON d.Professor_id_professor = p.id_professor;
                ");
                $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($disciplinas as $disciplina) {
                    $id_disciplina = htmlspecialchars($disciplina['id_disciplina']);
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($disciplina['codigoDisciplina']) . "</td>";
                    echo "<td>" . htmlspecialchars($disciplina['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($disciplina['carga_horaria']) . "</td>";
                    echo "<td>" . htmlspecialchars($disciplina['professor_digitado']) . "</td>";
                    echo "<td>" . htmlspecialchars($disciplina['descricao']) . "</td>";
                    echo "<td>" . htmlspecialchars($disciplina['semestre_periodo']) . "</td>";
                    echo "<td>" . htmlspecialchars($disciplina['nome_professor']) . "</td>";

                    echo "<td id='buttons-wrapper'>";
                    echo "<button onclick='atualizarDisciplina(\"$id_disciplina\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                    echo "<button onclick='excluirDisciplina(\"$id_disciplina\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='8'>Erro ao consultar disciplinas: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarDisciplina(id_disciplina) {
            window.location.href = "../../cadastros/cadastro-disciplina/form-disciplina.php?id_disciplina=" + id_disciplina;
        }

        function excluirDisciplina(id_disciplina) {
            const confirmar = confirm("Tem certeza que deseja excluir a disciplina com ID: " + id_disciplina + "?");
            if (confirmar) {
                window.location.href = "excluir-disciplina.php?id_disciplina=" + id_disciplina;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>