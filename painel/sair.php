<?php
session_start();
session_destroy();
header("Location: ../index.php");
exit();

// if (session_status() === PHP_SESSION_ACTIVE) {
//     if (isset($_SESSION['email'])) {
//         echo "a sessao existe";
//         exit();
//     }
// } else {
//     echo "Erro: A sessão não está ativa.";
// }

?>
