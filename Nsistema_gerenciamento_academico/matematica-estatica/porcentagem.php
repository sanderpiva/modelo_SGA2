<?php
    session_start(); // Inicia a sessão no início do arquivo
?>

<!DOCTYPE html>
<html>
<head>
    <title>Porcentagem</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="home">
    <div id="porcentagem_form"><br><br>
        <h1 class="titulo_porcentagem">Cálculo de Porcentagem</h1>
        <h2>Conceito</h2>
        <p>Porcentagem é uma forma de expressar uma parte de um todo como uma fração de 100. O símbolo "%" significa "por cento". Podemos calcular a porcentagem de um valor, o valor correspondente a uma porcentagem ou a porcentagem que um valor representa de outro.</p>
        <p>Escolha o tipo de cálculo que você deseja realizar:</p>
        <form method="post" action="">
            <label for="tipo_calculo">Tipo de Cálculo:</label><br>
            <select id="tipo_calculo" name="tipo_calculo">
                <option value="">Selecione:</option>
                <option value="calcular_porcentagem">Calcular a porcentagem de um valor</option>
                <option value="calcular_valor">Calcular o valor correspondente a uma porcentagem</option>
                <option value="calcular_percentual">Calcular o percentual entre dois valores</option>
            </select><br><br>

            <div id="form_calcular_porcentagem" style="display: none;">
                <h3>Calcular a porcentagem de um valor</h3>
                <label for="valor_total_porc">Digite o valor total:</label><br>
                <input type="number" id="valor_total_porc" name="valor_total_porc" placeholder="Valor Total" min="1"><br><br>
                <label for="porcentagem_porc">Digite a porcentagem (%):</label><br>
                <input type="number" id="porcentagem_porc" name="porcentagem_porc" placeholder="Porcentagem" min="1"><br><br>
                <button class="btn_calcular" type="submit" name="calcular_porcentagem_btn">Calcular</button><br><br>
            </div>

            <div id="form_calcular_valor" style="display: none;">
                <h3>Calcular o valor correspondente a uma porcentagem</h3>
                <label for="porcentagem_valor">Digite a porcentagem (%):</label><br>
                <input type="number" id="porcentagem_valor" name="porcentagem_valor" placeholder="Porcentagem" min="1"><br><br>
                <label for="total_valor">Digite o valor total:</label><br>
                <input type="number" id="total_valor" name="total_valor" placeholder="Valor Total" min="1"><br><br>
                <button class="btn_calcular" type="submit" name="calcular_valor_btn">Calcular</button><br><br>
            </div>

            <div id="form_calcular_percentual" style="display: none;">
                <h3>Calcular o percentual entre dois valores</h3>
                <label for="valor_parte_perc">Digite o valor da parte:</label><br>
                <input type="number" id="valor_parte_perc" name="valor_parte_perc" min="1" placeholder="Valor da Parte"><br><br>
                <label for="valor_total_perc">Digite o valor total:</label><br>
                <input type="number" id="valor_total_perc" name="valor_total_perc" min="1" placeholder="Valor Total"><br><br>
                <button class="btn_calcular" type="submit" name="calcular_percentual_btn">Calcular</button><br><br>
            </div>
        </form>
    </div>
    <div id="porcentagem_result">
        <?php
            if (isset($_POST['calcular_porcentagem_btn'])) {
                $valor_total = $_POST['valor_total_porc'];
                $porcentagem = $_POST['porcentagem_porc'];
                $resultado = ($porcentagem / 100) * $valor_total;
                echo "$porcentagem% de $valor_total é: $resultado";
                $_SESSION['porcentagem_status'] = 1;
            } elseif (isset($_POST['calcular_valor_btn'])) {
                $porcentagem = $_POST['porcentagem_valor'];
                $total = $_POST['total_valor'];
                $resultado = ($porcentagem * $total) / 100;
                echo "$porcentagem% de qual valor é $total? Resposta: $resultado"; // Inverti a lógica da pergunta para clareza
                $_SESSION['porcentagem_status'] = 1;
            } elseif (isset($_POST['calcular_percentual_btn'])) {
                $valor_parte = $_POST['valor_parte_perc'];
                $valor_total = $_POST['valor_total_perc'];
                $resultado = ($valor_parte / $valor_total) * 100;
                echo "$valor_parte é $resultado% de $valor_total";
                $_SESSION['porcentagem_status'] = 1;
            }
        ?>
        <br><br>
        <a class="btn_dashboard" href="../servicos-professor/dashboard-alunos-algebrando-estatico.php">Finalizar</a>
    </div>

    <script>
        document.getElementById('tipo_calculo').addEventListener('change', function() {
            document.getElementById('form_calcular_porcentagem').style.display = 'none';
            document.getElementById('form_calcular_valor').style.display = 'none';
            document.getElementById('form_calcular_percentual').style.display = 'none';

            if (this.value === 'calcular_porcentagem') {
                document.getElementById('form_calcular_porcentagem').style.display = 'block';
            } else if (this.value === 'calcular_valor') {
                document.getElementById('form_calcular_valor').style.display = 'block';
            } else if (this.value === 'calcular_percentual') {
                document.getElementById('form_calcular_percentual').style.display = 'block';
            }
        });
    </script>

</body><br><br>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>