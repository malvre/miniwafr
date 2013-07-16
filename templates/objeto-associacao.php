<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
		$(document).ready(function() {
			// captura ID do usuário
			var id_usuario = getParameterByName('id_usuario');

			// armazena ID do usuário em campo do formulário
			$("#f_usuario_id").val(id_usuario);

			// exibição inicial da lista de dados
			carregaLista(id_usuario);

			// ativa campo filtro da tabela
			Tables.showFilter('frmLista');

			// botão excluir
			$("#btnRemover").click(function() {
				if (confirm('Remover registros associados?')) {
					// chama serviço que exclui o relacionamento entre usuário e sistema
					$.post("../services/usuario-sistema-excluir.php", $("#frmLista").serialize(), function(data) {
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
			$("#btnAdicionar").click(function() {
				location = "../templates/objeto-mlov.php?id_usuario=" + id_usuario;
			});

			// botão voltar
			$("#btnVoltar").click(function() {
				location = "../templates/objeto-edicao.php?id_usuario=" + id_usuario;
			});

		});

		// função que carrega lista de dados na tabela
		function carregaLista(id_usuario) {
			$.getJSON("../services/usuario-sistema-lista.php", { "id_usuario" : id_usuario }, function(data) {
				$("#list-content").empty();
				$("#list-content").append($("#list-template").render(data.itens));

				$("h1").empty().append("Sistemas de "+data.titulo);
			});
		}
	</script>
</head>
<body>
	<div class="container">
		<h1></h1>
		<p class="lead">Relação de objetos</p>

		<button id="btnVoltar" class="btn btn-primary"><i class="iconic-arrow-left"></i><span class="hidden-phone"> Voltar</span></button>
		<button id="btnAdicionar" class="btn">Adicionar</button>
		<button id="btnRemover" class="btn">Remover</button>

		<div id="messages"></div>

		<form id="frmLista">
			<input type="hidden" name="f_usuario_id" id="f_usuario_id">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="center"><input type="checkbox" name="checkall" onclick="FormUtil.checkAll('frmLista')"></th>
						<th>Nome do sistema</th>
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