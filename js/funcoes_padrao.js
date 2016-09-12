//===========================================
//    FUNCOES_PADRAO.JS       18/10/2000
//===========================================
// IsEmpty(Campo)
// Dias_Fevereiro(ano)
// Validar_Campo_Data(campo,obrigatorio)
// Validar_Campo_Numerico(campo,char_valido)
// ValidaHora(Hora)
// ValidaHoraFim(HoraIni,HoraFim)
// Enabled_Radio_Campo(Campo,CampoFocus,Radio,i)
// Enabled_CBox_Campo(Campo,CampoFocus,CBox)
// SubstituiCaracter(str,atual,novo)
// valida_CPF(rcpf1,rcpf2,c)
// ValidaCGC(CGCaux)
// Valida_Email(Campo)
//alert('java-Padrão');

//========================================================
// Impede que uma pagina seja acessada fora do frame
//========================================================
/* function refinaPermissao() {
// EXEMPLO=> http://192.168.0.135/donato/index.php	//
// 			pagina[0]= 'http:'						//
// 			pagina[1]= ''							//
// 			pagina[2]= '192.168.0.135'				//
// 			pagina[4]= 'index.php' (pagina)			//
	pagina= top.location.href;
	pagina= pagina.split('/');
	pagina= pagina[pagina.length-1];
//	pagina2[0]= 'principal2' (pagina2)				//
//	pagina2[1]= 'php?acao=A'						//
	pagina2= pagina.split('.');
	pagina2= pagina2[0];
	if (pagina!='principal.php' && pagina2!='principal2') {
		location.href= 'index.php';
	}
 }*/

//========================================================
// Verifica se o campo passado como parâmetro está vazio
//========================================================
 function IsEmpty(campo){
   if  (campo.type == "select-one") var field = campo.options[campo.selectedIndex].value
   else var field = campo.value;
   for (var i = 0; i < field.length; i++) {
      var valor = field.charAt(i);
      if (valor != " ") return false;
   }
   return true;
 }

//==============================================
//retorna o numero de dias em fevereiro.
//==============================================
function Dias_Fevereiro(ano){
   if ( ano%4==0 && ( ano%100!=0  || ano%400==0) ) return 29;
   else return 28; 
}

//===============================================================================
// Verifica se o campo data passado como parâmetro está preenchido corretamente 
// (dd/mm/aaaa).
//===============================================================================
function Validar_Campo_Data(campo,obrigatorio){
   if (IsEmpty(campo) && (obrigatorio)) return false;
   
   var data = campo.value + '/';
   var part_data = "";
   var caracter = "";
   var dia = ""; var mes = ""; var ano = "";
   if (!IsEmpty(campo)){
    for (var i=0; i < data.length; i++) {
      if (data.charAt(i) != "/" ){  //joga o caracter que se encontra na posicao "i" da string "valor"
        part_data = part_data + data.charAt(i);
      } else { 
        if (dia == ""){
           dia = part_data;
           part_data = "";
        } else {
          if (mes == ""){
             mes = part_data;
             part_data = "";
          } else{
            if(ano == ""){
               ano = part_data;
               part_data = ""; 
			}
          }
        }
      }
    }
    if ((ano >= 1000) && (ano <= 3000)){
       if ((mes=="01") || (mes=="03") || (mes=="05") || (mes=="07") || (mes=="08") || (mes=="10") || (mes=="12")) {
          if((dia >= 01) && (dia <= 31)){
             return true;
          }
       } else{
          if ((mes=="04") || (mes=="06") || (mes=="09") || (mes=="11")) {
             if((dia >= 01) && (dia <= 30)){
               return true;
             }
          } else {
             if(mes=="02"){
               if ((dia >= 01) && (dia <= Dias_Fevereiro(ano))){
                 return true;
               }
             }
          }
       }
    } else {return false; }
  } else { return true; }
}

//===================================================================================
// Verifica se o campo passado como parâmetro é numérico, caso ele esteja preenchido.
//===================================================================================
    function Validar_Campo_Numerico(campo,char_valido) { 
      var validchars = "0123456789"+char_valido;
      if (!IsEmpty(campo)){
         var valor = campo.value;
         for (var i=0; i < valor.length; i++) {
           var numero = valor.charAt(i); //joga o caracter que se encontra na posicao "i" da string "valor"
           //verifico se eh um caracter valido (numerico)
           if(validchars.indexOf(numero) != -1) {  //retorna -1 quando nao encontra o caracter
             continue
           }
           else {
             return false;
           }
         }
         return true;
      }
      else
         return true;
    }

//==============================================
// Valida uma determinada hora no formato HH:MM
//==============================================
function ValidaHora(Hora){
 var i;
 var DoisPontos = "N";
 var PString    = "";
 var sHora      = ""; 
 var sMinuto    = "";
 var ValorHora  = Hora.value;		
 var SizeHora   = ValorHora.length;
	
 if (SizeHora > 5 || SizeHora  == 3) { 	
  return false;
 }
 for (i = 0; i<=SizeHora; i++) {	
  PString = ValorHora.substr(i,1);  
	if (PString == ":") {  
   if (i == 0 || i == SizeHora-1 || (SizeHora==4&&(i==2||PString=="0")) 
    || (SizeHora==5&&(i==1||i==3||PString=="0")) ) {
    return false;
   }   
   DoisPontos = "S";
  } 
  else {
   if (DoisPontos == "N"){
    sHora = sHora+PString;  
   }
   else{
   sMinuto = sMinuto+PString; 
   }
  }   
 }
 if (parseInt(sHora)>24 || parseInt(sMinuto)>59 ){
  return false;
 }	
 return true;	
}

//===========================================================================
// Valida se uma hora final e Menor ou Igual a uma hora inicio formato HH:MM
//===========================================================================
function ValidaHoraFim(HoraIni,HoraFim){  
 var i; 
 var ValHoraIni  = HoraIni.value;
 var ValHoraFim  = HoraFim.value;
 var SizeHoraIni = ValHoraIni.length;
 var SizeHoraFim = ValHoraFim.length;
 var DoisPontosI = "N";
 var DoisPontosF = "N"; 
 var sHoraIni    = "";
 var sHoraFim    = ""; 

 for (i= 0 ;i<=SizeHoraIni; i++) {
  pString = ValHoraIni.substr(i,1);
  if (pString==":"){
   DoisPontosI = "S";  
  }
 }
 for (i= 0 ;i<=SizeHoraFim; i++) {
  pString = ValHoraFim.substr(i,1);
  if (pString==":"){
   DoisPontosF = "S";      
  }
 }	
 
 //========================== Se Hora Inicial tem 2 pontos e Hora Final sem 2 pontos
 if (DoisPontosI=="S"&&DoisPontosF=="N"){		
   for (i = 0 ;i<=SizeHoraIni; i++) {
     pString = ValHoraIni.substr(i,1);
    if (pString != ":") {
     sHoraIni = sHoraIni+pString;
    } 
    else {
     break;
    } 
   }
	 for (i = 0 ;i<=SizeHoraFim; i++) {
     pString = ValHoraFim.substr(i,1);
    if (pString != ":") {
     sHoraFim = sHoraFim+pString;
    } 
   }
	 if (parseInt(sHoraFim) <= parseInt(sHoraIni)){
    return false;
   }
	return true;	
 }

 //===================================== Se Hora Inicial e Hora Final com 2 pontos
 if (DoisPontosI=="S"&&DoisPontosF=="S"){	
   for (i = 0 ;i<=SizeHoraIni; i++) {
     pString = ValHoraIni.substr(i,1);
    if (pString != ":"&&i!=0) {
     sHoraIni = sHoraIni+pString;
    }     	 	
   }	
	 if (sHoraIni.substr(0,1)=="0"){
		 SizeHoraIni = sHoraIni.length;
		 for (i = 1 ;i<=SizeHoraIni; i++) {
      pString = sHoraIni.substr(i,1);		
      sHoraIni = sHoraIni+pString;			
     } 
		}			
		
   for (i = 0 ;i<=SizeHoraFim; i++) {
     pString = ValHoraFim.substr(i,1);		
    if (pString != ":") {
     sHoraFim = sHoraFim+pString;			
    } 
	 }	
		if (sHoraFim.substr(0,1)=="0"){
		 SizeHoraFim = sHoraFim.length;
		 for (i = 1 ;i<=SizeHoraFim; i++) {
      pString = sHoraFim.substr(i,1);		
      sHoraFim = sHoraFim+pString;			
     } 
		}   			
		
   if (parseInt(sHoraFim) <= parseInt(sHoraIni)){
		return false;
   }
	return true;	
 } 

//================================= Se Hora Inicial e Hora Final com 2 pontos ou não
 for (i = 0 ;i<= SizeHoraIni; i++) {	
  pString = ValHoraIni.substr(i,1); 
  if (pString != ":"){
   sHoraIni = sHoraIni+pString;	 
  } 
 }
	
 for (i = 0; i<= SizeHoraFim; i++) {
  pString = ValHoraFim.substr(i,1);
  if (pString != ":"){
    sHoraFim = sHoraFim+pString;				
   }
 }

 ValHoraFim = sHoraFim;	
 if (DoisPontosF = "S"){	
  if (ValHoraFim.length > 2){
   sHoraIni = sHoraIni+"00";
  }
 }
 else{
	if (ValHoraFim.length > 2){
   sHoraIni = sHoraIni+"0";
  }
 }	

 if (parseInt(sHoraFim) <= parseInt(sHoraIni)) {	
  return false;
 }
 return true;	
}

//==================================================================
// Se checou um Radio, habilita e desabilita um determinado campo
//   Campo é o campo a ser desab./hab.
//   CampoFocus é o campo desejado a ter o focu
//   Radio é o nome do radiobutton e "i" o seu indice(0,1,2..)
//==================================================================
function Enabled_Radio_Campo(Campo,CampoFocus,Radio,i){
 if (Radio[i].checked == true){
  Campo.value = "";
  Campo.style.backgroundColor = "#eeeeee";  //cinza
  CampoFocus.focus();
 } 
 else {
  Campo.style.backgroundColor = "#ffffff"; //branco
  Campo.focus();
 }     
} 

//==================================================================
// Se checou um CheckBox, habilita e desabilita um determinado campo
//   Campo é o campo a ser desab./hab.
//   CampoFocus é o campo desejado a ter o focu
//   CBox é o nome do checkbox 
//==================================================================
function Enabled_CBox_Campo(Campo,CampoFocus,CBox){
 if (CBox.checked == true){
  Campo.value = "";
  Campo.style.backgroundColor = "#eeeeee";  //cinza
  CampoFocus.focus();
 } 
 else {
  Campo.style.backgroundColor = "#ffffff"; //branco
  Campo.focus();
 }     
}

//****************************************************************************************
// substitui a string atual pela string novo na string str -- Jaricia
//****************************************************************************************
function SubstituiCaracter(str,atual,novo){ 
   posicao=str.indexOf(atual);
   pular=atual.length;
   while(posicao!=-1){
     str=str.substring(0,posicao)+novo+str.substring(posicao+pular,str.length);
     posicao=str.indexOf(atual);
   }
   return str
}


//==============================================================================================
// Elaine
//==============================================================================================
function isDigit (c) {
        return ((c >= "0") && (c <= "9"))
}

//==============================================================================================
// Para Retirar caracteres inválidos
// Elaine
//==============================================================================================
function RetiraCaracteresInvalidos(strCampo,tam) {
     nTamanho = strCampo.length;
     szCampo = "";
     j=0;
     for (i = nTamanho-1;i>=0;i--) {
        if (isDigit(strCampo.charAt(i))) {
           szCampo = strCampo.charAt(i) + szCampo;
           j++;
           if (j > tam) break;
        }
     }
     if (szCampo.length < tam) {
        for (i = szCampo.length;i<tam;i++) {
           szCampo = "0" + szCampo;
        }
     }
     return szCampo;
}

//==============================================================================================
// Para Validar o Número do CPF
// Elaine
//==============================================================================================
function valida_CPF(CPFaux) { 
    var rcpf1 = CPFaux.substr(0,9);
    var rcpf2  = CPFaux.substr(9,2);

	 d1 = 0;
     for (i=0;i<9;i++)
        d1 += rcpf1.charAt(i)*(10-i);
        d1 = 11 - (d1 % 11);
        if (d1>9) d1 = 0;
        if (rcpf2.charAt(0) != d1)
           return false;
        d1 *= 2;
        for (i=0;i<9;i++)
            d1 += rcpf1.charAt(i)*(11-i);
            d1 = 11 - (d1 % 11);
            if (d1>9) d1 = 0;
            if (rcpf2.charAt(1) != d1)
               return false;
        return true;
}

//==============================================================================================
// Para Validar o Número do CGC
// Elaine
//==============================================================================================
function ValidaCGC(CGCaux) {

   CGCaux = RetiraCaracteresInvalidos(CGCaux,14);

   var wD = new Array(14);
   for (i=0;i<14;i++)  wD[i] = CGCaux.charAt(i);

   //Calcula 1o.Digito
   wTotal = (5*CGCaux.charAt(0))+(4*CGCaux.charAt(1))+(3*CGCaux.charAt(2))+(2*CGCaux.charAt(3))+
            (9*CGCaux.charAt(4))+(8*CGCaux.charAt(5))+(7*CGCaux.charAt(6))+(6*CGCaux.charAt(7))+
            (5*CGCaux.charAt(8))+(4*CGCaux.charAt(9))+(3*CGCaux.charAt(10))+(2*CGCaux.charAt(11));

   wPriDig = ( wTotal*10 ) % 11;
   if ( wPriDig == 10 ) wPriDig = 0;

   //Calcula 2o.Digito
   wTotal = (6*CGCaux.charAt(0))+(5*CGCaux.charAt(1))+(4*CGCaux.charAt(2))+(3*CGCaux.charAt(3))+
            (2*CGCaux.charAt(4))+(9*CGCaux.charAt(5))+(8*CGCaux.charAt(6))+(7*CGCaux.charAt(7))+
            (6*CGCaux.charAt(8))+(5*CGCaux.charAt(9))+(4*CGCaux.charAt(10))+(3*CGCaux.charAt(11))+
            (2*wPriDig);

   wSegDig = ( wTotal*10 ) % 11;
   if ( wSegDig == 10 ) wSegDig = 0;

   if ((wPriDig != CGCaux.charAt(12)) || (wSegDig != CGCaux.charAt(13)))
       return false
   else if (CGCaux == '00000000000000')
       return false
   else
      return true;
}

// Valida o Email
function Valida_Email(Campo){
caracter = ([" ","/",":",";","=",",","#","%","&","*"]);
  for (a=0;a < caracter.length;a++){
	if (Campo.indexOf(caracter[a]) > 0) {
	  return false;
    }
  }
  if (Campo.length > 5){
     if( (Campo.indexOf("@") < 2) || (Campo.length == Campo.indexOf("@")-1) ) {
			   return false;
	 }	   
     else {
       i= Campo.substring(Campo.indexOf("@")+2,Campo.length);
       if (i.indexOf(".") < 1){
		 return false;
	   } 
     }
  }
  else {
	 return false
  }
return  true;
}
////////////////////////////////
//////Extensível para campos métricos.
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}


