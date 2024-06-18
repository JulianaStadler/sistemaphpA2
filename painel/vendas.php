<?php
    session_start();
    include_once("lib/includes.php");
    include_once("header.php");

    /* verifica se vai ter algo para editar */
    $operacao = "Cadastrar";
    if (isset($_GET['id'])) {
        $atual = $_GET['id'];
        $query = "SELECT * FROM vendas WHERE id = $atual";
        $result = $mysqli->query($query);
        $atual = $result->fetch_assoc();
        if ($atual["id"] == "") {
            redireciona('vendas.php', 'success', 0, '');
            die();
        } else {
            $operacao = "Editar";
        }
    }
?>
<main>
    <div class="central">
        <div class="menu">
            <a href="vendas.php" class="padrao" style="<?= (isset($atual["id"])) ? "" : "background-color:#333;" ?>">Lista de vendas</a>
            <a href="vendas_op.php" class="padrao" style="<?= ($operacao == "Editar") ? "background-color:#333;" : "" ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
            <?php
                // Query para selecionar todas as vendas
                $result = $mysqli->query("SELECT * FROM vendas ORDER BY data_venda DESC ");
                if ($result) {
                    if ($result->num_rows > 0) { ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>VENDEDOR</th>
                                <th>CLIENTE</th>
                                <th>MODELO</th>
                                <th>DATA DA VENDA</th>
                                <th colspan="2">OPERAÇÕES</th>
                            </tr>

                            <?php while ($row = $result->fetch_assoc()) { 
                                $id_vendedor = $row['id_vendedor'];
                                $id_cliente = $row['id_cliente'];
                                $id_modelo = $row['id_modelo'];
                                $sql = $mysqli->query("SELECT nome FROM vendedores WHERE id = $id_vendedor");
                                $vendedor = $sql->fetch_assoc()['nome'];
                                $sql = $mysqli->query("SELECT nome FROM clientes WHERE id = $id_cliente");
                                $cliente = $sql->fetch_assoc()['nome'];
                                $sql = $mysqli->query("SELECT modelo FROM modelos WHERE id = $id_modelo");
                                $modelo = $sql->fetch_assoc()['modelo'];
                                
                                ?>

                                <tr>
                                    <td>
                                        <div><?= $row["id"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= $vendedor ?></div>
                                    </td>
                                    <td>
                                        <div><?= $cliente ?></div>
                                    </td>
                                    <td>
                                        <div><?= $modelo ?></div>
                                    </td>
                                    <td>
                                        <div><?= date("d/m/Y", strtotime($row["data_venda"])); ?></div>
                                    </td>
                                    <td>
                                        <a href="vendas_op.php?id=<?= $row["id"] ?>">Editar</a>
                                    </td>
                                    <td>
                                        <a href="vendas_op.php?ex=sim&id=<?= $row["id"] ?>">Excluir</a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>

                    <?php } else { ?>

                        Nenhuma venda encontrado no sistema

                <?php }
                } else { ?>

                    Erro ao executar a consulta

                <?php } ?>
            </div>
        </div>
    </div>
</main>
<?php
include_once("footer.php");
?>