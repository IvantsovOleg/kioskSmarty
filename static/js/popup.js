// начинается выполнение команд
$(document).ready(function(){

		var popupStatus = 0;

		//loading popup with jQuery magic!
		function loadPopup(){
			//loads popup only if it is disabled
			if(popupStatus==0){
				$("#backgroundPopup").css({
					"opacity": "0.5"
				});
				$("#backgroundPopup").fadeIn("slow");
				$("#popupContact").fadeIn("slow");
				popupStatus = 1;
			}
		}

		//disabling popup with jQuery magic!
		function disablePopup(){
			//disables popup only if it is enabled
			if(popupStatus==1){
				$("#backgroundPopup").fadeOut("slow");
				$("#popupContact").fadeOut("slow");
				popupStatus = 0;
			}
		}

		//centering popup
		function centerPopup()	{
			//request data for centering
			var windowWidth = document.documentElement.clientWidth;
			var windowHeight = document.documentElement.clientHeight;
			var popupHeight = $("#popupContact").height();
			var popupWidth = $("#popupContact").width();
			//centering
			$("#popupContact").css({
				"position": "absolute",
				"top": 100,
				"left": windowWidth/2-popupWidth/2
			});
			//only need force for IE6
			
			$("#backgroundPopup").css({
				"height": windowHeight
			});
		}
//////////////////////////////////////////////////////
	// при клике по строке с услугой
	$(".services_list tr").click(function () {
	
		// функция ajax, которая вызовет процедуру для preparation, передать keyid
		var data_keyid = $(this).children().children("input[type='hidden'].data_keyid").val();
		var fulltext = $(this).children().children("input[type='hidden'].data_fulltext").val();
		var price = $(this).children().children("input[type='hidden'].data_price").val();
		// поле с услугой:
		$("#name_service span").empty();
		$("#name_service span").append(fulltext);
		
		// поле с ценой:
		$("#price_service span").empty();
		$("#price_service span").append(price+" р.");	
		
		$.ajax({
			type: "POST",
			url: "ajax/ajax_serv_window.php",
			data: {
				data_keyid: data_keyid
			},
			success : function(html)
			{
				$("#for_ajax").children().remove();
				$("#for_ajax").append(html);
				var hp = $("#hid2").val();
				
				$("#cond_service span").empty();
				$("#cond_service span").append(hp);				
				
					// добавить в скрытое поле значение preparation
					// из скрытого поля необходимо его выцепить и засунуть в нижний div
					// не забыть отобразить цену!!!	
					
					//centering with css
					centerPopup();
					//load popup
					loadPopup();
			}
		});
		
		$(".close_modal").click(function(){
			disablePopup();
		});
		//Click out event!
		$("#backgroundPopup").click(function(){
			disablePopup();
		});
		//Press Escape event!
		$(document).keypress(function(e){
				if(e.keyCode==27 && popupStatus==1){
				disablePopup();
			}
		});
	});
	/////////////////////////////////
});
