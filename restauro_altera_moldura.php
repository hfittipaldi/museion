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
document.location=('restauro_altera_moldura.php?page='+ i + '&num=<? echo $_REQUEST[num] ?>&tipo=<? echo $_REQUEST[tipo] ?> ');
}}

</script>

</head>

<body>
<table width="546"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();

$dbm=new conexao();
$dbm->conecta();
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];

$sql="SELECT moldura from moldura as a where a.mold_registro like '$_REQUEST[moldura]'";
$db->query($sql);
$numlinhas=$db->dados();
$moldura=$numlinhas[moldura];
	
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
	  $sql="SELECT count(*) as total from restauro as a where a.moldura like '$moldura' and a.tipo='$_REQUEST[tipo]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 $count=0;
	  $count_ext='';
          $count_int='';

	  /////////////////////
	  $sql2="SELECT a.* from restauro as a where a.moldura like '$moldura' and a.tipo='$_REQUEST[tipo]' order by a.interna,a.moldura + 0, a.ir, a.seq_restauro, a.titulo";
	  $db->query($sql2);
	  ////////////////////
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="200%" height="1"></td>
        </tr>
      <tr bgcolor="#f4f4f4">
          <td width="60%" height="24" bgcolor="#f4f4f4" class="texto"><div align="left"> &nbsp;&nbsp;<?echo "(".$numlinhas.")";?>&nbsp;Ocorr&ecirc;ncias encontradas:<?  echo "<b><font color='#000000'>".ucfirst($_REQUEST[num])."</font>"; ?>            </div></td>
           <td width="2%" height="24" bgcolor="#f4f4f4" class="texto"><div align="right"><? echo "<a href=\"alteracao_restauro.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"?></div></td>
         </tr>
        <tr>
          <td colspan="2" bgcolor="#000000"><img src="imgs/transp.gif" width="200%" height="1"></td>
        </tr>

      </table> 
 
    <table width="100%" height="20"  border="0" cellpadding="1"  cellspacing="0"  bgcolor="#f2f2f2">
         <tr bgcolor="#96ADBE">
           <td width="40%"  align="left"   bgcolor="#ddddd5" class="texto_bold">Obra</td>
           <td width="13%"  align="center" bgcolor="#ddddd5" class="texto_bold">Tombo</td>
           <td width="5%"   align="center" bgcolor="#ddddd5" class="texto_bold">IR</td>
           <td width="10%"  align="center" bgcolor="#ddddd5" class="texto_bold">Restauração</td>
           <td width="7%"   align="center" bgcolor="#ddddd5" class="texto_bold">&nbsp;</td>
           <td width="7%"   align="center" bgcolor="#ddddd5" class="texto_bold">&nbsp;</td>
          <?if($_REQUEST[tipo]=='4'){?> 
               <td width="10%"   align="center" bgcolor="#ddddd5" class="texto_bold">Moldura</td>             
               <td width="7%"  align="center" bgcolor="#ddddd5" class="texto_bold">&nbsp;</td>
           <?}?>
       </tr>
        <tr>
          <td colspan="2" bgcolor="#000000"><img src="imgs/transp.gif" width="200%" height="1"></td>
        </tr>
      </table>  

 
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#f2f2f2">
	<? 

          while($row=$db->dados())
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
	   $pagina='restauracao_moldura_externa.php';}
	   elseif($row[interna]=='I' and $row[tombo]<>'') {
	   $pagina='restauracao_moldura_interna.php';}
           elseif($row[interna]=='I' and $row[tombo]=='') {
	   $pagina='restauracao_moldura_externa.php';}}

	   if($row[tipo]=='4'){
 	     $sqlm="SELECT * from moldura where moldura='$row[moldura]'";
	     $dbm->query($sqlm);
             $rowm=$dbm->dados();
             $mold_registro=$rowm[mold_registro];
             $num_registro=$rowm[num_registro];
           }

	 
          
              if($row[interna]=='E' and $count_ext==''){?>
              <tr class="texto">
               <td width="40%" align="left"><font color='blue'><? echo "Externas"?></font></td>
               <td width="13%" align="center">&nbsp;</td>
               <td width="5%"  align="center">&nbsp;</td>
               <td width="10%" align="center">&nbsp;</td>
               <td width="7%"  align="right">&nbsp;</td>
               <td width="7%"  align="left"> &nbsp;</td>
               <?if($row[tipo]=='4'){?>
                   <td width="10%" align="center">&nbsp;</td>
                   <td width="7%" align="center">&nbsp;</td>
               <?}?>
              </tr>

                <?$count_ext='E';  
                  $count=$count+1;
                 }
            if($row[interna]=='I' and $count_int==''){?>

              <tr class="texto">
               <td width="40%" align="left"><font color='blue'><? echo "Internas"?></font></td>
               <td width="13%" align="center">&nbsp;</td>
               <td width="5%"  align="center">&nbsp;</td>
               <td width="10%" align="center">&nbsp;</td>
               <td width="7%"  align="right">&nbsp;</td>
               <td width="7%"  align="left">&nbsp;</td>
               <?if($row[tipo]=='4'){?>
                   <td width="10%" align="center">&nbsp;</td>
                   <td width="7%" align="center">&nbsp;</td>

               <?}?>
              </tr>

                 <? $count_int='I';
                    $count=$count+1;
                }?>

        <tr class="texto">
           <?if ($row[titulo]==''){?>
                <td  width="40%" align="justify">&nbsp;</td>
                <td  width="13%" align="center"><em><? echo $num_registro?></em></td>
          <?}else{?>
                <td  width="40%" align="justify"><b><? echo $row[autor] ?></b><br><em><? echo $row[titulo]; ?></em></td>
                <td  width="13%" align="center"><em><? echo $row[tombo] ?></em></td>
          <?}?> 
          <td width="5%" align="center"><? echo $row[ir] ?></td>
          <td width="10%" align="center"><? echo $row[seq_restauro] ?></td>
          <td width="7%" align="right">
             <? 
               if ($pagina=='restauracao_moldura_externa.php' or $pagina=='restauracao_moldura_interna.php')
               {
                  if ($row[interna]=='I'){$tipo2=1;}else{$tipo2=2;}
                  echo "<a href=\"$pagina?op=update&op_restauro=update&id=".$row[restauro]."&form=restauro&tipo2=$tipo2&form2=alterar&filtro=".$row[ir]."&chama=moldura"."\"><img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar restauração'></a>";           
               }else{
                  echo "<a href=\"$pagina?op=update&id=".$row[restauro]."\"><img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar'></a>";
	       }
             ?>
          </td>
          <td width="7%" align="left">         
             <? echo "&nbsp;&nbsp;&nbsp;<a href=".$pagina."?op=del&id=".$row[restauro]." onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20' border='0' alt='Excluir restauração'>";?>     
            </td>
          <?if($row[tipo]=='4'){?>
              <td width="10%" align="center"><? echo $mold_registro?></td>
                   <td align="center" width='7%'><div align="center"><? echo "<a href=\"cadastro_moldura.php?&chama=moldura&tipo=4&ir=$row[ir]&op=update&tipo2=$tipo2&form=restauro_altera_moldura&obra=".$row[obra]."&parte=".$row[parte]."&moldura=".$row[moldura]."&tombo=".$_REQUEST[numregistro]."&num_registro=".$mold_registro."\">
						                        <img src='imgs/icons/moldura2.gif'  border='0' alt='Editar dados da moldura' 
						                         onMouseOver='document.getElementById(\"cor_fundo".$row[nome_objeto]."\").style.backgroundColor=\"#ddddd5\";' 
						                         onMouseOut='document.getElementById(\"cor_fundo".$row[nome_objeto]."\").style.backgroundColor=\"\";'>";?></div></td>
           <?}?>

        </tr>        
    <?}?>

      </table>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
