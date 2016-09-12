<?  include_once("seguranca.php") ?>
<style type="text/css">
<!--
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #34689A;
	text-decoration: none;
}
.divi {
	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
.divi1 {	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
	background-color: #f2f2f2;
}
-->
</style>
<script src="js/funcoes_padrao.js"></script>
<script language="JavaScript">
function ajustaAbas(index) {
	numAbas=6;

	if (index == 1)
		document.getElementById("aba1").style.borderLeftColor= "#34689A";
	else
		document.getElementById("aba1").style.borderLeftColor= "#34689A";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("link"+i).style.color= "#34689A";
	}
	document.getElementById("link"+index).style.color= "blue";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("aba"+i).style.borderBottomColor= "#34689A";
		document.getElementById("aba"+i).style.verticalAlign= "bottom";
		document.getElementById("aba"+i).style.backgroundColor= "";
	}
	document.getElementById("aba"+index).style.borderBottomColor= "#f2f2f2";
	document.getElementById("aba"+index).style.verticalAlign= "middle";
	document.getElementById("aba"+index).style.backgroundColor= "#f2f2f2";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("quadro"+i).style.display= "none";
	}
	document.getElementById("quadro"+index).style.display= "";
 if(index==6){ 
     document.form.submit.style.display='none';
     document.getElementById('rodape').style.display="none";
	}
  else {
    document.getElementById('rodape').style.display="";
	document.form.submit.style.display="";
  }
}
function Add(i,parametro)
{
   if(parametro!=''){
  var item="\n- "+parametro+": ";
  document.getElementById(i).value+=item;}
 }
/// validacao do form
function valida(){
    var mensagem = "";
    var form  = document.form;
    var campo = "";
    var num_elementos =  form.elements.length;
 for (var i = num_elementos-1; i >= 0 ; i--){	  	   
     var elemento = form.elements[i];
	 	 //Título
        if (elemento.name == "titulo"){
          if(IsEmpty(elemento)) 
		  {
             campo = elemento;
             mensagem = "Informe o Título da Obra \n\n" + mensagem;
          }
		  continue;
        } 
	//Sequencial (Restauração)
	if (elemento.name == "seq_restauro"){
          if(IsEmpty(elemento)) 
		  {
             campo = elemento;
             mensagem = "Número Sequencial da Restauração não pode ser vazio \n\n" + mensagem;
          }
		  continue;
       }
	 //Data_Início
        if (elemento.name == "data_inicio"){
          if(!IsEmpty(elemento)) 
		  {
			 if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data de início inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
		  continue;
        } 
       }
	//Data_Entrada 
	if (elemento.name == "data_entrada"){
          if(!IsEmpty(elemento)) 
		  {
			 if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data de entrada inválida (dd/mm/aaaa) \n\n" + mensagem;
          } }
		  else {
             campo = elemento;
             mensagem = "Data de entrada não pode ser vazia (dd/mm/aaaa) \n\n" + mensagem;
		  }
		  continue;
       }
	//Data_saida
	      if (elemento.name == "data_saida"){
          if(!IsEmpty(elemento)) 
		  {
			 if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data de Saída inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
		  continue;
        } 
       }
        if (elemento.name == "tecnico"){
          if(IsEmpty(elemento)) 
		  {
             campo = elemento;
             mensagem = "Informe o(s) técnico(s) restaurador(es) \n\n" + mensagem;
          }
		  continue;
        } 
     }	  //fecha loop do for
    
	 if (mensagem != ""){
        alert(mensagem);
        campo.focus();
        return false;
     } else return true;
}
//
padrao=/^\d+(,|.\d+)?$/;
function testavalor(e)
{
 if(e.value!='')
 {
      OK = padrao.exec(e.value);
 if (!OK){
    window.alert ("Valor numérico inválido\n Utilize apenas duas casas decimais separados por vírgula ou ponto.");
	ajustaAbas(1);
	e.focus();
	return false;
       
 } else { 
   return true;
    }
}
}

function abrepop(janela) {
 win=window.open(janela,'lista','left='+((window.screen.width/2)-175)+',top='+((window.screen.height/2)-150)+',width=350,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4) {
   win.window.focus();
 }
 return true;
}
</script>
<script>
function esconde_camadas()
{
 document.getElementById('camada_pro').style.display='none';
 document.getElementById('camada_sup').style.display='none';
 document.getElementById('camada_pict').style.display='none';
 document.getElementById('camada_fundo').style.display='none';
 document.getElementById('camada_chassis').style.display='none';
 document.getElementById('camada_moldura').style.display='none'; 
} 
function troca_camadas(valor){
if(valor=='P'){
 document.getElementById('camada_pro').style.display='';
 document.getElementById('camada_sup').style.display='none';
 document.getElementById('camada_pict').style.display='none';
 document.getElementById('camada_fundo').style.display='none';
 document.getElementById('camada_chassis').style.display='none';
 document.getElementById('camada_moldura').style.display='none'; }
if(valor=='S'){
 document.getElementById('camada_sup').style.display='';
 document.getElementById('camada_pro').style.display='none';
 document.getElementById('camada_pict').style.display='none';
 document.getElementById('camada_fundo').style.display='none';
 document.getElementById('camada_chassis').style.display='none';
 document.getElementById('camada_moldura').style.display='none';} 
if(valor=='PI'){
 document.getElementById('camada_pict').style.display='';
 document.getElementById('camada_pro').style.display='none';
 document.getElementById('camada_sup').style.display='none';
 document.getElementById('camada_fundo').style.display='none';
 document.getElementById('camada_chassis').style.display='none';
 document.getElementById('camada_moldura').style.display='none';} 
if(valor=='C'){ 
 document.getElementById('camada_chassis').style.display='';
 document.getElementById('camada_pro').style.display='none';
 document.getElementById('camada_sup').style.display='none';
 document.getElementById('camada_fundo').style.display='none';
 document.getElementById('camada_pict').style.display='none';
 document.getElementById('camada_moldura').style.display='none';} 
if(valor=='F'){
 document.getElementById('camada_fundo').style.display='';
 document.getElementById('camada_pro').style.display='none';
 document.getElementById('camada_sup').style.display='none';
 document.getElementById('camada_chassis').style.display='none'; 
 document.getElementById('camada_pict').style.display='none';
 document.getElementById('camada_moldura').style.display='none';} 
if(valor=='M'){
 document.getElementById('camada_moldura').style.display='';
 document.getElementById('camada_pro').style.display='none';
 document.getElementById('camada_sup').style.display='none';
 document.getElementById('camada_fundo').style.display='none';
 document.getElementById('camada_pict').style.display='none';
 document.getElementById('camada_chassis').style.display='none';} 
if(valor=='#'){
 esconde_camadas();}
}
</script>
<?php $aba=1; ?>
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
<body onLoad='ajustaAbas(<? echo $aba ?>); esconde_camadas(); '>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
  </div></th>
        <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
//
set_time_limit(0);

function insere_atualiza_seq() {
$seq=$_REQUEST['seq_restauro']; //sequencial passado no formulario.
global $db;
if ($seq == '')
	$seq= 0;
//if($_REQUEST[id]=='') {
   $sql2="SELECT seq_restauro,tombo, data_entrada from restauro where 
      tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and seq_restauro=$seq and restauro <> '$_REQUEST[id]' and tipo=2 and interna='E'";
 $db->query($sql2);
   $res=$db->dados();
   if($res<> '')
   {
       echo "<script>alert('A obra com Nº de Registro: $res[tombo] - Restauração: $res[seq_restauro] já se encontra cadastrada!');</script>";
       exit;
   }
// }
$where_atualiza='';
if($_REQUEST[id]!='')
{
$where_atualiza=" and restauro <> '$_REQUEST[id]'";
}	  
  $sql3="select seq_restauro, data_entrada from restauro where 
tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and tipo=2 and interna='E' $where_atualiza  order by seq_restauro asc";
$db->query($sql3);
   while($res=$db->dados()) 
   {
      $vet[$res['seq_restauro']]=$res['data_entrada'];
	 }
 
$vet[$_REQUEST['seq_restauro']] =explode_data($_REQUEST['data_entrada']);
ksort($vet);
reset($vet);
$dt_ant ='0000-00-00';
$tot=count($vet); 
foreach($vet as $dt){
	   if($dt<$dt_ant)    { 
	   	  	   	  $seq = -1;
			  break;
		 } else {
     	    $dt_ant = $dt;
		    }
	 }
return $seq;
}
//

$tecnico= $_SESSION['snome'];

if($_REQUEST[id]<>'' || $_REQUEST['op']=='update')
{
if ($_REQUEST['op'] == 'del') {
	$sql="DELETE from restauro where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	$sql="DELETE from restauro_obra where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	$sql="DELETE from restauro_fotografia where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	echo "<script>alert('Exclusão realizada com sucesso');</script>";
	echo "<script>location.href='alteracao_restauro.php'</script>";
}
else {
$sql="select a.*,b.* from restauro as a,restauro_obra as b where (a.restauro=b.restauro) and a.restauro=$_REQUEST[id]";
 $db->query($sql);
 $res=$db->dados();
 $seq_restauro=$res['seq_restauro'];
 $ir=$res['ir'];
   //////////////////////////////////
 ////////////RESTAURO////////////////
 //////////////////////////////////
                  $obra="0";
               $interna=$res['interna'];
          $_REQUEST[ir]=$res['ir'];
              $controle=$res['controle'];
           $nome_objeto=$res['nome_objeto'];
                 $autor=$res['autor'];
                $titulo=$res['titulo'];
                 $tombo=$res['tombo'];
           $altura_obra=$res['altura'];
          $largura_obra=$res['largura'];
               $tecnica=$res['tecnica'];
               $colecao=$res['colecao'];
                   $obs=$res['obs'];
          $data_entrada=formata_data($res['data_entrada']);
           $data_inicio=formata_data($res['data_inicio']);
            $data_saida=formata_data($res['data_saida']);
               $tecnico=$res['tecnico'];
     $profundidade_obra=$res['profundidade'];
             $peso_obra=$res['peso'];
         $diametro_obra=$res['diametro'];
     $profundidade_base=$res['profundidade_base'];
             $peso_base=$res['peso_base'];
           $altura_base=$res['altura_base'];
          $largura_base=$res['largura_base'];
         $diametro_base=$res['diametro_base'];

   //////////////////////////////////
 ////////////RESTAURO_OBRA/////////
 //////////////////////////////////
           $assinatura=$res['assinatura'];
               $exames=$res['exames'];
     $estado_cons_obra=$res['estado_cons_obra'];
      $tratamento_obra=$res['tratamento_obra'];
     $estado_cons_base=$res['estado_cons_base'];
      $tratamento_base=$res['tratamento_base'];
$estado_cons_estrutura=$res['estado_cons_estrutura'];
 $tratamento_estrutura=$res['tratamento_estrutura'];
   $estado_cons_patina=$res['estado_cons_patina'];
    $tratamento_patina=$res['tratamento_patina'];

   if($data_entrada == '00/00/0000')
	$data_entrada= '';
   
   if($data_inicio == '00/00/0000')
	$data_inicio= '';
   
   if($data_saida == '00/00/0000')
	$data_saida= '';

     $tecnica_detalhe=$res['tecnica_detalhe'];


     $estado_cons_obra=$res['estado_cons_obra'];
      $tratamento_obra=$res['tratamento_obra'];
     $estado_cons_base=$res['estado_cons_base'];
      $tratamento_base=$res['tratamento_base'];
$estado_cons_estrutura=$res['estado_cons_estrutura'];
 $tratamento_estrutura=$res['tratamento_estrutura'];
   $estado_cons_patina=$res['estado_cons_patina'];
    $tratamento_patina=$res['tratamento_patina'];

}
}
?>

<?
  
    if  ($_REQUEST['op']=='update') {$acao_restauro="alteracao_restauro.php";}else{ $acao="inclusao_restauro.php";}
?>
  </tr>
<form name="form" method="post" onSubmit='return valida();' enctype="multipart/form-data">
   <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="120" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Ficha tecnica</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Obra</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Base</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Estrutura</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>Pátina</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba6" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(6);"><div class="texto" id="abas"><a href="javascript:;" id="link6" onClick="ajustaAbas(6);" onMouseDown="this.click();"><span>Imagem</span></a></div></td>
    </tr>
      <td colspan="7" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="310" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
              <div id="quadro1" class="divi1" style="display: ; width:540px; ">
			          <table width="97%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;Tipo:</font></div></td>
                      <td width="16%" class="texto_bold"> <input name="interna" type="text"  class="combo_cadastro"  readonly="1" value="<? echo "Não Acervo"; ?>" id="interna" size="12"></td>
                      <td width="41%" class="texto_bold">IR:
                      <input name="ir" type="text" class="combo_cadastro"  id="ir" value="<? echo $_REQUEST[ir] ?>" size="5"></td>
                      <td width="5%"><div align="left">  <?if  ($_REQUEST['op']=='update') { echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";} else { echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";}?></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Autor:</div></td>
	                      <td colspan="3"><input name="autor"  type="text"  class="combo_cadastro" id="autor" size="75" 
					  value="<? echo htmlentities($autor, ENT_QUOTES); ?>">
</td>
                    </tr>
                    <tr class="texto_bold">
                    <td colspan="2"><div align="right">T&iacute;tulo:</div></td>
					<td colspan="3"><input name="titulo" type="text"   class="combo_cadastro" id="titulo" size="75" value="<? echo htmlentities($titulo, ENT_QUOTES); ?>">
 </tr>
                    <tr class="texto_bold">
                    <td colspan="2"><div align="right">Objeto:</div></td>
					<td colspan="3"><input name="nome_objeto" type="text"   class="combo_cadastro" id="nome_objeto" size="75" value="<? echo htmlentities($nome_objeto, ENT_QUOTES); ?>">
 </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">N&ordm; registro:</div></td>
                      <td colspan="3">
                        <input name="tombo" type="text" class="combo_cadastro"   id="tombo"  size="12" value="<? echo htmlentities($tombo, ENT_QUOTES); ?>">
&nbsp; Controle:
 <input name="controle"  class="combo_cadastro" id="controle"  size="5" type="text" value="<? echo htmlentities($controle, ENT_QUOTES); ?>">
 &nbsp; Restaura&ccedil;&atilde;o: &nbsp;
 <input name="seq_restauro" type="text" class="combo_cadastro"  id="seq_restauro" value="<? echo $seq_restauro; ?>" size="2">
</td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Cole&ccedil;&atilde;o:</div></td>
                      <td colspan="3"><input name="colecao" type="text"  class="combo_cadastro" id="colecao" size="75" value="<? echo $colecao ?>"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">T&eacute;cnica:</div></td>
                      <td colspan="3"><input name="tecnica" type="text" class="combo_cadastro" id="tecnica"  value="<? echo htmlentities($tecnica, ENT_QUOTES); ?>" size="60"></td>

                    </tr>
                        <!-- DIMENSOES : --> 
                      <tr class="texto_bold">
                      <td colspan="2" valign="top"><div valign="top" align="right"><font style="color:#9B9B9B">(Dim. da obra)</font></div></td>
                      <td colspan="3">altura: <input name="altura_obra" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="altura_obra" value="<? echo number_format($altura_obra,2,',','.'); ?>" size="4">
                                 cm &nbsp;&nbsp;&nbsp;&nbsp;largura: 
                                 <input name="largura_obra" type="text" class="combo_cadastro" id="largura_obra" onChange="return testavalor(this);" value="<? echo number_format($largura_obra,2,',','.'); ?>" size="4">
                                  cm 
                        </td>
                       </tr>
                        <tr class="texto_bold">
                          <td colspan="2" valign="top"></td>
                            <td colspan="3">diâmetro:
                              <input name="diametro_obra" type="text" class="combo_cadastro" id="diametro_obra" onChange="return testavalor(this);" value="<? echo number_format($diametro_obra,2,',','.'); ?>" size="4">
                              cm &nbsp;&nbsp;&nbsp;&nbsp;profundidade:
                              <input name="profundidade_obra" type="text" class="combo_cadastro" id="profundidade_obra" onChange="return testavalor(this);" value="<? echo number_format($profundidade_obra,2,',','.'); ?>" size="4">
                             cm 
                          </td>
                           </tr>
                           <tr class="texto_bold">
                          <td colspan="2" valign="top"></td>
                            <td colspan="3"> Peso:
                              <input name="peso_obra" type="text" class="combo_cadastro" id="peso_obra" onChange="return testavalor(this);" value="<? echo number_format($peso_obra,2,',','.'); ?>" size="4">&nbsp;kg
                         <br>
                      </td>
                      </tr>

                        <tr class="texto_bold">  
                      <td colspan="2" valign="top"><div valign="top" align="right"><font style="color:#9B9B9B">(Dim. da base)</font></div></td>
                      <td colspan="3">
                                 altura:<input name="altura_base" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="altura_base" value="<? echo number_format($altura_base,2,',','.'); ?>" size="4">
                                 cm &nbsp;&nbsp;&nbsp;&nbsp;largura:
                               <input name="largura_base" type="text" class="combo_cadastro" id="largura_base" onChange="return testavalor(this);" value="<? echo number_format($largura_base,2,',','.'); ?>" size="4">
                                cm
                        </td>
                       </tr>
                        <tr class="texto_bold">
                          <td colspan="2" valign="top"></td>
                            <td colspan="3">diâmetro:<input name="diametro_base" type="text" class="combo_cadastro" id="diametro_base" onChange="return testavalor(this);" value="<? echo number_format($diametro_base,2,',','.'); ?>" size="4">
                             cm &nbsp;&nbsp;&nbsp;&nbsp;profundidade:
                        <input name="profundidade_base" type="text" class="combo_cadastro" id="profundidade_base" onChange="return testavalor(this);" value="<? echo number_format($profundidade_base,2,',','.'); ?>" size="4">
                        cm
                        </td>
                           </tr>
                           <tr class="texto_bold">
                          <td colspan="2" valign="top"></td>
                            <td colspan="3"> Peso:
                              <input name="peso_base" type="text" class="combo_cadastro" id="peso_base" onChange="return testavalor(this);" value="<? echo number_format($peso_base,2,',','.'); ?>" size="4">&nbsp;kg
                     </td>
                    </tr>
    

                   <tr class="texto_bold">
                      <td colspan="2"><div align="right">Detalhe de material/técnica:<br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                      </div></td>
                      <td colspan="3"><textarea name="tecnica_detalhe" cols="65" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="tecnica_detalhe"><? echo $tecnica_detalhe ?></textarea></td>
                    </tr>



                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Assinatura:</div></td>
                      <td colspan="3"><input name="assinatura" type="text" class="combo_cadastro" id="assinatura" value="<? echo htmlentities($assinatura, ENT_QUOTES); ?>" size="60"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Obs:<br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                      </div></td>
                      <td colspan="3"><textarea name="obs" cols="65" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="obs"><? echo $obs ?></textarea></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Data de Entrada:</div></td>
                      <td colspan="3" nowrap><input name="data_entrada" type="text" class="combo_cadastro"  id="data_entrada" value="<? echo $data_entrada ?>" size="10">
&nbsp; In&iacute;cio:&nbsp;
<input name="data_inicio"   type="text" class="combo_cadastro" id="data_inicio" value="<? echo $data_inicio ?>" size="10">
&nbsp;Sa&iacute;da:
<input name="data_saida" type="text" class="combo_cadastro" id="data_saida"  value="<? echo $data_saida ?>" size="10"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Restaurador:</div></td>
                      <td colspan="3"><input name="tecnico" type="text" class="combo_cadastro" id="tecnico" value="<? echo htmlentities($tecnico, ENT_QUOTES); ?>" size="70">
						<a href="javascript:;" onClick="abrepop('pop_tecnico.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a></td>
                    </tr>
                </table></div>



         <!-- ABA 2 : OBRA -->
 
  		    <!-- ABA OBRA ESTADO DE CONERVACAO : --> 
        
		    <div id="quadro2" class="divi1" style="display:; width:540px; height:150px ">
                    <table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="#f2f2f2">
                    <tr>
                      <td width="300" colspan="3" class="texto_bold">Estado de conservação: 
                      
                        <select name="termos1" id='termos1' class="combo_cadastro" onChange="Add('estado_cons_obra',this.form.termos1.options[this.form.termos1.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_estado order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){ ?>
                                               <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                                           <? } ?>
                        </select>
                       </td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">
                        <textarea name="estado_cons_obra" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="estado_cons_obra"><? echo $estado_cons_obra ?></textarea></td>
                    </tr>

 		    <!-- ABA OBRA TRATAMENTO : --> 
                    <tr>
                      <td width="300" colspan="3" class="texto_bold">Tratamento: 
                      
                        <select name="termos2" id='termos2' class="combo_cadastro" 
                                  onChange="Add('tratamento_obra',this.form.termos2.options[this.form.termos2.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_tratamento order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){ ?>
                                               <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                                           <? } ?>
                        </select>
                       </td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">

                        <textarea name="tratamento_obra" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="tratamento_obra"><? echo $tratamento_obra ?></textarea></td>
                    </tr>
                  </table>
  		      </div>  






                 <!-- ABA 2 : BASE -->



		      <!-- ABA ESTADO DE CONERVACAO : -->         
		    <div id="quadro3" class="divi1" style="display:; width:540px; height:150px ">
                    <table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="#f2f2f2">
                    <tr>
                      <td width="300" colspan="3" class="texto_bold">Estado de conservação: 
                        <select name="termos3" id='termos3' class="combo_cadastro" onChange="Add('estado_cons_base',this.form.termos3.options[this.form.termos3.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_estado order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>



                      <td colspan="3" class="texto_bold">
                        <textarea name="estado_cons_base" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="estado_cons_base"><? echo $estado_cons_base ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="300" colspan="3" class="texto_bold">Tratamento:       
                        <select name="termos4" id='termos4' class="combo_cadastro" onChange="Add('tratamento_base',this.form.termos4.options[this.form.termos4.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_tratamento order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">
                        <textarea name="tratamento_base" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="tratamento_base"><? echo $tratamento_base ?></textarea></td>
                    </tr>
                </table>
  		      </div>  


                 <!-- ABA 4 : ESTRUTURA -->
		      <!-- ABA ESTADO DE CONERVACAO : -->         
		 <div id="quadro4" class="divi1" style="display:; width:540px; height:150px ">
                   <table  width="95%"  height="50%"  border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td width="100%" colspan="3" class="texto_bold">Estado de conservação: 
                        <select name="termos5" id='termos5' class="combo_cadastro" onChange="Add('estado_cons_estrutura',this.form.termos5.options[this.form.termos5.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_estado order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">
                        <textarea name="estado_cons_estrutura" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="estado_cons_estrutura"><? echo $estado_cons_estrutura ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="100%" colspan="3" class="texto_bold">Tratamento:       
                        <select name="termos6" id='termos6' class="combo_cadastro" onChange="Add('tratamento_estrutura',this.form.termos6.options[this.form.termos6.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_tratamento order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">
                        <textarea name="tratamento_estrutura" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="tratamento_estrutura"><? echo $tratamento_estrutura ?></textarea></td>
                    </tr>
                </table>
  		</div>  

                <!-- ABA 5 : PÁTINA -->


		      <!-- ABA ESTADO DE CONERVACAO : -->         
		  <div id="quadro5" class="divi1" style="display:; width:540px ">
                    <table  width="95%"  height="50%"  border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td width="100%" colspan="3" class="texto_bold">Estado de conservação: 
                        <select name="termos7" id='termos7' class="combo_cadastro" onChange="Add('estado_cons_patina',this.form.termos7.options[this.form.termos7.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_estado order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">
                        <textarea name="estado_cons_patina" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="estado_cons_patina"><? echo $estado_cons_patina?></textarea></td>
                    </tr>

                    <tr>
                      <td width="100%" colspan="3" class="texto_bold">Tratamento:       
                        <select name="termos8" id='termos8' class="combo_cadastro" onChange="Add('tratamento_patina',this.form.termos8.options[this.form.termos8.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_obra_tratamento order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">
                        <textarea name="tratamento_patina" cols="100" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="tratamento_patina"><? echo $tratamento_patina ?></textarea></td>
                    </tr>


                </table>
  	        </div>  
                              
		<!-- ABA 6 IMAGEM : -->
		<div id="quadro6" class="divi1" style="display:; width:540px; ">
		    <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                   
                   <tr>
                     <? if($_REQUEST['id']<>'')
                        { 
			   echo "<iframe name='abas' align='middle' src='restauro_imagem.php?id=$_REQUEST[id]&op=$_REQUEST[op]' width='520' height='380' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
			 } else { ?>
                            <tr>
                               <td align="center" class="texto_bold" style="color:#333333;">&Eacute; necess&aacute;rio
                                   salvar para incluir uma fotografia. 
                               </td>
                           </tr>
                      <? } ?>
                      </tr>
                     </table>
		   </div>
	      </td>
          </tr>
        </table>
          <table width="540" id="rodape" border="0" style="background-color: #f2f2f2;">
            <tr>
              <td width="149">&nbsp;</td>
              <td width="149">&nbsp;</td>
              <td width="134"><input align='middle' name="submit" type="submit" style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?> " class="botao" value="Gravar">
                <input name="op" type="hidden" value="<? echo $op ?>">
                <br>
                <br></td>
              <td width="168">&nbsp;<br><br></td>
            </tr>
          </table>
  </table>
</form>
</body>
<? 
//sequencial de entrada = incremento de quantas vezes aquela obra foi/nao restauro
//IR incremento
//tipo=papel=1/pintura=2
//tipo2=interna=I/externa=E
if($_REQUEST['submit']<>'')
{
 if($_REQUEST['id']<>'')
  {
 $seq= insere_atualiza_seq();
  if ($seq == -1) {
	// não faz nada
	echo "<script>alert('Restauração fora de ordem')</script>";
  }
  else{
   if($_REQUEST['data_entrada']==''){ $_REQUEST['data_entrada']='00/00/0000'; }   
   if($_REQUEST['data_inicio']==''){ $_REQUEST['data_inicio']='00/00/0000'; }
   if($_REQUEST['data_saida']==''){ $_REQUEST['data_saida']='00/00/0000'; }
   if($_REQUEST[altura_obra]==''){ $_REQUEST[altura_obra]='0.00';}
   if($_REQUEST[largura_obra]==''){ $_REQUEST[largura_obra]='0.00';}

	$tecnico= $_REQUEST['tecnico'];


  $sql="UPDATE restauro set
             ir='$_REQUEST[ir]', 
   seq_restauro='$seq',
       controle='$_REQUEST[controle]',
          autor='$_REQUEST[autor]',
         titulo='$_REQUEST[titulo]',
          tombo='$_REQUEST[tombo]',
   altura='".formata_valor(trim($_REQUEST[altura_obra]))."',
   largura='".formata_valor(trim($_REQUEST[largura_obra]))."',
   peso='".formata_valor(trim($_REQUEST[peso_obra]))."',
   diametro='".formata_valor(trim($_REQUEST[diametro_obra]))."',
   altura_base='".formata_valor(trim($_REQUEST[altura_base]))."',
   largura_base='".formata_valor(trim($_REQUEST[largura_base]))."',
   peso_base='".formata_valor(trim($_REQUEST[peso_base]))."',
   diametro_base='".formata_valor(trim($_REQUEST[diametro_base]))."',

   profundidade='".formata_valor(trim($_REQUEST[profundidade_obra]))."',
   profundidade_base='".formata_valor(trim($_REQUEST[profundidade_base]))."',

        tecnica='$_REQUEST[tecnica]',
        tecnico='$tecnico',
             obs='$_REQUEST[obs]',
   tecnica_detalhe='$_REQUEST[tecnica_detalhe]',
   colecao='$_REQUEST[colecao]',
   nome_objeto='$_REQUEST[nome_objeto]',
   data_entrada='".explode_data($_REQUEST[data_entrada])."',
    data_inicio='".explode_data($_REQUEST[data_inicio])."',
     data_saida='".explode_data($_REQUEST[data_saida])."'
 where restauro='$_REQUEST[id]'";


 $db->query($sql);

   $sql2="UPDATE restauro_obra set
  assinatura='".$_REQUEST[assinatura]."',
  estado_cons_obra='".$_REQUEST[estado_cons_obra]."',
  tratamento_obra='".$_REQUEST[tratamento_obra]."',
  estado_cons_base='".$_REQUEST[estado_cons_base]."',
  tratamento_base='".$_REQUEST[tratamento_base]."',
  estado_cons_estrutura='".$_REQUEST[estado_cons_estrutura]."',
  tratamento_estrutura='".$_REQUEST[tratamento_estrutura]."',
  estado_cons_patina='".$_REQUEST[estado_cons_patina]."',
  tratamento_patina='".$_REQUEST[tratamento_patina]."'
                 where restauro='$_REQUEST[id]'";
 $db->query($sql2);
 echo "<script>location.href='restauracao_obra_externa?id=$_REQUEST[id]'</script>";
 exit();
  }  
 }   
 else // se for um insert.....
 {
 $seq=insere_atualiza_seq();
 if ($seq == -1) {
	// não faz nada
	echo "<script>alert('Restauração fora de ordem')</script>";
}
else
{ 
   if($_REQUEST['data_entrada']=='')
   { $_REQUEST['data_entrada']='00/00/0000'; }
   
   if($_REQUEST['data_inicio']=='')
   { $_REQUEST['data_inicio']='00/00/0000'; }
   
  if($_REQUEST['data_saida']=='')
   { $_REQUEST['data_saida']='00/00/0000'; }  

 if($_REQUEST[altura_obra]=='')
  { $_REQUEST[altura_obra]='0.00';}
 if($_REQUEST[largura_obra]=='')
  { $_REQUEST[largura_obra]='0.00';}

	$tecnico= $_REQUEST['tecnico'];
   

   $sql="INSERT INTO restauro(seq_restauro,ir,obra,interna,parte,controle,nome_objeto,tipo,autor,titulo,tombo,
                                                altura,largura,tecnica,
                                                colecao,obs,data_entrada,data_inicio,data_saida,tecnico,propriedade,tecnica_detalhe,
                                                  profundidade,peso,diametro, altura_base,largura_base,profundidade_base,peso_base,diametro_base)


                     values('$seq','$_REQUEST[ir]','0','E','0',
                           '$_REQUEST[controle]','$_REQUEST[nome_objeto]','3','$_REQUEST[autor]',
                           '$_REQUEST[titulo]','$_REQUEST[tombo]',
                            '".formata_valor(trim($_REQUEST[altura_obra]))."','".formata_valor(trim($_REQUEST[largura_obra]))."',
                           '$_REQUEST[tecnica]','$_REQUEST[colecao]','$_REQUEST[obs]',
                           '".explode_data($_REQUEST[data_entrada])."','".explode_data($_REQUEST[data_inicio])."','".explode_data($_REQUEST[data_saida])."',
                           '$tecnico','N','$_REQUEST[tecnica_detalhe]',
                                                                      '".formata_valor_3(trim($_REQUEST[profundidade_obra]))."', '".formata_valor_3(trim($_REQUEST[peso_obra]))."',
                                                                       '".formata_valor_3(trim($_REQUEST[diametro_obra]))."','".formata_valor_3(trim($_REQUEST[altura_base]))."',
                                                                           '".formata_valor_3(trim($_REQUEST[largura_base]))."','".formata_valor_3(trim($_REQUEST[profundidade_base]))."',
                                                                                  '".formata_valor_3(trim($_REQUEST[peso_base]))."','".formata_valor_3(trim($_REQUEST[diametro_base]))."')";
  
  
  
  
  $db->query($sql);
  $idrest=$db->lastid();

 $sql3="INSERT INTO restauro_obra(restauro,assinatura,estado_cons_obra,tratamento_obra,estado_cons_base,tratamento_base,estado_cons_estrutura,tratamento_estrutura,estado_cons_patina,tratamento_patina)
 values('$idrest','$_REQUEST[assinatura]','$_REQUEST[estado_cons_obra]','$_REQUEST[tratamento_obra]','$_REQUEST[estado_cons_base]','$_REQUEST[tratamento_base]','$_REQUEST[estado_cons_estrutura]','$_REQUEST[tratamento_estrutura]','$_REQUEST[estado_cons_patina]','$_REQUEST[tratamento_patina]')";
 $db->query($sql3);
 echo "<script>location.href='restauracao_obra_externa?id=$idrest'</script>";
   }
 }
}
?>