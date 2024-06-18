<?php
    // Informações de conexão
    $hostname = 'localhost';
    $username = '';
    $password = '';
    $database = 'loja_de_carros';

    // Conexão com o banco de dados
    $mysqli = new mysqli($hostname, $username, $password, $database);

    // Verifica a conexão
    if ($mysqli->connect_error) {
        die("Erro de conexão: " . $mysqli->connect_error);
    }

?>
