<!DOCTYPE html>
<html>
<head>
    <title>Pagina Web - Prova</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="servicos_forms">

    <h2>Prova</h2>

    <form method="post" action="">
        <h3>Nome</h3>
        <input type="text" name="nome" id="nome" required>
        <h3>Email</h3>
        <input type="email" name="email" id="email" required>

        <h3>Questão 1</h3>
        <p>Qual o valor do quarto termo da PA: a1 = 2, r = 3?</p>
        <input type="radio" name="q1" value="a"> a) 11 <br>
        <input type="radio" name="q1" value="b"> b) 6 <br>
        <input type="radio" name="q1" value="c"> c) 7 <br>
        <input type="radio" name="q1" value="d"> d) 8 <br>

        <h3>Questão 2</h3>
        <p>Qual o valor do quarto termo da PG: a1 = 2, q = 2?</p>
        <input type="radio" name="q2" value="a"> a) 15 <br>
        <input type="radio" name="q2" value="b"> b) 16 <br>
        <input type="radio" name="q2" value="c"> c) 3 <br>
        <input type="radio" name="q2" value="d"> d) 8 <br>

        <h3>Questão 3</h3>
        <p>Quanto que é 20% de 200?</p>
        <input type="radio" name="q3" value="a"> a) 15 <br>
        <input type="radio" name="q3" value="b"> b) 6 <br>
        <input type="radio" name="q3" value="c"> c) 40 <br>
        <input type="radio" name="q3" value="d"> d) 100 <br>

        <h3>Questão 4</h3>
        <p>Se 2 operarios produzem 10 blusas, 6 operarios produzem?</p>
        <input type="radio" name="q4" value="a"> a) 15 <br>
        <input type="radio" name="q4" value="b"> b) 6 <br>
        <input type="radio" name="q4" value="c"> c) 7 <br>
        <input type="radio" name="q4" value="d"> d) 30 <br>

        <br><br>
        <button type="submit">Enviar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $q1 = isset($_POST["q1"]) ? $_POST["q1"] : "";
        $q2 = isset($_POST["q2"]) ? $_POST["q2"] : "";
        $q3 = isset($_POST["q3"]) ? $_POST["q3"] : "";
        $q4 = isset($_POST["q4"]) ? $_POST["q4"] : "";

        if (empty($nome) || empty($email) || empty($q1) || empty($q2) || empty($q3) || empty($q4)) {
            echo "<script>alert('Por favor, preencha todos os campos.');</script>";
        } else {
            $dados = array(
                "nome" => $nome,
                "email" => $email,
                "q1" => $q1,
                "q2" => $q2,
                "q3" => $q3,
                "q4" => $q4
            );

            $gabarito = array(
                "q1" => "a",
                "q2" => "b",
                "q3" => "c",
                "q4" => "d"
            );

            $acertos = 0;
            if ($dados["q1"] == $gabarito["q1"]) $acertos++;
            if ($dados["q2"] == $gabarito["q2"]) $acertos++;
            if ($dados["q3"] == $gabarito["q3"]) $acertos++;
            if ($dados["q4"] == $gabarito["q4"]) $acertos++;

            $porcentagem = ($acertos / 4) * 100;

            echo "<h3>Respostas:</h3>";
            echo "<p>Nome: " . $dados["nome"] . "</p>";
            echo "<p>Email: " . $dados["email"] . "</p>";
            echo "<p>Questão 1: " . $dados["q1"] . " (Gabarito: " . $gabarito["q1"] . ")</p>";
            echo "<p>Questão 2: " . $dados["q2"] . " (Gabarito: " . $gabarito["q2"] . ")</p>";
            echo "<p>Questão 3: " . $dados["q3"] . " (Gabarito: " . $gabarito["q3"] . ")</p>";
            echo "<p>Questão 4: " . $dados["q4"] . " (Gabarito: " . $gabarito["q4"] . ")</p>";
            echo "<p>Porcentagem de acertos: " . $porcentagem . "%</p>";

            if ($porcentagem == 100) {
                echo "<p>Dados enviados! Parabéns! 100% de acertos!</p>";
            } elseif ($porcentagem >= 70 && $porcentagem <= 90) {
                echo "<p>Dados enviados! Sucesso! Você foi aprovado.</p>";
            } else {
                echo "<p>Dados enviados! Que pena, não foi aprovado.</p>";
            }

            include "../servicos-professor/conexao.inc";

            $nome= $_POST['nome'];
            $email= $_POST['email'];
            $q1= $_POST['q1'];
            $q2= $_POST['q2'];
            $q3= $_POST['q3'];
            $q4= $_POST['q4'];
            $media = $porcentagem/10;

            $sql="Insert into tabeladados VALUES('$nome','$email',
            '$q1','$q2','$q3','$q4','$media')";
            $res=mysqli_query($conn, $sql);
            $lin=mysqli_affected_rows($conn);
            if($lin>0){

                echo "inserido $lin";
            }
            else{

                echo "nao inserido: email ja existe";

            }


            mysqli_close($conn);
        }
    }
    ?>
    <br>
    <a class="btn_dashboard" href="../index.php">Home Page</a>

</body>
<footer style="text-align: center; margin-top: 20px; padding: 10px; background-color: #f4f4f4;">
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>