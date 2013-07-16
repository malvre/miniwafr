<?php
include("../includes/common.php");

Security::verify(1);

$output = array();

$output["itens"] = DBH::getRows("SELECT *, date_format(data_cadastro, '%d/%m/%Y') as data_cadastro_f FROM historico WHERE usuario_id=" . $_GET["id_usuario"] . " ORDER BY data_cadastro DESC");
$output["titulo"] = DBH::getColumn("SELECT usuario.nome_real FROM usuario WHERE usuario_id=".$_GET["id_usuario"]);

echo json_encode($output);
