<?php
include("../includes/common.php");

Security::verify(1);

// Prepara dados de retorno
$result["ok"] = false;

$arrayProgramas = explode(",", $_GET["ids"]);

$db = new DBH();
$db->delete("grade_programacao", "1=1");
for ($i=0; $i < sizeof($arrayProgramas); $i++) { 
	$rows = array (
		"id_programa" => $arrayProgramas[$i],
		"ordem" => $i+1
	);
	$db->insert("grade_programacao", $rows);
}
$db = null;

$result["sucesso"] = "Programas adicionados!";
$result["ok"] = true;

echo json_encode($result);