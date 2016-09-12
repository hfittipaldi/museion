<? //include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor1() {
$_REQUEST['lista']='1';
document.location=('movimento_lista_obra.php?obrid=<? echo $_REQUEST[obrid] ?>&page='+ i);
}
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('movimento_lista_obra.php?obrid=<? echo $_REQUEST[obrid] ?>&page='+ i);

}}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
	$db2=new conexao();
	$db2->conecta();
        $lista=$_REQUEST['lista'];

 ?>
<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
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
	 $sql="SELECT count(*) as total from obra_movimentacao where obra='$_REQUEST[obrid]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.data_saida as saida_obra,a.data_retorno as retorno_obra,b.* from obra_movimentacao as a inner join movimentacao as b on(a.movimentacao=b.movimentacao) 
	   		where a.obra='$_REQUEST[obrid]' order by a.data_saida desc LIMIT $registroinicial,$pagesize ";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>




      <table align="center" width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="50%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212; "><div align="left"> &nbsp;Local/Instituição    (Total de movimentação: <?echo $numlinhas;?>)</div></td>
          <td width="13%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Tipo</div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Data saída</div></td>
          <td width="12%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Ret. provável</div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Ret. efetivo</div></td>

         <?if (($numlinhas>0) and ($_REQUEST[op_obra]=='update')){?>   
        
          <td width="5%" bgcolor="#ddddd5" align="center" >
      <?
          $comando="<a href=\"movimento_lista_obra.php?obrid=$_REQUEST[obrid]&lista=1\"; onClick=''>";
          echo $comando;
      ?>
         <img src='imgs/icons/btn_listar.gif'  border='0' alt='Listar'></a>
          </td>

      <?}?>
          <td width="5%" bgcolor="#ddddd5" align="center" style="border-right: 1px solid #121212; ">&nbsp;&nbsp;</td>
       </tr>


       <tr bgcolor="#96ADBE">
          <td  height="2" width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>     


 
<?if ($lista=='1'){?>  
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {
			$local="";
			if ($row['tipo_mov']=='EI' || $row['tipo_mov']=='LI') {
				if ($row['tipo_mov']=='LI' && $row['local_int_legado']<>'') {
					$txtTipo= '<font style="color:navy;">Interna</font>';
					$local= $row['local_int_legado'];
				} else {
					$txtTipo= '<font style="color:navy;">Interna</font>';
					$sql= "SELECT nome from local where local = '$row[local_destino]'";
					$db2->query($sql);
					$local= $db2->dados();
					$local= $local['nome'];
				}
			}
			elseif ($row['tipo_mov'] == 'EE') {
				$txtTipo= '<font style="color:maroon;">Externa</font>';
				$sql= "SELECT a.instituicao from exposicao as a, movimentacao_exposicao as b where a.exposicao = b.exposicao AND b.movimentacao = '$row[movimentacao]'";
				$db2->query($sql);
				$local= $db2->dados();
				$local= $local['instituicao'];
			}
			elseif ($row['tipo_mov'] == 'LE') {
				$txtTipo= '<font style="color:maroon;">Externa</font>';
				$local= $row['local_externo'];
			}

			$dtsaida= explode("-", $row['saida_obra']);
			$dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			$dtsaida= $dia."/".$mes."/".$ano;
			if ($dtsaida=='00/00/0000' || $dtsaida=="//")
				$dtsaida= "--/--/----";
			$dtretp= explode("-", $row['retorno_provavel']);
			$dia=$dtretp[2]; $mes=$dtretp[1]; $ano=$dtretp[0];
			$dtretp= $dia."/".$mes."/".$ano;
			if ($dtretp=='00/00/0000' || $dtretp=="//")
				$dtretp= "--/--/----";
			$dtrete= explode("-", $row['retorno_obra']);
			$dia=$dtrete[2]; $mes=$dtrete[1]; $ano=$dtrete[0];
			$dtrete= $dia."/".$mes."/".$ano;
			if ($dtrete=='00/00/0000' || $dtrete=="//")
				$dtrete= "--/--/----";
	  ?>
        <tr class="texto">
          <td width="51%"></td>
          <td width="14%"></td>
          <td width="11%"></td>
          <td width="13%"></td>
          <td width="11%"></td>
        </tr>
        <tr class="texto">
          <td height="23"><? echo $local; ?></td>
          <td align="center"><? echo $txtTipo; ?></td>
          <td align="center"><? echo $dtsaida; ?>
          <td align="center"><? echo $dtretp; ?>
          <td align="center"><? echo $dtrete; ?>
		  </td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="5" height="20">
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>

<?}?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>