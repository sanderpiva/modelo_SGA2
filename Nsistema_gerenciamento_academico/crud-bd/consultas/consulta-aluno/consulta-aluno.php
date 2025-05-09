<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Aluno</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Consulta Aluno</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Matricula</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Data nascimento</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Telefone</th>
                <th>Turma</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "../conexao.php";

            try {
                $stmt = $conexao->query("
                    SELECT
                        a.matricula,
                        a.nome,
                        a.cpf,
                        a.email,
                        a.data_nascimento,
                        a.endereco,
                        a.cidade,
                        a.telefone,
                        t.nomeTurma AS nome_turma,
                        a.id_aluno
                    FROM
                        aluno a
                    JOIN
                        turma t ON a.Turma_id_turma  = t.id_turma
                ");
                $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($alunos as $aluno) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($aluno['matricula']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['cpf']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['data_nascimento']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['endereco']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['cidade']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['telefone']) . "</td>";
                    echo "<td>" . htmlspecialchars($aluno['nome_turma']) . "</td>"; // Exibe o nome da turma
                    echo "<td id='buttons-wrapper'>";
                    echo "<button onclick='atualizarAluno(\"" . htmlspecialchars($aluno['id_aluno']) . "\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                    echo "<button onclick='excluirAluno(\"" . htmlspecialchars($aluno['id_aluno']) . "\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='10'>Erro ao consultar alunos: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarAluno(id_aluno) {
            window.location.href = "../../cadastros/cadastro-aluno/form-aluno.php?id_aluno=" + id_aluno;
        }

        function excluirAluno(id_aluno) {
            const confirmar = confirm("Tem certeza que deseja excluir o registro de matrícula: " + id_aluno + "?");
            if (confirmar) {
                window.location.href = "excluir-aluno.php?id_aluno=" + id_aluno;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>