<?php
include("../includes/common.php");

Security::verify(3);

// Prepara dados de retorno
$result["ok"] = false;

// id do registro
$id_usuario = intval($_POST["f_usuario_id"]);

// itens
$itens = $_POST["sel"];

// Validação
$error = new Error();
if (sizeof($itens)==0) $error->add("Nenhum registro selecionado");

// Atualização dos dados
if ($error->hasError()) {
	$result["erro"] = $error->toString();
} else {
	$db = new DBH();
	for ($x = 0; $x < sizeof($itens); $x++) {
		$id_sistema = $itens[$x];
		$rows = array(
				"usuario_id" => $id_usuario,
				"sistema_id" => $id_sistema,
				"ordem_exibicao" => 0
		);
		$db->insert("sistema_usuario", $rows);
	}
	$db = null;
	$result["ok"] = true;
}
echo json_encode($result);