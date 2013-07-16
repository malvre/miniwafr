<?php
include("../includes/common.php");

Security::verify(1);

$sql = "SELECT *, date_format(data_cadastro, '%d/%m/%Y') AS data_cadastro_f FROM usuario WHERE usuario_id=" . $_REQUEST["id_usuario"];
$row = DBH::getRow($sql);
echo json_encode($row);