<?php
include("../includes/common.php");

$rows = DBH::getRows("SELECT departamento_id as id, nome_departamento as label FROM departamento ORDER BY nome_departamento");
echo json_encode($rows);
