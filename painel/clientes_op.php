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
            <a href="clientes.php" class="padrao">Lista de clientes</a>
            <a href="clientes_op.php" class="padrao" style="<?= ($operacao == "Cadastrar") ? "background-color:#333;" : ""; ?>">Cadastrar</a>
        </div>
        <div class="conteudo">
            <div class="infos">
                <div class="alinhar-form-publicar">
                    <h1><?= $operacao ?> Cliente:</h1>
                    <form method="POST" enctype="multipart/form-data" id="form-publicar">
                        <?php
                        if ($operacao == "Editar" || $operacao == "Cadastrar") {
                        ?>
                            <label>Nome:</label>
                            <input type="text" maxlength="120" name="nome" class="form-control" placeholder="Nome" value="<?= $atual["nome"] ?? '' ?>" required/><br><br>
                            <label>Email:</label>
                            <input type="text" maxlength="260" name="email" class="form-control" placeholder="Email" value="<?= $atual["email"] ?? '' ?>" required/><br><br>
                            <label>CPF:</label>
                            <input type="text" maxlength="14" name="cpf" class="form-control" placeholder="CPF" value="<?= $atual["cpf"] ?? '' ?>" required inputmode="numeric" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" id="js_cpf"/><br><br>
                            <label>Data de Nascimento:</label>
                            <input type="date" name="data_de_nascimento" class="form-control" placeholder="Data de Nascimento" value="<?= $atual["data_de_nascimento"] ?? '' ?>" required/><br><br>
                            <label>Estado:</label>
                            <input type="text" maxlength="2" name="estado" class="form-control" placeholder="Estado" value="<?= $atual["estado"] ?? '' ?>" required/><br><br>
                            <label>Cidade:</label>
                            <input type="text" maxlength="50" name="cidade" class="form-control" placeholder="Cidade" value="<?= $atual["cidade"] ?? '' ?>" required/><br><br>
                            <label>Rua:</label>
                            <input type="text" maxlength="100" name="rua" class="form-control" placeholder="Rua" value="<?= $atual["rua"] ?? '' ?>" required/><br><br>
                            <label>Endereço:</label>
                            <input type="number" name="endereco" class="form-control" placeholder="Endereço" value="<?= $atual["endereco"] ?? '' ?>" required/><br><br>
                            <label>Complemento:</label>
                            <input type="text" maxlength="30" name="complemento" class="form-control" placeholder="Complemento" value="<?= $atual["complemento"] ?? '' ?>" required/><br><br>
                        <?php
                        } else {
                        ?>
                            <p>Deseja excluir permanentemente o cliente <?= $atual["nome"] ?> com id <?= $atual["id"] ?>??</p>
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
                if((validaCPF($_POST['cpf']) === true) || $operacao == "Excluir") {
                    if (($_POST['nome'] && $_POST['email'] && $_POST['cpf'] && $_POST['data_de_nascimento'] && $_POST['endereco']) || ($_POST['excluir'] == "Excluir")) {
                        // Inserir os dados no banco de dados
                        $nome = $_POST['nome'];
                        $email = $_POST['email'];
                        $cpf = $_POST['cpf'];
                        $data_de_nascimento = $_POST['data_de_nascimento'];
                        $estado = $_POST['estado'];
                        $cidade = $_POST['cidade'];
                        $rua = $_POST['rua'];
                        $endereco = $_POST['endereco'];
                        $complemento = $_POST['complemento'];
                        
                        switch ($operacao) {
                            case 'Cadastrar':
                                $query = "INSERT INTO clientes (nome, email, cpf, data_de_nascimento, estado, cidade, rua, endereco, complemento ) VALUES ('$nome', '$email', '$cpf', '$data_de_nascimento', '$estado', '$cidade', '$rua', '$endereco', '$complemento')";
                                break;
                            case 'Editar':
                                $id = $atual['id'];
                                $query = "UPDATE clientes SET nome='$nome', email='$email', cpf='$cpf', data_de_nascimento='$data_de_nascimento', estado='$estado', cidade='$cidade', rua='$rua', endereco='$endereco', complemento='$complemento' WHERE id = $id";
                                break;
                            case 'Excluir':
                                $id = $atual['id'];
                                $query = "DELETE FROM clientes WHERE id = $id";
                                break;
                            default:
                                break;
                        }
    
    
                        if ($mysqli->query($query) === TRUE) {
                            if ($mysqli->affected_rows > 0) {
                                redireciona('clientes.php', 'verde', 3, 'Operação realizada com sucesso.<br/> Redirecionando...');
                            } else if ($sql->affected_rows == 0) {
                                alerta("amarelo", "Nenhuma operação foi feita");
                            }
                        } else {
                            alerta("vermelho", "Erro ao realizar operação usuário");
                        }
                    } else {
                        alerta("amarelo", "Preencha todos os campos");
                    }

                } else {
                    alerta("amarelo", "CPF digitado invalido!");
                }
            }
            ?>

        </div>
    </div>
</main>
<?php
include_once("footer.php");
?>
