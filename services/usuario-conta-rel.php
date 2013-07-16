<?php
include("../includes/common.php");

$id_usuario = $_GET["id_usuario"];

$output = array();
$output["qtde_historico"] = DBH::getColumn("SELECT count(historico_id) FROM historico WHERE usuario_id=".$id_usuario);
$output["qtde_sistema"] = DBH::getColumn("SELECT count(sistema_id) FROM sistema_usuario WHERE usuario_id=".$id_usuario);

echo json_encode($output);