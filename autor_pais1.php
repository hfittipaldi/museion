<? include_once("seguranca.php") ?>
<html>
<head>
<title>Autores por País de Nascimento</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style>
@media print {
	.noprint {
		display: none;
	}
}
</style>
<script>
function obtem_valor(qual,i) {
if (qual.selectedIndex.selected!= '') {
document.location=('autor_pais1.php?page='+i+'&pais=<? echo $_REQUEST[pais]?>');
 }
}

</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="469" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$op=$_REQUEST['op'];
if ($_REQUEST[pagesize] < 999) {
echo $_SESSION[lnk];
}
?>
    </div></th>
    <th width="45" scope="col"><? if ($_REQUEST[pagesize] < 999) echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"?></th>
  </tr>
  <tr>
    <td colspan="2" valign="top"><form name="form1" method="post" action="">
      <?
 function ret_pais($valor) 
	  {
           global $db,$res;
	      $sql="SELECT nome from pais where pais='$valor'";
		  $db->query($sql);
	      $res=$db->dados();
		  $res=$res[0];
       }
ret_pais($_REQUEST[pais]);
	
	  /////Paginando
	  $pagesize=10;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(*) as total FROM autor a, pais b WHERE a.pais_nasc = b.pais AND b.pais = '$_REQUEST[pais]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	    $sql2="SELECT a.* FROM autor a, pais b WHERE a.pais_nasc = b.pais AND b.pais='$_REQUEST[pais]'
             ORDER BY a.nomeetiqueta ASC LIMIT $registroinicial,$pagesize"; 
	    $db->query($sql2);
	  ////////////////////

	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="65%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;Autores nascidos em: <font style="color: brown;"><? echo $res; ?></font></div></td>
          <td width="11%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="11%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="13%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['autor'] ?>">
          <td colspan="3" align="justify"><b><? echo $row['nomeetiqueta'] ?></b> - 
            <? $nasc='';
					$sql="SELECT nome from pais where pais = '$row[pais_nasc]'";
					$db2->query($sql);
					$pais= $db2->dados();
					$pais= $pais['nome'];
					if (strtoupper($pais) == 'BRASIL') {
						$sql= "SELECT uf from estado where estado = '$row[estado_nasc]'";
						$db2->query($sql);
						$estado= $db2->dados();
						$estado= $estado['uf'];
						$nasc.= $row[cidade_nasc].", ".$estado." ";
					}
					else {
						if ($row[cidade_nasc]=='?' && $pais=='?')
							$nasc.= "? ";
						else
							$nasc.= $row[cidade_nasc].", ".$pais." ";
					}

					if ($row[dt_nasc_tp] == 'circa')
						$nasc.= " circa ";

					if ($row[dt_nasc_ano1] <> '0') {
						$nasc.= $row[dt_nasc_ano1];
					}
					if ($row[dt_nasc_ano2] <> '0') {
						if ($row[dt_nasc_ano2] <> $row[dt_nasc_ano1])
						$nasc.= " / ".$row[dt_nasc_ano2];
					}

					if ($row[dt_nasc_tp] == '?')
						$nasc.=" (?) ";
				echo $nasc;
				?>
            <div align="center">
            </div>
            <div align="center"></div></td>
          <td align="center" width='13%'><? // nao passar op=view senao fara insert em log_pesquisa 
	 if ($_REQUEST[pagesize] < 999) echo "<a href=\"consulta_autor.php?id=".$row['autor']."&nosave=1\"> 
	 <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informa&ccedil;&otilde;es' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";} ?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td width="63%"></td>
          <td width="13%"></td>
          <td width="11%"></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"autor_pais1.php?pagesize=999999&page=1&pais=".$_REQUEST[pais]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
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

$a="<a href=\"autor_pais1.php?page=".$first."&pais=".$_REQUEST[pais]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"autor_pais1.php?page=".$menos."&pais=".$_REQUEST[pais]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"autor_pais1.php?page=".$mais."&pais=".$_REQUEST[pais]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"autor_pais1.php?page=".$last."&pais=".$_REQUEST[pais]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
  if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i onChange='obtem_valor(this,this.value)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
//echo"$lista_combo";
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}
$g= " Total de registros encontrados: $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <p>
          <input name="est" type="hidden" id="est" value="<? echo $est ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">

		  <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
