<?php
include("../includes/common.php");

$rows = DBH::getRows("SELECT sistema_id as id, nome_sistema as label FROM sistema ORDER BY nome_sistema");
echo json_encode($rows);
