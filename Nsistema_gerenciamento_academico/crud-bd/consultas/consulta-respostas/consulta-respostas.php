

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Respostas</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Consulta Respostas</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Código Resposta</th>
                <th>Resposta Dada</th>
                <th>Acertou?</th>
                <th>Nota</th>
                <th>Descrição Questão</th>
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
                    a.nome AS nome_aluno,
                    r.id_respostas,
                    r.codigoRespostas,
                    r.respostaDada,
                    r.acertou,
                    r.nota,
                    q.descricao AS descricao_questao,
                    p.codigoProva AS codigo_prova,
                    d.nome AS nome_disciplina,
                    prof.nome AS nome_professor
                FROM respostas r
                JOIN aluno a ON r.Aluno_id_aluno = a.id_aluno
                JOIN questoes q ON r.Questoes_id_questao = q.id_questao
                JOIN prova p ON r.Questoes_Prova_id_prova = p.id_prova
                JOIN disciplina d ON r.Questoes_Prova_Disciplina_id_disciplina = d.id_disciplina
                JOIN professor prof ON r.Questoes_Prova_Disciplina_Professor_id_professor = prof.id_professor
                ORDER BY a.nome;
                ");
                $respostas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo count($respostas);
                foreach ($respostas as $resposta) {
                    //var_dump($resposta);
                    $id_resposta = htmlspecialchars($resposta['id_respostas']);
                    
                    echo "<tr>";
                    
                    echo "<td>" . htmlspecialchars($resposta['nome_aluno']) . "</td>";
                    echo "<td>" . htmlspecialchars($resposta['codigoRespostas']) . "</td>";
                    echo "<td>" . htmlspecialchars($resposta['respostaDada']) . "</td>";
                    echo "<td>" . (htmlspecialchars($resposta['acertou']) ? 'Sim' : 'Não') . "</td>";
                    echo "<td>" . htmlspecialchars($resposta['nota']) . "</td>";
                    echo "<td>" . htmlspecialchars($resposta['descricao_questao']) . "</td>";
                    echo "<td>" . htmlspecialchars($resposta['codigo_prova']) . "</td>";
                    echo "<td>" . htmlspecialchars($resposta['nome_disciplina']) . "</td>";
                    echo "<td>" . htmlspecialchars($resposta['nome_professor']) . "</td>";
                    echo "<td id='buttons-wrapper'>";
                    echo "<button onclick='atualizarResposta(\"$id_resposta\")'><i class='fa-solid fa-pen'></i> Atualizar</button>";
                    echo "<button onclick='excluirResposta(\"$id_resposta\")'><i class='fa-solid fa-trash'></i> Excluir</button>";
                    
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='9'>Erro ao consultar respostas: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="../../../servicos-professor/pagina-servicos-professor.php">Voltar aos Serviços</a>

    <script>
        function atualizarResposta(id_resposta) {
            window.location.href = "../../cadastros/cadastro-respostas/form-respostas.php?id_resposta=" + id_resposta;
        }

        function excluirResposta(id_resposta) {
            const confirmar = confirm("Tem certeza que deseja excluir a resposta com ID: " + id_resposta + "?");
            if (confirmar) {
                console.log("URL de exclusão:", "excluirRespostas.php?id_resposta=" + id_resposta);
                window.location.href = "excluir-respostas.php?id_resposta=" + id_resposta;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>