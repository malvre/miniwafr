<?php
include_once("../includes/common.php");

$result = array();
$result["usuario"] = "<a href='../pages/login.php'>Login</a>";
$result["usuario_button"] = "<a class='btn' href='../pages/login.php'>Login</a>";

if ($_SESSION["sis_logado"]) {
	$result["usuario"] = "<i class='iconic-user'></i> " . $_SESSION["sis_usuario"] . " (<a href='../services/logout.php'>Sair</a>)";
	$result["usuario_button"] = "<i class='iconic-user'></i> " . $_SESSION["sis_usuario"] . " <a class='btn' href='../services/logout.php'>Sair</a>";
}

echo json_encode($result);