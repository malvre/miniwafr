<?php
include("../includes/common.php");

Security::verify(1);

$output = array();

$output["itens"] = DBH::getRows("SELECT sistema.* FROM sistema, sistema_usuario WHERE sistema.sistema_id=sistema_usuario.sistema_id AND sistema_usuario.usuario_id=" . $_GET["id_usuario"] . " ORDER BY nome_sistema");
$output["titulo"] = DBH::getColumn("SELECT usuario.nome_real FROM usuario WHERE usuario_id=".$_GET["id_usuario"]);

echo json_encode($output);
