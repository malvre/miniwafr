function getParameterByName(name, padrao) {
	if (padrao == null) {
		padrao = 0;
	}
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    var result = match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    if (result == null) result = padrao;
    return result;
}

var Messages = {
	info: function(str) {
		str += "";
		if ($.trim(str) != "") {
			$("#messages-info").remove();
			$("#messages-error").remove();
			$("#messages").append('<div id="messages-info"><div style="margin-top: 5px; margin-bottom: 5px;" class="alert alert-info"><a class="close" data-dismiss="alert" href="#">&times;</a>'+str+'</div></div>');
		}
	},
	where: function(str) {
		str += "";
		if ($.trim(str) != "") {
			$("#messages-where").remove();
			$("#messages").append('<div id="messages-where"><div style="margin-top: 5px; margin-bottom: 5px;" class="alert alert-warning"><a class="close" href="?clear=1">&times;</a>'+str+'</div></div>');
		}
	},
	error: function(str) {
		str += "";
		if ($.trim(str) != "") {
			$("#messages-error").remove();
			$("#messages-info").remove();
			$("#messages").append('<div id="messages-error"><div style="margin-top: 5px; margin-bottom: 5px;" class="alert alert-error"><a class="close" data-dismiss="alert" href="#">&times;</a>'+str+'</div></div>');
		}
	}
}

var Tables = {
	showFilter: function(theTable) {
		// cria campo
		$(".btn:last").after("<input id='filterField' type='text' placeholder='filtro' value='' class='input-medium pull-right hidden-phone' />");
		// aplica evento
		$("#filterField").keyup(function() {
			var t = $("#"+theTable+" table");
			$.uiTableFilter(t, $("#filterField").val());
		});
	}
}



jQuery.fn.populaSELECT = function(P){
	var SELECT_local = this;
	
	P = jQuery.extend({
		url: false,
		defaultValue: 'null',
		fieldValue: "id",
		fieldName: "label",
		whaitTest: "Aguarde...",
		whaitClass: "aguarde",
		data: {},
		attr: {},
		success: function(){
			return false;
		}
	}, P);
	
	jQuery.ajax({
		url: P.url,
		data: P.data,
		dataType: "json",
		beforeSend: function(){
			jQuery("option[value!='null']",SELECT_local).remove();
			SELECT_local.addClass(P.whaitClass);
			jQuery("<option/>").html(P.whaitTest).val("").appendTo(SELECT_local);
		},
		success: function(json){
			jQuery("option[value!='null']",SELECT_local).remove();
			if(json){
				jQuery.each(json, function(i, valor){
					jQuery("<option/>").html(valor[P.fieldName]).attr(P.attr).attr({
						value:valor[P.fieldValue]
					}).appendTo( SELECT_local );
				});
		
				setTimeout(function(){
					SELECT_local.val(P.defaultValue);
				}, 50);
			}
			SELECT_local.removeClass(P.whaitClass);
			P.success(json);
		}
	});
	return this;
};

var FormUtil = {
	
	checkAll: function(id) {
		var ipts = $("#"+id).find("td input");
		var val = $('input[name=checkall]').prop("checked");
		$.each(ipts, function(){
			$(this).prop('checked', val);
		});
	},
	setRadioValue: function(group, value) {
		$("input[name=" + group + "][value=" + value + "]").prop('checked', true);
	},
	getRadioValue: function(group) {
		$("input:radio[name="+group+"]").val();
	},
	mapEnterKey: function(trigger) {
		$(document).keyup(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == 13){
				$("#"+trigger).click();
			}
		});
	}
}

var Page = {

	top: function() {
		$('html, body').animate({scrollTop: '0px'}, 300);
	}
	
}
