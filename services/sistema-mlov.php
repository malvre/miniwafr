<?php
include("../includes/common.php");

Security::verify(1);

$output = array();

$id_usuario = intval($_GET["id_usuario"]);
$search = $_GET["search"];

$where = "";
if (strlen($search)>0) $where = " AND nome_sistema LIKE '%{$search}%' ";

$sqlNotIn = "SELECT sistema_id FROM sistema_usuario WHERE usuario_id=".$id_usuario;
$sql = "SELECT * FROM sistema WHERE sistema_id NOT IN ($sqlNotIn) $where ORDER BY nome_sistema";

$output["itens"] = DBH::getRows($sql);
$output["titulo"] = DBH::getColumn("SELECT usuario.nome_real FROM usuario WHERE usuario_id=".$_GET["id_usuario"]);

echo json_encode($output);