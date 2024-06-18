<?php
	session_start();
    include_once("lib/bdconnect.php");
    include_once("lib/settings.php");
    include_once("lib/functions.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | Loja de Carros</title>

    <link rel="stylesheet" type="text/css" href="../css/colors.css"/>
    <link rel="stylesheet" type="text/css" href="css/login.css"/>
    <link rel="stylesheet" type="text/css" href="css/alertas.css"/>

</head>
<body>
<main>
	<div class="caixa-principal">
        <div class="caixa-central">
            <div class="esq">
                <div class="titlogin">LOGIN</div>

				<div style="color:white">
					email: email@gmail.com<br>
					senha: senha@123
				</div>

                <form method="POST" class="loog">
                    <input type="text" name="email" class="form-control" placeholder="Email"/><br/><br/>
                    <input type="password" name="senha" class="form-control" placeholder="Senha"/><br/>
					<div class="pai-conectar">
						<input type="submit" value="Entrar" class="btn-conectar"/> 
					</div>
                    <input type="hidden" name="env" value="log">
                </form>
            </div>
        </div>
    </div>

</main>
<?php
	if (isset($_POST['env']) && $_POST['env'] == "log"){
		if($_POST['email'] && $_POST['senha']){
			$email = mysqli_real_escape_string($mysqli, $_POST['email']);
			$senha = mysqli_real_escape_string($mysqli, $_POST['senha']);

			$query = "SELECT * FROM admins WHERE email = '$email' AND senha = '$senha'";
			$resultado = mysqli_query($mysqli, $query);
			
			if (mysqli_num_rows($resultado) == 1) {
				$_SESSION['email'] = $_POST['email'];
				redireciona("vendedores.php", "verde", 3, "Seja bem vindo...<br>Redirecionando");
			} else {
				alerta("vermelho", "Nome de usuário ou senha invalidos.");
			}
				
		}else{
			alerta("amarelo", "Preencha todos os campos");
		}
	}

?>
<footer>
</footer>
</body>
</html>