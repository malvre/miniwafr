<?php
include("../includes/common.php");

Security::verify(1);

// Prepara dados de retorno
$result["ok"] = false;

// id do registro
$id = intval($_GET["id"]);
$ordem = intval($_GET["ordem"]) + 1;

$rows = array (
	"id_programa" => $id,
	"ordem" => $ordem
);
$db = new DBH();
$db->insert("grade_programacao", $rows);
$result["id"] = $db->lastInsertId();
$db = null;

$result["sucesso"] = "Programa adicionado!";
$result["ordem"] = $ordem;
$result["ok"] = true;

echo json_encode($result);