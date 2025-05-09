<?php
    session_start(); // Inicia a sessão no início do arquivo
?>

<!DOCTYPE html>
<html>
<head>
    <title>PG</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="home">
    <div id="pg_form"><br><br>
        <h1 class="titulo_pg">Progressão Gemétrica: P.G</h1>
        <h2>Conceito</h2>
        <p>Uma Progressão Geométrica (PG) é uma sequência numérica em que cada termo, a partir do segundo, é obtido multiplicando o termo anterior por uma constante chamada razão.</p>
        <p>Por exemplo, a sequência 2, 6, 18, 54... é uma PG com razão 3. As PGs são úteis para modelar situações com crescimento ou decrescimento exponencial.</p>
        <p>Agora, vamos demonstrar o cálculo do termo geral e da soma dos termos da PG finita:</p>
       <form method="post" action="">
            <label for="a1">Digite o primeiro termo: a1</label><br>
            <input type="number" id="a1" name="a1" placeholder="a1" min="1"required><br><br>
            <label for="r">Digite a razão: q</label><br>
            <input type="number" id="q" name="q" placeholder="q" min="1" required><br><br>
            <label for="n">Digite o número de termos: n</label><br>
            <input type="number" id="n" name="n" placeholder="n" min="1" required><br><br>
            <button class="btn_calcular" type="submit">Calcular</button><br><br>
        </form>
    </div>
    <div id="pg_result">
        <?php
            if (isset($_POST['a1']) && isset($_POST['q']) && isset($_POST['n'])) {
                $a1 = $_POST['a1'];
                $q = $_POST['q'];
                $n = $_POST['n'];
                $an = $a1 * pow($q, ($n - 1));
                $soma = (($a1 + $an)/2)*$n;
                echo "O primeiro termo é: $a1<br>";
                echo "A razão é: $q<br>";
                echo "O número de termos é: $n<br>";
                echo "a$n = a1 * an ^ (n - 1)<br>";
                echo "O termo geral a$n é: $an<br>";
                echo "A soma dos termos é: $soma";
                
                // Definir status na sessão ao calcular
                $_SESSION['pg_status'] = 1;
            }
        ?>
        <br><br>
        <a class="btn_dashboard" href="../servicos-professor/dashboard-alunos-algebrando-estatico.php">Finalizar</a>
    </div>
    
</body><br><br>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>
