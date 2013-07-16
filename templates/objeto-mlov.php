<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// captura o ID do usuário
		var id_usuario = getParameterByName('id_usuario');

		// guarda o id do usuário no formulário
		$("#f_usuario_id").val(id_usuario);

		// exibição inicial da lista de dados
		carregaLista(id_usuario, "");

		// botão voltar
		$("#btnVoltar").click(function() {
			location = "../templates/objeto-associacao.php?id_usuario=" + id_usuario;
		});

		// botão busca
		$("#btnBusca").click(function() {
			carregaLista(id_usuario, $("#f_busca").val());
		});

		// botão selecionar
		$("#btnSelecionar").click(function() {
			// chama o serviço que associa os sistemas ao usuário
			$.post("../services/usuario-sistema-associar.php", $("#frmLista").serialize(), function(data) {
				if (data.ok) {
					carregaLista(id_usuario, "");
					Messages.info("Sistemas associados com sucesso");
				} else {
					Messages.error(data.erro);
				}
			}, "json");
		});

	});

	// função de montagem da lista de dados
	function carregaLista(id_usuario, str) {
		$.getJSON("../services/sistema-mlov.php", { "id_usuario" : id_usuario, "search" : str }, function(data) {
			$("#list-content").empty();
			$("#list-content").append($("#list-template").render(data.itens));

			$("h1").empty().append("Sistemas disponíveis para "+data.titulo);
		});
	}

	</script>
</head>
<body>
	<div class="container">
		<h1></h1>
		<p class="lead">Selecione os objetos</p>

		<button id="btnVoltar" class="btn btn-primary"><i class="iconic-arrow-left"></i><span class="hidden-phone"> Voltar</span></button>
		<button id="btnSelecionar" class="btn"><i class="iconic-check"></i><span class="hidden-phone"> Selecionar</span></button>

		<div class="pull-right input-append">
			<input type="text" name="f_busca" id="f_busca" class="span2" style="width: 150px">
			<button id="btnBusca" class="btn"><i class="icon-search"></i><span class="hidden-phone"> Busca</span></button>
		</div>

		<div id="messages"></div>

		<form id="frmLista">
			<input type="hidden" name="f_usuario_id" id="f_usuario_id">

			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="center"><input type="checkbox" name="checkall" onclick="FormUtil.checkAll('frmLista')"></th>
						<th>Nome do Sistema</th>
					</tr>
				</thead>
				<tbody id="list-content">
				</tbody>
			</table>
		</form>

		<script id="list-template" type="text/x-jsrender">
		<tr>
			<td class="center"><input type="checkbox" name="sel[]" id="sel_{{>sistema_id}}" value="{{>sistema_id}}"></td>
			<td>{{>nome_sistema}}</td>
		</tr>
		</script>

	</div>
</body>
</html>