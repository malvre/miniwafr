<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<script type="text/javascript">
		$(document).ready(function() {
			var f = new Filter();
			f.addText('f_nome_aluno', 'Nome do aluno');
			f.addText('f_email', 'E-mail');
			f.addDate('f_data_nascimento', 'Data de nascimento');
			f.addDateInterval('f_periodo', 'Período');

			f.debug();

			f.render("#frm");
			
		});

		function Filter() {
			this.fields = [];
			this.counter = 0;
		}
		Filter.prototype.addText = function(id, label) {
			this.fields.push(
				{ id: id,
				  label: label,
				  type: 'text',
				  operators: [
				  	{ label: 'Contém', name: 'like' },
				  	{ label: 'Não contém', name: 'not like' }
				  ]
				}
			);
		}
		Filter.prototype.addDate = function(id, label) {
			this.fields.push(
				{ id: id,
				  label: label,
				  type: 'date',
				  operators: [
				  	{ label: 'Igual a', name: '=' },
				  	{ label: 'Diferente de', name: '!=' },
				  	{ label: 'Maior ou igual a', name: '>=' },
				  	{ label: 'Menor ou igual a', name: '<=' }
				  ]
				}
			);	
		}
		Filter.prototype.addDateInterval = function(id, label) {
			this.fields.push(
				{ id: id,
				  label: label,
				  type: 'dateInterval',
				  operators: [
				  	{ label: 'Entre', name: 'between' }
				  ]
				}
			);	
		}
		Filter.prototype.debug = function() {
			$("#debug").append(JSON.stringify(this.fields));
		}
		Filter.prototype._criaSelectCampos = function() {
			this.counter ++;
			var out = '<select id="fld_'+this.counter+'">';
			out += '<option value="">Selecione um campo</option>';
			this.fields.forEach(function(field) {
                out += '<option value="'+field.id+'">' + field.label + '</option>';
			});
			out += '</select>';
			out += ' <a href="">remover</a>';
			return out;
		}
		Filter.prototype.render = function(obj) {
			$(obj).append(this._criaSelectCampos());
			$(obj).append("<br><input type='button' class='btn btn-primary' id='btnNovoCampo' onclick='' value='Novo campo' />");
		}

	</script>
</head>
<body>
	<div class="container">
		<h1>Título</h1>
		<p class="lead">Subtítulo</p>
		
		<div id="messages"></div>
		
		<div class="row">
			<div class="span12">
				<div id="divFiltro">
					<form id="frm">
					</form>
				</div>
			</div>
		</div>

		<div id="debug"></div>
		
	</div>
</body>
</html>
