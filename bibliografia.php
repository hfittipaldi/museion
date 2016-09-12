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
        $tipo='autor';
        $lista=$_REQUEST['lista'];
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
function abrepopBibliografia(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-340)+',top='+((window.screen.height/2)-200)+',width=700,height=440, scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('bibliografia.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);

}}
</script>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	// $sql="SELECT count(*) as total from autor_bibliografia where autor='$autid'";
         $sql="SELECT count(*) as total from autor_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
	  where a.autor='$autid'";

	  $db->query($sql);
	  $numlinhas=$db->dados();
          $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	 // $sql2="SELECT a.* from bibliografia as a order by bibliografia";
	  $sql2="SELECT a.*,b.* from autor_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
	  where a.autor='$autid' order by b.ano";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>      
 

    <table align="center" width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="93%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;" ><div align="left"> Total de referências bibliográficas: <?echo $numlinhas; ?> </div>
             </td>
       <td width="7%" align="center" >

        <? if (($numlinhas>0) and ($_REQUEST[op_autor]=='view') ){?>
           
      <?
          $comando="<a href=\"bibliografia.php?op_autor=$_REQUEST[op_autor]&autid=$autid&lista=1\";>";
          echo $comando;
      ?>
         <img src='imgs/icons/btn_listar.gif'  border='0' alt='Listar'></a>
          </td>
          <td width="7%" align="center" style=";">&nbsp;&nbsp;</td>
      <?}else{?>
 



     <? if (($numlinhas>0) and ($_REQUEST[op_autor]=='update') ){?>
           
      <?
          $comando="<a href=\"bibliografia.php?autid=$autid&lista=1\";>";
          echo $comando;
      ?>
         <img src='imgs/icons/btn_listar.gif'  border='0' alt='Listar'></a>
          </td>
          <td width="7%" align="center" style=";">&nbsp;&nbsp;</td>
      <?}else{ ?>

          <td width="7%" align="center"><? $ref="bibliografia_insere2.php?op_autor=$_REQUEST[op_autor]lista=".$lista."&op=update&autid=".$autid."&tipo=".$tipo;?>
          <a href='javascript:;' onClick="abrepopBibliografia('<?echo $ref;?>');"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar bibliografia'></a>
          </td>
      <?}
       }?>
          <td width="7%" align="center" style="border-right: 1px solid #121212;">&nbsp;&nbsp;</td>

        </tr>
         <tr>
          <td height="2" colspan="8" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>


<? if (($_REQUEST['lista']=='1') or ($_REQUEST['op_obra']=='insert') or ($_REQUEST['op_obra']=='view'))
   {?>
     
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
	<? while($row=$db->dados())
	{  ?>
        <tr class="texto">
          <td width="70%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['bibliografia'] ?>">
          <td  valign="top" class="texto" colspan="3" width="70%">
               <? echo "- ".$row[autoria].".&nbsp;<em><b>".htmlentities($row['referencia'], ENT_QUOTES)."</b></em>.&nbsp;";
	       if ($row[sub_titulo]!='')echo $row[sub_titulo].".&nbsp;";
	       if ($row[local]!='')echo $row[local].":&nbsp;";
	       if ($row[editora]!='')echo $row[editora].",&nbsp;";
	       if ($row[ano]!='0'){echo $row[ano].".&nbsp;";} else {echo "s/d".".&nbsp;";}
	       if ($row[notas]!='')echo $row[notas].".&nbsp;";
               if ($row[observacao]!=''){echo $row[observacao].".";}
		 ?>
         </td>
         <?if ($_REQUEST['op_autor']<>'view'){?>
            <td width="5%" align="center"><? echo "<a href=\"bibliografia1.php?lista=".$lista."&op=del&autid=".$autid."&bib=".$row[bibliografia]."\"
	    onClick='return confirm(".'"Confirma Exclus&atilde;o do Registro ?"'.")'><img src='imgs/icons/ic_remover.gif' border='0' alt='Excluir' 
	    onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	    onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?>
	    </td>
            <td  width="5%" align="center"><? echo "<a href=\"bibliografia1.php?lista=".$lista."&op=update&autid=".$autid."&bib=".$row[bibliografia]."\">
	    <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
	    onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	    onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";         

         } else {?>
         <td  width="5%" align="center"><? echo "<a href=\"consulta_bibliografia1.php?lista=".$lista."&op=view&bib=".$row[bibliografia]."&id=".$autid."\">
	    <img src='imgs/icons/relat.gif' width='20' height='20'border='0' alt='Visualizar' 
	    onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	    onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";   
          }      
         }?>
          </td>
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
          </tr>
         <tr class="texto">
          <td colspan="4" height="20">
            <div align="center"></div></td>
          </tr>

           <tr>
          <td height="2" colspan="8" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>



      </table>

<?}?>
          <input name="bibliografia" type="hidden" id="bibliografia" value="<? echo $bibliografia ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          <input name="id" type="hidden" id="id" value="<? echo $autid ?>">
    </form>
	</td>
  </tr>
</table>
</body>
</html>
