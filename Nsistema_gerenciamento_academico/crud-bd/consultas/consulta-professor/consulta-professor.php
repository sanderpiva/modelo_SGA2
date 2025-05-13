<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Professor</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Consulta Professor</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Registro</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "../conexao.php";

            try {
                $stmt = $conexao->query("SELECT id_professor, registroProfessor, nome, email, endereco, telefone FROM professor");
                $professores = $stmt->fetchAll();

                foreach ($professores as $professor) {
                    $id_professor = htmlspecialchars($professor['id_professor']);
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($professor['registroProfessor']) . "</td>";
                    echo "<td>" . htmlspecialchars($professor['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($professor['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($professor['endereco']) . "</td>";
                    echo "<td>" . htmlspecialchars($professor['telefone']) . "</td>";
                    echo "<td id='buttons-wrapper'>";
                    echo "<button onclick='atualizarProfessor(\"$id_professor\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                    echo "<button onclick='excluirProfessor(\"$id_professor\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='7'>Erro ao consultar professores: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarProfessor(id_professor) {
            //"../../cadastros/cadastro-professor/form-professor.php?id_professor=" + encodeURIComponent(id_professor);
            window.location.href = "../../../login/cadastro-professor.php?id_professor=" + encodeURIComponent(id_professor);
        }

        function excluirProfessor(id_professor) {
            const confirmar = confirm("Tem certeza que deseja excluir o professor com ID: " + id_professor + "?");
            if (confirmar) {
                window.location.href = "excluir-professor.php?id_professor=" + encodeURIComponent(id_professor);
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>
