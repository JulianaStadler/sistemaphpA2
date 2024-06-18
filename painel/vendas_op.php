<?php
session_start();
include_once("lib/includes.php");
include_once("header.php");

/* verifica se vai ter algo para editar */
$atual = [];
$operacao = "Cadastrar";
if (isset($_GET['id'])) {
    $atual = $_GET['id'];
    $query = "SELECT * FROM vendas WHERE id = $atual";
    $result = $mysqli->query($query);
    $atual = $result->fetch_assoc();
    if ($atual["id"] == "") {
        redireciona('vendas.php', 'success', 0, '');
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
            <a href="vendas.php" class="padrao">Lista de vendas</a>
            <a href="vendas_op.php" class="padrao" style="<?= ($operacao == "Cadastrar") ? "background-color:#333;" : ""; ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
                <div class="alinhar-form-publicar">
                    <h1><?= $operacao ?> Vendas:</h1>
                    <form method="POST" enctype="multipart/form-data" id="form-publicar">
                        <?php
                        if ($operacao == "Editar" || $operacao == "Cadastrar") {
                        ?>
                            <?php
                            $mod = $mysqli->query("SELECT * FROM vendedores ORDER BY nome ASC");
                            if ($mod) {
                                if ($mod->num_rows > 0) { ?>
                                    <label>Vendedor:</label>
                                    <select name="id_vendedor">
                                        <?php while ($result = $mod->fetch_assoc()) { ?>
                                            <option value="<?= $result['id'] ?>" <?= ($result['id'] == $atual['id_vendedor']) ? "selected" : "" ?>><?= $result['nome'] ?></option>
                                        <?php } ?>
                                    </select><br><br>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            $mod = $mysqli->query("SELECT * FROM clientes ORDER BY cpf ASC");
                            if ($mod) {
                                if ($mod->num_rows > 0) { ?>
                                    <label>Cliente:</label>
                                    <select name="id_cliente">
                                        <?php while ($result = $mod->fetch_assoc()) { ?>
                                            <option value="<?= $result['id'] ?>" <?= ($result['id'] == $atual['id_cliente']) ? "selected" : "" ?>><?= $result['cpf'] ?> - <?= $result['nome'] ?></option>
                                        <?php } ?>
                                    </select><br><br>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            $mod = $mysqli->query("SELECT * FROM modelos ORDER BY modelo ASC");
                            if ($mod) {
                                if ($mod->num_rows > 0) { ?>
                                    <label>Modelo:</label>
                                    <select name="id_modelo">
                                        <?php while ($result = $mod->fetch_assoc()) { ?>
                                            <option value="<?= $result['id'] ?>" <?= ($result['id'] == $atual['id_modelo']) ? "selected" : "" ?>><?= $result['modelo'] ?></option>
                                        <?php } ?>
                                    </select><br><br>
                                    <?php
                                }
                            }
                            ?>

                            <label>Data da venda:</label>
                            <input type="date" name="data_venda" class="form-control" placeholder="Data de Venda" value="<?= $atual["data_venda"] ?? date('Y-m-d') ?>" required/><br><br>
                            
                        <?php
                        } else {
                        ?>
                            <p>Deseja excluir permanentemente a venda com id <?= $atual["id"] ?>??</p>
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
                if ((isset($_POST['id_vendedor']) && isset($_POST['id_cliente']) && isset($_POST['id_modelo']) && isset($_POST['data_venda'])) || ($_POST['excluir'] == "Excluir")) {
                    // Inserir os dados no banco de dados
                    $id_vendedor = $_POST['id_vendedor'];
                    $id_cliente = $_POST['id_cliente'];
                    $id_modelo = $_POST['id_modelo'];
                    $data_venda = $_POST['data_venda'];

                    switch ($operacao) {
                        case 'Cadastrar':
                            $query = "INSERT INTO vendas ( id_cliente, id_vendedor, id_modelo, data_venda) VALUES ('$id_cliente', '$id_vendedor', '$id_modelo', '$data_venda')";
                            break;
                        case 'Editar':
                            $id = $atual['id'];
                            $query = "UPDATE vendas SET id_vendedor='$id_vendedor', id_cliente='$id_cliente', id_modelo='$id_modelo', data_venda='$data_venda' WHERE id = $id";
                            break;
                        case 'Excluir':
                            $id = $atual['id'];
                            $query = "DELETE FROM vendas WHERE id = $id";
                            break;
                        default:
                            break;
                    }


                    if ($mysqli->query($query) === TRUE) {
                        if ($mysqli->affected_rows > 0) {
                            redireciona('vendas.php', 'verde', 3, 'Operação realizada com sucesso.<br/> Redirecionando...');
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
