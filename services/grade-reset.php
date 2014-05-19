<?php
include("../includes/common.php");

Security::verify(1);


try {
	$db = new DBH();
	$db->delete("grade_programacao", "1=1");
	$db = null;

	$output["mensagem"] = "Registros excluídos com sucesso!";
	$output["ok"] = true;
} catch (Exception $e) {
	$output["mensagem"] = "Erro durante a exclusão";
}
echo json_encode($output);