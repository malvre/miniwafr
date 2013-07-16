<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {

		// campo multiselect
		$.getJSON("../services/sistema-select.php", function(result) {

			// monta itens do select
			var options = '';
			$.each(result, function() {
				options += '<option value="' + this.id + '">' + this.label + '</option>';
			});
			$("#f_sistemas").append(options);

			// aplica aparência
			$("#f_sistemas").multiselect();

			// exemplo de itens selecionados
			var selected = "2,4,6";
			var arraySelected = selected.split(",");
			$("#f_sistemas").val(arraySelected);
			$("#f_sistemas").multiselect("refresh");

		});

		// botão submit
		$("#btnSubmit").click(function() {
			if ($("#f_sistemas").val()) {
				Messages.info("Valores selecionados: "+$("#f_sistemas").val().join(", "));
			} else {
				Messages.info("Nenhum item selecionado");
			}
		});


	});
	</script>
</head>
<body>
	<div class="container">
		<h1>Exemplo de MultiSELECT</h1>
		<p class="lead">Relacionamento N:N</p>
		
		<div id="messages"></div>
		
		<form id="frm" class="form-horizontal">

			<div class="control-group">
				<label class="control-label" for="f_sistemas">Sistemas</label>
				<div class="controls">
					<select id="f_sistemas" name="f_sistemas[]" class="multiselect"></select>
				</div>
			</div>

			<div class="form-actions">
				<button type="button" class="btn btn-primary" id="btnSubmit">Capturar valores selecionados</button>
			</div>

		</form>
		
	</div>
</body>
</html>
