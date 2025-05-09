<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Questões Prova</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Consulta Questões Prova</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Código Questão</th>
                <th>Descrição Questão de Prova</th>
                <th>Tipo Prova</th>
                <th>Código Prova</th>
                <th>Nome Disciplina</th>
                <th>Nome Professor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../conexao.php';

            try {
                $stmt = $conexao->query("
                    SELECT
                        q.id_questao,
                        q.codigoQuestao,
                        q.descricao,
                        q.tipo_prova,
                        p.codigoProva AS codigo_prova,
                        d.nome AS nome_disciplina,
                        prof.nome AS nome_professor
                    FROM
                        questoes q
                    JOIN
                        prova p ON q.Prova_id_prova = p.id_prova
                    JOIN
                        disciplina d ON q.Prova_Disciplina_id_disciplina = d.id_disciplina
                    JOIN
                        professor prof ON q.Prova_Disciplina_Professor_id_professor = prof.id_professor;
                ");
                $questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($questoes as $questao) {
                    $id_questaoProva = htmlspecialchars($questao['id_questao']);
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($questao['codigoQuestao']) . "</td>";
                    echo "<td>" . htmlspecialchars($questao['descricao']) . "</td>";
                    echo "<td>" . htmlspecialchars($questao['tipo_prova']) . "</td>";
                    echo "<td>" . htmlspecialchars($questao['codigo_prova']) . "</td>";
                    echo "<td>" . htmlspecialchars($questao['nome_disciplina']) . "</td>";
                    echo "<td>" . htmlspecialchars($questao['nome_professor']) . "</td>";
                    echo "<td id='buttons-wrapper'>";
                    echo "<button onclick='atualizarQuestaoProva(\"$id_questaoProva\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                    echo "<button onclick='excluirQuestaoProva(\"$id_questaoProva\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='7'>Erro ao consultar questões da prova: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarQuestaoProva(id_questaoProva) {
            window.location.href = "../../cadastros/cadastro-questoes-prova/form-questoes-prova.php?id_questaoProva=" + id_questaoProva;
        }

        function excluirQuestaoProva(id_questaoProva) {
            const confirmar = confirm("Tem certeza que deseja excluir a questão da prova com ID: " + id_questaoProva + "?");
            if (confirmar) {
                window.location.href = "excluir-questoes-prova.php?id_questaoProva=" + id_questaoProva;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>