<?php
include_once("../includes/common.php");

$result = array();
$result["ok"] = false;

$usuario = $_POST["f_usuario"];
$senha = sha1($_POST["f_senha"]);

$row = DBH::getRow("SELECT * FROM usuario WHERE nome_usuario='$usuario' AND senha='$senha' AND ativo=1");

if ($row != null) {
	$_SESSION["sis_logado"] = true;
	$_SESSION["sis_usuario"] = $row->nome_usuario;
	$_SESSION["sis_usuario_nome"] = $row->nome_real;
	$_SESSION["sis_usuario_nivel"] = $row->nivel_acesso;
	$_SESSION["sis_usuario_email"] = $row->email;
	$result["ok"] = true;
} else {
	unset($_SESSION["sis_logado"]);
	unset($_SESSION["sis_usuario"]);
	unset($_SESSION["sis_usuario_nome"]);
	unset($_SESSION["sis_usuario_nivel"]);
	unset($_SESSION["sis_usuario_email"]);
	$result["erro"] = "Nome de usuário ou senha inválidos";
}

echo json_encode($result);