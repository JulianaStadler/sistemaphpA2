<?php
session_start();
include_once("lib/includes.php");
include_once("header.php");

/* verifica se vai ter algo para editar */
$operacao = "Cadastrar";
if (isset($_GET['id'])) {
    $atual = $_GET['id'];
    $query = "SELECT * FROM marcas WHERE id = $atual";
    $result = $mysqli->query($query);
    $atual = $result->fetch_assoc();
    if ($atual["id"] == "") {
        redireciona('marcas.php', 'success', 0, '');
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
            <a href="marcas.php" class="padrao">Lista de Marcas</a>
            <a href="marcas_op.php" class="padrao" style="<?= ($operacao == "Cadastrar") ? "background-color:#333;" : ""; ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
                <div class="alinhar-form-publicar">
                    <h1><?= $operacao ?> Marca:</h1>
                    <form method="POST" enctype="multipart/form-data" id="form-publicar">
                        <?php
                        if ($operacao == "Editar" || $operacao == "Cadastrar") {
                        ?>
                            <label>Nome da Marca:</label>
                            <input type="text" maxlength="50" name="marca" class="form-control" placeholder="Nome da Marca" value="<?= $atual["marca"] ?? '' ?>" /><br><br>
                        <?php
                        } else {
                        ?>
                            <p>Deseja excluir permanentemente a marca <?= $atual["marca"] ?> com id <?= $atual["id"] ?>??</p>
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
            //verifica se o botao foi pessionado anteriormente
            //se o botao for clicado ele vai fazer:
            //verificacao se o nome, email e senha estao preenchidos
            //se nao vai mostrar a mensagem de erro
            //senao
            //
            if (isset($_POST['alt']) && $_POST['alt'] == "cad") {
                if (($_POST['marca']) || ($_POST['excluir'] == "Excluir")) {
                    // Inserir os dados no banco de dados
                    $marca = $_POST['marca'];

                    switch ($operacao) {
                        case 'Cadastrar':
                            $query = "INSERT INTO marcas (marca) VALUES ('$marca')";
                            break;
                        case 'Editar':
                            $id = $atual['id'];
                            $query = "UPDATE marcas SET marca = '$marca' WHERE id = $id";
                            break;
                        case 'Excluir':
                            $id = $atual['id'];
                            $query = "DELETE FROM marcas WHERE id = $id";
                            break;
                        default:
                            break;
                    }


                    if ($mysqli->query($query) === TRUE) {
                        if ($mysqli->affected_rows > 0) {
                            redireciona('marcas.php', 'verde', 3, 'Operação realizada com sucesso.<br/> Redirecionando...');
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