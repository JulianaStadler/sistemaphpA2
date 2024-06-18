function mostradiv(div) {
    var apagadiv = document.querySelectorAll('.mostradivjs');
    var apagacor = document.querySelectorAll('.cormostradivjs');
    
    apagadiv.forEach(function(elemento) {
        elemento.style.display = "none";
    });

    apagacor.forEach(function(elemento) {
        elemento.style.backgroundColor = "#858585";
    });

    cor = "cor"+div+"js";
    document.getElementById(cor).style.backgroundColor = "#333";
    document.getElementById(div).style.display = "flex";
}
function abrir_menu(){
    menu = document.getElementById("menu_painel");
    menu.style.transform = "translate(0%, 0)";
}
function fechar_menu(){
    menu = document.getElementById("menu_painel");
    menu.style.transform = "translate(-100%, 0)";
}

input = document.getElementById("js_cpf");
input.addEventListener("keyup", function () {
    if (`input.value.length` <= "14") {
        $(input).mask('###.###.###-##');   
    } else {
        $(input).mask('###.###.###-##');  
    }
});