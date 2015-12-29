/*  
  JS dormulario
  JavaScript pré-processamento de todos os formularios

  Sistema:  Kanban
  Autor:    Rogério Eduardo Pereira
  Data:     26/08/2014
*/
//Função para requisição ajax
function doPost(formName, actionName)
{
	var hiddenControl = document.getElementById('action');
	var theForm = document.getElementById(formName);

	hiddenControl.value = actionName;
    theForm.submit();
}