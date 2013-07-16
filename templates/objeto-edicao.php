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
		
		// popula campos
		if (id_usuario > 0) {
			$(".remove-edicao").remove(); // remove os elementos em edição

			// chama serviço que carrega os dados do usuário
			$.getJSON("../services/usuario-consulta.php", { "id_usuario" : id_usuario }, function(data) {
				$("#f_usuario_id").val(data.usuario_id);
				$("#f_data_cadastro").val(data.data_cadastro_f);
				$("#f_nome_usuario").val(data.nome_usuario);
				$("#f_nome_completo").val(data.nome_real);
				$("#f_email").val(data.email);
				FormUtil.setRadioValue("f_nivel_acesso", data.nivel_acesso);
				$("#f_descricao").val(data.descricao);
				$("#f_ativo").attr("checked", data.ativo == 1);
				$("#f_departamento_id").populaSELECT({ url: "../services/departamento-select.php", defaultValue: data.departamento_id });

				// chama serviço que retorna as contagens dos relacionamentos
				$.getJSON("../services/usuario-conta-rel.php", { "id_usuario" : id_usuario }, function(data) {
					$("#linkHistorico span").html(data.qtde_historico);
					$("#linkSistemas span").html(data.qtde_sistema);
				});
			});

			// link para a página de históricos do usuário
			$("#linkHistorico").click(function() {
				location = "../templates/objeto-lista-1n.php?id_usuario="+id_usuario;
			});

			// link para a página de sistemas associados ao usuário
			$("#linkSistemas").click(function() {
				location = "../templates/objeto-associacao.php?id_usuario="+id_usuario;
			});
		} else {
			$(".remove-inclusao").remove(); // remove os elementos em inclusao
			$("#f_departamento_id").populaSELECT({ url: "../services/departamento-select.php", defaultValue: null });
			$.getJSON("../services/data-atual.php", function(data) {
				$("#f_data_cadastro").val(data.data_atual);
			});
		}

		// botão salvar
		$("#btnSubmit").click(function() {
			// chama serviço que armazena os dados do usuário
			$.post("../services/usuario-salvar.php", $("#frm").serialize(), function(data) {
				if (data.ok) {
					location = "../templates/objeto-lista.php";
				} else {
					Messages.error(data.erro);
					Page.top();
				}
			}, "json");
		});

		// datepicker para o campo data de cadastro
		$("#f_data_cadastro").datepicker();

		// foco no campo
		$("#f_nome_usuario").focus();

	});
	</script>
</head>
<body>
	<div class="container">
		<h1>Edição</h1>
		<p class="lead">Preencha os campos abaixo</p>

		<div id="messages"></div>

		<div class="row">
			<div class="span9">
				<form id="frm" class="form-horizontal">
					<legend>Dados gerais</legend>
			
					<input type="hidden" id="executed" name="executed" value="s">
					<input type="hidden" id="f_usuario_id" name="f_usuario_id" value="0">

					<div class="control-group">
						<label class="control-label" for="f_data_cadastro">Cadastro</label>
						<div class="controls">
							<input type="text" id="f_data_cadastro" name="f_data_cadastro" class="input-medium" data-mask="99/99/9999" placeholder="dd/mm/aaaa">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_nome_usuario">Nome de usuário</label>
						<div class="controls">
							<input type="text" id="f_nome_usuario" name="f_nome_usuario" class="input-medium" placeholder="nome de usuário">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_nome_completo">Nome completo</label>
						<div class="controls">
							<input type="text" id="f_nome_completo" name="f_nome_completo" class="input-xxlarge" placeholder="nome completo do usuário">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_email">E-mail</label>
						<div class="controls">
							<input type="email" id="f_email" name="f_email" class="input-xxlarge" placeholder="e-mail do usuário">
						</div>
					</div>

					<div class="control-group remove-edicao">
						<label class="control-label" for="f_senha">Senha</label>
						<div class="controls">
							<input type="password" id="f_senha" name="f_senha" class="input-medium" placeholder="senha inicial">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_nivel_acesso">Nível de acesso</label>
						<div class="controls">
							<label class="radio"><input type="radio" name="f_nivel_acesso" id="f_nivel_acesso_1" value="1" checked>Operação</label>
							<label class="radio"><input type="radio" name="f_nivel_acesso" id="f_nivel_acesso_2" value="2">Manutenção</label>
							<label class="radio"><input type="radio" name="f_nivel_acesso" id="f_nivel_acesso_3" value="3">Administração</label>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_departamento_id">Departamento</label>
						<div class="controls">
							<select id="f_departamento_id" name="f_departamento_id" class="input-xlarge">
								<option value="null">-- Selecione --</option>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="f_descricao">Descrição</label>
						<div class="controls">
							<textarea id="f_descricao" name="f_descricao" rows="5" class="input-xxlarge"></textarea>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<label class="checkbox"><input type="checkbox" id="f_ativo" name="f_ativo" value="1">Ativo</label>
						</div>
					</div>

					<div class="form-actions">
						<button type="button" class="btn btn-primary" id="btnSubmit"><i class="iconic-check"></i> Salvar</button>
						<a href="../templates/objeto-lista.php" class="btn">Fechar</a>
					</div>

				</form>
			</div>

			<div class="span3">
				<ul class="nav nav-list well remove-inclusao">
					<li class="nav-header">Relacionamentos</li>
					<li><a href="#" id="linkHistorico">Histórico <span class="badge badge-warning"></span></a></li>
					<li><a href="#" id="linkSistemas">Sistemas que utiliza <span class="badge badge-warning"></span></a></li>
				</ul>
			</div>


		</div>

	</div>
</body>
</html>