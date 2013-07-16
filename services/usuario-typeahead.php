<?php
include("../includes/common.php");

$rows = DBH::getRows("SELECT usuario_id, nome_real FROM usuario WHERE nome_real LIKE '%".$_GET["q"]."%' ORDER BY nome_real", 50);

// lista de array key => value
$array = array();
foreach ($rows as $row) {
	$array[$row["usuario_id"]] = $row["nome_real"];
}

echo json_encode($array);