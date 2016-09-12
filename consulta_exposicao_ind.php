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
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
	if ($movid <> '') {
		$tipo= 'movimentacao';
		$valor= $movid;
		$parametro= 'movid';
	}
	elseif ($obrid <> '') {
		$tipo= 'obra';
		$valor= $obrid;
		$parametro= 'obrid';
	}
	elseif ($autid <> '') {
		$tipo= 'autor';
		$valor= $autid;
		$parametro= 'autid';
	}
	else
		echo "<script>alert('Tipo não informado!'); history.back();</script>";
 ?>

<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('consulta_exposicao_ind.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);
}}
</script>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=8;
	  if ($tipo == 'autor')
		  $pagesize=6;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total FROM exposicao as a 
	 INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao) where $tipo='$valor' and tipo='I'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2="SELECT a.exposicao as expid,a.cidade,a.nome,a.instituicao,a.estado,a.periodo,b.* FROM exposicao as a  
	  INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao) where $tipo='$valor' 
	     and tipo='I' order by a.dt_inicial,a.nome LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="70%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-right: 1px solid #121212;border-left: 1px solid #121212;"><div align="left"> &nbsp;T&iacute;tulo </div></td>
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
          <td width="70%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['expid'] ?>">
          <td colspan="3"><? echo "- "."<b>". $row['nome']."</b>".", ".$row['instituicao'].", ".$row['cidade'].", ".$row['periodo']."<br>";
              echo  "<font color='darkred'>".$row['premio']; 
              ?>
		    <div align="center"></div></td>
		  <? if ($movid <> '') { ?>
          <? } else { ?>
		  <? } ?>
          <td align="center"><? echo "<a href=\"consulta_expo1.php?op=view&tipoexp=I&".$parametro."=".$valor."&id=".$row['expid']."\">
						<img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		  </td>
          <td align="center">&nbsp;
		  </td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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

$a="<a href=\"?".$parametro."=".$valor."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"?".$parametro."=".$valor."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"?".$parametro."=".$valor."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"?".$parametro."=".$valor."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de exposições: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
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
    </form>
	</td>
  </tr>
</table>
</body>
</html>