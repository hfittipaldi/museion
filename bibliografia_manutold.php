<? //include_once("seguranca.php") ?>
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
document.location=('bibliografia_manut.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);

//document.location=('bibliografia_manut.php?obrid=<? echo $_REQUEST[obra] ?>&page='+ i);

}}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
        $obrid=$_REQUEST['obra'];

	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];



 ?>
<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="8" >
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
	 $sql="SELECT count(*) as total from bibliografia where bibliografia not in (select bibliografia from obra_bibliografia)";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT b.bibliografia,b.referencia,b.autoria,b.local,b.editora,b.ano from bibliografia as b 
	   where bibliografia not in (select bibliografia from obra_bibliografia) LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="70%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Referências bibliográficas </div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['bibliografia'] ?>">
          <td colspan="2"><? 
                             echo "- ".$row[autoria].".&nbsp;<em><b>".htmlentities($row['referencia'], ENT_QUOTES)."</b></em>.&nbsp;".$row[local].",&nbsp;";
			     if ($row[editora]!='')
					echo $row[editora].",&nbsp;";
			     if ($row[ano]!='0'){
					echo $row[ano].".&nbsp;";}
			     else {
					echo "s/d".".&nbsp;";}

                          ?></td>
          <td>
            <div align="center"><? echo "<a href=\"bibliografia_manut1.php?op=delbib&bib=".$row['bibliografia']."\"
	onClick='return confirm(".'"Confirma Exclus&atilde;o do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20'
	border='0' alt='Excluir' 
	onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?>
		    </div>
          </td>


        </tr>

        <? } ?>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
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

$a="<a href=\"bibliografia_manut.php?".$parametro."=".$valor."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"bibliografia_manut.php?".$parametro."=".$valor."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"bibliografia_manut.php?".$parametro."=".$valor."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"bibliografia_manut.php?".$parametro."=".$valor."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de bibliografias para esta obra: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
          <input name="bibliografia" type="hidden" id="bibliografia" value="<? echo $bibliografia ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
    </form>
	</td>
  </tr>
</table>
</body>
</html>
