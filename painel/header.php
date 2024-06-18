<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | Loja de Carros</title>

    <link rel="stylesheet" type="text/css" href="../css/colors.css"/>
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="css/alertas.css"/>
    <link rel="stylesheet" type="text/css" href="css/header.css"/>

</head>
<body>
<header>
    <div class="btn-abrir-menu" onclick="abrir_menu()">MENU</div>
    <div class="engloba-menu" id="menu_painel">
        <div class="esq">
            <div class="logo"><a href="../index.php" target="_blank">Loja de Carros</a></div>
            <div class="infos">
                <a class="padrao" href="vendedores.php">Vendedores</a>
                <a class="padrao" href="clientes.php">Clientes</a>
                <a class="padrao" href="marcas.php">Marcas</a>
                <a class="padrao" href="modelos.php">Modelos</a>
                <a class="padrao" href="vendas.php">Vendas</a>

                <a class="padrao sair" href="sair.php">Sair</a>
            </div>
        </div>
        <div class="dir" onclick="fechar_menu()"></div>
    </div>
</header>