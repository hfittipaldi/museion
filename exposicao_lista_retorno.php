<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();

	$movid= $_REQUEST['movid'];

	$tipo= 'movimentacao';
	$valor= $movid;
	$parametro= 'movid';
 ?>

<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('exposicao_lista_retorno.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);
}}
</script>

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
	 $sql="SELECT count(*) as total FROM exposicao as a  INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao) where $tipo='$valor'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2="SELECT a.exposicao as expid,a.nome,b.* FROM exposicao as a  INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao) where $tipo='$valor' order by a.dt_inicial,a.nome LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="2" bgcolor="#000000" class="texto_bold"  style="border-left: 1px solid #121212;"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="100%" height="24" class="texto_bold"><div align="left" > &nbsp;Número / Exposição </div></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
        <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
          <? while($row=$db->dados())
	  {
	  ?>
          <tr class="texto"> 
            <td width="100%" colspan="2"></td>
          </tr>
          <tr class="texto" id="cor_fundo<? echo $row['expid'] ?>"> 
            <td width="80%" height="23"><? echo "<em>".$row['expid']."</em>. ". $row['nome']; ?></td>
          <td align="center"><? echo "<a href=\"mov_exp_consulta.php?op=view&".$parametro."=".$valor."&id=".$row['expid']."\">
						<img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		  </td>
          </tr>
          <? } ?>
          <tr class="texto"> 
            <td colspan="2">&nbsp;</td>
          </tr>
        <tr bgcolor="#96ADBE">
          <td colspan="2" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
          <tr bgcolor="#ddddd5" class="texto"> 
            <td colspan="2" height="20"> 
              <? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"exposicao_lista_retorno.php?".$parametro."=".$valor."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"exposicao_lista_retorno.php?".$parametro."=".$valor."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"exposicao_lista_retorno.php?".$parametro."=".$valor."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"exposicao_lista_retorno.php?".$parametro."=".$valor."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de exposições da movimentação: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>";   
?>
                  <div align="center"></div></td>
          </tr>
        <tr bgcolor="#96ADBE">
          <td colspan="2" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
          <tr> 
            <td colspan="3"></td>
          </tr>
        </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>