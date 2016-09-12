<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/ajax.js" type="text/javascript"></script>

<script>
function ativacao(id) {
  document.form1.submit.disabled=true;
  document.form1.moldura.disabled=true;
  if (!document.form1.tipo[3].checked) {
     document.form1.submit.disabled=false;
     document.form1.moldura.disabled=true;
  } else {
        piece=id.split(".");
        if (piece[1]=='S') {
           document.form1.submit.disabled=false;
           document.form1.txtmoldura.value=piece[0];
           document.form1.moldura.disabled=true;
        } 
        if (piece[1]=='N') {
           document.form1.submit.disabled=true;
           document.form1.moldura.disabled=false;
        }
  }
  return true;
}

function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=350,height=370, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}

function valida()
{
 with(document.form1)
 {

    if(!tipo[0].checked && !tipo[1].checked&& !tipo[2].checked&& !tipo[3].checked){
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

function abremoldura(id) {
 win=window.open('consulta_moldura.php?id='+id+'&pop=1','moldura','left='+((window.screen.width/2)-300)+',top='+((window.screen.height/2)-250)+',width=590,height=500, scrollbars=yes, resizable=no');
 if(parseInt(navigator.appVersion)>=4) {
   win.window.focus();
 }
 return true;
}

function desabilita()
{ 
 document.getElementById('numregistro2').style.display='none';
 document.getElementById('atualiza').style.display='none';
 document.form1.submit.disabled=true;
 document.form1.moldura.disabled=true;
 
 if(document.form1.tipo[3].checked) {
	document.getElementById('molduratxt').style.display='';
 }else{
	document.getElementById('molduratxt').style.display='none';
 }
} 
function carrega_combo()
{ 
 document.getElementById('atualiza').style.display='';
 atualiza(document.getElementById('numregistro').value);
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
$txtmoldura=$_REQUEST[txtmoldura];
montalinks();
$_SESSION['lnk']=$link;



   function ret_moldura($val)
   {
    if ($val<>"")
    {
      global $db;
      $sql="select moldura from moldura where num_registro=$val";
      $db->query($sql);
      $nome=$db->dados();
      return $nome[0];
     }
     alert('teste');
    }




?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onsubmit='return valida()';this.focus(); >
     <table width="100%"  border="0" cellpadding="0" cellspacing="8" >
        <tr>
          <td colspan="4">
          </span></td>
        </tr>
        <tr>
          <td width="8%" class="texto_bold">&nbsp;</td>
          <td colspan="3" class="texto"><div align="left"><em>Informe inicialmente
              os par&acirc;metros abaixo: </em></div><br></td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="right">1)</div></td>
          <td colspan="3"><div align="left"><span class="texto_bold">
                <input name="tipo" type="radio" value="1" onclick="document.getElementById('molduratxt').style.display='none';document.form1.submit.disabled=true; document.form1.moldura.disabled=true;">
                Papel &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="tipo" type="radio" value="2" onclick="document.getElementById('molduratxt').style.display='none';document.form1.submit.disabled=true; document.form1.moldura.disabled=true;">
                  Pintura&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="tipo" type="radio" value="3" onclick="document.getElementById('molduratxt').style.display='none';document.form1.submit.disabled=true; document.form1.moldura.disabled=true;">
                  Objeto 3D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="tipo" type="radio" value="4" onclick="document.form1.submit.disabled=true; document.form1.moldura.disabled=true;">
                  Moldura
               </span></div>
           </td>
 
      
          </tr>
         <tr><td>&nbsp;</td></tr>

         <tr>
          <td class="texto_bold"><div align="right">2)</div></td>
          <td nowrap>
              <select name="tipo2" class="combo_cadastro" id="tipo2"
			   onChange="if (this.options[this.selectedIndex].value=='E' || this.options[this.selectedIndex].value=='0'){ 
			    document.getElementById('numregistro2').style.display='none';
			    document.getElementById('atualiza').style.display='none'; 
				document.form1.submit.disabled=false;
                               if (document.form1.tipo[3].checked){document.getElementById('molduratxt').style.display='';}else{document.getElementById('molduratxt').style.display='none';}
                          } else {
			    document.getElementById('numregistro2').style.display='';
				document.getElementById('atualiza').style.display='none';
				document.form1.submit.disabled=true;
                              if (document.form1.tipo[3].checked){document.getElementById('molduratxt').style.display='';}else{document.getElementById('molduratxt').style.display='none';}

                          };">
			      <option value="0" selected></option>
			      <option value="I" >Interna</option>
                              <option value="E" >Externa</option>
              </select>
		    </td>
 
            <td nowrap class="texto_bold" align="right" colspan="2"><div id='numregistro2'>
            N&ordm; do registro:
            <input name="numregistro" type="text" class="combo_cadastro" id="numregistro"  value="<? echo $numregistro ?>" size="15">
            <a href='javascript:;' onClick="carrega_combo();"><img src="imgs/icons/lupa.gif" title="Buscar Partes" border=0 ></a></div></td>

           </tr>



          <tr>

          <td colspan="2" class="texto_bold"><div id='label' align="right"></div></td>
          <td colspan="2" class="texto_bold"><div id='atualiza' align="right">Aguarde...</div></td>
          </tr>

     <tr>
        <td class="texto_bold"><div align="right">&nbsp;</div></td>
        <td>&nbsp;</td>
          <td nowrap class="texto_bold" align="right" colspan="2"><div id='txtmoldura'>
            Moldura:
            <input name="txtmoldura" type="text" class="combo_cadastro" id="txtmoldura"  value="<? echo $txtmoldura ?>" size="15">
          <a href='javascript:;' onClick="abrepop('pop_molduras.php?moldura='+document.form1.txtmoldura.value);"><img src="imgs/icons/lupa.gif" title="Buscar Moldura" border=0 ></a></div></td>
          
        </tr>

        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
         <tr>
          <td>
              <div align="left">
                <input type="text" name="textfield" style="display:none" >
              </div></td>
              <td width="45%" align="left"><input name="submit" type="submit" class="botao" value="Incluir Restauro"></td>
             <td width="45%" align="left"><input name="moldura" type="submit" class="botao" value="Cadastrar Moldura"></td>
 
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
$parteid= substr($_REQUEST[parte], 2);
if ($_REQUEST[moldura]<>'')
{       
   
            $sql= "SELECT * from moldura where num_registro=$_REQUEST[txtmoldura]";
            $db->query($sql);
            $row=$db->dados();
            $numregistro=$row['num_registro'];
            if ($numregistro=="") $numregistro=$_REQUEST[txtmoldura];
       

        if ($_REQUEST[tipo2]=="E")
        echo"<script>location.href='cadastro_moldura.php?op=insert&tipo2=2&pNum_registro=$_REQUEST[numregistro]&pId_parte=$parteid&num_registro=$numregistro';</script>";
        else
        echo"<script>location.href='cadastro_moldura.php?op=insert&tipo2=1&pNum_registro=$_REQUEST[numregistro]&pId_parte=$parteid&num_registro=$numregistro';</script>";

  

}

if($_REQUEST[submit]<>'')
{
  if($_REQUEST[tipo]=='1')
 {
    if($_REQUEST[tipo2]=='E'){
       echo"<script>location.href='restauracao_papel_externa.php?tipo2=E';</script>";}
	if($_REQUEST[tipo2]=='I'){
	   echo"<script>location.href='restauracao_papel_interna.php?op=insert&tipo2=I&pNum_registro=$_REQUEST[numregistro]&pId_parte=$parteid';</script>";}
 } // fim do if tipo 1
 if($_REQUEST[tipo]=='2')
 {
    if($_REQUEST[tipo2]=='E'){
       echo"<script>location.href='restauracao_pintura_externa.php?tipo2=E'</script>";}
	if($_REQUEST[tipo2]=='I'){
	   echo"<script>location.href='restauracao_pintura_interna.php?op=insert&tipo2=I&pNum_registro=$_REQUEST[numregistro]&pId_parte=$parteid'</script>";}
	//sendo I do tipo 2
 } // fim di if tipo 2
 if($_REQUEST[tipo]=='3')
 {
    if($_REQUEST[tipo2]=='E')
    {
       echo"<script>location.href='restauracao_obra_externa.php?tipo2=E'</script>";
     }
    if($_REQUEST[tipo2]=='I')
    {
       echo"<script>location.href='restauracao_obra_interna.php?op=insert&tipo2=I&pNum_registro=$_REQUEST[numregistro]&pId_parte=$parteid';</script>";}
      //sendo I do tipo 2
    }
  }// if do submit

?>