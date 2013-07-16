<?php
session_start();
unset($_SESSION["sis_logado"]);
unset($_SESSION["sis_usuario"]);
unset($_SESSION["sis_usuario_nome"]);
unset($_SESSION["sis_usuario_nivel"]);
unset($_SESSION["sis_usuario_email"]);
session_destroy();
header("Location: ../pages/index.php");
die();