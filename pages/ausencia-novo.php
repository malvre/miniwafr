<?php
// Arquivo de teste. Desconsiderar


include_once("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {

		$("#f_setores").val("STD".split(","));
		$("#f_setores").multiselect();
		$("#f_ldap").multiselect();
		$("#f_pessoas").multiselect();

		$("#f_data_saida").datepicker();
		$("#f_data_retorno").datepicker();

		$("#f_nome_funcionario,#f_substituto").typeahead({
			source: ["Marcelo Rezende","Marcio Morales","Matheus Schmidt","Sandro Londero","Everton Canez","Anamaria Becker", "Mauro Valle", "Barak Obama"]
		});

		// botão salvar
		$("#btnSubmit").click(function() {
			Messages.info("Comunicado de ausência enviado com sucesso.");
		});

		$("#f_nome_funcionario").focus();

	});
	</script>
</head>
<body>
	<div class="container">
		<h1>Novo comunicado de ausência</h1>
		<p class="lead">Preencha os campos abaixo</p>

		<div id="messages"></div>

		<form id="frm" class="form-horizontal">
			<div class="row">
				<div class="span6">

					<legend>Dados da ausência</legend>

					<div class="control-group">
						<label class="control-label" for="f_nome_funcionario">Nome do funcionário</label>
						<div class="controls">
							<input type="text" id="f_nome_funcionario" name="f_nome_funcionario" class="input-xlarge">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_data_saida">Saída</label>
						<div class="controls">
							<input type="text" id="f_data_saida" name="f_data_saida" class="input-small" data-mask="99/99/9999">
							<input type="text" id="f_hora_saida" name="f_hora_saida" class="input-mini" data-mask="99:99">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_data_retorno">Retorno</label>
						<div class="controls">
							<input type="text" id="f_data_retorno" name="f_data_retorno" class="input-small" data-mask="99/99/9999">
							<input type="text" id="f_hora_retorno" name="f_hora_retorno" class="input-mini" data-mask="99:99">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_motivo">Motivo</label>
						<div class="controls">
							<select id="f_motivo" name="f_motivo" class="input-xlarge">
								<option value="null">-- Selecione --</option>
								<option value="Exame médico">Exame médico</option>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_substituto">Substituto</label>
						<div class="controls">
							<input type="text" id="f_substituto" name="f_substituto" class="input-xlarge">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_obs">Observações</label>
						<div class="controls">
							<textarea id="f_obs" name="f_obs" rows="2" class="input-xlarge"></textarea>
						</div>
					</div>


				</div>

				<div class="span6">
					<legend>Avisos</legend>

					<div class="control-group">
						<label class="control-label" for="f_setores">Setores</label>
						<div class="controls">
							<select id="f_setores" name="f_setores[]" class="multiselect" multiple="multiple">
								<option value="STD">STD</option>
								<option value="STE">STE</option>
								<option value="SMO">SMO</option>
								<option value="SSW">SSW</option>
								<option value="STR">STR</option>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_ldap">Grupos LDAP</label>
						<div class="controls">
							<select id="f_ldap" name="f_ldap[]" class="multiselect" multiple="multiple">
								<option value="1">Suporte MS</option>
								<option value="2">Suporte JAVA</option>
								<option value="3">Oracle</option>
								<option value="4">Gestão Conhecimento</option>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_pessoas">Pessoas</label>
						<div class="controls">
							<select id="f_pessoas" name="f_pessoas" class="multiselect" multiple="multiple">
								<option value="1">Sandro Eduardo Londero</option>
								<option value="2">Marcelo Alves Rezende</option>
								<option value="3">Anamaria Macedo Becker</option>
								<option value="4">Everton Canez</option>
							</select>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<label class="checkbox"><input type="checkbox" id="f_guardar" name="f_guardar" value="1" checked="checked">Lembrar os destinatários na próxima vez</label>
						</div>
					</div>

				</div>

			</div>
			<div class="row">
				<div class="span12">
					<div class="form-actions">
						<button type="button" class="btn btn-primary" id="btnSubmit">Enviar</button>
					</div>
				</div>
			</div>
		</form>


	</div>
</body>
</html>