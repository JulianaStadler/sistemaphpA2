<?php
    session_start();
    include_once("lib/includes.php");
    include_once("header.php");

    /* verifica se vai ter algo para editar */
    $operacao = "Cadastrar";
    if (isset($_GET['id'])) {
        $atual = $_GET['id'];
        $query = "SELECT * FROM clientes WHERE id = $atual";
        $result = $mysqli->query($query);
        $atual = $result->fetch_assoc();
        if ($atual["id"] == "") {
            redireciona('clientes.php', 'success', 0, '');
            die();
        } else {
            $operacao = "Editar";
        }
    }
?>
<main>
    <div class="central">
        <div class="menu">
            <a href="clientes.php" class="padrao" style="<?= (isset($atual["id"])) ? "" : "background-color:#333;" ?>">Lista de clientes</a>
            <a href="clientes_op.php" class="padrao" style="<?= ($operacao == "Editar") ? "background-color:#333;" : "" ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
            <?php
                // Query para selecionar todas as clientes
                $result = $mysqli->query("SELECT * FROM clientes ORDER BY nome ASC");
                if ($result) {
                    if ($result->num_rows > 0) { ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>EMAIL</th>
                                <th>CPF</th>
                                <th>DATA DE NASCIMENTO</th>
                                <th>ENDEREÇO</th>
                                <th colspan="2">OPERAÇÕES</th>
                            </tr>

                            <?php while ($row = $result->fetch_assoc()) { ?>

                                <tr>
                                    <td>
                                        <div><?= $row["id"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= $row["nome"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= $row["email"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= $row["cpf"] ?></div>
                                    </td>
                                    <td>
                                        <div><?= date("d/m/Y", strtotime($row["data_de_nascimento"])); ?></div>
                                    </td>
                                    <td>
                                        <div><?= $row["cidade"] ?> <?= $row["estado"] ?>, <?= $row["rua"] ?> <?= $row["endereco"] ?> - <?= $row["complemento"] ?></div>
                                    </td>
                                    <td>
                                        <a href="clientes_op.php?id=<?= $row["id"] ?>">Editar</a>
                                    </td>
                                    <td>
                                        <a href="clientes_op.php?ex=sim&id=<?= $row["id"] ?>">Excluir</a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>

                    <?php } else { ?>

                        Nenhum cliente encontrado no sistema

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