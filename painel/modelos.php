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
        } else {
            $operacao = "Editar";
        }
    }
?>
<main>
    <div class="central">
        <div class="menu">
            <a href="modelos.php" class="padrao" style="<?= (isset($atual["id"])) ? "" : "background-color:#333;" ?>">Lista de modelos</a>
            <a href="modelos_op.php" class="padrao" style="<?= ($operacao == "Editar") ? "background-color:#333;" : "" ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
            <?php
                // Query para selecionar todas as modelos
                $result = $mysqli->query("SELECT * FROM modelos ORDER BY modelo ASC");
                if ($result) {
                    if ($result->num_rows > 0) { ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>MODELO</th>
                                <th>ANO</th>
                                <th>MARCA</th>
                                <th>PREÇO</th>
                                <th colspan="2">OPERAÇÕES</th>
                            </tr>

                            <?php while ($row = $result->fetch_assoc()) { 
                                $id_marca = $row['id_marca'];
                                $sql_marca = $mysqli->query("SELECT marca FROM marcas WHERE id = $id_marca");
                                $marca = $sql_marca->fetch_assoc()['marca'];
                            ?>
                                <tr>
                                    <td>
                                        <div><?= $row["id"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= $row["modelo"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= $row["ano"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= $marca ?></div>
                                    </td>
                                    <td>
                                        <div><?= $row["preco"] ?></div>
                                    </td>
                                    <td>
                                        <a href="modelos_op.php?id=<?= $row["id"] ?>">Editar</a>
                                    </td>
                                    <td>
                                        <a href="modelos_op.php?ex=sim&id=<?= $row["id"] ?>">Excluir</a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>

                    <?php } else { ?>

                        Nenhum modelo encontrado no sistema

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