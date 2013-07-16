<?php
include("../includes/common.php");

Security::verify(3);

$output = array();
$output["ok"] = false;

$itens = implode(",", $_POST["sel"]);
$id_usuario = intval($_POST["f_usuario_id"]);

// validação
$error = new Error();
if (strlen($itens)==0) $error->add("Nenhum registro selecionado");

// transação
if ($error->hasError()) {
	$output["mensagem"] = $error->toString();
} else {
	try {
		$db = new DBH();
		$db->delete("sistema_usuario", "usuario_id = $id_usuario AND sistema_id IN ($itens)");
		$db = null;

		$output["mensagem"] = "Registros removidos com sucesso!";
		$output["ok"] = true;
	} catch (Exception $e) {
		$output["mensagem"] = "Erro durante a remoção";
	}
}
echo json_encode($output);