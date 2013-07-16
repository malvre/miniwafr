<?php
include("../includes/common.php");

Security::verify(2);

$output = array();
$output["itens"] = DBH::getRows("SELECT * FROM departamento ORDER BY nome_departamento");
echo json_encode($output);