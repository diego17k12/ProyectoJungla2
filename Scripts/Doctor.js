$(document).ready(function(){
	//lo que se quiere es que se oculte el boton de exportar PDF cuando la tabla no arroje datos
	if($("#tblClientes td").length == 0)
	{
		$("#exportarPDF").hide();	
	}
});