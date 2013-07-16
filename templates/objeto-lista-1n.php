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

		// exibição inicial da lista de dados
		carregaLista(id_usuario);

		// ativa campo de filtro na tabela
		Tables.showFilter('frmLista');

		// botão excluir
		$("#btnExcluir").click(function() {
			if (confirm('Excluir registros selecionados?')) {
				// chama serviço que exclui históricos do usuário
				$.post("../services/usuario-historico-excluir.php", $("#frmLista").serialize(), function(data) {
					if (data.ok) {
						carregaLista(id_usuario);
						Messages.info(data.mensagem);
					} else {
						Messages.error(data.mensagem);
					}
				}, "json");
			}
		});

		// botão edição
		$("#btnEdicao").click(function() {
			location = "../templates/objeto-edicao-1n.php?id_usuario=" + id_usuario;
		});

		// botão voltar
		$("#btnVoltar").click(function() {
			location = "../templates/objeto-edicao.php?id_usuario=" + id_usuario;
		});

	});

	// função que carrega a lista de dados e popula a tabela
	function carregaLista(id_usuario) {
		// chama serviço que retorna os históricos do usuário
		$.getJSON("../services/usuario-historico-lista.php", { "id_usuario" : id_usuario }, function(data) {
			$("#list-content").empty();
			$("#list-content").append($("#list-template").render(data.itens));

			$("h1").empty().append("Histórico de "+data.titulo);
		});
	}
	</script>
</head>
<body>
	<div class="container">
		<h1></h1>
		<p class="lead">Relação de objetos</p>

		<button id="btnVoltar" class="btn btn-primary"><i class="iconic-arrow-left"></i><span class="hidden-phone"> Voltar</span></button>
		<button id="btnEdicao" class="btn">Novo</button>
		<button id="btnExcluir" class="btn">Excluir</button>

		<div id="messages"></div>

		<form id="frmLista">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="center"><input type="checkbox" name="checkall" onclick="FormUtil.checkAll('frmLista')"></th>
						<th>Data</th>
						<th>Descrição</th>
					</tr>
				</thead>
				<tbody id="list-content">
				</tbody>
			</table>
		</form>

		<script id="list-template" type="text/x-jsrender">
		<tr>
			<td class="center"><input type="checkbox" name="sel[]" id="sel_{{>historico_id}}" value="{{>historico_id}}"></td>
			<td>{{>data_cadastro_f}}</td>
			<td><a href="../templates/objeto-edicao-1n.php?id_usuario={{>usuario_id}}&id_historico={{>historico_id}}">{{>descricao}}</a></td>
		</tr>
		</script>

	</div>
</body>
</html>