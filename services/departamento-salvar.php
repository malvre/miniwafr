<?php
include("../includes/common.php");

Security::verify(2);

// Prepara dados de retorno
$result["ok"] = false;

// campos do formulário
$id_departamento = intval($_POST["f_departamento_id"]);
$nome_departamento = $_POST["f_nome_departamento"];

// Validação
$error = new Error();
if ($_POST["f_nome_departamento"] == "") $error->add('Nome do departamento deve ser informado.');

// Atualização dos dados
if ($error->hasError()) {
	$result["erro"] = $error->toString();
} else {
	$rows = array (
		"nome_departamento" => $nome_departamento
	);
	$db = new DBH();
	if ($id_departamento > 0) {
		$db->update("departamento", $rows, "departamento_id=" . $id_departamento);
		$result["mensagem"] = "Departamento <strong>$nome_departamento</strong> atualizado";
	} else {
		$db->insert("departamento", $rows);
		$result["mensagem"] = "Departamento <strong>$nome_departamento</strong> incluído";
	}
	$db = null;
	
	$result["ok"] = true;
}
echo json_encode($result);