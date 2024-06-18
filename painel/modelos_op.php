<?php
session_start();
include_once("lib/includes.php");
include_once("header.php");

/* verifica se vai ter algo para editar */
$operacao = "Cadastrar";
if (isset($_GET['id'])) {
    $atual = $_GET['id'];
    $query = "SELECT * FROM modelos WHERE id = $atual";
    $result = $mysqli->query($query);
    $atual = $result->fetch_assoc();
    if ($atual["id"] == "") {
        redireciona('modelos.php', 'success', 0, '');
        die();
    }
    $operacao = "Editar";
    if (isset($_GET['ex'])) {
        $operacao = "Excluir";
    }
}
?>
<main>
    <div class="central">
        <div class="menu">
            <a href="modelos.php" class="padrao">Lista de modelos</a>
            <a href="modelos_op.php" class="padrao" style="<?= ($operacao == "Cadastrar") ? "background-color:#333;" : ""; ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
                <div class="alinhar-form-publicar">
                    <h1><?= $operacao ?> Modelo:</h1>
                    <form method="POST" enctype="multipart/form-data" id="form-publicar" enctype="multipart/form-data">
                        <?php
                        if ($operacao == "Editar" || $operacao == "Cadastrar") {
                        ?>
                            <label>Modelo:</label>
                            <input type="text" maxlength="120" name="modelo" class="form-control" placeholder="Modelo" value="<?= $atual["modelo"] ?? '' ?>" required/><br><br>
                            <label>Ano:</label>
                            <input type="number" maxlength="4" name="ano" class="form-control" placeholder="Ano" value="<?= $atual["ano"] ?? '' ?>" required/><br><br>
                            
                            <?php
                            $mod = $mysqli->query("SELECT * FROM marcas");
                            if ($mod) {
                                if ($mod->num_rows > 0) { ?>
                                    <label>Marca:</label>
                                    <select name="id_marca">
                                        <?php while ($marca = $mod->fetch_assoc()) { ?>
                                            <option value="<?= $marca['id'] ?>" <?= ($marca['id'] == $atual['id_marca']) ? "selected" : "" ?>><?= $marca['marca'] ?></option>
                                        <?php } ?>
                                    </select><br><br>
                                    <?php
                                }
                            }
                            ?>
                            
                            <label>Preço:</label>
                            <input type="text" maxlength="10" name="preco" class="form-control" placeholder="Preço" value="<?= $atual["preco"] ?? '' ?>" required/><br><br>
                            
                            <label>Imagem</label>
                            <input type="hidden" name="bkpimagem" value="<?= $atual["imagem"] ?? "sem-imagem.jpg" ?>"/>
                            <input type="file" accept="image/*" name="imagem" class="form-control"/><br/><br/>
                        <?php
                        } else {
                        ?>
                            <p>Deseja excluir permanentemente o modelo <?= $atual["modelo"] ?> com id <?= $atual["id"] ?>??</p>
                            <input type="hidden" name="excluir" value="<?= $operacao ?>" />
                        <?php
                        }
                        ?>
                        <div class="alinhar-btn-publicar">
                            <input type="submit" value="<?= $operacao ?>" class="btn-editarp" />
                            <input type="hidden" name="alt" value="cad" />
                        </div>
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST['alt']) && $_POST['alt'] == "cad") {
                if (($_POST['modelo'] && $_POST['ano'] && $_POST['id_marca'] && $_POST['preco']) || ($_POST['excluir'] == "Excluir")) {
                    // Inserir os dados no banco de dados
                    $modelo = $_POST['modelo'];
                    $ano = $_POST['ano'];
                    $id_marca = $_POST['id_marca'];
                    $preco = $_POST['preco'];
                    $nomeArquivo = $_POST['bkpimagem'];

                    if(isset($_FILES["imagem"]['name']) && !empty($_FILES['imagem']['name'])){
                        $diretorio = "../img/modelos/";
                        $nomeArquivo =  uniqid('img_').".".pathinfo($_FILES["imagem"]['name'], PATHINFO_EXTENSION);
                        $caminhoCompleto = $diretorio . $nomeArquivo;

                        if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoCompleto)) {
                            // Move a imagem para o diretório de uploads
                        } else {
                            redireciona("modelos.php", "amarelo", 5, "Erro ao enviar a imagem para o servidor. <br>Tente novamente mais tarde.");
                        }
                    }

                    
                    switch ($operacao) {
                        case 'Cadastrar':
                            $query = "INSERT INTO modelos (modelo, ano, id_marca, preco, imagem) VALUES ('$modelo', '$ano', '$id_marca', '$preco', '$nomeArquivo')";
                            break;
                        case 'Editar':
                            $id = $atual['id'];
                            $query = "UPDATE modelos SET modelo='$modelo', ano='$ano', id_marca='$id_marca', preco='$preco', imagem='$nomeArquivo' WHERE id = $id";
                            break;
                        case 'Excluir':
                            $id = $atual['id'];
                            $query = "DELETE FROM modelos WHERE id = $id";
                            break;
                        default:
                            break;
                    }


                    if ($mysqli->query($query) === TRUE) {
                        if ($mysqli->affected_rows > 0) {
                            redireciona('modelos.php', 'verde', 3, 'Operação realizada com sucesso.<br/> Redirecionando...');
                        } else if ($sql->affected_rows == 0) {
                            alerta("amarelo", "Nenhuma operação foi feita");
                        }
                    } else {
                        alerta("vermelho", "Erro ao realizar operação usuário");
                    }
                } else {
                    alerta("amarelo", "Preencha todos os campos");
                }
            }
            ?>

        </div>
    </div>
</main>
<?php
include_once("footer.php");
?>