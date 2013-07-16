<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// captura ID do histórico
		var id_historico = getParameterByName('id_historico');

		// captura ID do usuário
		var id_usuario = getParameterByName('id_usuario');
		
		// chama serviço que carrega o histórico do usuário
		$.getJSON("../services/usuario-historico-consulta.php", { "id_historico" : id_historico, "id_usuario" : id_usuario }, function(data) {
			$("#f_data_cadastro").val(data.historico.data_cadastro_f);
			$("#f_descricao").val(data.historico.descricao);
			$("#f_historico_id").val(data.historico.historico_id);
			$("#f_usuario_id").val(data.usuario.usuario_id);

			$("h1").append("Histórico de "+data.usuario.nome_real);

			if (id_historico == 0) { // se for inclusão, chama o serviço que popula data de cadastro com data atual
				$.getJSON("../services/data-atual.php", function(data) {
					$("#f_data_cadastro").val(data.data_atual);
				});
			}
		});

		// botão salvar
		$("#btnSubmit").click(function() {
			// chama serviço que armazena os dados de histórico do usuário
			$.post("../services/usuario-historico-salvar.php", $("#frm").serialize(), function(data) {
				if (data.ok) {
					location = "../templates/objeto-lista-1n.php?id_usuario="+id_usuario;
				} else {
					Messages.error(data.erro);
				}
			}, "json");
		});

		// botão cancelar
		$("#btnCancelar").click(function() {
			location = "../templates/objeto-lista-1n.php?id_usuario="+id_usuario;
		});

		// datepicker no campo data
		$("#f_data_cadastro").datepicker();

		// máscara do campo data
		$("#f_data_cadastro").mask("99/99/9999");


	});
	</script>
</head>
<body>
	<div class="container">
		<h1></h1>
		<p class="lead">Preencha os campos abaixo</p>

		<div id="messages"></div>

		<form id="frm" class="form-horizontal">
			
			<input type="hidden" id="executed" name="executed" value="s">
			<input type="hidden" id="f_historico_id" name="f_historico_id" value="0">
			<input type="hidden" id="f_usuario_id" name="f_usuario_id" value="0">

			<div class="control-group">
				<label class="control-label" for="f_data_cadastro">Cadastro</label>
				<div class="controls">
					<input type="text" id="f_data_cadastro" name="f_data_cadastro" class="input-medium" placeholder="dd/mm/aaaa">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="f_descricao">Descrição</label>
				<div class="controls">
					<textarea id="f_descricao" name="f_descricao" rows="5" class="input-xxlarge"></textarea>
				</div>
			</div>

			<div class="form-actions">
				<button type="button" class="btn btn-primary" id="btnSubmit">Salvar</button>
				<button type="button" class="btn" id="btnCancelar">Fechar</button>
			</div>

		</form>
	</div>
</body>
</html>