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
document.location=('restauro_altera_titulo.php?page='+ i + '&titulo=<? echo $_REQUEST[titulo]?>&tipo=<? echo $_REQUEST[tipo] ?>');
}}


</script>
</head>

<body>
<table width="546"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
//$val=$_REQUEST['usuario'];
$op=$_REQUEST['op'];
//montalinks();
echo $_SESSION['lnk'];
	
?>
    </div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  $pagina='';
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize; 
      $sql="SELECT count(*) as total from restauro as a where ( a.titulo='$_REQUEST[titulo]' or a.titulo like '%$_REQUEST[titulo]%') AND a.tipo='$_REQUEST[tipo]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	  /////////////////////
	  $sql2="SELECT a.* from restauro as a where (a.titulo='$_REQUEST[titulo]' or a.titulo like '%$_REQUEST[titulo]%') AND
	   a.tipo='$_REQUEST[tipo]' order by a.ir, a.seq_restauro, a.tombo + 0, a.tombo, a.titulo LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="2" bgcolor="#000000" class="texto"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#f4f4f4">
          <td width="53%" height="24" bgcolor="#f4f4f4" class="texto"><div align="left"> &nbsp;&nbsp;Ocorr&ecirc;ncias encontradas para:
            <?  echo "<font color='#000000'><b>&nbsp;".$_REQUEST[titulo]."</b></font>"; ?></div>            
            <div align="left"></div><div align="left"></div><div align="left"></div></td>
            <td width="2%" height="24" bgcolor="#f4f4f4" class="texto"><div align="right"><? echo "<a href=\"alteracao_restauro.php?'\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"?></div></td>

        </tr>
        <tr>
          <td colspan="2" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
       </table>         



   <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
         <tr bgcolor="#96ADBE">
           <td width="50%" bgcolor="#ddddd5" class="texto_bold">Obra</td>
           <td width="10%"  align="center" bgcolor="#ddddd5" class="texto_bold">Tombo</td>
           <td width="10%"  align="center" bgcolor="#ddddd5" class="texto_bold">IR</td>
           <td width="10%"  align="center" bgcolor="#ddddd5" class="texto_bold">Restauração</td>
           <td width="10%"  align="center" bgcolor="#ddddd5" class="texto_bold">&nbsp;</td>
           <td width="10%"  align="center" bgcolor="#ddddd5" class="texto_bold">&nbsp;</td>
       </tr>
        <tr>
          <td colspan="2" bgcolor="#000000"><img src="imgs/transp.gif" width="200%" height="1"></td>
        </tr>
      </table>       

      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="1">
		<? while($row=$db->dados())
	  {
	   if($row[tipo]=='1'){
	    if($row[interna]=='E'){
	   $pagina='restauracao_papel_externa.php';}
	   elseif($row[interna]=='I') {
	   $pagina='restauracao_papel_interna.php';}}
	   //
	   if($row[tipo]=='2'){
	    if($row[interna]=='E'){
	   $pagina='restauracao_pintura_externa.php';}
	   elseif($row[interna]=='I') {
	   $pagina='restauracao_pintura_interna.php';}}
           //
	   if($row[tipo]=='3'){
	    if($row[interna]=='E'){
	   $pagina='restauracao_obra_externa.php';}
	   elseif($row[interna]=='I') {
	   $pagina='restauracao_obra_interna.php';}}
	   if($row[tipo]=='4'){
	    if($row[interna]=='E'){
	   $pagina='restauracao_mldura_externa.php';}
	   elseif($row[interna]=='I') {
	   $pagina='restauracao_moldura_interna.php';}}
	  ?>


      <tr class="texto">
          <td  width="50%" align="justify"><b><? echo $row[autor] ?></b><br><em><? echo $row[titulo]; ?></em></td>
          <td width="10%" align="center"><em><? echo $row[tombo] ?></em></td>
          <td width="10%" align="center"><? echo $row[ir] ?></td>
          <td width="10%" align="center"><? echo $row[seq_restauro] ?></td>
          <td width="10%" align="center">
          

           <?
              if ($pagina=='restauracao_moldura_interna.php'){
                  echo "<a href=\"$pagina?op=update&id=".$row[restauro]."&form=restauro&tipo2=1&form2=alterar&filtro=".$_REQUEST[titulo]."&chama=titulo"."\">
	          <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar'></a>";
              }else{
		  echo "<a href=\"$pagina?op=update&id=".$row[restauro]."\">
	          <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar'></a>";
              }
            ?>
         <td width="10%" align="center">
            <?
	      	
			        echo "&nbsp;&nbsp;&nbsp;<a href=\"$pagina?op=del&id=".$row[restauro]."\" onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20' border='0' alt='Excluir'>";
	      
          ?>

       <?  }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td width="42%"></td>
          <td colspan="3"></td>
          <td width="9%"></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="4">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#ddddd5" class="texto">
          <td colspan="6" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"restauro_altera_titulo.php?page=".$first."&tipo=".$_REQUEST[tipo]."&titulo=".$_REQUEST[titulo]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"restauro_altera_titulo.php?page=".$menos."&tipo=".$_REQUEST[tipo]."&titulo=".$_REQUEST[titulo]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"restauro_altera_titulo.php?page=".$mais."&tipo=".$_REQUEST[tipo]."&titulo=".$_REQUEST[titulo]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"restauro_altera_titulo.php?page=".$last."&tipo=".$_REQUEST[tipo]."&titulo=".$_REQUEST[titulo]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
//echo"$lista_combo";
$g= " Total de ocorr&ecirc;ncias: $numlinhas - P&aacute;gina: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='#000000'>$g</font>"; 		  
?></td>
        </tr>
        <tr>
          <td colspan="6"></td>
        </tr>
      </table>
    </form>

  </tr>
</table>
</body>
</html>
