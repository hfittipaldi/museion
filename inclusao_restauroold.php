<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/ajax.js" type="text/javascript"></script>

<script>
function valida()
{
 with(document.form1)
 {
    if(!tipo[0].checked && !tipo[1].checked&& !tipo[2].checked){
     alert ('Selecione entre papel, pintura ou obra.');
	  return false;} 
	 if(tipo2.value==0){
	 alert('Selecione entre interna ou externa');
	  return false;}
	 if(tipo2.value=='I')
	 {
	   if(numregistro.value=='')
	   {
	     alert('Informe o Nº de registro da Obra');
		 numregistro.focus();
	     return false;
	   }
	   if(parte.value=='#'){
	   alert('É necessário escolher a parte relacionada a esta Obra');
	   return false;}
	 }
  }
}
function desabilita()
{
 document.getElementById('numregistro2').style.display='none';
 document.getElementById('atualiza').style.display='none';
 document.form1.submit.disabled=true;
} 
function carrega_combo()
{ 
 document.getElementById('atualiza').style.display='';
 atualiza(document.getElementById('numregistro').value);
 document.form1.submit.disabled=false;
}

</script>  
</head>
<body onLoad="desabilita()">      
<table width="497" height="50%"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="481" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$op=$_REQUEST['op'];
montalinks();
$_SESSION['lnk']=$link;

?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onsubmit='return valida()' >
<table width="100%"  border="0" cellpadding="0" cellspacing="8" >
        <tr>
          <td colspan="4">
          </span></td>
        </tr>
        <tr>
          <td width="8%" class="texto_bold">&nbsp;</td>
          <td colspan="3" class="texto"><div align="left"><em>Informe inicialmente
              os par&acirc;metro abaixo: </em></div><br></td>
          </tr>
        <tr>
          <td class="texto_bold"><div align="right">1)</div></td>
          <td colspan="3"><div align="left"><span class="texto_bold">
                <input name="tipo" type="radio" value="1">
                Papel &nbsp;
                <input name="tipo" type="radio" value="2">
                  Pintura&nbsp;
                <input name="tipo" type="radio" value="3">
                  Objeto 3D
                <input name="tipo" type="radio" value="4">
                  Moldura
              </span></div>
           </td>
          </tr>
        <tr>
          <td class="texto_bold"><div align="right">2)</div></td>
          <td nowrap>
              <select name="tipo2" class="combo_cadastro" id="tipo2"
			   onChange="if (this.options[this.selectedIndex].value=='E' || this.options[this.selectedIndex].value=='0'){ 
			    document.getElementById('numregistro2').style.display='none';
			    document.getElementById('atualiza').style.display='none'; 
				document.form1.submit.disabled=false;}
			   else {
			    document.getElementById('numregistro2').style.display='';
				document.getElementById('atualiza').style.display='none';
				document.form1.submit.disabled=true;};">
			      <option value="0" selected></option>
				  <option value="I" >Acervo do Museu</option>
                  <option value="E" >Não é Acervo do Museu</option>
              </select>
		    </td>
          <td nowrap class="texto_bold" align="right" colspan="2"><div id='numregistro2'>
            N&ordm; do registro:
            <input name="numregistro" type="text" class="combo_cadastro" id="numregistro"  value="<? echo $numregistro ?>" size="15">
          <a href='javascript:;' onClick="carrega_combo()"><img src="imgs/icons/lupa.gif" title="Buscar Partes" border=0 ></a></div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"><div id='label' align="right"></div></td>
          <td colspan="2" class="texto_bold"><div id='atualiza' align="right">Aguarde...</div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="20%">
              <div align="left">
                <input type="text" name="textfield" style="display:none" >
              </div></td>
        
              <td align="left"><input name="submit" type="submit" class="botao" value="Incluir"></td>

          </tr>
      </table>
      <br>
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>

<?
///////////////
//1: para papel
//2:  "   pintura
//num: " numero do registro.
//nao sera mais chamado o controle e sim  o objeto associado a sua chave(parte).
/////////////////
global $db;
if($_REQUEST[submit]<>'')
{
  if($_REQUEST[tipo]=='1')
 {
    if($_REQUEST[tipo2]=='E'){
       echo"<script>location.href='restauracao_papel_externa.php?tipo2=E';</script>";}
	if($_REQUEST[tipo2]=='I'){
	   echo"<script>location.href='restauracao_papel_interna.php?op=insert&tipo2=I&pNum_registro=$_REQUEST[numregistro]&pId_parte=$_REQUEST[parte]';</script>";}
 } // fim do if tipo 1
 if($_REQUEST[tipo]=='2')
 {
    if($_REQUEST[tipo2]=='E'){
       echo"<script>location.href='restauracao_pintura_externa.php?tipo2=E'</script>";}
	if($_REQUEST[tipo2]=='I'){
	   echo"<script>location.href='restauracao_pintura_interna.php?op=insert&tipo2=I&pNum_registro=$_REQUEST[numregistro]&pId_parte=$_REQUEST[parte]';</script>";}
	//sendo I do tipo 2
 } // fim di if tipo 2
 if($_REQUEST[tipo]=='3')
 {
    if($_REQUEST[tipo2]=='E'){
       echo"<script>location.href='restauracao_obra_externa.php?tipo2=E'</script>";}
	if($_REQUEST[tipo2]=='I'){
	   echo"<script>location.href='restauracao_obra_interna.php?op=insert&tipo2=I&pNum_registro=$_REQUEST[numregistro]&pId_parte=$_REQUEST[parte]';</script>";}
	//sendo I do tipo 2
 }
}// if do submit

?>