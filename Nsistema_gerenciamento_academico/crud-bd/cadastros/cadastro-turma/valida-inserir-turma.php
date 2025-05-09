<?php
$erros = "";

if (
    empty($_POST["codigoTurma"]) ||
    empty($_POST["nomeTurma"])) {
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}

if (strlen($_POST["codigoTurma"]) < 3 || strlen($_POST["codigoTurma"]) > 20) {
    $erros .= "Erro: campo 'Código da Turma' deve ter entre 3 e 20 caracteres.<br>";
}
if (strlen($_POST["nomeTurma"]) < 6 || strlen($_POST["nomeTurma"]) > 15) {
    $erros .= "Erro: campo 'Nome da Turma' deve ter entre 6 e 15 caracteres.<br>";
}

if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erros ao Cadastrar Turma</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Turma</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='formTurma.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    
    echo '<form action="inserir-turma.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
