<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
	$(document).ready(function() {

	});
	</script>
</head>
<body>
	<div class="container">
		<h1>Upload</h1>
		<p class="lead">Exemplo de campo de upload</p>
		
		<div id="messages"></div>

		<form id="frmUpload" class="form-horizontal" enctype="multipart/form-data" method="post" action="../services/upload.php">

			<div class="control-group">
				<label class="control-label" for="f_descricao">Descrição</label>
				<div class="controls">
					<input type="text" name="f_descricao" id="f_descricao" class="input-large">		
				</div>
			</div>

			<!-- exemplo de upload de arquivo -->
			<div class="control-group">
				<label class="control-label" for="f_arquivo">Arquivo</label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<span class="btn btn-file">
							<span class="fileupload-new">Selecione o arquivo</span>
							<span class="fileupload-exists">Alterar</span>
							<input type="file" name="f_arquivo"/>
						</span>
						<span class="fileupload-preview"></span>
						<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
					</div>		
				</div>
			</div>

			<!-- exemplo de upload de imagem -->
			<div class="control-group">
				<label class="control-label" for="f_imagem">Imagem</label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
						<div>
							<span class="btn btn-file">
								<span class="fileupload-new">Selecione a imagem</span>
								<span class="fileupload-exists">Alterar</span>
								<input type="file" name="f_imagem"/>
							</span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
						</div>
					</div>
				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary" id="btnSubmit"><i class="iconic-upload"></i> Enviar</button>
			</div>

		</form>
		
	</div>
</body>
</html>
