<?php
include("../includes/common.php");

Security::verify(1);

$output = array();
$output["ok"] = false;

$id = $_GET["id"];


try {
	$db = new DBH();
	$db->delete("grade_programacao", "id=".$id);
	$db = null;

	$output["mensagem"] = "Registros excluídos com sucesso!";
	$output["ok"] = true;
} catch (Exception $e) {
	$output["mensagem"] = "Erro durante a exclusão";
}
echo json_encode($output);