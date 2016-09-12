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
document.location=('parte_obra.php?obra=<? echo $_REQUEST[obra] ?>&page='+ i);

}}
</script>

</head>


<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
	$dbm=new conexao();
	$dbm->conecta();
	$dbm1=new conexao();
	$dbm1->conecta();
	$dbm2=new conexao();
	$dbm2->conecta();
	$dbm3=new conexao();
	$dbm3->conecta();

        $lista=$_REQUEST['lista'];
 ?>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">


      <?
	  /////Paginando
	  $pagesize=50;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total from parte where obra='$_REQUEST[obra]'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.* from parte as a where a.obra='$_REQUEST[obra]' order by controle LIMIT $registroinicial,$pagesize ";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>

    <table align="center" width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="93%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;" ><div align="left">Total de partes: <?echo $numlinhas; ?>&nbsp;</div>
             </td>
        <? if (($numlinhas>0) and ($_REQUEST[op_obra]==update)){?>   
          <td width="7%" align="center" ><? $ref="parte_obra.php?lista=".$lista."&op=insert&obra=".$_REQUEST[obra];?>
         
      <?
      ?>
		</a>
          </td>
         <td  width="7%" align="center" ><? echo "<a href=\"parte_obra1.php?op=insert&obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Nova parte' >"?></td>
          <td width="7%" align="center" style=";">&nbsp;&nbsp;</td>
       <?}else{?>
         <td width="7%" align="center" style=";">&nbsp;&nbsp;</td>
         <td  width="7%" align="center" ><? echo "<a href=\"parte_obra1.php?op=insert&obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Nova parte' >"?></td>             
       <?}?>
  
                    

         <td width="7%" align="center" style="border-right: 1px solid #121212;">&nbsp;&nbsp;</td>

        </tr>


       <tr bgcolor="#96ADBE">
          <td  height="2" width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>
        <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {

	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['parte'] ?>">
          <td width="80%">&nbsp;<? echo $row[controle]." - ".$row[nome_objeto];?></td>

           <?if ($moldura_fim_restauro<>'' or $moldura_sem_restauro<>'') {?>
            <td width="10%" align="center"><? echo "<a href=\"parte_obra1.php?moldura=".$row[moldura]."&lista=1&op=del&obra=".$row[obra]."&parte=".$row[parte]."\"
	      onClick='return confirm(".'"Existe moldura cadastrada para a parte. Confirma a exclusão da parte e da moldura?"'.")'><img src='imgs/icons/ic_remover.gif' 
	      border='0' alt='Remover da lista' 
	      onMouseOver='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"#ddddd5\";' 
	      onMouseOut='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"\";'>";?>
	     </td>
            <?}else{?>   

           <?if ($moldura_com_restauro<>''){?>
            <td width="10%" align="center"><? echo "<a href=\"parte_obra1.php?moldura=".$row[moldura]."&lista=1&op=del&obra=".$row[obra]."&parte=".$row[parte]."\"
	      onClick='return confirm(".'"Existe moldura cadastrada para a parte que se encontra na restauração. Confirma a exclusão da parte e da moldura?"'.")'><img src='imgs/icons/ic_remover.gif' 
	      border='0' alt='Remover da lista' 
	      onMouseOver='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"#ddddd5\";' 
	      onMouseOut='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"\";'>";?>
	     </td>
            <?}else{?>   

            <td width="10%" align="center"><? echo "<a href=\"parte_obra1.php?moldura=".$row[moldura]."&lista=1&op=del&obra=".$row[obra]."&parte=".$row[parte]."\"
	      onClick='return confirm(".'"Confirma Exclus&atilde;o do Registro ?"'.")'><img src='imgs/icons/ic_remover.gif' 
	      border='0' alt='Remover da lista' 
	      onMouseOver='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"#ddddd5\";' 
	      onMouseOut='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"\";'>";?>
	     </td>
            <?}
                }?>
          <td width="10%" align="center"><? echo "<a href=\"parte_obra1.php?lista=1&op=update&obra=".$row[obra]."&parte=".$row[parte]."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[parte]."\").style.backgroundColor=\"\";'>"; }?>
		  </td>
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
        </tr>
       <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>

         <tr>
          <td colspan="4"></td>
        </tr>
      </table>

</body>
</html>
