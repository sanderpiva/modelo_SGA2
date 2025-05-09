<?php

$erros = "";
//var_dump($_POST);

if (
    empty($_POST["aluno_id"])||
    empty($_POST["disciplina_id"])
) {
    $erros .= "Por favor, selecione um aluno e uma disciplina.<br>";
}


if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erros ao Cadastrar Matrícula</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Matrícula</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='form-matricula.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    
    echo '<form action="inserir-matricula.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>