<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proporção Simples</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="home">
    <div id="proporcao_form"><br><br>
        <h1 class="titulo_proporcao">Cálculo de Proporção</h1>
        <h2>Conceito</h2>
        <p>Uma proporção é uma igualdade entre duas razões. Uma razão compara dois valores através da divisão. Se temos duas razões a/b e c/d, uma proporção é expressa como a/b = c/d</p>
        <p>Na proporção que vamos calcular, a/b = c/x, queremos encontrar o valor desconhecido 'x' sabendo os valores de 'a', 'b' e 'c'. A propriedade fundamental da proporção nos diz que o produto dos meios é igual ao produto dos extremos: a * x = b * c</p>
        <p>Agora, vamos demonstrar como encontrar o valor de 'x' nesta proporção:</p>
        <h2>Encontre o valor de x em a/b = c/x</h2>
        
        <form method="post" action="">
            <label for="a">Digite o valor de a:</label><br>
            <input type="number" id="a" name="a" min="1" placeholder="a" required><br><br>
            <label for="b">Digite o valor de b:</label><br>
            <input type="number" id="b" name="b" min="1" placeholder="b" required><br><br>
            <label for="c">Digite o valor de c:</label><br>
            <input type="number" id="c" name="c" min="1" placeholder="c" required><br><br>
            <button class="btn_calcular" type="submit">Calcular x</button><br><br>
        </form>
    </div>
    <div id="proporcao_result">
        <?php
            if (isset($_POST['a']) && isset($_POST['b']) && isset($_POST['c'])) {
                $a = $_POST['a'];
                $b = $_POST['b'];
                $c = $_POST['c'];
                $x = ($b * $c) / $a;
                echo "Dado a proporção: {$a}/{$b} = {$c}/x<br><br>";
                echo "O valor de x é: $x";
                $_SESSION['proporcao_status'] = 1;
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