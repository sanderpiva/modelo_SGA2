<?php
    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'gerenciamento_academico_completo';


    try 
    {
    
    $dsn = "mysql:host=$servidor;dbname=$banco;charset=utf8"; 
    $conexao = new PDO($dsn, $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexão com o SGBD estabelecida com sucesso!";
    } 
    catch (PDOException $e)
    {
        echo "Erro na conexão com o servidor: " . $e->getMessage();
    }
?>