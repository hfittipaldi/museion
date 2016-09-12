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
  	win=window.open('consulta_obra.php?nosave=1&titulo='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-240)+',height=480,width=780,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
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
 ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=8;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total from autor as a INNER JOIN autor_obra as b on(a.autor=b.autor) INNER JOIN obra as c on(b.obra=c.obra) 
			where a.autor='$_REQUEST[id]' AND c.status='P'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2="SELECT c.* from autor as a INNER JOIN autor_obra as b on(a.autor=b.autor) INNER JOIN obra as c on(b.obra=c.obra) 
			where a.autor='$_REQUEST[id]' AND c.status='P' order by c.num_registro + 0, c.num_registro, c.titulo LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="70%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Título</div></td>
          <td width="20%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Nº de registro</div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())  {	  ?>
        <tr class="texto">
          <td width="70%"></td>
          <td width="20%"></td>
          <td width="10%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['obra'] ?>">
          <td height="23" onClick="abre_pagina(<? echo $row[obra] ?>,'<? echo htmlentities(str_replace("'","`",$row[titulo]), ENT_QUOTES); ?>');" style="cursor:pointer;" onMouseOut="this.style.textDecoration='';" onMouseOver="this.style.textDecoration='underline';"><? echo $row['titulo']; ?></td>
          <td align="center"><? echo $row['num_registro']; ?></td>
          <td align="center"></td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="5" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"lista_obras_autor.php?id=".$_REQUEST[id]."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"lista_obras_autor.php?id=".$_REQUEST[id]."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"lista_obras_autor.php?id=".$_REQUEST[id]."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"lista_obras_autor.php?id=".$_REQUEST[id]."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
 if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i value=$i onChange='obtem_valor(this)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
$g= " Total de obras do autor: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>