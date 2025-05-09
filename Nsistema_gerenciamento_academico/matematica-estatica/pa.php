<?php
    session_start(); // Inicia a sessão no início do arquivo
?>

<!DOCTYPE html>
<html>
<head>
    <title>PA</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="home">
    <div id="pa_form"><br><br>
        <h1 class="titulo_pa">Progressão Aritmética: P.A</h1>
        <h2>Conceito</h2>
        <p>Uma Progressão Aritmética (PA) é uma sequência numérica em que cada termo, a partir do segundo, é obtido somando uma constante chamada razão ao termo anterior.</p> 
        <p>Por exemplo, a sequência 2, 5, 8, 11... é uma PA com razão 3. As PAs são úteis para modelar situações em que há um crescimento ou decrescimento linear.</p>
        <p>Agora, vamos demonstrar o calculo do termo geral e da soma da PA:</p>
        <form method="post" action="">
            <label for="a1">Digite o primeiro termo: a1</label><br>
            <input type="number" id="a1" name="a1" placeholder="a1" min="1"required><br><br>
            <label for="r">Digite a razão: r</label><br>
            <input type="number" id="r" name="r" placeholder="r" min="1" required><br><br>
            <label for="n">Digite o número de termos: n</label><br>
            <input type="number" id="n" name="n" placeholder="n" min="1" required><br><br>
            <button class="btn_calcular" type="submit">Calcular</button><br><br>
        </form>
    </div>
    <div id="pa_result">
        <?php
            if (isset($_POST['a1']) && isset($_POST['r']) && isset($_POST['n'])) {
                $a1 = $_POST['a1'];
                $r = $_POST['r'];
                $n = $_POST['n'];
                $an = $a1 + ($n - 1) * $r;
                $soma = ($a1 + $an) * $n / 2;
                echo "O primeiro termo é: $a1<br>";
                echo "A razão é: $r<br>";
                echo "O número de termos é: $n<br>";
                echo "a$n = a1 + (n - 1) * r<br>";
                echo "a$n = $a1 + ($n - 1) * $r<br>";
                echo "O termo geral a$n é: $an<br>";
                echo "A soma dos termos é: $soma";
                
                // Definir status na sessão ao calcular
                $_SESSION['pa_status'] = 1;
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
