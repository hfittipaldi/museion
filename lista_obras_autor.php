<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('lista_obras_autor.php?id=<? echo $_REQUEST[id] ?>&page='+ i);
}}

function abre_pagina(idobra,title)
{ 
  	win=window.open('consulta_obra_2.php?nosave=1&num_registro='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-240)+',height=520,width=780,scrollbars=yes,status=no,toolbar=no,menubar=no,location=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
              $lsita=$_REQUEST['lista'];
 ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
         $numlinhas=0;
	 $sql="SELECT count(*) as total from autor as a INNER JOIN autor_obra as b on(a.autor=b.autor) INNER JOIN obra as c on(b.obra=c.obra) 
			where a.autor='$_REQUEST[id]' AND c.status='P'";
         
	 $db->query($sql);
	 $numlinhas=$db->dados();
         $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2="SELECT c.* from autor as a INNER JOIN autor_obra as b on(a.autor=b.autor) INNER JOIN obra as c on(b.obra=c.obra) 
			where a.autor='$_REQUEST[id]' AND c.status='P' order by c.num_registro + 0, c.num_registro, c.titulo";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>

    <table align="center" width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="100%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;" ><div align="left">Total de obras do autor: <?echo $numlinhas;?> </div>
             </td>
          <td width="7%" align="center" ><? $ref="exposicao_insere2.php?lista=".$lista."&op=insert&".$parametro."=".$valor;?>        
      <?
          $comando="<a href=\"lista_obras_autor.php?id=$_REQUEST[id]&lista=1\";>";
          echo $comando;
      ?>
         <img src='imgs/icons/btn_listar.gif'  border='0' alt='Listar'></a>
          </td>
          <td width="7%" align="center" >&nbsp;&nbsp;</td> 
          
        <td width="7%" align="center" style="border-right: 1px solid #121212;">&nbsp;&nbsp;</td>
        </tr>
         <tr>
          <td height="2" colspan="8" bgcolor="#000000" style="border-right: 1px solid #121212;"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table> 


<? if ($_REQUEST['lista']=='1')
{?>      
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
   <? while($row=$db->dados()) 
   {?>
     <tr class="texto">
        <td width="20%"></td>
        <td width="80%"></td>
      </tr>
      <tr class="texto" id="cor_fundo<? echo $row['obra'] ?>">
         <td align="left"><? echo $row['num_registro']; ?></td>
         <td align="left" height="15"><? echo $row['titulo']; ?></td>
         <td width="5%" align="center"><? echo "<a href=\"javascript:abre_pagina($row[obra],'');\">
			  <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações'  
	      onMouseOver='document.getElementById(\"cor_fundo".$row[log_pesquisa]."\").style.backgroundColor=\"#ddddd5\";' 
		  onMouseOut='document.getElementById(\"cor_fundo".$row[log_pesquisa]."\").style.backgroundColor=\"\";'>";?>
         </td>
     </tr>
 <? } ?>
     <tr class="texto">
        <td colspan="4" height="20">
        <div align="center"></div></td>
     </tr>
    <tr>
       <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
   </tr>
  <tr>
    <td colspan="4"></td>
  </tr>
</table>
<?}?>
</form>
</td>
</tr>
</table>
</body>
</html>