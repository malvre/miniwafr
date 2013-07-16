<?php
include("../includes/common.php");

Security::verify(3);

$output = array();
$output["ok"] = false;

$itens = implode(",", $_POST["sel"]);

// validação
$error = new Error();
if (DBVal::checkFK("sistema_usuario", "usuario_id", $itens)) $error->add("Existem registros associados em Sistemas do Usuário.");
if (DBVal::checkFK("historico", "usuario_id", $itens)) $error->add("Existem registros associados em Histórico.");
if (strlen($itens)==0) $error->add("Nenhum registro selecionado");

// transação
if ($error->hasError()) {
	$output["mensagem"] = $error->toString();
} else {
	try {
		$db = new DBH();
		$db->delete("usuario", "usuario_id IN ($itens)");
		$db = null;

		$output["mensagem"] = "Registros excluídos com sucesso!";
		$output["ok"] = true;
	} catch (Exception $e) {
		$output["mensagem"] = "Erro durante a exclusão";
	}
}
echo json_encode($output);