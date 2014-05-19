<?php
include("../includes/common.php");
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<?php include("../includes/head.html"); ?>
	<style>
	body.dragging, body.dragging * {
		cursor: move !important;
	}

	.dragged {
		position: absolute;
		opacity: 0.5;
		z-index: 2000;
	}

	ol.example li.placeholder {
		position: relative;
		/** More li styles **/
	}

	ol.example li.placeholder:before {
		position: absolute;
		/** Define arrowhead **/
	}

	ol.simple_with_animation li, ol.default li {
		cursor: pointer;
	}

	ol.vertical li {
		display: block;
		margin: 5px;
		padding: 5px;
		border: 1px solid #cccccc;
		color: #0088cc;
		background: #eeeeee;
	}
	li {
		line-height: 18px;
	}
	ol {
		list-style-type: none;
	}
	ol {
		list-style: decimal;
	}

	#previewTimeline {
		background-color: #F0F0F0;
		width: 100%;
	}

	#previewTimeline table {
		width: 100%;
		font-size: 0.8em;
		color: #CCCCCC;
	}

	#previewTimeline table td {
		width: 4.1666666666%;
	}

	#timelineContainer {
		position: relative;
		white-space: nowrap;
	}

	.bloco-preview {
		font-size: 0.8em;
		padding: 1px;
		color: #FFFFFF;
		padding: 0px;
		background-color: #FF0000;
		position: absolute;
		height: 40px;
		display: inline-block;
	}
	</style>
	<script src="../js/jquery-sortable.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			carregaListaProgramas("");
			carregaGrade();

			previewTimeline();

			// botão busca
			$("#btnBusca").click(function() {
				carregaListaProgramas($("#f_busca").val());
				$("#f_busca").focus();
			});

			$("#f_busca").focus();



			var adjustment;


			$("ol.simple_with_animation").sortable({
				group: 'simple_with_animation',
				pullPlaceholder: false,

				// animation on drop
				onDrop: function  (item, targetContainer, _super) {

					var clonedItem = $('</li>').css({height: 0});
					item.before(clonedItem);
					//item.prepend('00:00:00');

					// obtem ordem e IDs
					var myarray = [];
					$("#ol-content-grade li").each(function(){
						myarray.push($(this).data('idprograma'));
					});

					// salva grade
					addProgramas(myarray);

					// carrega nova versão da grade
					carregaGrade();

					clonedItem.animate({'height': item.height()});
					item.animate(clonedItem.position(), function  () {
						clonedItem.detach();
						_super(item);
					});
				},

				// set item relative to cursor position
				onDragStart: function ($item, container, _super) {
					var offset = $item.offset(),
					pointer = container.rootGroup.pointer;

					adjustment = {
						left: pointer.left - offset.left,
						top: pointer.top - offset.top
					}

					_super($item, container);
				},

				onDrag: function ($item, position) {
					$item.css({
						left: position.left - adjustment.left,
						top: position.top - adjustment.top
					})
				},
				isValidTarget: function($item, container) {
					return (container.el[0].id == 'ol-content-grade');
				}
			})

		});

function carregaListaProgramas(str) {
	$.getJSON("../services/programa-lista.php", { "search" : str }, function(data) {
		$("#ol-content-programas").empty();
		$("#ol-content-programas").append($("#ol-template-programas").render(data.itens));
	});
}

function carregaGrade() {
	$.getJSON("../services/grade-lista.php", function(data) {
		$("#ol-content-grade").empty();
		$("#ol-content-grade").append($("#ol-template-grade").render(data.itens));
		if (data.itens.length == 0) {
			$("#ol-content-grade").append("<li class='placeholder'></li>");
		}
	});
}

function addPrograma(id_programa) {
	$.getJSON("../services/programa-add.php", { "id" : id_programa }, function(data) {
		//carregaGrade();
	});
}

function addProgramas(arrayProgramas) {
	$.getJSON("../services/programas-add.php", { "ids" : arrayProgramas.join(",") }, function(data) {
		//Messages.info(data.sucesso);
	});

}

function removeProgramaDaGrade(id) {
	$.getJSON("../services/grade-excluir.php", { "id" : id }, function(data) {
		carregaGrade();
	});
}

function moveUp(id, ordem) {
	$.getJSON("../services/grade-move.php", { "id" : id, "ordem" : ordem, "direcao" : "up" }, function(data) {
		if (data.ok) {
			carregaGrade();
		} else {
			Messages.error(data.erro);
		}
	});
}

function moveDown(id, ordem) {
	$.getJSON("../services/grade-move.php", { "id" : id, "ordem" : ordem, "direcao" : "down" }, function(data) {
		if (data.ok) {
			carregaGrade();
		} else {
			Messages.error(data.erro);
		}
	});
}

function previewTimeline() {
	var colors = [];
	colors.push("#FF0000");
	colors.push("#00FF00");
	colors.push("#0000FF");
	colors.push("#FF00FF");
	var posColor = 0;

	$.getJSON("../services/grade-preview.php", function(data) {
		for(var key in data.itens) {
			//console.log('bloco: ' + data.itens[key].bloco);
			//var inicio = (data.itens[key].hora * 100) / 1440;
			var inicio = (data.itens[key].hora * 0.069444444443);
			//var duracao = (data.itens[key].duracao * 100) / 86400;
			var duracao = (data.itens[key].duracao * 0.001157);

			inicio = inicio.toFixed(2);
			duracao = duracao.toFixed(2);

			var strLeft = 'left: ' + inicio + '%;';
			/*
			if (inicio < 5) {
				strLeft = "";
			}
			*/

			
			if (posColor == (colors.length-1)) {
				posColor = 0;
			} else {
				posColor++;
			}
			var strColor = "background-color: "+colors[posColor]+"; ";

			$("#timelineContainer").append("<div class='bloco-preview' style='"+strColor+strLeft+" width: "+duracao+"%'>"+data.itens[key].bloco+"</div>");
    	} 
	});
}


</script>
</head>
<body>
	<div class="container">
		<h1>Exemplo de Timeline</h1>
		<p class="lead">05/11/2013</p>

		<div id="messages"></div>

		<div class="row">
			<div class="span6">
				<h3>Programas disponíveis</h3>
				
				<form class="form-search">
					<input type="text" name="f_busca" id="f_busca" class="input-medium search-query" placeholder="Busca">
					<button type="button" id="btnBusca" class="btn btn-primary"><i class="iconic-magnifying-glass"></i></button>
				</form>

				<ol id="ol-content-programas" class="simple_with_animation vertical">
				</ol>

				<script id="ol-template-programas" type="text/x-jsrender">
					<li data-idprograma='{{>id}}'>
						{{>nome_programa}} {{>duracao_display}}	
					</li>
				</script>
			</div>

			<div class="span6">
				<h3>Grade de programação</h3>

				<ol id="ol-content-grade" class="simple_with_animation vertical">
				</ol>

				<script id="ol-template-grade" type="text/x-jsrender">
					<li data-idprograma='{{>id_programa}}'>
						{{>duracao_total_display}} <strong>{{>nome_programa}}</strong> {{>duracao_display}} <button type="button" onclick="removeProgramaDaGrade({{>id}})" class="btn btn-danger btn-mini">Excluir</button>
					</li>
				</script>
			</div>
		</div>

		<div class="row">
			<div class="span12">
				<div id="previewTimeline">
					<table>
						<tr>
							<td>0h</td>
							<td>1h</td>
							<td>2h</td>
							<td>3h</td>
							<td>4h</td>
							<td>5h</td>
							<td>6h</td>
							<td>7h</td>
							<td>8h</td>
							<td>9h</td>
							<td>10h</td>
							<td>11h</td>
							<td>12h</td>
							<td>13h</td>
							<td>14h</td>
							<td>15h</td>
							<td>16h</td>
							<td>17h</td>
							<td>18h</td>
							<td>19h</td>
							<td>20h</td>
							<td>21h</td>
							<td>22h</td>
							<td>23h</td>
						</tr>
					</table>
					<div id="timelineContainer"></div>
				</div>
			</div>
		</div>
		<br><br><br><br><br><br>


	</div>
</body>
</html>