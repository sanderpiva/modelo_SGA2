<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Conteúdo</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="servicos_forms">

    <h2>Consulta Conteúdo</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Professor</th>
                <th>Disciplina</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "../conexao.php";

            try {
                $stmt = $conexao->query("SELECT * FROM conteudo");
                $conteudos = $stmt->fetchAll();

                foreach ($conteudos as $conteudo) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($conteudo['codigoConteudo']) . "</td>";
                    echo "<td>" . htmlspecialchars($conteudo['titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($conteudo['descricao']) . "</td>";
                    echo "<td>" . htmlspecialchars($conteudo['data_postagem']) . "</td>";
                    echo "<td>" . htmlspecialchars($conteudo['professor']) . "</td>";
                    echo "<td>" . htmlspecialchars($conteudo['disciplina']) . "</td>";
                    echo "<td>" . htmlspecialchars($conteudo['tipo_conteudo']) . "</td>";

                    $id_conteudo = htmlspecialchars($conteudo['id_conteudo']);

                    echo "<td id='buttons-wrapper'>";
                    echo "<button onclick='atualizarConteudo(\"$id_conteudo\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                    echo "<button onclick='excluirConteudo(\"$id_conteudo\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='8'>Erro ao consultar conteúdos: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarConteudo(id_conteudo) {
            window.location.href = "../../cadastros/cadastro-conteudo/form-conteudo.php?id_conteudo=" + id_conteudo;
        }

        function excluirConteudo(id_conteudo) {
            const confirmar = confirm("Tem certeza que deseja excluir o conteúdo: " + id_conteudo + "?");
            if (confirmar) {
                window.location.href = "excluir-conteudo.php?id_conteudo=" + id_conteudo;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>
