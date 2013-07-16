<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// exibição inicial da lista de dados
		carregaLista();

		// botão incluir
		$("#btnIncluir").click(function() {
			// chama o serviço que armazena os dados do departamento
			$.post("../services/departamento-salvar.php", $("#frmLista").serialize(), function(data) {
				if (data.ok) {
					carregaLista();
					$("#btnLimpar").click();
					Messages.info(data.mensagem);
				} else {
					Messages.error(data.erro);
				}
			}, "json");
		});

		// botão excluir
		$("#btnExcluir").click(function() {
			// chama o serviço que exclui os departamentos
			$.post("../services/departamento-excluir.php", $("#frmLista").serialize(), function(data) {
				if (data.ok) {
					carregaLista();
					Messages.info(data.mensagem);
				} else {
					Messages.error(data.erro);
				}
			}, "json");
		});

		// botão limpar
		$("#btnLimpar").click(function() {
			$("#f_departamento_id").val("");
			$("#f_nome_departamento").val("");
			$("#btnIncluir").html("Incluir");
			$("#f_nome_departamento").focus();
		});

		// foco no campo
		$("#f_nome_departamento").focus();

	});

	// carga da lista de dados
	function carregaLista() {
		$.getJSON("../services/departamento-lista.php", function(data) {
			$("#list-content").empty();
			$("#list-content").append("<tr><td></td><td><input type='text' name='f_nome_departamento' id='f_nome_departamento' class='input-xlarge'></td></tr>");
			$("#list-content").append($("#list-template").render(data.itens));
		});
	}

	// entra no modo de edição
	function preparaEdicao(id, valor) {
		$("#f_departamento_id").val(id);
		$("#f_nome_departamento").val(valor);
		$("#btnIncluir").html("Salvar");
		$("#f_nome_departamento").focus();
	}
	</script>
</head>
<body>
	<div class="container">
		<h1>MiniCRUD</h1>
		<p class="lead">Lista, Inclusão, Alteração e Exclusão de registros</p>

		<button id="btnIncluir" class="btn">Incluir</button>
		<button id="btnLimpar" class="btn">Limpar</button>
		<button id="btnExcluir" class="btn">Excluir</button>

		<div id="messages"></div>

		<form id="frmLista">
			<input type="hidden" name="f_departamento_id" id="f_departamento_id">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="center"><input type="checkbox" name="checkall" onclick="FormUtil.checkAll('frmLista')"></th>
						<th>Departamento</th>
					</tr>
				</thead>
				<tbody id="list-content">
				</tbody>
			</table>
		</form>

		<script id="list-template" type="text/x-jsrender">
		<tr>
			<td class="center"><input type="checkbox" name="sel[]" id="sel_{{>departamento_id}}" value="{{>departamento_id}}"></td>
			<td><a href="#" onclick="preparaEdicao({{>departamento_id}},'{{>nome_departamento}}')">{{>nome_departamento}}<a/></td>
		</tr>
		</script>

	</div>
</body>
</html>