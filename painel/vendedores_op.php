<?php
session_start();
include_once("lib/includes.php");
include_once("header.php");

/* verifica se vai ter algo para editar */
$operacao = "Cadastrar";
if (isset($_GET['id'])) {
    $atual = $_GET['id'];
    $query = "SELECT * FROM vendedores WHERE id = $atual";
    $result = $mysqli->query($query);
    $atual = $result->fetch_assoc();
    if ($atual["id"] == "") {
        redireciona('vendedores.php', 'success', 0, '');
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
            <a href="vendedores.php" class="padrao">Lista de vendedores</a>
            <a href="vendedores_op.php" class="padrao" style="<?= ($operacao == "Cadastrar") ? "background-color:#333;" : ""; ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
                <div class="alinhar-form-publicar">
                    <h1><?= $operacao ?> Vendedor:</h1>
                    <form method="POST" enctype="multipart/form-data" id="form-publicar">
                        <?php
                        if ($operacao == "Editar" || $operacao == "Cadastrar") {
                        ?>
                            <label>Nome:</label>
                            <input type="text" maxlength="120" name="nome" class="form-control" placeholder="Nome" value="<?= $atual["nome"] ?? '' ?>" required/><br><br>
                            <label>Email:</label>
                            <input type="text" maxlength="260" name="email" class="form-control" placeholder="Email" value="<?= $atual["email"] ?? '' ?>" required/><br><br>
                        <?php
                        } else {
                        ?>
                            <p>Deseja excluir permanentemente o vendedor <?= $atual["nome"] ?> com id <?= $atual["id"] ?>??</p>
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
                if (($_POST['nome'] && $_POST['email']) || ($_POST['excluir'] == "Excluir")) {
                    // Inserir os dados no banco de dados
                    $nome = $_POST['nome'];
                    $email = $_POST['email'];
                    
                    switch ($operacao) {
                        case 'Cadastrar':
                            $query = "INSERT INTO vendedores (nome, email) VALUES ('$nome', '$email')";
                            break;
                        case 'Editar':
                            $id = $atual['id'];
                            $query = "UPDATE vendedores SET nome='$nome', email='$email' WHERE id = $id";
                            break;
                        case 'Excluir':
                            $id = $atual['id'];
                            $query = "DELETE FROM vendedores WHERE id = $id";
                            break;
                        default:
                            break;
                    }


                    if ($mysqli->query($query) === TRUE) {
                        if ($mysqli->affected_rows > 0) {
                            redireciona('vendedores.php', 'verde', 3, 'Operação realizada com sucesso.<br/> Redirecionando...');
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