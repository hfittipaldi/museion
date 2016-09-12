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
document.location=('obra_lista.php?movid=<? echo $_REQUEST[movid] ?>&page='+ i);

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
 ?>
<body>
<table width="<? if ($_REQUEST[pagesize] < 999) echo "100%"; else echo "520"; ?>" border="0" align="left" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=8;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total from obra_movimentacao where movimentacao='$_REQUEST[movid]'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2="SELECT a.num_registro,a.titulo,b.*,b.data_saida as saida_obra FROM obra as a  INNER JOIN  obra_movimentacao as b on (a.obra=b.obra) where movimentacao='$_REQUEST[movid]' order by a.num_registro";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
       <tr><td>&nbsp;</td></tr>

        <tr bgcolor="#96ADBE">
          <td colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
<?if ($numlinhas==1){ $g= " ($numlinhas obra)";}else{$g= " ($numlinhas obras)";}?>

          <td width="15%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;" ><div align="left"><?echo $g;?></div></td>
          <td width="45%" height="24" bgcolor="#ddddd5" class="texto_bold" ><div align="left"> &nbsp;Nº reg / Obra</div></td>
          <td width="20%" bgcolor="#ddddd5" class="texto_bold"><div align="left">Data de saída</div></td>
          <td width="5%" bgcolor="#ddddd5" class="texto_bold"><div align="center"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"obra_lista_pesquisa_1.php?page=1&pagesize=999999&movid=".$_REQUEST[movid]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold" style="border-right: 1px solid #121212;"><div align="center"><? if ($_REQUEST[pagesize] < 999) { echo "<a href=\"obra_insere.php?op=insert&movid=".$_REQUEST[movid]."\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar obra'>"; } ?></div></td>

        </tr>
        <tr>
          <td colspan="8" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="2"></td>

 
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#f2f2f2">
		<? while($row=$db->dados())
	  {
			$dtsaida= explode("-", $row['saida_obra']);
			$dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			$dtsaida= $dia."/".$mes."/".$ano;
			if ($dtsaida=="00/00/0000" || $dtsaida=="//")
				$dtsaida= "--/--/----";
	  ?>
        <tr class="texto">
          <td width="15%"></td>
          <td width="45%"></td>
          <td width="20%"></td>
          <td width="5%"></td>
          <td width="15%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['obra_movimentacao'] ?>">
          <td>&nbsp;</td>
          <td height="23"><? echo $row['num_registro'] . ". " . $row['titulo']; ?></td>

 
          <td align="center"><? echo $dtsaida; ?>&nbsp;&nbsp;
					<? if ($_REQUEST[pagesize] < 999) { if ($dtsaida <> "--/--/----") {
						 echo "<a href=\"mov_obra_data.php?op=limpar&movid=".$_REQUEST['movid']."&obra=".$row['obra']."\">
						 <img src='imgs/icons/ic_apagar.gif' border='0' alt='Limpar data' 
						 onMouseOver='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"#ddddd5\";' 
						 onMouseOut='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"\";'></a>"; } } ?>
		  </td>

 
          <td align="center">
					<? if ($_REQUEST[pagesize] < 999) { echo "<a href=\"mov_obra_data.php?movid=".$_REQUEST['movid']."&obra=".$row['obra']."\">
					 <img src='imgs/icons/ic_calendar.gif' border='0' alt='Alterar data' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"\";'></a>"; } ?>
		  </td>

        <td align="center"><? echo "<a href=\"javascript:abre_pagina($row[obra],'');\">
			  <img src='imgs/icons/visualiza.gif' border='0' alt='Visualizar'
	                              onMouseOver='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"#ddddd5\";' 
		                onMouseOut='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"\";'>";?>
         </td>

          <td align="center">
					<? if ($_REQUEST[pagesize] < 999) { echo "<a href=\"obra_insere.php?op=del&movid=".$_REQUEST['movid']."&id=".$row['obra_movimentacao']."\"
					 onClick='return confirm(".'"O item será removido da lista. Confirma Remoção ?"'.")'><img src='imgs/icons/ic_remover.gif' border='0' alt='Remover da lista' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"\";'>"; } ?>
		  </td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td colspan="3">&nbsp;</td>
          </tr>
        <tr class="texto">
        </tr>
        <tr bgcolor="#96ADBE">
          <td colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="2"></td>
        </tr>
        <tr  class="texto">
          <td colspan="7" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"obra_lista.php?movid=".$_REQUEST[movid]."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"obra_lista.php?movid=".$_REQUEST[movid]."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"obra_lista.php?movid=".$_REQUEST[movid]."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"obra_lista.php?movid=".$_REQUEST[movid]."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}
?>               
            <div align="center"></div></td>
          </tr>
       </table>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>