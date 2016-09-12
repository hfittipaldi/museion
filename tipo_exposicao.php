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
		document.location=('tipo_exposicao.php?page=' + pag +'&tipo=' + niv);
	}
}
</script>

</head>

<body onLoad="if (navigator.appName != 'Netscape') { document.getElementById('tipo').options[0]= null; }   if ('<? echo $tipo; ?>' == 'nenhum') { document.getElementById('tipo').selectedIndex=-1; }">
<table width="452"  border="0" align="left" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><span class="texto_bold"> Selecione o tipo da exposi&ccedil;&atilde;o:
        <?php
		    include("classes/classe_padrao.php");
            include("classes/funcoes_extras.php");
            $db=new conexao();
            $db->conecta();
		    $pagesize=10;
	        $page=1;
	          if(!empty($_GET['page']))
		           $page=$_GET['page'];
	               $page--;
	               $registroinicial=$page*$pagesize;
				   //
	               $nivel='nenhum';
	               if(!empty($_GET['tipo']))
		           $tipo=$_GET['tipo'];
				   
			$sql="SELECT distinct(tipo) from exposicao as a ";
			$db->query($sql);
			$i=0;
			$combo = "<option value='0'></option>";
			$combo.="<option value='T' selected>TODOS </option>";
			while($res=$db->dados()) {
				if ($res[tipo]==$tipo)
					$combo = $combo . "<option value='$res[tipo]' selected>$res[tipo]</option>";
				else
				    $combo = $combo . "<option value='$res[tipo]'>$res[tipo]</option>";
				
			}
			$lista_combo="<select class=texto name=tipo id=tipo onChange='obtem_valor(this,1,this.value);'>$combo</select>";
			echo"$lista_combo";
			//Conta quantidade total de itens referentes ao fundo (tipo) selecionado//
			  $sql="SELECT count(*) from exposicao where ('$tipo'='T' or tipo='$tipo') and autor='26'";
			  $db->query($sql);
			  $numlinhas=$db->contalinhas();
			//Lista os itens referentes ao fundo selecionado//
			// $sql="SELECT a.* from exposicao as a where a.autor='$_REQUEST[id]' and a.tipo='$_REQUEST[tipo]' order by a.exposicao asc LIMIT $registroinicial,$pagesize ";
	       
			 $sql="SELECT a.* from exposicao as a where a.autor='26' and ('$tipo'='T' OR a.tipo='$tipo') order by a.exposicao asc LIMIT $registroinicial,$pagesize ";
	        
		   $db->query($sql);
			////
			$temregistro= 0;
			while($row=$db->dados())
			{
		?>
    </span></td>
  </tr>
  <tr>
    <td width="436" valign="top"><form name="form1" method="post" action="">
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="45%" height="24" bgcolor="#96ADBE" class="texto_bold"><div align="left">&nbsp;&nbsp;Nome</div></td>
          <td width="20%" bgcolor="#96ADBE" class="texto_bold"><div align="center">Tipo</div></td>
          <td width="21%" bgcolor="#96ADBE" class="texto_bold">&nbsp;</td>
          <td width="14%" bgcolor="#96ADBE" class="texto_bold">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCFF">
        <tr class="texto">
          <td align="justify" class="texto"><? echo $row[nome] ?>
            <div align="center">
            </div></td>
          <td align="center" class="texto"><? if($row[tipo]=='C') { echo "coletiva"; } else { echo"individual";} ?>
            <div align="center"></div></td>
          <td width='21%' align="center" class="texto"><? echo "<a href=\"exposicao1.php?op=del&tipo=".$row[tipo]."&exp=".$row[exposicao]."&id=".$_REQUEST[id]."\"
	onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20'
	border='0' alt='Excluir'>";?>
            <div align="center"></div></td>
          <td width='14%' align="center" class="texto"><? echo "<a href=\"exposicao1.php?op=update&exp=".$row[exposicao]."&id=".$_REQUEST[id]."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' >"; ?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td width="44%"></td>
          <td width="21%"></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
          <td align="center"><? echo "<a href=\"exposicao1.php?op=insert&id=$_REQUEST[id]\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Novo Registro' >"?><? } ?></td>
        </tr>
        <tr bgcolor="#336799" class="texto">
          <td colspan="4"><span class="texto_bold">
            <?php
				//Retomando a paginacao//
				$numpages=ceil($numlinhas/$pagesize);
				$page_atual=$page+1;
				$mais=$page_atual+1;
				$menos=$page_atual-1;
				$first=1;  
				$last=$numpages;
				if($mais>$numpages)
					$mais=$numpages;
				$combo="";
				//Evita a entrada de uma pagina invalida pela URL//
				if (!$temregistro && $page_atual > 1) {
					echo "<script>location.href='tipo_exposicao.php?page=".$last."&tipo=".$tipo."'</script>";
				}
				////
				for($i=1;$i<=$numpages;$i++) {
					if ($i==$page_atual) {
						$combo = $combo . "<option value='$i' selected>$i</option>";
					} else {
						$combo = $combo . "<option value='$i'>$i</option>";
					}
				}
				$lista_combo="<select class=texto name=i onChange='obtem_valor(this,this.value,\"".$tipo."\");'>$combo</select>";
				if ($tipo=='nenhum') {
					$g="<b>Nenhum tipo est&aacute; selecionado &nbsp;</b>";
				} else {
					$g="Total de exposicoes deste tipo: <b>$numlinhas</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; P&aacute;gina $lista_combo de $numpages &nbsp;";
				}
				echo"$g";
			?>
          </span></td>
        </tr>
        <tr bgcolor="#ccccff" class="texto">
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr bgcolor="#ccccff" class="texto">
          <td colspan="4"> <? echo "<a href=\"tipo_exposicao.php?id=$_REQUEST[id]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' ></a>"?>             
            <div align="center"></div></td>
          </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <br>
        <p>
          <input name="id" type="hidden" id="id" value="<? echo $_REQUEST['id'] ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          <input name="tipo" type="hidden" id="tipo" value="<? echo $_REQUEST[tipo] ?>">

		  <input name="exp" type="hidden" id="exp" value="<? echo $_REQUEST[expo]  ?>">
		  <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
