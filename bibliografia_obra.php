<? //include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
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
function posiciona(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('bibliografia_obra.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);

}}
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('bibliografia_obra.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);

//document.location=('bibliografia_obra.php?obrid=<? echo $_REQUEST[obra] ?>&page='+ i);

}}
</script>
<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
 <?
         // $sql="SELECT count(*) as total from obra_bibliografia as a inner join bibliografia as b on(a.bibliografia=b.bibliografia) where a.obra=".$obrid;

	   $sql="SELECT count(*) as total from obra_bibliografia as a inner join bibliografia as b on(a.bibliografia=b.bibliografia)
	   where a.obra=".$obrid;


	  $db->query($sql);
	  $numlinhas=$db->dados();
                $numlinhas=$numlinhas[0];
	  /////////////////////
	  $sql2="SELECT a.*,b.bibliografia, b.referencia,b.autoria,b.local,b.editora,b.ano,b.sub_titulo,b.notas,a.observacao from obra_bibliografia as a inner join bibliografia as b on(a.bibliografia=b.bibliografia)
	   where a.obra=".$obrid." order by b.ano, a.obra_bibliografia, b.referencia";
	  $db->query($sql2);
	  ////////////////////
	 
	   ?>


    <table align="center" width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="93%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;" ><div align="left"> Total de referências bibliográficas: <?echo $numlinhas;?> </div>
             </td>

        <?if (($numlinhas>0) and ($_REQUEST[op_obra]=='update')){?>
       <td width="7%" align="center" >           
      <?
          $comando="<a href=\"bibliografia_obra.php?obrid=$obrid&lista=1\";>";
          echo $comando;
      ?>
         <img src='imgs/icons/btn_listar.gif'  border='0' alt='Listar'></a>
          </td>
          <td width="7%" align="center" style=";">&nbsp;&nbsp;</td>
       <?}else{?>
          <td width="7%" align="center" ><? $ref="bibliografia_listar.php?op_obra=".$_REQUEST[op_obra]."&op=update&obrid=".$valor."&tipo=".$tipo;?>
          <a href='javascript:;' onClick="abrepopBibliografia('<?echo $ref;?>');"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar bibliografia'></a>
          </td>

       <?}?>
          <td width="7%" align="center" style="border-right: 1px solid #121212;">&nbsp;&nbsp;</td>
        </tr>
         <tr>
          <td height="2" colspan="8" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>      

<? if (($_REQUEST['lista']=='1') or ($_REQUEST['op_obra']=='insert'))
   {?>
     
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto">
          <td width="80%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['bibliografia'] ?>">
          <td colspan="2"><? 
                             echo "- ".$row[autoria].".&nbsp;<em><b>".htmlentities($row['referencia'], ENT_QUOTES)."</b></em>.";
			     if ($row[sub_titulo]!='') echo "&nbsp;" . $row[sub_titulo].".";
			     if ($row[local]!='') echo "&nbsp;" .$row[local].":&nbsp;";
			     if ($row[editora]!='') echo "&nbsp;" .$row[editora].",&nbsp;";
			     if ($row[ano]!='0'){
					echo $row[ano].".&nbsp;";}
			     else {
					echo "s/d".".&nbsp;";}
                                               if ($row[observacao]!=''){
			     if ($row[notas]!='') echo "&nbsp;" .$row[notas].".&nbsp;";
			        echo $row[observacao].".";}
                          ?></td>
         <td>
           <div align="center"><? echo "<a href=\"bibliografia_obra_alterar.php?op_obra=".$_REQUEST[op_obra]."&lista=".$lista."&tipo=".$valor."&op=del&obrid=".$row['obra']."&bib=".$row['bibliografia']."\"
	       onClick='return confirm(".'"O item será removido da lista. Confirma Remoção ?"'.")'><img src='imgs/icons/ic_remover.gif'
	       border='0' alt='Remover da lista' 
	       onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	       onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?>
	    </div>
         </td>


           <td align="center"><? echo "<a href=\"bibliografia_obra_alterar.php?op_obra=".$_REQUEST[op_obra]."&lista=".$lista."&op=update&obrid=".$row['obra']."&bib=".$row['bibliografia']."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>"; }?>
		  </td>

        
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>

 
          
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
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
<?}?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
