<?php
include_once("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// botão de login
		$("#btnLogin").click(function() {
			// chama serviço que autentica o usuário
			$.post("../services/login.php", $("#frmLogin").serialize(), function(data) {
				if (data.ok) {
					location = "../pages/index.php";
				} else {
					Messages.error(data.erro);
					$("#f_usuario").focus();
				}
			}, "json");
		});

		// foco no campo
		$("#f_usuario").focus();

		// aciona o botão de login ao pressionar ENTER
		FormUtil.mapEnterKey("btnLogin");
	});
	</script>
</head>
<body>
	<div class="container">
		<h1>Login</h1>
		<p class="lead">Por favor, efetue login para continuar</p>

		<div id="messages"></div>

		<div class="row-fluid">
			<div class="span12">


				<form id="frmLogin" class="form">
					<div class="control-group">
						<label class="control-label" for="f_usuario">Usuário</label>
						<div class="controls">
							<input type="text" id="f_usuario" name="f_usuario" placeholder="Nome de usuário" class="input-large">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="f_senha">Senha</label>
						<div class="controls">
							<input type="password" id="f_senha" name="f_senha" placeholder="Senha" class="input-large">
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="button" id="btnLogin" class="btn btn-primary"><i class="iconic-key"></i> Login</button>
						</div>
					</div>
				</form>

			</div>

		</div>
	</div>
</body>
</html>