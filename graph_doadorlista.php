<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual,i) {
if (qual.selectedIndex.selected!= '') {
document.location=('graph_doadorlista.php?page='+i);
}}

function abre_grafico(p1,p2,p3)
{
  	win=window.open('graphdoador.php?p1='+p1+'&p2='+p2+'&p3='+p3,'Grafico','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-225)+',scrollbars=no, height=450,width=740,status=no,toolbar=no,menubar=no,location=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>
</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="5%" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
montalinks();
$_SESSION['lnk']= $link;
?>
    </div></th>
  </tr>
  <tr>
    <td valign="top" colspan="2"><form name="form1"  method="post">
    <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(*) T  FROM  obra a
            WHERE a.forma_aquisicao = 'D'group by a.doador ORDER BY T DESC";
	  $db->query($sql);
	  $numlinhas=$db->contalinhas();
	 
	  $sql2="SELECT distinct count(a.doador) FROM obra a WHERE a.forma_aquisicao='D'";
	  $db->query($sql2);
	  $tot_geral=$db->dados();
	 
	  $sql3="SELECT a.doador, count( * ) T, a.obra FROM obra a
      WHERE a.forma_aquisicao='D' GROUP BY a.doador ORDER BY T DESC   LIMIT $registroinicial,$pagesize";
	  
	  $db->query($sql3); 
	 
	 ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="44%" height="24" bgcolor="#ddddd5" class="texto_bold">&nbsp;&nbsp;Doador</td>
          <td width="12%" bgcolor="#ddddd5" class="texto_bold"> <div align="center"></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">              </div></td>
          <td width="14%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td colspan="8" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	    ?>
        <tr class="texto" id="<? echo $row[doador] ?>">
          <td align="justify" height="20"><b>&nbsp;<? echo $row[doador] ?></b> 
		  </td>
          <td align="center" width='14%'><? // nao passar op=view senao fara insert em log_pesquisa 
	 echo "<a href=\"javascript:;\" OnClick=\"abre_grafico(".$tot_geral[0].",".$row[T].",'".$row[doador]." (".$row[T].")"."')\" > 
	 <img src='imgs/icons/ic_graph.gif'  border='0' alt='Visualizar gráfico' 
	 onMouseOver='document.getElementById(\"".$row[doador]."\").style.backgroundColor=\"#f2eee5\";' 
	 onMouseOut='document.getElementById(\"".$row[doador]."\").style.backgroundColor=\"\";'>";} ?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="3"></td>
        </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
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

$a="<a href=\"graph_doadorlista.php?page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial'></a>";

$b="<a href=\"graph_doadorlista.php?page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior'></a>";

$c="<a href=\"graph_doadorlista.php?page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro'></a>";

$d="<a href=\"graph_doadorlista.php?page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro'></a>";

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
$g= "<b>".$numlinhas."</b> doadores, <b>".$tot_geral[0]."</b> obras - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";
echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
<? //} ?>
</table>
</body>
</html>