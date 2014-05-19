<?php
include("../includes/common.php");

Security::verify(1);

// Prepara dados de retorno
$result["ok"] = false;

$id = intval($_GET["id"]);
$ordem = intval($_GET["ordem"]);
$direcao = $_GET["direcao"];

$min = DBH::getColumn("select min(ordem) from grade_programacao");
$max = DBH::getColumn("select max(ordem) from grade_programacao");

$id_ant = DBH::getColumn("select id from grade_programacao where ordem = ".($ordem-1));
$id_prox = DBH::getColumn("select id from grade_programacao where ordem = ".($ordem+1));

$error = new Error();

if (($ordem == $max) && ($direcao == "down")) $error->add('Programa já é o último.');
if (($ordem == $min) && ($direcao == "up")) $error->add('Programa já é o primeiro.');

// Atualização dos dados
if ($error->hasError()) {
	$result["erro"] = $error->toString();
} else {

	$db = new DBH();
	
	if ($direcao == "up") {
		$rows1 = array(
			"ordem" => intval($ordem)-1
		);
		$db->update("grade_programacao", $rows1, "id=" . $id);

		$rows2 = array(
			"ordem" => intval($ordem)
		);
		$db->update("grade_programacao", $rows2, "id=" . $id_ant);
	}

	if ($direcao == "down") {
		$rows1 = array(
			"ordem" => intval($ordem)+1
		);
		$db->update("grade_programacao", $rows1, "id=" . $id);

		$rows2 = array(
			"ordem" => intval($ordem)
		);
		$db->update("grade_programacao", $rows2, "id=" . $id_prox);
	}
	
	$db = null;
	$result["ok"] = true;
}
echo json_encode($result);