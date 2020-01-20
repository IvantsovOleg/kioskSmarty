﻿jQuery.fn.print = function(){
	if (this.size() > 1){
		this.eq( 0 ).print();
		return;
	} else if (!this.size()){
		return;
	}
	var strFrameName = ("printer-" + (new Date()).getTime());
 	var jFrame = jQuery( "<iframe name='" + strFrameName + "'>" );
 
	jFrame
		.css( "width", "1px" )
		.css( "height", "1px" )
		.css( "position", "absolute" )
		.css( "left", "-9999px" )
		.appendTo( jQuery( "body:first" ) )
	;
	var objFrame = window.frames[ strFrameName ];
	var objDoc = objFrame.document;
	var jStyleDiv = jQuery( "<div>" ).append(
		jQuery( "style" ).clone()
	);
	var jElem = jQuery( "<div>" ).append(
		jQuery( "#hide" ).html()
	);
 
	objDoc.open();
	objDoc.write( "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">" );
	objDoc.write( "<html>" );
	objDoc.write( "<head>" );
	objDoc.write( "<title>" );
	objDoc.write( document.title );
	objDoc.write( "</title>" );
	objDoc.write( jStyleDiv.html() );
	objDoc.write( "</head>" );
	objDoc.write( "<body>" );
	objDoc.write( this.html() );
	objDoc.write( "<p>" );
	objDoc.write( jElem.html() );
	objDoc.write( "</p>" );
	objDoc.write( "<p>" );
	objDoc.write( jStyleDiv.html() );
	objDoc.write( "</p>" );
	objDoc.write( "</body>" );
	objDoc.write( "</html>" );
	objDoc.close();
 
	objFrame.focus();
	objFrame.print();
 
	setTimeout(
		function(){
			jFrame.remove();
		},
		(60 * 1000)
		);
}