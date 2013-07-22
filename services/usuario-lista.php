<?php
include("../includes/common.php");

Security::verify(1);

$output = array();

$where = "";
if (strlen($_GET["search"])>0) $where = " AND usuario.nome_real LIKE '%" . $_GET["search"] . "%' ";

$sql = "SELECT usuario.*, departamento.nome_departamento, date_format(data_cadastro, '%d/%m/%Y') AS data_cadastro_f, if(ativo=1,'Sim','Não') as ativo_f " .
		"FROM usuario, departamento " .
		"WHERE usuario.departamento_id=departamento.departamento_id " .
		Where::getWhere() .
		$where .
		"ORDER BY usuario.nome_usuario";

$output["itens"] = DBH::getRows($sql);
$output["mensagem"] = Where::getMensagemFiltro();

echo json_encode($output);
