<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
		$(document).ready(function() {

			// typeahead
			$("#f_nome").typeahead({
				source: "../services/usuario-typeahead.php"
			});

			// botão enviar
			$("#btnSubmit").click(function() {
				Messages.info("ID selecionado: " + $("#f_nome").data("value"));
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<h1>Exemplo de Typeahead</h1>
		<p class="lead">Mais conhecido como autocomplete</p>

		<div id="messages"></div>

		<form id="frm" class="form-horizontal">
			
			<div class="control-group">
				<label class="control-label" for="f_nome">Nome</label>
				<div class="controls">
					<input type="text" id="f_nome" name="f_nome" class="input-large">
				</div>
			</div>

			<div class="form-actions">
				<button type="button" class="btn btn-primary" id="btnSubmit">Enviar</button>
			</div>
			
		</form>

	</div>
</body>
</html>