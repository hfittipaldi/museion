<?
include_once("seguranca.php"); 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$obra=$_REQUEST[obra];
?>

<style type="text/css">
<!--
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #f2f2f2;
	text-decoration: none;
}
.divi {
	scrollbar-arrow-color:#f2f2f2;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#f2f2f2;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
.divi1 {	scrollbar-arrow-color:#f2f2f2;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#f2f2f2;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
-->
</style>

<script>
function esconde()
{
   document.getElementById("obra").style.display="";
   document.getElementById("autor").style.display="none";
   document.getElementById("parte").style.display="none";
   document.getElementById("bio").style.display="none";
   document.getElementById("expo").style.display="none";
   document.getElementById("img").style.display="none";
   document.getElementById("dim").style.display="none";
   document.getElementById("movi").style.display="none";
   document.getElementById("relac").style.display="none";
}
function navega(opcao)
{
 switch(opcao)
 {
    case 0: //Obra
	{
	  with(document)
	   {
	     getElementById("obra").style.display="";
	     getElementById("parte").style.display="none";
		 getElementById("autor").style.display="none";
		 getElementById("bio").style.display="none"; 
	     getElementById("expo").style.display="none"; 
		 getElementById("img").style.display="none";
		 getElementById("dim").style.display="none";
		 getElementById("movi").style.display="none";
                 getElementById("relac").style.display="none";
	   } 
      break;
	}
    case 1: //Parte
	{
	  with(document)
	  {
	   getElementById("parte").style.display="";
	   getElementById("autor").style.display="none";
	   getElementById("bio").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("expo").style.display="none"; 
	   getElementById("img").style.display="none";
	   getElementById("dim").style.display="none";
		 getElementById("movi").style.display="none";
           getElementById("relac").style.display="none";

	  }
    break;
   }
      case 2: //Autor
	{
	  with(document)
	  {
	   getElementById("autor").style.display="";
	   getElementById("parte").style.display="none";
	   getElementById("bio").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("expo").style.display="none"; 
	   getElementById("img").style.display="none";
	   getElementById("dim").style.display="none";
		 getElementById("movi").style.display="none";
		 getElementById("relac").style.display="none";

	  }
    break;
   }
   case 3: //Bio
	{
	  with(document)
	  {
	   getElementById("bio").style.display="";
	   getElementById("parte").style.display="none";
	   getElementById("autor").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("expo").style.display="none"; 
	   getElementById("img").style.display="none";
	   getElementById("dim").style.display="none";
		 getElementById("movi").style.display="none";
           getElementById("relac").style.display="none";
	  }
    break;
   } 
   case 4: // Exposicao
	{
	  with(document)
	  {
	   getElementById("expo").style.display="";
	   getElementById("parte").style.display="none";
	   getElementById("autor").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("bio").style.display="none";
	   getElementById("img").style.display="none";
	   getElementById("dim").style.display="none";
	   getElementById("movi").style.display="none";
           getElementById("relac").style.display="none";
	  }
    break;
   } 
    case 5: // Imagem
	{
	  with(document)
	  {
	   getElementById("img").style.display="";
	   getElementById("parte").style.display="none";
	   getElementById("autor").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("bio").style.display="none";
	   getElementById("expo").style.display="none"; 
	   getElementById("dim").style.display="none";
	   getElementById("movi").style.display="none";
           getElementById("relac").style.display="none";
	  }
    break;
   }
       case 6: // Imagem
	{
	  with(document)
	  {
	   getElementById("dim").style.display="";
	   getElementById("img").style.display="none";
	   getElementById("parte").style.display="none";
	   getElementById("autor").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("bio").style.display="none";
	   getElementById("expo").style.display="none"; 
	   getElementById("movi").style.display="none";
	   getElementById("relac").style.display="none";
	  }
    break;
   }
    case 7: // movimentacao
	{
	  with(document)
	  {
	   getElementById("movi").style.display="";
	   getElementById("parte").style.display="none";
	   getElementById("autor").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("bio").style.display="none";
	   getElementById("expo").style.display="none"; 
	   getElementById("dim").style.display="none";
           getElementById("img").style.display="none";
           getElementById("Relac").style.display="none";
	  }
    break;
   }
case 8: // relacionamento
	{
	  with(document)
	  {
           getElementById("Relac").style.display="";
	   getElementById("parte").style.display="none";
	   getElementById("autor").style.display="none";
	   getElementById("obra").style.display="none";
	   getElementById("bio").style.display="none";
	   getElementById("expo").style.display="none"; 
	   getElementById("dim").style.display="none";
           getElementById("img").style.display="none";
	   getElementById("movi").style.display="none";

	  }
    break;
   }
 }
} 
//
function getobject(obj){
   if (document.getElementById)
      return document.getElementById(obj)
   else if (document.all)
      return document.all[obj]
}
function controle_lista(lista,imagem){
 obj=getobject(lista);
 if (obj.style.display == "block"){ 
    obj.style.display = "none"; 
    getobject(imagem).src="imgs/icons/mais.gif"
 } else {
   obj.style.display = "block";
  getobject(imagem).src="imgs/icons/menos.gif"
 }
}
</script>

<link href="css/home.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<title><? echo str_replace('\"','"',$_REQUEST['titulo']); ?></title><body class="combo_cadastro" onload='esconde()' >
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
    </div></th>
  </tr>
 <?
 // retorna o valor da colecao referente à obra q esta sendo passada para ser incluida no log_pesquisa
 
 function ret_colecao()
 { 
  global $db;
    $sql="SELECT colecao from obra where obra='$_REQUEST[obra]'";
	$db->query($sql);
	$res=$db->dados();
  if($res==0) {
   return 0;}
 else{
   return $res[0];}  
 }

//if($_REQUEST[op]=='view') {
  $colecao=ret_colecao();
  $sql="INSERT INTO log_pesquisa(colecao,autor,obra,data_hora)values('$colecao','0','$_REQUEST[obra]',now())";
  $db->query($sql);
//}

   /// Funcao q troca o usuario da sessao pelo seu nome correspondente.
   function ret_nome($idnome)
   {
    global $db;
	$sql="select nome from usuario where usuario=$idnome";
	$db->query($sql);
	$nome=$db->dados();
	return $nome[0];
    }
   $sql="select a.* from obra as a where a.obra='$_REQUEST[obra]'";
   $db->query($sql);
   while($row=$db->dados())
	  { 
	    $obra=$row['obra'];
		//$museu_origem=$row['museu'];
	    $num_registro=$row['num_registro'];
		$colecao=$row['colecao'];
		$inventario=$row['inventario'];
		if ($inventario == 0)
			$inventario= '';
	        $ctrlinv=$row['controle_inv'];
		$status=$row['status'];
		$forma_aquisicao=$row['forma_aquisicao'];
		$objeto=$row['objeto'];
		$copia=$row['copia'];
		$titulo=$row['titulo'];
		$num_serie=$row['num_serie'];
		$titulo_ingles=$row['titulo_ingles'];
		$titulo_etiq=$row['titulo_etiq'];
		$texto_etiq=$row['texto_etiq']; 
		$periodo=$row['periodo'];
		$escola=$row['escola'];
		$estilo=$row['estilo'];
        $material_tecnica=$row['material_tecnica'];
		$movimento=$row['movimento'];
        $impressor=$row['impressor'];
        $editor=$row['editor'];
	    $num_edicao=$row['num_edicao'];
        $desc_conteudo=$row['desc_conteudo'];
		$subtema=$row['sub_tema'];
//data
/*		$dt_aq_di= $row['dt_aquisicao_di']."-";
		$dt_aq_df= $row['dt_aquisicao_df'];
		$dt_aq_extra2= $row['dt_aquisicao_tp'];
		dtformato_externo($dt_aq_di, $dt_aq_df, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
		$dt_aqdia= $data['dia'];
		$dt_aqmes= $data['mes'];
		$dt_aqano= $data['ano'];
		$dt_aq_extra1= $data['ano2'];*/
		$dt_aqdia= $row['dt_aquisicao_dia'];
		$dt_aqmes= $row['dt_aquisicao_mes'];
		$dt_aqano= $row['dt_aquisicao_ano1'];
		$dt_aq_extra1= $row['dt_aquisicao_ano2'];
		$dt_aq_extra2= $row['dt_aquisicao_tp'];
//
       $num_processo=$row['num_processo'];
       $doador=$row['doador'];
       $val_compra=$row['val_compra'];
       $val_seguro=$row['val_seguro'];
       $ex_proprietarios=$row['ex_proprietarios'];
	   $local_fixo=$row['local_fixo'];
	   $trainel_gaveta=$row['trainel_gaveta'];
	   $obs=$row['obs'];
	   $catalogado=ret_nome($row['catalogado']);
	   $atualizado= ret_nome($row['atualizado']);
	   $dim_obra_altura=trim($row['dim_obra_altura']);
	   $dim_obra_largura=trim($row['dim_obra_largura']);
	   $dim_obra_diametro=trim($row['dim_obra_diametro']);
	   $dim_obra_profund=trim($row['dim_obra_profund']);
	   $dim_obra_peso=trim($row['dim_obra_peso']);
	   $dim_obra_formato=$row['dim_obra_formato'];
	   $aimp_obra_altura=trim($row['aimp_obra_altura']);
	   $aimp_obra_largura=trim($row['aimp_obra_largura']);
	   $aimp_obra_diametro=trim($row['aimp_obra_diametro']);
	   $aimp_obra_formato=$row['aimp_obra_formato'];
       ///
	 $data_catalog1=convertedata($row['data_catalog1'],'d/m/y - h:i');
	 if($row[data_catalog2]=='0000-00-00 00:00:00')
		{ $data_catalog2='';}
	 if($row[data_catalog2]!='0000-00-00 00:00:00')
		 { $data_catalog2=convertedata($row[data_catalog2],'d/m/y - h:i');}
	   //
		  }
		  
$sql2="SELECT a.nome
FROM tema AS a INNER JOIN tema_obra AS b, obra AS c
WHERE (b.obra = c.obra and b.tema=a.tema)AND b.obra = '$obra'";
$db->query($sql2);
while($temas=$db->dados())
{
 $t[]=$temas[0];
}
$tot=count($t);
for($i=0;$i<=$tot;$i++){
$tema.=$t[$i];
if($i<$tot-1)
  {
   $tema.=', ';
   }
}
 function conta_total()
{
 global $db;
 $sql="SELECT sum(quantidade) T from log_pesquisa where obra='$_REQUEST[obra]'";
 $db->query($sql);
 $row=$db->dados();
 echo $row[T];
}


////////SQL para obter museu fixo////////
  $sql="select a.nome,a.museu from museu as a where a.museu in (select valor from parametro where parametro = 'LOCAL_INSTAL')";
  $db->query($sql);
  $museu=$db->dados();
  $museu_origem=$museu[0]; 
  $museu_id=$museu[1];					
/////////////////////////////////////////
  ?>
<table width="520">
<tr>
<td>

  df~çaslf~sçfls
        <form name="form2" method="post" action="">
            <span class="texto_bold">Consultas realizadas:
               <input name="textfield" align="middle" type="text" class="combo_cadastro" readonly="1" size="7" value="<? conta_total() ?>">
            </span>   
        </form>     

</td>
<td>
<table colspan="6" width="80%" border="1">
    <tr>
       <td nowrap class="combo_cadastro" width="60%">
         <input name="Submit" type="submit" onClick="navega(0);"class="text" style="width: 45px;" value=" Obra " >
         <input name="Submit" type="submit" onClick="navega(6);"class="text" style="width: 80px;" value="Dimens&otilde;es">
         <input name="Submit" type="submit" onClick="navega(1);"class="text" style="width: 50px;" value="Partes">
         <input name="Submit" type="submit" onClick="navega(2);"class="text" style="width: 50px;" value="Autoria">
         <input name="Submit" type="submit" onClick="navega(3);"class="text" style="width: 87px;" value="Bibliografia">
         <input name="Submit" type="submit" onClick="navega(4);"class="text" style="width: 87px;" value="Exposi&ccedil;&otilde;es">
         <input name="Submit" type="submit" onClick="navega(7);"class="text" style="width: 105px;" value="Movimenta&ccedil;&otilde;es">
         <input name="Submit" type="submit" onClick="navega(5);"class="text" style="width: 60px;" value="Imagem">
         <input name="Submit" type="submit" onClick="navega(8);"class="text" style="width: 105px;" value="Relacionamento">
 
	<a href="javascript:window.close()" class="texto_bold"><? echo "<img src=imgs/icons/ic_remover.gif border=0 alt='Fechar' align='baseline'>&nbsp;&nbsp;Fechar</a>"; ?></a>
      </td>
     </tr>
</table>



  <div id="obra" style="display:">
    <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
       <tr>
         <td width="24%" class="texto_bold"><div align="left">Tombo:&nbsp;<? echo "<span class='texto'>$num_registro</span>"; ?> </div></td>
         <td width="19%" class="texto_bold">Assinada:&nbsp;
		 <? $sql="SELECT assinada from parte where obra='$obra' and assinada='S'";
		    $db->query($sql); $row=$db->dados(); 
			if($row[0]==''){ echo "<span class='texto'>Não</span>"; }else{ echo "<span class='texto'>Sim</span>";}  
		  ?></td>
         <td width="34%" class="texto_bold">N&ordm; de invent&aacute;rio:&nbsp;<? echo "<span class='texto'>$inventario</span>"; ?></td>
         <td width="5%" class="texto_bold">&nbsp;</td>
         <td width="18%" class="texto_bold">Controle:&nbsp;<? echo "<span class='texto'>$ctrlinv</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Cole&ccedil;&atilde;o/Classe:&nbsp;
		 <? $sqlx="SELECT nome from colecao where colecao='$colecao'";
		  $db->query($sqlx); $row=$db->dados(); echo "<span class='texto'>$row[0]</span>"; ?>
	</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold"><div align="left">Objeto:&nbsp;<? echo "<span class='texto'>$objeto</span>"; ?></div></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Autor principal:&nbsp;
		 <?  
		 $sqly="SELECT a.nomeetiqueta FROM autor  AS a INNER JOIN  autor_obra as b on (a.autor=b.autor) 
		         where obra='$_REQUEST[obra]' and hierarquia='1'";
	     $db->query($sqly);$row=$db->dados(); echo "<span class='texto'>$row[0]</span>";
		  ?> 
	 </td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Movimento: 
           <? echo "<span class='texto'>$movimento</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Estilo: 
           <? echo "<span class='texto'>$estilo</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">C&oacute;pia:&nbsp;<? echo "<span class='texto'>$copia</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Periodo:&nbsp;<? echo "<span class='texto'>$periodo</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Escola/ Grupo Cultural:&nbsp;<? echo "<span class='texto'>$escola</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold"><div align="left"></div>
             <div align="left">T&iacute;tulo/T&iacute;tulo da s&eacute;rie:&nbsp;<? echo "<span class='texto'>$titulo</span>"; ?></div></td>
       </tr>
       <tr>
         <td colspan="2" class="texto_bold"><div align="left">N&ordm; de s&eacute;rie:&nbsp;<? echo "<span class='texto'>$num_serie</span>"; ?></div></td>
         <td colspan="2" class="texto_bold">N&ordm; do processo:&nbsp;<? echo "<span class='texto'>$num_processo</span>"; ?> &nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" nowrap class="texto_bold"><div align="left">T&iacute;tulo p/ etiqueta:&nbsp;<? echo "<span class='texto'>$titulo_etiq</span>"; ?></div></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Texto para etiqueta:&nbsp;
         <? echo "<span class='texto'>$texto_etiq</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Temas:&nbsp;
		 <? $sqlz="select nome from tema as x,tema_obra as y where x.tema=y.tema and y.obra='$obra'"; $db->query($sqlz);
$row=$db->dados; $res[]=$row[0]; 
  for($i=0;$i<count($res);$i++){
    $str=$res[$i];
  if($i+1 < count($res))
     $str.=",";
    $tema.=$str;}
echo "<span class='texto'>$tema</span>"; ?>
</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Sub-Temas:&nbsp;<? echo "<span class='texto'>$subtema</span>";?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Descri&ccedil;&atilde;o de conte&uacute;do:<? echo "<span class='texto'><br>$desc_conteudo</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Data de aquisi&ccedil;&atilde;o:
		  <? $dat='';
		   if ($dt_aqdia > '0' and $dt_aqmes >'0' and $dt_aq_extra1 == '0000')
	           	$dat = $dt_aqdia."/".$dt_aqmes."/".$dt_aqano;
		   if ($dt_aqdia == '0' and $dt_aqmes >'0' and $dt_aq_extra1 == '0000')
	           	$dat = $dt_aqmes."/".$dt_aqano;
		   if ($dt_aqdia == '0' and $dt_aqmes =='0' and $dt_aq_extra1 == '0000')
	           	$dat = $dt_aqano;
		   if ($dt_aqano == '0000' and $dt_aq_extra1 <> '0000')
	           	$dat = $dt_aq_extra1." (data no campo errado - corrigir ficha)";
		   if ($dt_aqano <> '0000' and $dt_aq_extra1 <> '0000')
	           	$dat = $dt_aqano."-". $dt_aq_extra1;
		   if ($dt_aq_extra2 == 'circa')
			$dat.= " (circa) ";
		   if ($dt_aq_extra2 == '?')
			$dat.=" (?) ";
        echo "<span class='texto'>$dat</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Forma de aquisi&ccedil;&atilde;o:&nbsp;
           <? 
					  $sql="SELECT nome from forma_aquisicao where forma_aquisicao='".trim($forma_aquisicao)."'"; 
					  $db->query($sql);
					  $row=$db->dados();echo "<span class='texto'>$row[nome]</span>";?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Doador/Vendedor:&nbsp;<? echo "<span class='texto'>$doador</span>"; ?></td>
       </tr>
		<?
			if ($_SESSION[snome] == 'VISITANTE') { 
				$val_compra= "";
				$val_seguro= "";
				$local_fixo= "nda";
				$trainel_gaveta= "";
				$obs= "";
			}
		?>
		<? if ($_SESSION[snome] <> 'VISITANTE') { ?>
       <tr>
         <td colspan="2" class="texto_bold">Valor de compra:&nbsp;<? echo "<span class='texto'>$val_compra</span>"; ?> </td>
         <td colspan="2" class="texto_bold"> Valor de seguro:&nbsp;<? echo "<span class='texto'>$val_seguro</span>"; ?> </td>
       </tr>
		<? } ?>
       <tr>
         <td colspan="4" class="texto_bold">Ex-propriet&aacute;rios:&nbsp;<? echo "<span class='texto'><br>$ex_proprietarios</span>"; ?></td>
       </tr>
		<? if ($_SESSION[snome] <> 'VISITANTE') { ?>
       <tr>
         <td colspan="4" class="texto_bold">Localiza&ccedil;&atilde;o fixa:
             <? 
					  $sql="SELECT nome from local where local='$local_fixo'";
					  $db->query($sql);
					  $res2=$db->dados();
					  echo "<span class='texto'>$res2[0]</span>";
				  ?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Trainel/Gaveta/Estante: <? echo "<span class='texto'>$trainel_gaveta</span>";?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Observa&ccedil;&otilde;es:<? echo "<span class='texto'><br>$obs</span>";?></td>
       </tr>
		<? } ?>
       <tr>
         <td colspan="4" class="texto_bold">Catalogado por:&nbsp;<? echo  "<span class='texto'>$catalogado</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Data de cataloga&ccedil;&atilde;o:&nbsp;<? echo "<span class='texto'>$data_catalog1</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Data de &uacute;ltima altera&ccedil;&atilde;o:&nbsp;<? echo "<span class='texto'>$data_catalog2</span>"; ?></td>
       </tr>


    </table>




  </div>
<div id='autor' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td height="30" bgcolor="#f2f2f2"  ><? echo "<iframe align='middle' src='consulta_autor_obra.php?obra=$_REQUEST[obra]' width='700' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>
    </tr>
  </table>
</div>
 <div id='parte' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td height="30" bgcolor="#f2f2f2"  ><? echo "<iframe align='middle' src='consulta_parte_obra.php?obra=$_REQUEST[obra]' width='700' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>
    </tr>
  </table>
 </div>
 <div id='bio' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td height="30" bgcolor="#f2f2f2"  ><? echo "<iframe align='middle' src='consulta_bibliografia_obra.php?id=$_REQUEST[obra]' width='700' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>
    </tr>
  </table>
</div>
    <div id='expo' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td height="30" bgcolor="#f2f2f2"  ><? echo "<iframe align='middle' src='consulta_exposicao_obra.php?id=$_REQUEST[obra]' width='700' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>
    </tr>
  </table>
  </div>
  <div id='movi' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td height="30" bgcolor="#f2f2f2"  ><? echo "<iframe align='middle' src='consulta_movimento_obra.php?id=$_REQUEST[obra]' width='700' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>
    </tr>
  </table>
  </div>
  <div id='img' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td height="30" bgcolor="#f2f2f2"  ><? echo "<iframe align='middle' src='imagem_lista.php?obra=$_REQUEST[obra]' width='700' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>
    </tr>
  </table>
  </div>

 <div id='Relac' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td height="30" bgcolor="#f2f2f2"  ><? echo "<iframe align='middle' src='relacionamento_obra2.php?obra=$_REQUEST[obra]' width='700' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>
    </tr>
  </table>
  </div>




   <div id='dim' style="display:" >
  <table width="100%"  border="0">
    <tr>
      <td width="100%" height="343" colspan="3" bgcolor="#f2f2f2" class="texto_bold">
		&nbsp;Editor:<? echo "<span class='texto'>&nbsp;$editor</span>"; ?><br>
        <br>
        &nbsp;Impressor/Fundi&ccedil;&atilde;o/Fabricante:<? echo "<span class='texto'>&nbsp;$impressor</span>"; ?><br>
        <br>
        &nbsp;N&ordm; de Edi&ccedil;&atilde;o:<? echo "<span class='texto'>&nbsp;$num_edicao</span>"; ?><br>
        <br>
        &nbsp;Material/t&eacute;cnica:<? echo "<span class='texto'>&nbsp;$material_tecnica</span>"; ?>
        <p><u>&nbsp;Dimens&otilde;es da Obra:</u></p>
        <p>&nbsp;Altura:
          <?  $altura=number_format($dim_obra_altura,2,',','.'); echo "<span class='texto'>$altura</span>"; ?>&nbsp;
          cm &nbsp;&nbsp;&nbsp;&nbsp;Largura:
<? $largura=number_format($dim_obra_largura,2,',','.'); echo "<span class='texto'>$largura</span>"; ?>&nbsp;
cm &nbsp;&nbsp;&nbsp;Di&acirc;metro:
<? $diametro=number_format($dim_obra_diametro,2,',','.');  echo "<span class='texto'>$diametro</span>"; ?>&nbsp;
cm </p>
      <p>&nbsp;Profundidade:
        <?  $prof=number_format($dim_obra_profund,2,',','.'); echo "<span class='texto'>$prof</span>"; ?>
&nbsp;&nbsp;Peso:
<? $peso=number_format($dim_obra_peso,2,',','.'); echo "<span class='texto'>$peso</span>"; ?>
&nbsp;Kg &nbsp;&nbsp;&nbsp;Formato:
<? if($dim_obra_formato=='C') echo "<span class='texto'>Circular</span>"; 
   elseif($dim_obra_formato=='I') echo "<span class='texto'>Irregular</span>";
   elseif($dim_obra_formato=='L') echo "<span class='texto'>Los&acirc;ngico</span>";
   elseif($dim_obra_formato=='0') echo "<span class='texto'>Oval</span>";
   elseif($dim_obra_formato=='T') echo "<span class='texto'>Triangular</span>"; ?>
<br>
<br>
<u>&nbsp;Dimens&otilde;es da &aacute;rea impressa:</u></p>
      <p>&nbsp;Altura:
        <?  $altura=number_format($aimp_obra_altura,2,',','.'); echo "<span class='texto'>$altura</span>"; ?>&nbsp;
cm &nbsp;&nbsp;&nbsp;&nbsp;Largura:
<? $largura=number_format($aimp_obra_largura,2,',','.'); echo "<span class='texto'>$largura</span>"; ?>&nbsp;
cm &nbsp;&nbsp;&nbsp;Di&acirc;metro:
<? $diametro=number_format($aimp_obra_diametro,2,',','.');  echo "<span class='texto'>$diametro</span>"; ?>
&nbsp;cm &nbsp;&nbsp;&nbsp;Formato:
<? if($aimp_obra_formato=='C') echo "<span class='texto'>Circular</span>"; 
   elseif($aimp_obra_formato=='I') echo "<span class='texto'>Irregular</span>";
   elseif($aimp_obra_formato=='L') echo "<span class='texto'>Los&acirc;ngico</span>";
   elseif($aimp_obra_formato=='0') echo "<span class='texto'>Oval</span>";
   elseif($aimp_obra_formato=='T') echo "<span class='texto'>Triangular</span>"; ?>
</p>
      </td>
    </tr>
  </table>
  </div>
  </form>
   <table align="left" border="0">
      <td width="100%" align="left">
         <form name="form2" method="post" action="">
            <span class="texto_bold">Consultas realizadas:
               <input name="textfield" align="middle" type="text" class="combo_cadastro" readonly="1" size="7" value="<? conta_total() ?>">
            </span>   
        </form>     
      </td>
      <td width="470">
         <form name="form1" method="post" action="obraconsulta.php">
         </form>
      </td>
   </table> 
   </td> 
  </tr>
</table> 
</body>
