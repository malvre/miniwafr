<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// carrega lista quando a janela modal for exibida
		$('#myModal').on('show', function () {
			carregaLista("");
		});

		// esvazia a lista quando a janela desaparecer
		$('#myModal').on('hide', function() {
			$("#f_search").val("");
			$("#lista-lov").empty();
		});

		// botão de pesquisa
		$("#btnSearch").click(function() {
			carregaLista($("#f_search").val());
		});

		// botão que limpa campos
		$("#btnLimpaUsuario").click(function() {
			$("#f_usuario").val("");
			$("#f_id").val("");
		});
	});

	// função que carrega lista de dados na tabela
	function carregaLista(search) {
		$.getJSON("../services/usuario-lista.php", {"search" : search }, function(data) {
			$("#lista-lov").empty();
			$("#lista-lov").append($("#lista-lov-template").render(data.itens));
		});
	}

	// função que transfere dados do registro selecionado para os campos do formulário
	function transfereUsuario(id, nome) {
		$("#f_usuario").val(nome);
		$("#f_id").val(id);
		$("#myModal").modal("hide");
	}
	</script>
</head>
<body>
	<div class="container">
		<h1>Exemplo de LOV</h1>
		<p class="lead">List Of Values</p>
		
		<div id="messages"></div>
		
		<form id="frm" class="form-horizontal">

			<div class="control-group">
				<label class="control-label" for="f_usuario">Usuário</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" id="f_usuario" name="f_usuario" class="input-xlarge uneditable-input" readonly="readonly">
						<a href="#myModal" role="button" class="btn" data-toggle="modal"><i class="iconic-magnifying-glass"></i></a>
						<a id="btnLimpaUsuario" href="#" class="btn"><i class="iconic-trash"></i></a>
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="f_id">ID</label>
				<div class="controls">
					<input type="text" id="f_id" name="f_id" class="input-mini" disabled>
				</div>
			</div>

			<div class="form-actions">
				<button type="button" class="btn btn-primary" id="btnSubmit">Enviar</button>
			</div>

		</form>
		
	</div>
















	<!-- Modal -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Título</h3>
		</div>
		<div class="modal-body">
			<form class="form">
				<div class="input-append">
					<input class="span2" id="f_search" name="f_search" type="text" placeholder="Busca">
					<button class="btn" id="btnSearch" type="button"><i class="iconic-magnifying-glass"></i></button>
				</div>
			</form>
			<ul id="lista-lov" class="nav nav-tabs nav-stacked">
			</ul>
		</div>
		<div class="modal-footer">
		</div>
	</div>

	<script id="lista-lov-template" type="text/x-jsrender">
	<li><a href="#" onclick="transfereUsuario({{>usuario_id}},'{{>nome_real}}')">{{>nome_real}}</a></li>
	</script>




</body>
</html>
