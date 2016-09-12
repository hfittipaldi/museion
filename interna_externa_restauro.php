<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/ajax.js" type="text/javascript"></script>

<script>
function cancela()
{

document.form1.submit.submit=window.close();


  return true;
}
function ativacao(id) {
  
  document.form1.submit.disabled=true;
  document.form1.moldura.disabled=true;
        if (id.substr(0,1)=='S') {
           document.form1.submit.disabled=false;
           document.form1.moldura.disabled=true;
           document.getElementById('possui').style.display='';
        } 
        if (id.substr(0,1)=='N') {
           document.form1.submit.disabled=true;
           document.form1.moldura.disabled=false;
          document.getElementById('possui').style.display='none';

        }
  return true;
}

function desabilita()
{ 
 document.getElementById('numregistro2').style.display='';
 document.getElementById('possui').style.display='none';
 document.getElementById('atualiza').style.display='';
 document.form1.submit.disabled=true;
 } 


function carrega_combo()
{ 
 document.getElementById('atualiza').style.display='';
 atualiza(document.getElementById('numregistro').value);
}
</script>  
</head>
<body onLoad="desabilita()">      
<table width="100%" height="100%"  border="1" align="left" cellpadding="0" cellspacing="1">
  <tr>
  	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$op=$_REQUEST['op'];
$id_moldura=$_REQUEST[id_moldura];
$num_registro=$_REQUEST[num_registro];



?>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onsubmit=this.focus(); >
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
           <tr> 
           <td>
         <table width="100%"  border="1" align="left" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2"> 
             <?echo "<span class='tit_interno'>Restauração / Moldura / Alterar /  interna - externa"."</span>";?>
            </table>
         </td>
       </tr>
       <tr>
        <td>
          <table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" >
           <tr width="90%">
            <br><br> 
        <td class="texto_bold"><div align="right">&nbsp;</div></td>
        <td>&nbsp;</td>
 
            <td nowrap class="texto_bold" align="right" colspan="2"><div id='numregistro2'>
            N&ordm; do registro:
            <input name="numregistro" type="text" class="combo_cadastro" id="numregistro"  value="<? echo $numregistro ?>" size="15">
            <a href='javascript:;' onClick="carrega_combo()"><img src="imgs/icons/lupa.gif" title="Buscar Partes" border=0 ></a></div></td>


              <td width="90%" nowrap class="texto_bold" align="left" colspan="0"><div id='label'></div></td>
              <td width="90%" nowrap class="texto_bold" align="left" colspan="0"><div id='atualiza' ></div></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
          </table>
       </td>
      </tr>
    </table>
          <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
            <tr width="100%">
             <td width="100%"class="texto" align="center" colspan="0">
                <div id='possui' width="100%"><font bgcolor='#c7c7c7' style='font-family:arial,times new roman;color:brown; font-weight:normal; font-size:12px;'><i>A Parte já possui muldura cadastrada!</i><font>
                 </div>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
          </table>
          <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
              <tr width="100%">
               <div align="left">
                <input type="text" name="textfield" style="display:none" >
              </div></td>
               <td width="45%" align="right"><input name="moldura" type="submit" class="botao" value="Alterar"></td>
               <td width="10%" align="left">&nbsp;</td>
               <td width="45%" align="left"><input name="submit" type="submit" class="botao" value="Fechar" onClick="cancela()"></td>
            </tr>
          </table>
 
    </form>
      </td>
     </tr>
   </table>
 </body>
</html>

<?
global $db;
$parteid= substr($_REQUEST[parte], 2);
echo $_REQUEST[numregistro];


?>