<?php
include("../includes/common.php");

Security::verify(1);

$output = array();

$output["historico"] = DBH::getRow("SELECT *, date_format(data_cadastro, '%d/%m/%Y') as data_cadastro_f FROM historico WHERE historico_id=".$_GET["id_historico"]);
$output["usuario"] = DBH::getRow("SELECT * FROM usuario WHERE usuario_id=".$_GET["id_usuario"]);

echo json_encode($output);