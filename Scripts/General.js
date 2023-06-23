//función que se encarga de validar la eliminación de un registro
function valida(evt)
{
	if(confirm("¿Desea eliminar este registro?"))
	{
		return;
	}else{
		evt.preventDefault();
	}
}