<?php
    include_once("painel/lib/bdconnect.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Carros</title>

    <link rel="stylesheet" type="text/css" href="css/colors.css"/>
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
</head>
<body>
    <header>
        <div class="center">
            <div class="alinha-menu">
                <div class="logo"><p>Loja de Carros</p></div>
                <div class="botoes">
                    <a href="painel/login.php" class="padrao">Painel</a>
                </div>
            </div>
        </div>
    </header>
    <main>
    <?php
    // Query para selecionar todas as modelos
    $result = $mysqli->query("SELECT * FROM modelos ORDER BY modelo ASC");
    if ($result) {
        if ($result->num_rows > 0) { ?>
            <div class="center">
                <div class="alinha-title">
                    <h1 class="title">Veículos</h1>
                    <div class="sub-title"><?= $result->num_rows ?> veículos encontrados</div>
                </div>
                <div class="alinha-main">
                
                <?php while ($row = $result->fetch_assoc()) { 
                    $id_marca = $row['id_marca'];
                    $sql_marca = $mysqli->query("SELECT marca FROM marcas WHERE id = $id_marca");
                    $marca = $sql_marca->fetch_assoc()['marca'];
                    ?>
                        <div class="padrao">
                            <div class="img"><img src="img/modelos/<?= $row['imagem'] ?? 'sem-imagem.jpg' ?>"></div>
                            <div class="infos">
                                <div class="title"><b><?= $marca ?></b> <?= $row['modelo'] ?></div>
                                <div class="sub-title">ANO: <?= $row['ano'] ?></div>
                                <div class="preco">PREÇO: <?= $row['preco'] ?></div>
                            </div>
                        </div>
                    <?php 
                } ?>

                        
                </div>
            </div>
        <?php } else { ?>

        <div class="center">
            <div class="erro">Nenhum veículo encontrado no sistema</div>
        </div>

    <?php }
    } else { ?>

        <div class="center">
            <div class="erro">Nenhum veículo encontrado no sistema</div>
        </div>

    <?php } ?>
    </main>
    <footer>
        <div class="center">
            <div class="alinha-footer">
                <p>Desenvolvido por Juliana Stadler - Junho/2024</p>
            </div>
        </div>
    </footer>
</body>
</html>


