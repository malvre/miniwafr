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

		// ativa campo de filtro na tabela
		Tables.showFilter('frmLista');

		// botão excluir
		$("#btnExcluir").click(function() {
			if (confirm('Excluir registros selecionados?')) {
				// chama serviço que exclui os usuários
				$.post("../services/usuario-excluir.php", $("#frmLista").serialize(), function(data) {
					if (data.ok) {
						carregaLista();
						Messages.info(data.mensagem);
					} else {
						Messages.error(data.mensagem);
					}
				}, "json");
			}
		});

	});

	// função que carrega a lista de dados na tabela
	function carregaLista() {
		$.getJSON("../services/usuario-lista.php", function(data) {
			$("#list-content").empty();
			$("#list-content").append($("#list-template").render(data.itens));
			Messages.where(data.mensagem);
		});
	}
	</script>
</head>
<body>
	<div class="container">
		<h1>Lista</h1>
		<p class="lead">Relação de objetos</p>

		<a href="../templates/objeto-pesquisa.php" class="btn"><i class="iconic-magnifying-glass"></i><span class="hidden-phone"> Pesquisa</span></a>
		<a href="../templates/objeto-edicao.php" class="btn"><i class="iconic-plus"></i><span class="hidden-phone"> Novo Objeto</span></a>
		<button id="btnExcluir" class="btn"><i class="iconic-trash"></i> Excluir</button>

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
						<th class="center">Ativo</th>
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
			<td class="center"><span class="label {{if ativo==1}}label-success{{else}}label-important{{/if}}">{{>ativo_f}}</span></td>
		</tr>
		</script>

	</div>
</body>
</html>