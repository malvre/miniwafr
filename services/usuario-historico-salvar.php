<?php
include("../includes/common.php");

Security::verify(3);

// Prepara dados de retorno
$result["ok"] = false;

// id do registro
$id_historico = intval($_POST["f_historico_id"]);

// Validação
$error = new Error();

if ($_POST["f_descricao"] == "") $error->add('Descrição deve ser informada.');
if ($_POST["f_data_cadastro"] == "") $error->add('Data de cadastro deve ser informada.');
if (!Validation::date($_POST["f_data_cadastro"])) $error->add('Data inválida');

// Atualização dos dados
if ($error->hasError()) {
	$result["erro"] = $error->toString();
} else {
	$rows = array (
		"data_cadastro" => Dates::format($_POST["f_data_cadastro"]),
		"descricao" => $_POST["f_descricao"],
		"usuario_id" => intval($_POST["f_usuario_id"])
	);
	$db = new DBH();
	if ($id_historico > 0) {
		$db->update("historico", $rows, "historico_id=" . $id_historico);
	} else {
		$db->insert("historico", $rows);
		$result["id"] = $db->lastInsertId();
	}
	$db = null;

	$result["ok"] = true;
}
echo json_encode($result);