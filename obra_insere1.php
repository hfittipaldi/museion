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
document.location=('obra_insere1.php?movid=<? echo $_REQUEST[movid] ?>&page='+ i+ '&registro=<? echo $_REQUEST[registro] ?>&titulo=<? echo $_REQUEST[titulo] ?>');
}}

function abrepop(janela) {
	win=window.open(janela,'lista_imagem','left='+((window.screen.width/2)-740/2)+',top='+((window.screen.height/2)-520/2)+',width=720,height=460,scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}

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
	$db2=new conexao();
	$db2->conecta();
 ?>

<body>
<? if (trim($_REQUEST['registro']) <> '' || trim($_REQUEST['titulo']) <> '') { ?>
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
	 $sql= "SELECT count(*) from obra where (num_registro = '$_REQUEST[registro]' or '$_REQUEST[registro]' = '') AND (titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]' = '')";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2= "SELECT obra,num_registro,titulo from obra where (num_registro = '$_REQUEST[registro]' or '$_REQUEST[registro]' = '') AND (titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]' = '') 
			order by titulo LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="75%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;"><div align="left"> &nbsp;Pesquisa de Obra a Vincular</div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold" style="border-right: 1px solid #121212;"><div align="center"></div>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="">
		<? while($row=$db->dados()) {  ?>
        <tr class="texto">
          <td width="75%"></td>
          <td width="15%"></td>
          <td colspan="2" width="10%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['obra'] ?>">
          <td><? echo $row['num_registro'].". ".$row['titulo']; ?></td>
  

         <td align="center"><? echo "<a href=\"javascript:abre_pagina($row[obra],'');\">
			  <img src='imgs/icons/visualiza.gif' border='0' alt='Visualizar'
	                              onMouseOver='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"#ddddd5\";' 
		                onMouseOut='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"\";'>";?>
         </td>

          <td align="center"><? echo "<a href=\"obra_insere.php?op=add&movid=".$_REQUEST['movid']."&obra=".$row['obra']."\">
						<img src='imgs/icons/ic_adicionar.gif' border='0' alt='Adicionar à lista' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"\";'>";?>
		  </td>
        </tr>
		<? } ?>

       <tr>
          <td colspan="3" bgcolor=""><br><br></td>
        </tr>

        <tr>
          <td colspan="3" bgcolor="#000000"></td>
        </tr>
        <tr bgcolor="" class="texto">
          <td colspan="4" height="1"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

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
$g= " Total de obras encontradas: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo";
echo"&nbsp";

//echo"<font color='ffffff'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
    </form>
        <tr>
          <td colspan="4" class="texto_bold"><? echo "<a href=\"obra_insere.php?movid=".$_REQUEST[movid]."\"><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar' >"?></td>
        </tr>
	</td>
  </tr>
</table>
<? } else{ ?>
	<script>alert('Preencha com algum parametro!'); location.href="obra_insere.php?movid=<? echo $_REQUEST[movid]; ?>";</script>
<? } ?>
</body>
</html>