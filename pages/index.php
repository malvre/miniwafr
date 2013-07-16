<?php
include_once("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// chama o serviço que retorna informações sobre o login do usuário
		$.getJSON("../services/login-info.php", function(data) {
			$("#loginFooterPlaceholder").append(data.usuario_button);
		});

		// chama serviço que popula algumas áreas da dashboard
		$.getJSON("../services/dashboard.php", function(data) {
			$("#t1").html(data.t1);
			$("#t2").html(data.t2);
			$("#t3").html(data.t3);
			$("#t21").html(data.t21);
			$("#t22").html(data.t22);
		});
	});
	</script>
</head>
<body>
	<div class="container">
		<h1>Hello world!</h1>
		<p class="lead">Exemplo de dashboard</p>

		<div id="messages"></div>

		<div class="row hidden-desktop">
			<div class="span12">
				<div class="procergs-icon"><a href="../templates/objeto-lista.php" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
				<div class="procergs-icon"><a href="#" class="act act-primary"><img class="img-rounded" data-src="holder.js/120x120" alt=""><p>Usuários</p></a></div>
			</div>
		</div>

		<div class="row visible-desktop">
			<div class="span4" id="t1"></div>
			<div class="span4" id="t2"></div>
			<div class="span4" id="t3"></div>
		</div>

		<div class="row visible-desktop">
			<div class="span8" id="t21"></div>
			<div class="span4" id="t22"></div>
		</div>

		<div id="footer" class="hidden-desktop">
			<div class="row">
				<div class="span12">
					<div id="loginFooterPlaceholder" class="well"></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>