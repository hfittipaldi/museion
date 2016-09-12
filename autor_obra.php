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
document.location=('autor_obra.php?obra=<? echo $_REQUEST[obra] ?>&page='+ i);

}}
function abreAutor(id) {
 win=window.open('consulta_autor.php?id='+id+'&pop=1','autor','left='+((window.screen.width/2)-300)+',top='+((window.screen.height/2)-250)+',width=590,height=500, scrollbars=yes, resizable=no');
 if(parseInt(navigator.appVersion)>=4) {
   win.window.focus();
 }
 return true;
}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
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
	 $sql="SELECT count(*) as total from autor_obra where obra='$_REQUEST[obra]'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.nomeetiqueta,b.* FROM autor  AS a INNER JOIN  autor_obra as b on (a.autor=b.autor) where obra='$_REQUEST[obra]' order by b.hierarquia asc LIMIT $registroinicial,$pagesize";
	 // $sql2="SELECT a.* from bibliografia as a order by bibliografia asc LIMIT $registroinicial,$pagesize";
	  //$sql2="SELECT a.* from autor_obra as a where obra='$obra' order by a.hierarquia asc LIMIT $registroinicial,$pagesize ";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>



      <table align="center" width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="93%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;" ><div align="left"> Total de autores: <?echo $numlinhas;?> </div>
             </td>
     <?if (($numlinhas>0) and ($_REQUEST[op_obra]=='update')){?>      
        <td width="7%" bgcolor="#ddddd5" align="center"><? echo "<a href=\"autor_obra1.php?op=insert&obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar autor' >"?></td>
          <td width="7%" align="center" style=";">&nbsp;&nbsp;</td>
      <?}else{?>
        <td width="7%" bgcolor="#ddddd5" align="center"><? echo "<a href=\"autor_obra1.php?op=insert&obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar autor' >"?></td>
      <?}?>
          <td width="7%" align="center" style="border-right: 1px solid #121212;">&nbsp;&nbsp;</td>

        </tr>


       <tr bgcolor="#96ADBE">
          <td  height="2" width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>



<?{ ?>

       <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto">
          <td width="80%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['autor'] ?>">

          <td  width="80%" style="cursor:pointer;" onMouseOut="this.style.textDecoration='';" onMouseOver="this.style.textDecoration='underline';" onClick="abreAutor(<? echo $row['autor']; ?>);"><? echo $row[hierarquia] ?> - <? echo $row[nomeetiqueta] ?></td>
         
          <td  width="10%" align="center"><? echo "<a href=\"autor_obra1.php?op=del&obra=".$row[obra]."&autor=".$row[autor]."\"
	onClick='return confirm(".'"Confirma Exclus&atilde;o do Registro ?"'.")'><img src='imgs/icons/ic_remover.gif' 
	border='0' alt='Excluir' 
	onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
	onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?>
		  </td>
          <td  width="10%" align="center"><? echo "<a href=\"autor_obra1.php?op=update&obra=".$row[obra]."&autor=".$row[autor]."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>"; }?>
		  </td>
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
        </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
</table>
<?}?>
</body>
</html>
