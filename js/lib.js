/***********************************************************
Valida um endereço de email passado como argumento.

Parametros:
	- umEmail: o email a ser validado
Retorno:
	- true:	o email é válido
	- false: o email não é válido
Criada: 22/09/2004
************************************************************/
function validaEmail(umEmail)
{
	var indice=umEmail.indexOf('@');
	var validos="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-._";
	if(indice==-1)return false;
	for(i=0;i<indice;i++)
	{
		var cv=false;
		/*****************************************************************
		Nota: os servidores de email aceitam o uso de alias
		especificados pelo caractere '+' (endereco+alias@isp.com).
		Por este motivo, não podemos usar abaixo o método search(regexp)
		na string válidos, pois o interpretador de expressões regulares
		itá interpretar o '+' destes endereços como qualificadores e irá
		gerar um erro.
		******************************************************************/
		for(j=0;j<validos.length;j++)
		{
			if(umEmail.charAt(i)==validos.charAt(j))cv=true;
		}
		if(!cv)return false;
	}
	for(i=indice+1;i<umEmail.length;i++)
	{
		if(validos.search(umEmail.charAt(i))==-1)return false;
	}
	return true;
}

function ValidaData(input) {


	//Objetivo: checa se a data é valida, retornando true para válida e false para inválida. Espera receber uma data no formato DD/MM/AAAA.

	var iDia,iBarra1,iBarra2,iMes,iAno;
	var err=0,psj=0;

	strData=input.value;

	if (strData.length != 10) err=1;

	numLen = strData.length;
	auxdata = '';
	// Verifica se o Ano da data é formado somente por caracteres numéricos
	for (i = 0; i < numLen; i++) {
		strChar = strData.charAt(i);
		if ((strChar >= "0") && (strChar <= "9")) auxdata = auxdata + strChar;
	}
	numAno = auxdata;
	numLen = numAno.length;
	// Verifica se são 08 números
	if (numLen != 8) return false;


	iDia = parseInt(strData.substring(0, 2),10);   // Dia
	iBarra1 = strData.substring(2, 3);             // '/'
	iMes = parseInt(strData.substring(3, 5),10);   // Mes
	iBarra2 = strData.substring(5, 6);             // '/'
	iAno = parseInt(strData.substring(6, 10),10);  // Ano

	//Checando erros básicos

	if (iMes<1 || iMes>12) err = 1;
	if (iBarra1 != '/') err = 1;
	if (iDia<1 || iDia>31) err = 1;
	if (iBarra2 != '/') err = 1;
	if (iAno<0 || iAno>2999) err = 1;
	
	//Checando erros avançados

	//Meses com 30 dias

	if (iMes==4 || iMes==6 || iMes==9 || iMes==11) {if (iDia==31) err=1;}

	// Fevereiro e Ano bissexto

	if (iMes==2) {
		var g=parseInt(iAno/4,10);
		if (isNaN(g)) err=1;
		if (iDia>29) err=1;
		if (iDia==29 && ((iAno/4)!=parseInt(iAno/4,10))) err=1;
	}

	if (err==1) return false;
	else return true;
}

function ValidaHora(input) {
    //Objetivo: checa se conteúdo de input é uma Hora válida
    var err = 0;
    var strHora = input.value;
    if (strHora.length != 5) err=1;
    if (err == 0) {
       var iHora = parseInt(strHora.substring(0,2),10);
       var iMin  = parseInt(strHora.substring(3,5),10);
    }
    if (iHora < 0 || iHora > 23 || iMin < 0 || iMin > 59 || err==1) {
	alert('Hora inválida.');
	input.focus();
	return false;
    }
    return true;
}

function ValidaCNPJ(input) {

	// Objetivo: checa se CNPJ é valido, retornando true para válido e false para inválido.
	// Pode receber um CNPJ formatado ou não. Se receber um CNPJ não formatado, mas válido, o CNPJ será formatado.

	var numLen;
	var strChar;
	var numSomat;
	var numInd;
	var numDigit;
	var auxcgc;
	
	numCgc = input.value;
	numLen = numCgc.length;

	if (numLen==0) return false;

	auxcgc = "";

	// Elimina caracteres não numéricos

	for (i = 0; i < numLen; i++) {
		strChar = numCgc.charAt(i);
		if ((strChar >= "0") && (strChar <= "9")) auxcgc = auxcgc + strChar;
	}
	
	numCgc = auxcgc;
	numLen = numCgc.length;

	// Verifica se são 14 números
	
	if (numLen != 14) return false;

	// Calcula o primeiro dígito verificador

	numSomat = 0;
	numInd = 6;
	for (i = 0; i < 12; i++) {
		numInd--;
		if (numInd == 1) numInd = 9;
		numSomat += (numInd) * (eval(numCgc.charAt(i)));
	}
	numDigit = 11 - (numSomat % 11);
	if ((numSomat % 11) < 2) numDigit = 0;		 
	if (eval(numCgc.charAt(12)) != numDigit) return false;
	
	// Calcula o segundo dígito verificador

	numSomat = 0;
	numInd = 7;
	for (i = 0; i < 13; i++) {
		numInd--;
		if (numInd == 1) numInd = 9;
		numSomat += (numInd) * (eval(numCgc.charAt(i)));
	}
	numDigit = 11 - (numSomat % 11);
	if ((numSomat % 11) < 2) numDigit = 0;
	if (eval(numCgc.charAt(13)) != numDigit) return false;

	input.value = numCgc.substring(0, 2) + '.' + numCgc.substring(2,5) + '.' + numCgc.substring(5,8) + '/' + numCgc.substring(8, 12) + '-' + numCgc.substring(12, 14);
	return true;
}


function ValidaCPF(input){

	// Objetivo: checa se CPF é valido, retornando true para válido e false para inválido.
	// Pode receber um CPF formatado ou não. Se receber um CPF não formatado, mas válido, o CPF será formatado.

	var numCpf;
	var numLen;
	var strChar;
	var auxcpf;
	
	numCpf = input.value;
	numLen = numCpf.length;

	if (numLen==0) return false;

	auxcpf = '';

	// Elimina caracteres não numéricos

	for (i = 0; i < numLen; i++) {
		strChar = numCpf.charAt(i);
		if ((strChar >= "0") && (strChar <= "9")) auxcpf = auxcpf + strChar;
	}
	
	numCpf = auxcpf;
	numLen = numCpf.length;

	// Verifica se são 11 números
	
	if (numLen != 11 || numCpf=='00000000000' || numCpf=='11111111111' || numCpf=='22222222222' || numCpf=='33333333333' || numCpf=='44444444444' || numCpf=='55555555555' || numCpf=='66666666666' || numCpf=='77777777777' || numCpf=='88888888888' || numCpf=='99999999999') return false;

	var s=null
	var r=null

	v = numCpf;

	s=0
	for(var i=0;i<9;i++)s+=parseInt(v.charAt(i))*(10-i)
	r=11-(s%11)
	if(r==10||r==11)r=0
	if(r!=parseInt(v.charAt(9)))return false
	s=0
	for(var i=0;i<10;i++)s+=parseInt(v.charAt(i))*(11-i)
	r=11-(s%11)
	if(r==10||r==11)r=0
	if(r!=parseInt(v.charAt(10)))return false

	input.value = numCpf.substring(0,3) + '.' + numCpf.substring(3,6) + '.' + numCpf.substring(6,9) + '-' + numCpf.substring(9,11);
	return true;
}

function ValidaCEP(input) {
    cep=input.value;
    if (cep!='') {
        cepaux="";
        strChar=0;
        for (i=0;i<cep.length;i++) {
            strChar=cep.charCodeAt(i);
            if ((strChar>47)&&(strChar<58)) cepaux=cepaux+cep.charAt(i);
        }
        if (cepaux.length!=8) {
            alert('CEP inválido. Padrão: 99999-999 ou 99999999');
            input.focus();
            return;
        }
	cepaux=cepaux.substr(0,2)+'.'+cepaux.substr(2,3)+'-'+cepaux.substr(5,3);
    input.value=cepaux;
    }
}
