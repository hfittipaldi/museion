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
document.location=('autor_ocorrencia_altera.php?page='+ i + '&nomeetiqueta=<? echo $_REQUEST[nomeetiqueta] ?>');
}}

function posiciona(valor) {
var i = valor;
document.location=('inclusao_restauro.php?page='+ i+ '&obra=<?$_REQUEST[obra]?>&tipo2=<? echo $_REQUEST[tipo2] ?>&op=<? echo $_REQUEST[op] ?>&numregistro=<? echo $_REQUEST[numregistro] ?>&num_registro=<? echo $_REQUEST[num_registro] ?>');
}


</script>

</head>
<? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$dbm1=new conexao();
$dbm1->conecta();

    
         $obra=$_REQUEST[obra];
  $numregistro=$_REQUEST[numregistro];
        $tipo2=$_REQUEST[tipo2];
         $tipo=$_REQUEST[tipo];
           $op=$_REQUEST['op'];
        $papel=$_REQUEST[papel];
      $pintura=$_REQUEST[pintura];
     $objeto3d=$_REQUEST[objeto3d];
$mold_registro=$_REQUEST[mold_registro];



    
 
 
?>
<body>
<table width="100%"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
<tr>
   <td valign="top">
     <? if ($tipo=='1') {?><div align="left" class="tit_interno">Restauração / Incluir / Papel</div><?}?>
     <? if ($tipo=='2') {?><div align="left" class="tit_interno">Restauração / Incluir / Pintura</div><?}?>
     <? if ($tipo=='3') {?><div align="left" class="tit_interno">Restauração / Incluir / Obra 3D</div><?}?>
     <? if ($tipo=='4' and $tipo2==1) {?><div align="left" class="tit_interno">Restauração / Incluir / Moldura Interna</div><?}?>
     <? if ($tipo=='4' and $tipo2==2) {?><div align="left" class="tit_interno">Restauração / Incluir / Moldura Externa</div><?}?>
     
     
 
                                 
   

 <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor=#f2f2f2>
          <tr>
             <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="250%" height="1"></td>
           </tr>

      
           <tr bgcolor="#f4f4f4">
           <td width="90%" height="24" bgcolor="#f4f4f4" class="texto_bold"><div align="left">&nbsp;&nbsp;</div></td>
                         
              <td align="center" width='20%'><div align="center"></td>
               <td align="center" width='20%'><div align="center"><? echo "<a href=\"inclusao_restauro.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";?></div></td>

          </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="250%" height="1"></td>
        </tr>
</table> 

 <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor=#f2f2f2>
            <tr  bgcolor="#ddddd5">
               <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;&nbsp;Moldura</div></td>   
               <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold" align="center">Registro</td>
               <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold" align="center">Controle</td>                                                  
               <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold" align="center">Editar Moldura</td>                                                  
               <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold" align="center">Restauro</td>                                                  
            </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="500%" height="1"></td>
        </tr>
</table> 


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2" bgcolor=#f2f2f2>
  <tr>




    <td valign="top"><form name="form1" method="get" action="moldura_ocorrencia.php">



       <?       
          if ($_REQUEST[mold_registro]>0)
         {
 
             $sql2="SELECT a.* from moldura as a where a.mold_registro=".$_REQUEST[mold_registro]." and a.parte='0'";    
             $db->query($sql2); 
             while($row=$db->dados())
             {?>
               <tr class="texto" id="cor_fundo<? echo $row['mold_registro'] ?>">               
                  <td width="20%" colspan="2" align="justify">&nbsp;&nbsp;<? echo $row[mold_registro]?><div align="left"></div></td>
                  <td align="center" width='20%'><div align="center"><? echo  $row[num_registro]?></div></td>
                  <td align="center" width='20%'><div align="center"><? echo  $row[controle]?></div></td>
                  <td align="center" width='20%'><div align="center"><? echo "<a href=\"cadastro_moldura.php?op=externa&tipo2=$_REQUEST[tipo2]&form=restauro&obra=".$row[obra]."&parte=".$row[parte]."&moldura=".$row[moldura]."&tombo=".$_REQUEST[numregistro]."&moldura=".$row[moldura]."\">
						                        <img src='imgs/icons/moldura2.gif'  border='0' alt='Editar dados da moldura' 
						                         onMouseOver='document.getElementById(\"cor_fundo".$row[mold_registro]."\").style.backgroundColor=\"#ddddd5\";' 
						                         onMouseOut='document.getElementById(\"cor_fundo".$row[mold_registro]."\").style.backgroundColor=\"\";'>";?></div></td>
               
                  <td align="center" width='20%'><div align="center"><? echo "<a href=\"restauracao_moldura_externa.php?op=insert&tipo2=$_REQUEST[tipo2]&pNum_registro=".$_REQUEST[numregistro]."&pId_parte=".$row[parte]."&controle=".$row[controle]."&moldura=".$row[moldura]."&mold_registro=".$_REQUEST[mold_registro]."\">
						                         <img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir ficha de restauração' 
						                          onMouseOver='document.getElementById(\"cor_fundo".$row[mold_registro]."\").style.backgroundColor=\"#ddddd5\";' 
	       					                          onMouseOut='document.getElementById(\"cor_fundo".$row[mold_registro]."\").style.backgroundColor=\"\";'>";?></div></td>
               </tr>          
             <?}
            } else {?>
              <tr class="texto" id="cor_fundo<? echo $row['mold_registro'] ?>">               
                  <td width="20%" colspan="2" align="justify">&nbsp;&nbsp;<div align="left"></div></td>
                  <td align="center" width='20%'><div align="center"></div></td>
                  <td align="center" width='20%'><div align="center"></div></td>

            <?}?>

         <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
        </tr>
        <tr>
           <td colspan="10" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="250%" height="1"></td>
        </tr>
        <tr class="texto"  bgcolor="#ddddd5">
          <td colspan="10" height="20"></td>
        </tr>
        <tr>
           <td colspan="10" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="250%" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>

    </form>
   </tr>
</table>

</body>
</html>