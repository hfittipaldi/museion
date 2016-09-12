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
$obra=$_REQUEST['obra'];

	if ($_REQUEST['op'] == 'add') 
         {
	   $sql_ini="SELECT obra,bibliografia from obra_bibliografia where obra='$_REQUEST[id]' and bibliografia='$_REQUEST[bib]'";
	   $db->query($sql_ini);
	   $conta=$db->contalinhas();

	   if($conta<>0)
	   {
	      echo "<script>alert('Bibliografia já cadastrada para esta obra.Selecione outra!')</script>";
		  echo "<script>location.href='bibliografia_insere1.php?id=$_REQUEST[id]'</script>";
	   }
	   else{
	      $sql="INSERT INTO obra_bibliografia(obra,bibliografia) values('$_REQUEST[id]','$_REQUEST[bib]')";
	      $db->query($sql);
	      echo "<script>location.href='bibliografia_obra.php?id=$_REQUEST[id]';</script>";
               }
	 }
 ?>

<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('bibliografia_insere2.php?id=<? echo $_REQUEST[id]; ?>&page='+ i+ '&desc=<? echo $_REQUEST[desc] ?>');
}}
</script>

<body>
<? if (trim($_REQUEST['desc']) <> '') { ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" >
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
	  $sql= "SELECT count(*) from bibliografia where referencia like'%$_REQUEST[desc]%'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2= "SELECT bibliografia,referencia from bibliografia where referencia like '%$_REQUEST[desc]%' order by referencia LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td height="24" bgcolor="#96ADBE" class="texto_bold"><div align="left"> &nbsp;&nbsp;Referência</div></td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCFF">
         <? while($row=$db->dados())
	  { ?>
             <tr class="texto">
                <td width="90%"></td>
                <td width="10%"></td>
             </tr>
  <? echo $_REQUEST[id]; ?>
             <tr class="texto" id="cor_fundo<? echo $row['bibliografia'] ?>">
                <td><? echo $row['referencia']; ?></td>
                <td align="center"><? echo "<a href=\"bibliografia_insere2.php?obra=$obra&op=add&id=$_REQUEST[id]&bib=".$row['bibliografia']."\">
						<img src='imgs/icons/ic_adicionar.gif' border='0' alt='Adicionar à lista' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#CCFFAA\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?></td>
       </tr>
		<? } ?>
        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="4" height="20"><? 
		   
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
$g= " Total de bibliografias encontradas:$numlinhas - Pagina:$page_atual de $numpages &nbsp $lista_combo";
echo"&nbsp";

echo"<font color='ffffff'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
    </form>
        <tr>
          <td colspan="4" class="texto_bold"><? echo "<a href=\"bibliografia_insere1.php?obra=$obra\"><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar' >"?></td>
        </tr>
	</td>
  </tr>
</table>
<? }  ?>
</body>
</html>