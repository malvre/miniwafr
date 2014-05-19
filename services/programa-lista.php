<?php
include("../includes/common.php");

Security::verify(1);

$output = array();

$where = "";
if (strlen($_GET["search"])>0) $where = " WHERE nome_programa LIKE '%" . $_GET["search"] . "%' ";

$sql = "SELECT *, TIME_FORMAT(SEC_TO_TIME(duracao),'%Hh %im') as duracao_display FROM programa " . $where . "ORDER BY nome_programa";

$output["itens"] = DBH::getRows($sql);

echo json_encode($output);
