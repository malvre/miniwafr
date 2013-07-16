<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// carrega select de departamentos
		$("#f_departamento_id").populaSELECT({ url: "../services/departamento-select.php", defaultValue: null });

		// botão de submit
		$("#btnSubmit").click(function() {
			// chama serviço de pesquisa de usuários
			$.post("../services/usuario-pesquisa.php", $("#frmPesquisa").serialize(), function(dados) {
				if (dados.ok == true) {
					location = "../templates/objeto-lista.php";
				}
			}, "json");
		});

		// foco no primeiro campo texto
		$("input[type=text]:visible:first").focus();

		// aciona o botão ao pressionar ENTER
		FormUtil.mapEnterKey("btnSubmit");
	});
	</script>
</head>
<body>
	<div class="container">
		<h1>Pesquisa</h1>
		<p class="lead">Preencha os campos com os critérios de sua busca</p>

		<form id="frmPesquisa" class="form-horizontal">
			<input type="hidden" name="executed" value="s">
			<div class="control-group">
				<label class="control-label" for="f_usuario">Nome de usuário</label>
				<div class="controls">
					<input type="text" id="f_usuario" name="f_usuario" class="input-xlarge">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="f_nome_completo">Nome completo</label>
				<div class="controls">
					<input type="text" id="f_nome_completo" name="f_nome_completo" class="input-xlarge">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="f_departamento_id">Departamento</label>
				<div class="controls">
					<select id="f_departamento_id" name="f_departamento_id" class="input-xlarge">
						<option value="null">Todos</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="f_situacao">Situação</label>
				<div class="controls">
					<select id="f_situacao" name="f_situacao" class="input-medium">
						<option value="">Todos</option>
						<option value="1">Ativos</option>
						<option value="0">Inativos</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="button" class="btn btn-primary" id="btnSubmit"><i class="iconic-magnifying-glass"></i> Pesquisar</button>
				</div>
			</div>

		</form>
	</div>
</body>
</html>