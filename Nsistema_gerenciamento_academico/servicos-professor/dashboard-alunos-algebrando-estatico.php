<?php
  session_start(); // Inicie a sessão no início do arquivo
 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pagina Web - Atividades/Provas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="home">
    <h1> Atividades/Provas - Algebrando </h1><br>
    <div id="cards-container">
        <div class="card">
            <a href="../matematica-estatica/pa.php">
                <img src="../img/i_pa.png" alt="img1">
            </a>
            <?php
                if (isset($_SESSION['pa_status']) && $_SESSION['pa_status'] == 1) {
                    echo '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">';
                } else {
                    echo "Nao visto";
                }
            ?>
        </div>
        <div class="card">
            <a href="../matematica-estatica/pg.php">
                <img src="../img/i_pg.png" alt="img1">
            </a>
            <?php
                if (isset($_SESSION['pg_status']) && $_SESSION['pg_status'] == 1) {
                    echo '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">';
                } else {
                    echo "Nao visto";
                }
            ?>
        </div>
        <div class="card">
            <a href="../matematica-estatica/porcentagem.php">
                <img src="../img/i_porcentagem.png" alt="img1">
            </a>
            <?php
                if (isset($_SESSION['porcentagem_status']) && $_SESSION['porcentagem_status'] == 1) {
                    echo '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">';
                } else {
                    echo "Nao visto";
                }
            ?>
        </div>
        <div class="card">
            <a href="../matematica-estatica/proporcao.php">
                <img src="../img/i_proporcao.png" alt="img1">
            </a>
            <?php
                if (isset($_SESSION['proporcao_status']) && $_SESSION['proporcao_status'] == 1) {
                    echo '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">';
                } else {
                    echo "Nao visto";
                }
            ?>
        </div>
    </div>
    <br><br><br>

    <div class="btn_prova">
    <?php
            if (isset($_SESSION['pa_status']) && $_SESSION['pa_status'] == 1 &&
                isset($_SESSION['pg_status']) && $_SESSION['pg_status'] == 1 &&
                isset($_SESSION['porcentagem_status']) && $_SESSION['porcentagem_status'] == 1 &&
                isset($_SESSION['proporcao_status']) && $_SESSION['proporcao_status'] == 1) {
                

                 // Zera os status ANTES de redirecionar
                $_SESSION['pa_status'] = 0;
                $_SESSION['pg_status'] = 0;
                $_SESSION['porcentagem_status'] = 0;
                $_SESSION['proporcao_status'] = 0;

                echo '<button class="btn_prova" onclick="window.location.href=\'../matematica-estatica/prova.php\'">Fazer Prova</button>';
            } else {
                echo '<button class="btn_prova" onclick="mostrarMensagem()">Fazer Prova</button>';
                echo '<p id="mensagem-erro" style="color: red; display: none;">Você não fez todas as tarefas!</p>';
            }
        ?>
      
    </div>
    <script>
        function mostrarMensagem() {
            document.getElementById('mensagem-erro').style.display = 'block';
        }
    </script>
</body>
<br><br><br><br><br><br><br>

<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>