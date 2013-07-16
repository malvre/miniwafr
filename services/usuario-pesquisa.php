<?php
include("../includes/common.php");

Security::verify(1);

$where = new Where();

$where->add("Nome de usuário contém '*'", "AND usuario.nome_usuario LIKE '%*%'", $_POST["f_usuario"], $_POST["f_usuario"] != "");
$where->add("Nome completo contém '*'", "AND usuario.nome_real LIKE '%*%'", $_POST["f_nome_completo"], $_POST["f_nome_completo"] != "");

$sit = intval($_POST["f_situacao"])==1?"Ativo":"Inativo";
$where->add("Situação = $sit", "AND usuario.ativo=*", $_POST["f_situacao"], $_POST["f_situacao"] != "");

$txtDep = DBH::getColumn("SELECT nome_departamento FROM departamento WHERE departamento_id=" . intval($_POST["f_departamento_id"]));
$where->add("Departamento = " . $txtDep, "AND usuario.departamento_id=*", intval($_POST["f_departamento_id"]), intval($_POST["f_departamento_id"]) > 0);

$where->handleWhere();

$output = array();
$output["ok"] = true;
$output["debug"] = $_POST["f_usuario"];

echo json_encode($output);