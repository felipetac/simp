$(function() {
    function initialExecute(){	
	$("#menuNavigation li").hover(
	    function(){
		$(this).not(".ui-state-active").addClass("ui-state-hover");
	    },
	    function(){
		$(this).removeClass("ui-state-hover");
	    }
	);
	
	$("#formPager").submit(function(){
	    
	    $.post(this.action, $(this).serialize()).done(function(data){
		var old_trpager = $("#tr-pager");
		$(old_trpager).before(data);
		$(old_trpager).remove();
		initialExecute();
	    });
	    return false; // Previne o form de ser enviado pela forma normal
	})
	
	$('select[multiple!="multiple"]').combobox();
	$('select[multiple="multiple"]').multiselect();
	$('select[multiple="multiple"]').addClass("ui-corner-all");
	$('select[multiple="multiple"]').next("br").css("clear","both");
	$(".radio").buttonset();
	$(".radio").next("br").css("clear","both");
	$(".radio").prev("label").css("margin-top","16px");
	
	/*$("#usuario-nav").buttonset();*/
	
	$("input[type=text], input[type=password], textarea").addClass("ui-widget ui-widget-content ui-corner-all");
	
	$(".btnNovo").button({
	    icons: {
		primary: "ui-icon-plus"
	    }
	});
	
	$(".btnEntrar").button({
	    icons: {
		primary: "ui-icon-key"
	    }
	});
	
	$(".btnSalvar").button({
	    icons: {
		primary: "ui-icon-disk"
	    }
	});
	
	$(".btnCancelar").button({
	    icons: {
		primary: "ui-icon-cancel"
	    }
	});
	
	$(".btnLimpar").button({
	    icons: {
		primary: "ui-icon-trash"
	    }
	});
	
	$(".btnBuscar").button({
	    icons: {
		primary: "ui-icon-search"
	    }
	});
	
	$(".btnText").button({
	});
	
	$(".btnEditar").button({
	    icons: {
		primary: "ui-icon-pencil"
	    },
	    text:false
	});
	
	$(".btnExcluir").button({
	    icons: {
		primary: "ui-icon-trash"
	    },
	    text:false
	}).click(function(){
	    var url = $(this).attr("href");
	    var param = $(this).parent().parent().find(".itemConfirm").text();
	    $("#dialog-confirm").remove();
	    $("body").append('<div id="dialog-confirm" title="Apagar?"></div>');
	    $("#dialog-confirm").prepend('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Você deseja realmente apagar <br />"<b>'+ param +'</b>"?</p>');
	    $("#dialog-confirm").dialog({
			    resizable: false,
			    height:140,
			    modal: true,
			    buttons: {
				    "Confirmar": function() {		
					    $(window.document.location).attr("href",url);
				    },
				    "Cancelar": function() {
					    $( this ).dialog( "close" );
				    }
			    }
		    });
	    return false;
	});
	
	$(".successMsgContainer").show("fast");
	$(".successMsgContainer").delay(3200).hide("fast");
	
	if ($("input").is(":disabled") == true){
	    $(this).addClass("ui-state-disabled");
	}
	
	$('.disabled').addClass("ui-state-disabled").attr('disabled', 'disabled');
	
	$('.tip[title]').qtip({
	    content: {
		text: false // Use each elements title attribute
	    },
	    style: 'cream' // Give it some style
	});
	
	$("input").focusin(
	    function(){
		$(this).css("border","1px solid #FCCE7E");
	    });
	$("input").focusout(
	    function(){
		$(this).css("border","1px solid #dddddd");
	    });
	
	$(".subNav li a").hover(
		function(){
		    $(this).not(".ui-state-active").addClass("ui-state-hover");
		},
		function(){
		    $(this).removeClass("ui-state-hover");
		}
	    );
	
	$(".yesButton").wrapInner('<span class="yesButtonWrap ui-corner-all" />');
	$(".noButton").wrapInner('<span class="noButtonWrap ui-corner-all" />');
	$(".codButton").removeClass("codButton").wrapInner('<span class="codButtonWrap ui-corner-all" />');
	$(".pagerfanta nav span").wrapInner('<span class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="cursor: auto;"><span class="ui-button-text" /></span>');
	$(".pagerfanta nav a").addClass('tip ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only').wrapInner('<span class="ui-button-text" />');
	$(".pagerfanta nav span.dots").html(' ... ');
    }
    
    initialExecute();
          
});

