<?php
    protegePagina();
    function protegePagina() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            if (!isset($_SESSION['email'])) {
                header("Location: login.php");
                exit();
            }
        } else {
            header("Location: login.php");
            exit();
        }
    }
?>