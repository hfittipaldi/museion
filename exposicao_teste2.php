<? //include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual,pag,niv) {
	if (qual.selectedIndex.selected != '') {
		document.location=('exposicao_teste2.php?id=<? echo $_REQUEST[id] ?>&page=' + pag +'&tipo=' + niv);
		}
}
</script>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
	//////////  Verifica se existe alguma exposicao do tipo I/C para o usuario;
	$sql_init="select tipo from exposicao as a where a.autor='$_REQUEST[id]' and (a.tipo='I' OR a.tipo='C')";
	$db->query($sql_init);
	$res=$db->dados();
	if($res==null)
	{
	  include("exposicao_prev.php");
exit; 
}
 ?>

</head>
<body onload="if (navigator.appName != 'Netscape') { document.getElementById('tipo').options[0]= null; }   if ('<? echo $tipo; ?>' == 'nenhum') { document.getElementById('tipo').selectedIndex=-1; }">
<table width="484"  border="0" align="left" cellpadding="0" cellspacing="8" >
  <tr>
    <th width="468" bgcolor="ccccff" class="texto_bold" scope="col"><div align="left" class="tit_interno">
      <span class="texto_bold">
      Selecione o tipo da exposi&ccedil;&atilde;o:
      <?
 if($res!=null)
 {
	/////////
	$pagesize=1;
	$page=1;
	if(!empty($_GET['page']))
		$page=$_GET['page'];
	$page--;
	$registroinicial=$page*$pagesize;

	$tipo='nenhum';
	if(!empty($_GET['tipo']))
		$tipo=$_GET['tipo'];
		
			$sql="SELECT distinct(tipo) from exposicao as a where a.autor='$_REQUEST[id]'";
			
			$db->query($sql);
			function troca($tipo)
			{
			  if($tipo=='C')
			   {
			   return 'COLETIVA';
				}
			  else
			  {
			   return 'INDIVIDUAL';
              }
			}			
			$i=0;
			$combo = "<option value='0'></option>";
			$combo.="<option value='T' selected>TODOS</option>";
			while($res=$db->dados()) {
				if ($res[tipo]==$tipo){
				   $combo = $combo . "<option value='$res[tipo]' selected>".troca($res[tipo])."</option>";} 	
				else{ 
				    $combo = $combo . "<option value='$res[tipo]'>".troca($res[tipo])."</option>";
			}}
			
			$lista_combo="<select class=texto name=tipo id=tipo onChange='obtem_valor(this,1,this.value)';>$combo</select>";
			echo"$lista_combo";
			
			$sql="SELECT exposicao from exposicao where ('$tipo'='T' or tipo='$tipo') and autor='$_REQUEST[id]'";
			
			$db->query($sql);
			$numlinhas=$db->contalinhas();
			
			$sql="SELECT a.* from exposicao as a where a.autor='$_REQUEST[id]' and ('$tipo'='T' OR a.tipo='$tipo') order by a.exposicao asc LIMIT $registroinicial,$pagesize ";
	        
		   $db->query($sql);
			
			$temregistro= 0;
			
		?>
    </span>    </div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="57%" height="24" bgcolor="#96ADBE" class="texto_bold"><div align="left"> &nbsp;&nbsp;Nome</div></td>
          <td width="15%" bgcolor="#96ADBE" class="texto_bold"><div align="center">Tipo</div></td>
          <td width="12%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
          <td width="16%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCFF">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto">
          <td align="justify" width='58%'><? echo $row[nome] ?></td>
          <td width='14%'><div align="center"><span class="texto_bold"><? if($row[tipo]=='C') echo "Coletiva"; else  echo "Individual"; ?></span>
            </div></td>
          <td align="center" width='12%'>
            <div align="center"><? echo "<a href=\"exposicao1.php?op=del&exp=".$row['exposicao']."&id=".$_REQUEST[id]."\"
	onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20'
	border='0' alt='Excluir'>";?></div></td>
          <td align="center" width='16%'>
            <div align="left"><span class="texto_bold"><? echo "<a href=\"exposicao1.php?op=update&exp=".$row['exposicao']."&id=".$_REQUEST['id']."&tipo=".$_REQUEST['tipo']."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' >";} ?></span></div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left"><? echo "<a href=\"exposicao1.php?op=insert&id=$_REQUEST[id]\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Novo Registro' >"?></td>
        </tr>
        <tr bgcolor="#336799" class="texto">
          <td colspan="4">			<?php
				//Retomando a paginacao//
				$numpages=ceil($numlinhas/$pagesize);
				$page_atual=$page+1;
				$mais=$page_atual+1;
				$menos=$page_atual-1;
				$first=1;  
				$last=$numpages;
				if($mais>$numpages)
					$mais=$numpages;
	         $a="<a href=\"exposicao_teste2.php?id=$_REQUEST[id]&tipo=$_REQUEST[tipo]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

             $b="<a href=\"exposicao_teste2.php?id=$_REQUEST[id]&tipo=$_REQUEST[tipo]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

             $c="<a href=\"exposicao_teste2.php?id=$_REQUEST[id]&tipo=$_REQUEST[tipo]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

            $d="<a href=\"exposicao_teste2.php?id=$_REQUEST[id]&tipo=$_REQUEST[tipo]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
				$combo="";
				//Evita a entrada de uma pagina invalida pela URL//
				/*if (!$temregistro && $page_atual > 1) {
					echo "<script>location.href='exposicao_teste2.php?page=".$last."&nivel=".$nivel."'</script>";
				}*/
				////
				for($i=1;$i<=$numpages;$i++) {
					if ($i==$page_atual) {
						$combo = $combo . "<option value='$i' selected>$i</option>";
					} else {
						$combo = $combo . "<option value='$i'>$i</option>";
					}
				}
				$lista_combo="<select class=texto name=i onChange='obtem_valor(this,this.value,\"".$nivel."\");'>$combo</select>";
				if ($nivel=='nenhum') {
					$g="<b>Nenhum tipo foi selecionado &nbsp;</b>";
				} else {
					$g="Total de exposições: $numlinhas - Pagina:$page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";}
				echo"<font color='ffffff'>$g</font>";
	}
			?>              
            <div align="center"></div></td>
          </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <p>
          <input name="id" type="hidden" id="id" value="<? echo $_REQUEST[id]  ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">

		  <input name="exp" type="hidden" id="exp" value="<? echo $exp ?>">
		  <input name="tipo" type="hidden" id="tipo" value="<? echo $tipo ?>">
		  <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
