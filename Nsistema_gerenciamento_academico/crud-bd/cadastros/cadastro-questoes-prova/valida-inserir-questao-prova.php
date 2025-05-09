<?php
$erros = "";

//var_dump($_POST);

if (
    empty($_POST["codigoQuestaoProva"]) ||
    empty($_POST["descricao_questao"]) ||
    empty($_POST["tipo_prova"])||
    empty($_POST["id_disciplina"]) ||
    empty($_POST["id_prova"]) ||
    empty($_POST["id_professor"])
) {
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}

if (strlen($_POST["codigoQuestaoProva"]) < 3 || strlen($_POST["codigoQuestaoProva"]) > 20) {
    $erros .= "Erro: campo 'Código da Questão' deve ter entre 3 e 20 caracteres.<br>";
}

if (strlen($_POST["descricao_questao"]) < 10 || strlen($_POST["descricao_questao"]) > 300) {
    $erros .= "Erro: campo 'Descrição da Questão' deve ter entre 10 e 300 caracteres.<br>";
}

if (strlen($_POST["tipo_prova"]) < 5 || strlen($_POST["tipo_prova"]) > 20) {
    $erros .= "Erro: campo 'Tipo de Prova' deve ter entre 5 e 20 caracteres.<br>";
}

//Validar IDs? Sao chaves estrangeiras!

if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erros ao Cadastrar Questão da Prova</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Questão da Prova</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='form-questoes-prova.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    
    echo '<form action="inserir-questao-prova.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
