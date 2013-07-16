<?php
include("../includes/common.php");

Security::verify(3);

// Prepara dados de retorno
$result["ok"] = false;

// id do registro
$id = intval($_POST["f_usuario_id"]);

// Validação
$error = new Error();

if ($_POST["f_nome_usuario"] == "") $error->add('Nome de usuário deve ser informado.');
if ($_POST["f_nome_completo"] == "") $error->add('Nome deve ser informado.');
if ($id == 0) {
	if ($_POST["f_senha"] == "") $error->add('Senha deve ser informada.');
	if (strlen($_POST["f_senha"]) < 6) $error->add('Senha deve ter 6 ou mais caracteres.');
}
if (DBVal::isDuplicated("usuario", "nome_usuario", "usuario_id", $_POST["f_nome_usuario"], $id)) $error->add('Nome de usuário já existe.');
if (!Validation::date($_POST["f_data_cadastro"])) $error->add('Data inválida');

// Atualização dos dados
if ($error->hasError()) {
	$result["erro"] = $error->toString();
} else {
	$rows = array (
		"data_cadastro" => Dates::format($_POST["f_data_cadastro"]),
		"nome_usuario" => $_POST["f_nome_usuario"],
		"nivel_acesso" => $_POST["f_nivel_acesso"],
		"nome_real" => $_POST["f_nome_completo"],
		"departamento_id" => intval($_POST["f_departamento_id"]),
		"email" => $_POST["f_email"],
		"descricao" => $_POST["f_descricao"],
		"ativo" => $_POST["f_ativo"]==1?1:0
	);
	$db = new DBH();
	if ($id > 0) {
		$db->update("usuario", $rows, "usuario_id=" . $id);
	} else {
		$rows["senha"] = sha1($_POST["f_senha"]);
		$db->insert("usuario", $rows);
		$result["id"] = $db->lastInsertId();
	}
	$db = null;

	$result["sucesso"] = "Dados atualizados com sucesso!";
	$result["ok"] = true;
}
echo json_encode($result);