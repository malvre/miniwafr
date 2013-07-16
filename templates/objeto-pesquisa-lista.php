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
		carregaLista("");

		// botão excluir
		$("#btnExcluir").click(function() {
			if (confirm('Excluir registros selecionados?')) {
				// chama serviço de exclusão de usuários
				$.post("../services/usuario-excluir.php", $("#frmLista").serialize(), function(data) {
					if (data.ok) {
						carregaLista("");
						Messages.info(data.mensagem);
					} else {
						Messages.error(data.mensagem);
					}
				}, "json");
			}
		});

		// botão busca
		$("#btnBusca").click(function() {
			carregaLista($("#f_busca").val());
		});

	});

	// função de montagem da lista de dados
	function carregaLista(str) {
		$.getJSON("../services/usuario-lista.php", { "search" : str }, function(data) {
			$("#list-content").empty();
			$("#list-content").append($("#list-template").render(data.itens));
		});
	}
	</script>
</head>
<body>
	<div class="container">
		<h1>Pesquisa Lista</h1>
		<p class="lead">Relação de objetos</p>

		<a href="../templates/objeto-edicao.php" class="btn"><i class="iconic-plus"></i><span class="hidden-phone"> Novo Objeto</span></a>
		<button id="btnExcluir" class="btn"><i class="iconic-trash"></i><span class="hidden-phone"> Excluir</span></button>
		<div class="pull-right input-append">
			<input type="text" name="f_busca" id="f_busca" class="span2" style="width: 150px" placeholder="Nome do usuário">
			<button id="btnBusca" class="btn"><i class="iconic-magnifying-glass"></i></button>
		</div>

		<div id="messages"></div>

		<form id="frmLista">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="center"><input type="checkbox" name="checkall" onclick="FormUtil.checkAll('frmLista')"></th>
						<th>Nome</th>
						<th class="hidden-phone">Usuário</th>
						<th class="hidden-phone">Cadastro</th>
						<th class="hidden-phone">E-mail</th>
						<th class="hidden-phone">Departamento</th>
						<th class="hidden-phone center">Ativo</th>
					</tr>
				</thead>
				<tbody id="list-content">
				</tbody>
			</table>
		</form>

		<script id="list-template" type="text/x-jsrender">
		<tr>
			<td class="center"><input type="checkbox" name="sel[]" id="sel_{{>usuario_id}}" value="{{>usuario_id}}"></td>
			<td><a href="../templates/objeto-edicao.php?id_usuario={{>usuario_id}}">{{>nome_real}}</a></td>
			<td class="hidden-phone">{{>nome_usuario}}</td>
			<td class="hidden-phone">{{>data_cadastro_f}}</td>
			<td class="hidden-phone">{{>email}}</td>
			<td class="hidden-phone">{{>nome_departamento}}</td>
			<td class="hidden-phone center">{{>ativo_f}}</td>
		</tr>
		</script>
	</div>
</body>
</html>