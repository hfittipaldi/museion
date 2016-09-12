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
document.location=('consulta_parte_obra.php?obra=<? echo $_REQUEST[obra] ?>&page='+ i);

}}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
 ?>
<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total from parte where obra='$_REQUEST[obra]'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.* from parte as a where a.obra='$_REQUEST[obra]' order by controle LIMIT $registroinicial,$pagesize ";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="21%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;&nbsp;Controle </div></td>
          <td width="55%" bgcolor="#ddddd5" class="texto_bold">&nbsp;Nome
            da parte </td>
          <td width="24%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['parte'] ?>">
          <td width="21%">&nbsp;<? echo $row[controle] ?></td>
          <td width="55%"><? echo $row[nome_objeto] ?></td>
          <td width="12%" align="center"><? echo "<a href=\"consulta_parte_obra1.php?op=view&obra=".$row[obra]."&parte=".$row[parte]."\">
	 <img src='imgs/icons/relat.gif' width='20' height='20'border='0' alt='Informações' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"\";'>"; }?>
		  </td>
          <td width="12%" align="center">&nbsp;
		  </td>
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="" class="texto">
          <td colspan="4" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"consulta_parte_obra.php?obra=$_REQUEST[obra]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"consulta_parte_obra.php?obra=$_REQUEST[obra]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"consulta_parte_obra.php?obra=$_REQUEST[obra]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"consulta_parte_obra.php?obra=$_REQUEST[obra]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
//echo"$lista_combo";
$g= " Total de partes da obra: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
