<? include_once("seguranca.php") ?>

<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

</head>
<script>
function abre_pagina(obra,id,title)
{

  	win=window.open('consulta_restauracao.php?&obraid='+obra+'&op=view&nosave=1&titulo='+title+'&id='+id,'PAG','left='+((window.screen.width/2)-412)+',top='+((window.screen.height/2)-140)+',height=470,width=900,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);

 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>
<?
	include("classes/classe_padrao.php");
        include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
        $lista=$_REQUEST['lista'];
        $obra=$_REQUEST['obra'];
        $parte=$_REQUEST['parte'];
        $tipo2=$_REQUEST['tipo2'];
if ($tipo2==1) {$tipo2='I'; }else{$tipo2='E';}

        $restauro=$_REQUEST['restauro'];
        $moldura=$_REQUEST['moldura'];
        $mold_registro=$_REQUEST['mold_registro'];
      
 
        $tipo=$_REQUEST['tipo'];
        if ($tipo2==I){
           $sql="SELECT num_registro from obra where obra='".$obra."'";
           $db->query($sql);
           $row=$db->dados();
           $tombo=$row[num_registro];
         }

       if ($lista==1){


        if ($tipo2=='I' and $tombo>0){
 
         $sql2="SELECT restauro, seq_restauro, ir, tipo, data_inicio, data_entrada, data_saida from restauro as a 
                       where a.tombo='".$tombo."' and a.parte='".$parte."' and a.obra='".$obra."' and a.tipo='".$tipo."' and a.interna='".$tipo2."' order by a.seq_restauro DESC";
         }
        if ($tipo2=='I' and $tombo==''){
 
          $sql2="SELECT * from restauro where moldura='".$moldura."' and tipo='".$tipo."' and interna='I' order by seq_restauro DESC";

         }
         if ($tipo2=='E')
         {
         $sql2="SELECT * from restauro where moldura='".$moldura."' and tipo='".$tipo."' and interna='E' order by seq_restauro DESC";
         }
                 $db->query($sql2);
          }
      ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

       <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="20" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
         

        <tr bgcolor="#ddddd5">
          <td width="5%" style="border-left: 1px solid #121212;"><img src="imgs/transp.gif" width="1" height="1"></td>
          <td width="18%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="center">IR </div></td>
	  <td width="18%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="center">Restauração </div></td>
	  <td width="18%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="center">Entrada </div></td>
	  <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="center">Início </div></td>
	  <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="center">Saída </div></td>
          <td width="5%" align="center" >        
              <? $comando="<a href=\"lista_obras_restauro.php?tipo=$_REQUEST[tipo]&tombo=$_REQUEST[tombo]&tipo2=$_REQUEST[tipo2]&obra=$_REQUEST[obra]&parte=$_REQUEST[parte]&mold_registro=$_REQUEST[mold_registro]&moldura=$_REQUEST[moldura]&lista=1\";>";
                 echo $comando;?>

              <img src='imgs/icons/btn_listar.gif'  border='0' alt='Listar'></a>
          </td>
	  <td>&nbsp;</td>
          <td width="1%" style="border-right: 1px solid #121212;"><img src="imgs/transp.gif" width="100%" height="1"></td>
          </tr>
      <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="20" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100%" height="1"></td>
        </tr>


<? if ($_REQUEST['lista']=='1')
{?>      
   <? while($row=$db->dados()) 
   {  $id=$row['restauro'];
      $datainicior=formata_data($row[data_inicio]);if ($datainicior=='00/00/0000') {$datainicior="s/d";}
      $dataentradar=formata_data($row[data_entrada]);if ($dataentradar=='00/00/0000') {$dataentradar="s/d";}
      $datasaidar=formata_data($row[data_saida]);if ($datasaidar=='00/00/0000') {$datasaidar="s/d";}?>
      <tr class="texto" id="cor_fundo">
         <td  width="5%"></td>
         <td  width="15%" align="center"><div align="center"><?echo $row['ir'];?> </div></td>
         <td  width="15%" align="center"><div align="center"><?echo $row['seq_restauro'];?> </div></td>
         <td  width="15%" align="center"><div align="center"><?echo $dataentradar;?> </div></td>
         <td  width="20%" align="center"><div align="center"><?echo $datainicior;?> </div></td>
         <td  width="20%" align="center"><div align="center"><?echo $datasaidar;?> </div></td>
         <td width="5%" align="center"><a href="javascript:;" style="text-decoration: none;" onClick="abre_pagina('<? echo $obra; ?>','<? echo $row['restauro']; ?>','<? echo htmlentities(str_replace("'","`",$row[titulo]), ENT_QUOTES); ?>');"><sub><img src="imgs/icons/visualiza.gif" border="0" title="Detalhe..."></sub></a></td>
       </tr>
 <? } ?>
     <tr class="texto">
        <td colspan="4" height="20">
        <div align="center"></div></td>
     </tr>
    <tr>
       <td height="2" colspan="20" bgcolor="#003366"><img src="imgs/transp.gif" width="100%" height="1"></td>
   </tr>
  <tr>
    <td colspan="4"></td>
  </tr>
<?}?>

</table>
</body>
</html>