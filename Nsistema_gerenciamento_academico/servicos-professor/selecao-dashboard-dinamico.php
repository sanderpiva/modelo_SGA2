<html>
<head>
    <?php
    // Sempre inicie a sessão no topo de qualquer página PHP que a utilize
    session_start();
    ?>
    <title>Atividades Dinamicas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="servicos_forms">

<?php
    // Verifica se o formulário foi submetido via método POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Verifica se 'turma' e 'disciplina' foram enviados e não estão vazios
        if (isset($_POST['turma']) && !empty($_POST['turma']) &&
            isset($_POST['disciplina']) && !empty($_POST['disciplina'])) {

            // Atribui os valores postados a variáveis
            $turma = $_POST['turma'];
            $disciplina = $_POST['disciplina'];

            // Armazena os valores na sessão
            $_SESSION['turma_selecionada'] = $turma;
            $_SESSION['disciplina_selecionada'] = $disciplina;

            // Redireciona o usuário para a página de destino
            // Certifique-se de que não há NENHUM output (echo, HTML, etc.) antes desta linha
            header("Location: ../servicos-professor/dashboard-alunos-dinamico.php");

            // Garante que o script pare de executar após o redirecionamento
            exit();

        } else {
            // Mensagem de erro caso turma ou disciplina não tenham sido selecionadas/enviadas corretamente
            echo "<p style='color:red;'>Por favor, selecione uma opção para turma e disciplina.</p>";
        }
    }
?>
    <div class="form_container">
        <form class="form" method="post" action="">

            <h2>Login Aluno</h2>

            <select id="turma" name="turma" required> <option value="">Selecione serie/turma:</option>
                <option value="6s">6 serie</option>
                <option value="7s">7 serie</option>
                <option value="8s">8 serie</option>
                <option value="1aem">1 ano ensino medio</option>
            </select><br><br>

            <select id="disciplina" name="disciplina" required> <option value="">Selecione disciplina:</option>
                <option value="matematica">matematica</option>
                <option value="portugues">portugues</option>
                <option value="geografia">geografia</option>
                <option value="historia">historia</option>
            </select><br><br>

            <button type="submit">Login</button>
        </form>

    </div>
    <a href="../index.php">Home Page</a>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>