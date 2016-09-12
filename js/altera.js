// JavaScript Document
////////////////////
//Informa se mudou ou nao o conteudo

 initFormValues = '';

  // fill this array with the names of the formelements that you want to exclude from the check
  // (or leave it like it is when you don't want to include all)
 skipNames = ['submit'];		

  // this functions builds a string of all the values in the forms
 function compareValues()
 {
	var formValues = '';
	if (document.forms[0])
	{
		for (f=0;f<document.forms.length;f++)
		{
			for (x=0;x<document.forms[f].length;x++)
			{
				if (document.forms[f].elements[x].type != 'checkbox' && document.forms[f].elements[x].type != 'radio')
				{
					if (inArray(document.forms[f].elements[x].name, skipNames))
					{
						// these elements are not to be included in the combined form-values
						// so, any change made to them by the user won't result in the alert
					}
					else
					{
						// alert(document.forms[f].elements[x].name+' '+document.forms[f].elements[x].value);
						formValues = formValues+document.forms[f].elements[x].value;
					}
				}
				else
				{
					 // we're dealing with a checkox or radiobutton
					formValues = formValues+document.forms[f].elements[x].checked;
				}
			}
		}
	}
	return formValues;
 }

  // filling a var with the initial values, on loading the page
  // (this function has to be called by onLoad() in the <body>-tag
 function setInitFormValues()
 {
	initFormValues = compareValues();
 }

  // filling another var with the values, on leaving the page, so we can compare them
  // (it will be triggered by the onbeforeunload event (see below)
 function checkValues()
 {
	if (initFormValues == compareValues())
	{
		 // apparently, nothing has changed
		return;
	}
	else
	{
		 // apparently, changes have been made
	    //return 'Mudanças no cadastro foram realizadas.';
	   event.returnValue='Mudou';
	}
 }
	
 window.onbeforeunload = checkValues;

  // of course, if the form is being submitted, we don't want the alert to be triggered.
  // so, instead of using the normal submit-button, create one that calls this function
 function submitForm(formulier)
 {
	if (document.forms[formulier])
	{
		window.onbeforeunload = null;
		document.forms[formulier].submit();
	}
 }

 function inArray(needle, haystack)
 {
	for (var i in haystack)
	{
		if (needle == haystack[i])
			return true;
	}
 }