<?php
	function redireciona($url, $tipo, $tempo, $mensagem){
		echo "<meta http-equiv='refresh' content='{$tempo}; URL={$url}'>";
		if($tipo != false){
			echo "<div class='alerta $tipo'>$mensagem</div>";
        }
    }

	function alerta($tipo, $mensagem){
		echo "<div class='alerta $tipo'>$mensagem</div>";
    }

	function mask($mask_pattern, $mask_item){
		$masked = "";
		for($i = 0, $j = 0; $i < strlen($mask_pattern); $i++){
			$patternChar = $mask_pattern[$i];
			$itemChar = $mask_item[$j];
			if($patternChar == "#" && is_numeric($itemChar)){ $masked .= $itemChar; $j++; }
			else if($patternChar == "%" && !is_numeric($itemChar)){ $masked .= $itemChar; $j++; }
			else{ $masked .= $patternChar; }
		}
		return $masked;
	}
	function validaCPF($cpf) {
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		
		if (strlen($cpf) != 11) {
			return false;
		}
		
		if (preg_match('/(\d)\1{10}/', $cpf)) {
			return false;
		}
		
		$soma = 0;
		for ($i = 0; $i < 9; $i++) {
			$soma += ($cpf[$i] * (10 - $i));
		}
		$verificador1 = 11 - ($soma % 11);
		if ($verificador1 >= 10) {
			$verificador1 = 0;
		}
		
		$soma = 0;
		for ($i = 0; $i < 10; $i++) {
			$soma += ($cpf[$i] * (11 - $i));
		}
		$verificador2 = 11 - ($soma % 11);
		if ($verificador2 >= 10) {
			$verificador2 = 0;
		}

		if ($cpf[9] == $verificador1 && $cpf[10] == $verificador2) {
			return true;
		} else {
			return false;
		}
	}
	


    // function protegePagina($explode){
	// 	//iniciando a variavel array pgn-protegida
	// 	$paginas_protegidas = array("inicio");

	// 	if(!isset($_SESSION['usuarioID']) && in_array($explode, $paginas_protegidas)){
	// 		redireciona('admin/login', false, 0, false);
	// 		exit();
	// 	}

	// 	if(isset($_SESSION['usuarioID']) && $explode == "login"){
	// 		redireciona('pags/inicio', false, 0, false);
	// 		exit();
	// 	}
	// } 

	// function trazer_pagina(){
	// $url = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : 'login';
	// 	$explode = explode('/', $url);

	// switch($explode){
	// 	case 'inicio':
	// 		$titulo = "Inicio - ".$titulo;
	// 		break;
	
	// 	}
	// }

?>