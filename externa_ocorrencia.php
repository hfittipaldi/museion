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

$num_moldura=$_REQUEST[num_moldura];
$moldura=$_REQUEST[moldura];
$obra=$_REQUEST[obra];
$numregistro=$_REQUEST[numregistro];
$tipo2=$_REQUEST[tipo2];
$tipo=$_REQUEST[tipo];
$op=$_REQUEST['op'];
$papel=$_REQUEST[papel];
$pintura=$_REQUEST[pintura];
$objeto3d=$_REQUEST[objeto3d];
$moldura=$_REQUEST[moldura];



if ($_REQUEST[num_moldura]<>''){
  $sql="select a.obra,b.titulo_etiq, b.num_registro from parte as a inner join  obra as b where (a.obra=b.obra) and a.moldura='".$_REQUEST[num_moldura]."'";
  $db->query($sql);
  $row=$db->dados();
  $_REQUEST[obra]=$row[obra];
  $_REQUEST[numregistro]=$row[num_registro];
  $_REQUEST[titulo_etiq]=$row[titulo_etiq];
  $_REQUEST[obra]=$row['obra'];
  $obra=$row['obra'];
 
}
if ($_REQUEST[numregistro]=='' and $tipo2<>'0'){

  $sql="SELECT num_registro from obra where obra=".$_REQUEST[obra];
  $db->query($sql);
  $row=$db->dados();
  $_REQUEST[numregistro]=$row[num_registro];
}

 if ($tipo2==0){
     $sql="SELECT parte, obra, interna from moldura where mold_registro=".$num_moldura;echo $sql;
     $db->query($sql);
     $row=$db->dados();
     $_REQUEST[parte]=$row[parte];
     $_REQUEST[obra]=$row[obra];
     $tipo2=$row[interna];
     if ($tipo2=='E'){$tipo2=2;}else{$tipo2=1;}

      if ($_REQUEST[obra]<>0)
      {
        $sql="SELECT num_registro from obra where obra=".$_REQUEST[obra];echo $sql;
        $db->query($sql);
        $row=$db->dados();
        $_REQUEST[numregistro]=$row[num_registro];
      }
     
  }


if ($_REQUEST[numregistro]<>''){

  $sql="SELECT obra, titulo_etiq, num_registro from obra where num_registro='".$_REQUEST[numregistro]."'";echo $sql;
  $db->query($sql);
  $row=$db->dados(); 
  $_REQUEST[titulo_etiq]=$row[titulo_etiq];
  $_REQUEST[obra]=$row['obra'];
  $obra=$row['obra'];

}
	
?>
<body>
<table width="100%"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>

  <tr>
    <td valign="top">
<? if ($tipo==1) {?><div align="left" class="tit_interno">Restauração / Incluir / Papel</div><?}?>
<? if ($tipo==2) {?><div align="left" class="tit_interno">Restauração / Incluir / Pintura</div><?}?>
<? if ($tipo==3) {?><div align="left" class="tit_interno">Restauração / Incluir / Obra 3D</div><?}?>
<? if ($tipo==4) {?><div align="left" class="tit_interno">Restauração / Incluir / Moldura</div><?}?>

<br>
<?  if (($obra<>'0'or $obra<>'') or $_REQUEST[num_moldura]<>'') 
     {     
       $_REQUEST[titulo_etiq]="Não existe ocorrência.";
       $wheremold ='';$wherereg='';
       if ($_REQUEST[num_moldura]<>'') $wheremold =" moldura=$_REQUEST[num_moldura] ";
       if ($_REQUEST[numregistro]<>'') $wherereg=" obra=$obra";
        
       if ( ($wheremold<>'') and ($wherereg='') ) 
         {
          $sql2="SELECT * from parte Where".$wheremold;echo $sql2;
          $row=$db->dados();
          $_REQUEST[obra]=$row[obra]; 
          if ( $_REQUEST[obra] <> '')
          {
             $sql2="SELECT num_registro, titulo_etiq from obra where obra=".$_REQUEST[obra];echo $sql2;
             $db->query($sql2); 
             $row=$db->dados();
             $_REQUEST[titulo_etiq]=$row[titulo_etiq];
           }
         if ( ($wheremold='') and ($wherereg<>'') ) 
        {
          
          $sql2="SELECT obra,num_registro, titulo_etiq from obra where".$wherereg;echo $sql2;
          $db->query($sql2); 
          $row=$db->dados();
          $_REQUEST[obra]=$row[obra];
          if ($_REQUEST[obra]<>'') $_REQUEST[titulo_etiq]=$row[titulo_etiq];
          }
        }
     }
  ?>

 <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor=#f2f2f2>
          <tr>
             <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="250%" height="1"></td>
           </tr>

      
           <tr bgcolor="#f4f4f4">
              <? if ($_REQUEST[obra]<>'' or $_REQUEST[obra]<>'0'){?>
            <td width="90%" height="24" bgcolor="#f4f4f4" class="texto_bold"><div align="left">&nbsp;&nbsp;<?echo $row[titulo_etiq]."(".$row[num_registro].")"?></div></td>   
	    <td width="10%" align="right">                                        

                             <? echo "<a href=\"inclusao_restauro.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";
                                 ?>
             <?}else{?>
                 <? if ($tipo2=='E' or $tipo2=='2'){?>

                       <td width="90%" height="24" bgcolor="#f4f4f4" class="texto_bold"><div align="left">&nbsp;&nbsp;<? echo "Não pertence ao Acervo"?></div></td> 

                   <? }else{?>
                       <td width="90%" height="24" bgcolor="#f4f4f4" class="texto_bold"><div align="left">&nbsp;&nbsp;<? echo "Sem ocorrência para o registro ".$_REQUEST[numregistro];?></div></td> 
                    <?}?>  
	    <td width="10%" align="right">                                        

                             


                             <? echo "<a href=\"inclusao_restauro.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";
                                 ?>

             <?}?>

          </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="250%" height="1"></td>
        </tr>
</table> 

 <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor=#f2f2f2>
            <tr  bgcolor="#ddddd5">
            <?
              if ($tipo2=='E' or $tipo=='2'){?>
                 <td width="40%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;&nbsp;Registro</div></td>
              <?}else{?>
                 <td width="40%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;&nbsp;Partes</div></td>
              <?}?>   
            <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold" align="center">Moldura</td>         
            <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold" align="center">Incluir/alterar</td>                                                  
            <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold" align="center">Restauro</td>                                                  
          </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="250%" height="1"></td>
        </tr>
</table> 



<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2" bgcolor=#f2f2f2>
  <tr>

<? if ($_REQUEST[obra]<>'' or ($num_moldura<>'' and ($tipo2=='E' or $tipo2=='2'))){?>


    <td valign="top"><form name="form1" method="get" action="alterarautor.php">
       <?
 
         if ($num_moldura<>'' and $tipo2=='E' or $tipo=='2'){
             $sql2="select * from moldura where moldura=".$_REQUEST[num_moldura];
             $db->query($sql2);
          }else{
                
            $wheremoldp ='';$whereregp='';
            if ($_REQUEST[num_moldura]<>'') $wheremoldp =" moldura=$_REQUEST[num_moldura] ";
            if ($_REQUEST[numregistro]<>'') $whereregp=" obra=$_REQUEST[obra] ";

            if (($wheremold<>'') and ($wherereg=''))
            {
               $sql2="SELECT * from parte where".$wheremoldp;
               $db->query($sql2); 

            }else {
              $sql2="SELECT * from parte where".$whereregp;
              $db->query($sql2); 
            }
         }
         while($row=$db->dados())
          {

         $moldurasel='';

      if ($_REQUEST[tipo]=="4") 
       {

              if ($row[moldura]<>'')
              {
                  $sqlm1="select * from moldura where moldura=".$row[moldura];
                  $dbm1->query($sqlm1);
                  $rowm1=$dbm1->dados();
                  $moldurasel=$rowm1[mold_registro];
                  $id_moldura=$rowm1[moldura];
               }

            
            ?>
              <tr class="texto" id="cor_fundo<? echo $row['nome_objeto'] ?>">
               <td width="40%" colspan="2" align="justify">&nbsp;&nbsp;<? echo $row[nome_objeto]?><div align="left"></div></td>

              <?if ($tipo2=='I'){$tipo2=1;}else{$tipo2=2;}
                if ($row[moldura]>0){?>
                   <td align="center" width='20%'><div align="center"><? echo $moldurasel?></div></td>
                   <td align="center" width='20%'><div align="center"><? echo "<a href=\"cadastro_moldura.php?op=insert&tipo2=$tipo2&form=restauro&obra=".$row[obra]."&parte=".$row[parte]."&moldura=".$row[moldura]."&tombo=".$_REQUEST[numregistro]."&num_registro=".$rowm1[mold_registro]."\">
						                        <img src='imgs/icons/moldura2.gif'  border='0' alt='Editar dados da moldura' 
						                         onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
						                         onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?></div></td>
                  <?if ($tipo2==2){?>    
                     <td align="center" width='20%'><div align="center"><? echo "<a href=\"restauracao_moldura_externa.php?op=insert&tipo2=$tipo2&pNum_registro=".$_REQUEST[numregistro]."&pId_parte=".$row[parte]."&controle=".$row[controle]."&moldura=".$_REQUEST[num_moldura]."&moldura=".$id_moldura."&mold_registro=".$moldurasel."\">
						                         <img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir ficha de restauração' 
						                          onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
						                          onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?></div></td>
                  
                  <?}else{?>

                      <td align="center" width='20%'><div align="center"><? echo "<a href=\"restauracao_moldura_interna.php?op=insert&tipo2=$tipo2&pNum_registro=".$_REQUEST[numregistro]."&pId_parte=".$row[parte]."&controle=".$row[controle]."&moldura=".$_REQUEST[num_moldura]."&moldura=".$id_moldura."&mold_registro=".$moldurasel."\">
						                         <img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir ficha de restauração' 
						                          onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
						                          onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?></div></td>

                   <?}?>

            <?}else{ ?> 

                   <td align="center" width='20%'><div align="center">_</div></td>            
                   <td align="center" width='20%'><div align="center"><? echo "<a href=\"cadastro_moldura.php?op=insert&tipo2=1&form=restauro&obra=".$row[obra]."&parte=".$row[parte]."&moldura=".$row[moldura]."&tombo=".$_REQUEST[numregistro]."&num_registro=".$rowm1[mold_registro]."\">
						 <img src='imgs/icons/moldura.gif'  border='0' alt='Incluir moldura' 
						 onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
						 onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?></div></td>
                                   
                   <td align="center" width='20%'><div align="center">&nbsp;</div></td>            
           
              <? }
         }else { ?>

            <tr class="texto" id="cor_fundo<? echo $row['nome_objeto'] ?>">
               <td width="35%" colspan="2" align="justify">&nbsp;&nbsp;<? echo $row[nome_objeto] ?><div align="left"></div></td>

                 <td align="center" width='15%'><div align="center">&nbsp;</div></td>
                 <td align="center" width='15%'><div align="center">&nbsp;</div></td>
                 <td align="center" width='15%'><div align="center">
                <?if ($_REQUEST[tipo2]=='E'){$_REQUEST[tipo2]='2';}else{$_REQUEST[tipo2]='1';}

                   if ($_REQUEST[tipo]==1) {
                     if ($_REQUEST[tipo2]==I) {?>
                                <? echo "<a href=\"restauracao_papel_interna.php?op=insert&tipo2=I&pNum_registro=".$_REQUEST[numregistro]."&pId_parte=".$row[parte]."\">
				<img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir restauro' 
				onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?>
                      <?}else{?>
                                <? echo "<a href=\"restauracao_papel_externa.php?tipo2=E\">
				<img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir restauro' 
				onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?>
                      <?}?>
                <?}?>

                <?if ($_REQUEST[tipo]==2) {
                     if ($_REQUEST[tipo2]==I) {?>
                                <? echo "<a href=\"restauracao_pintura_interna.php?op=insert&tipo2=I&pNum_registro=".$_REQUEST[numregistro]."&pId_parte=".$row[parte]."\">
				<img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir restauro' 
				onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?>
                      <?}else{?>
                                <? echo "<a href=\restauracao_pintura_externa.php?tipo2=E\">
				<img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir restauro' 
				onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?>
                      <?}?>
                <?}?>

               <?if ($_REQUEST[tipo]==3) {
                     if ($_REQUEST[tipo2]==I) {?>
                                <? echo "<a href=\"restauracao_obra_interna.php?op=insert&tipo2=I&pNum_registro=".$_REQUEST[numregistro]."&pId_parte=".$row[parte]."\">
				<img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir restauro' 
				onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?>
                      <?}else{?>
                                <? echo "<a href=\"restauracao_obra_externa.php?tipo2=E\">
				<img src='imgs/icons/btn_plus.gif'  width='13' height='13'   border='0' alt='Incluir restauro' 
				onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";?>
                      <?}?>
                <?}?>


                </div></td>
 

           <? } ?>
              </tr>


        <?}?>

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
