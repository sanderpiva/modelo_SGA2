<?php
$erros = "";

if (
    empty($_POST["codigoConteudo"]) ||
    empty($_POST["tituloConteudo"]) ||
    empty($_POST["descricaoConteudo"]) ||
    empty($_POST["data_postagem"]) ||
    empty($_POST["professor"]) ||
    empty($_POST["disciplina"]) ||
    empty($_POST["tipo_conteudo"])||
    empty($_POST["id_disciplina"])
) {
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}

if (strlen($_POST["codigoConteudo"]) < 5 || strlen($_POST["codigoConteudo"]) > 20) {
    $erros .= "Erro: campo 'Código do Conteúdo' deve ter entre 5 e 20 caracteres.<br>";
}

if (strlen($_POST["tituloConteudo"]) < 5 || strlen($_POST["tituloConteudo"]) > 40) {
    $erros .= "Erro: campo 'Titulo de Conteúdo' deve ter entre 5 e 40 caracteres.<br>";
}           

if (strlen($_POST["descricaoConteudo"]) < 30 || strlen($_POST["descricaoConteudo"]) > 300) {
    $erros .= "Erro: campo 'Descrição do Conteúdo' deve ter entre 30 e 300 caracteres.<br>";
}

if (strlen($_POST["professor"]) < 5 || strlen($_POST["professor"]) > 20) {
    $erros .= "Erro: campo 'Professor' deve ter entre 5 e 20 caracteres.<br>";
}

if (strlen($_POST["disciplina"]) < 5 || strlen($_POST["disciplina"]) > 20) {
    $erros .= "Erro: campo 'Disciplina' deve ter entre 5 e 20 caracteres.<br>";
}   

if (strlen($_POST["tipo_conteudo"]) < 5 || strlen($_POST["tipo_conteudo"]) > 20) {
    $erros .= "Erro: campo 'Tipo de Conteúdo' deve ter entre 5 e 20 caracteres.<br>";
}           


if (!empty($erros)) {
    
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erro de Validação</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Conteúdo</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='form-conteudo.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    
    echo '<form action="inserir-conteudo.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
