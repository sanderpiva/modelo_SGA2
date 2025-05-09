<?php
$erros = "";
//var_dump($_POST);

if (
    empty($_POST["codigoProva"]) ||
    empty($_POST["tipo_prova"]) ||
    empty($_POST["disciplina"]) ||
    empty($_POST["conteudo"]) ||
    empty($_POST["data_prova"]) ||
    empty($_POST["nome_professor"]) ||
    empty($_POST["id_disciplina"]) ||
    empty($_POST["id_professor"]) 
    
) {
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}

if (strlen($_POST["codigoProva"]) < 3 || strlen($_POST["codigoProva"]) > 20) {
    $erros .= "Erro: campo 'Código da Prova' deve ter entre 3 e 20 caracteres.<br>";
}

if (strlen($_POST["tipo_prova"]) < 3 || strlen($_POST["tipo_prova"]) > 30) {
    $erros .= "Erro: campo 'Tipo de Prova' deve ter entre 3 e 30 caracteres.<br>";
}

if (strlen($_POST["disciplina"]) < 3 || strlen($_POST["disciplina"]) > 20) {
    $erros .= "Erro: campo 'Disciplina' deve ter entre 3 e 20 caracteres.<br>";
}

if (strlen($_POST["conteudo"]) < 30 || strlen($_POST["conteudo"]) > 300) {
    $erros .= "Erro: campo 'Conteúdo da Prova' deve ter entre 30 e 300 caracteres.<br>";
}


if (strlen($_POST["nome_professor"]) < 5 || strlen($_POST["nome_professor"]) > 20) {
    $erros .= "Erro: campo 'Professor' deve ter entre 5 e 20 caracteres.<br>";
}


if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erros ao Cadastrar Prova</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Prova</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='form-prova.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    
    echo '<form action="inserir-prova.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
