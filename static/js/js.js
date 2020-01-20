jQuery.fn.extend({
    disableSelection : function() {
            this.each(function() {
                    this.onselectstart = function() { return false; };
                    this.unselectable = "on";
                    jQuery(this).css('-moz-user-select', 'none');
            });
    }
});

$(document).ready(function () {	
	$('body *').disableSelection();
	// mousedown, mouseout и mouseup
	$(".yellow_button").mouseup(function () {
		$(this).removeClass("yellow_button_press");
		$(this).addClass("yellow_button");
	});
	$(".yellow_button").mousedown(function () {
		if (!$(this).hasClass('confirm_button_unact'))
		{
			$(this).removeClass("yellow_button");
			$(this).addClass("yellow_button_press");
		}
	});
	$(".yellow_button").mouseout(function () {
		$(this).removeClass("yellow_button_press");
		$(this).addClass("yellow_button");
	});
	
	// для каждого!
	$(".yellow_button").each(function (i) {
		var span = $(this).children('span').height();
		var span_w = $(this).children('span').width();
		if (span > 71 || span_w > 500)
		{
			// изменить шрифт в спане
			$(this).css("font-size", "20pt");
			 $(this).children('span').css("top", "15px");
			// var span = $(this).children('span').height();
		//		var span_w = $(this).children('span').width();
		}		
	});
	
	$(".count_numbs_yellow").mouseup(function () {
		$(this).removeClass("count_numbs_green");
		$(this).addClass("count_numbs_yellow");
	});
	$(".count_numbs_yellow").mousedown(function () {
		$(this).removeClass("count_numbs_yellow");
		$(this).addClass("count_numbs_green");		
	});
	$(".count_numbs_yellow").mouseout(function () {
		$(this).removeClass("count_numbs_green");
		$(this).addClass("count_numbs_yellow");		
	});
});