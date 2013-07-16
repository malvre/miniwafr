<?php
include("../includes/common.php");

Security::verify(2);

$output = array();
$output["ok"] = false;

$itens = implode(",", $_POST["sel"]);

// validação
$error = new Error();
if (DBVal::checkFK("usuario", "departamento_id", $itens)) $error->add("Existem registros associados em Usuários.");
if (strlen($itens)==0) $error->add("Nenhum registro selecionado");

// transação
if ($error->hasError()) {
	$output["erro"] = $error->toString();
} else {
	try {
		$db = new DBH();
		$db->delete("departamento", "departamento_id IN ($itens)");
		$db = null;

		$output["mensagem"] = "Registros excluídos com sucesso!";
		$output["ok"] = true;
	} catch (Exception $e) {
		$output["erro"] = "Erro durante a exclusão";
	}
}
echo json_encode($output);