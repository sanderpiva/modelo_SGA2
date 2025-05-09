<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Matrícula</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Consulta Matrícula</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Disciplina</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../conexao.php';

            try {
                $stmt = $conexao->query("
                    SELECT
                        m.Aluno_id_aluno,
                        m.Disciplina_id_disciplina,
                        a.nome AS nome_aluno,
                        d.nome AS nome_disciplina
                    FROM
                        matricula m
                    JOIN
                        aluno a ON m.Aluno_id_aluno = a.id_aluno
                    JOIN
                        disciplina d ON m.Disciplina_id_disciplina = d.id_disciplina
                ");
                $matriculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($matriculas) > 0) {
                    foreach ($matriculas as $matricula) {
                        $id_aluno = htmlspecialchars($matricula['Aluno_id_aluno']);
                        $id_disciplina = htmlspecialchars($matricula['Disciplina_id_disciplina']);
                        $nome_aluno = htmlspecialchars($matricula['nome_aluno']);
                        $nome_disciplina = htmlspecialchars($matricula['nome_disciplina']);

                        echo "<tr>";
                        echo "<td>$nome_aluno</td>";
                        echo "<td>$nome_disciplina</td>";
                        echo "<td id='buttons-wrapper'>";
                        echo "<button onclick='atualizarMatricula(\"$id_aluno\", \"$id_disciplina\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                        echo "<button onclick='exclusaoEmDesenvolvimento(\"$id_aluno\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhuma matrícula encontrada.</td></tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='3'>Erro ao consultar matrículas: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarMatricula(id_aluno, id_disciplina) {
            window.location.href = "../../cadastros/cadastro-matricula/form-matricula.php?id_aluno=" + encodeURIComponent(id_aluno) + "&id_disciplina=" + encodeURIComponent(id_disciplina);
        }

        function exclusaoEmDesenvolvimento(id_aluno) {
            const confirmar = confirm("Tem certeza que deseja excluir todas as matrículas do aluno com ID: " + id_aluno + "?");
            if (confirmar) {
                window.location.href = "excluir-matricula.php?id_aluno=" + encodeURIComponent(id_aluno);
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>