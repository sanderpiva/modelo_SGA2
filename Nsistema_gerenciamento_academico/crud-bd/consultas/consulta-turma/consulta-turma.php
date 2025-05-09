<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Turma</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Consulta Turma</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Código Turma</th>
                <th>Nome Turma</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../conexao.php';

            try {
                $stmt = $conexao->query("SELECT id_turma, codigoTurma, nomeTurma FROM turma");
                $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($turmas as $turma) {
                    $id_turma = htmlspecialchars($turma['id_turma']);
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($turma['codigoTurma']) . "</td>";
                    echo "<td>" . htmlspecialchars($turma['nomeTurma']) . "</td>";
                    echo "<td id='buttons-wrapper'>";
                    echo "<button onclick='atualizarTurma(\"$id_turma\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                    echo "<button onclick='excluirTurma(\"$id_turma\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='4'>Erro ao consultar turmas: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarTurma(id_turma) {
            window.location.href = "../../cadastros/cadastro-turma/form-turma.php?id_turma=" + id_turma;
        }

        function excluirTurma(id_turma) {
            const confirmar = confirm("Tem certeza que deseja excluir a turma com ID: " + id_turma + "?");
            if (confirmar) {
                window.location.href = "excluir-turma.php?id_turma=" + id_turma;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>