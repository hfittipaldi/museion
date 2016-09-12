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
	numAbas=5;

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
 if(index==5){ 
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
      if (elemento.name == "ir"){
          if(IsEmpty(elemento)) 
		  {
             campo = elemento;
             mensagem = "Informe o IR \n\n" + mensagem;
            }
          }

	 //Data_Inicio
        if (elemento.name == "data_inicio"){
          if(!IsEmpty(elemento)) 
		  {
			 if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data de Início inválida (dd/mm/aaaa) \n\n" + mensagem;
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
             mensagem = "Data de Entrada inválida (dd/mm/aaaa) \n\n" + mensagem;
          } }
		  else {
             campo = elemento;
             mensagem = "Data de Entrada não pode ser vazia (dd/mm/aaaa) \n\n" + mensagem;
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
$tombo=$_REQUEST[tombo];
$documento=$_REQUEST[documento];
$autor=$_REQUEST[autor];
$interna=$_REQUEST[interna];
$ir=$_REQUEST[ir];
$titulo=$_REQUEST[titulo];
$nome_objeto=$_REQUEST[nome_objeto];
$controle=$_REQUEST[controle];
$seq_restauro=$_REQUEST[seq_restauro];
$colecao=$_REQUEST[colecao];
$tecnica=$_REQUEST[tecnica];
$altura_obra=$_REQUEST[altura_obra];
$largura_obra=$_REQUEST[largura_obra];
$assinatura=$_REQUEST[assinatura];
$obs=$_REQUEST[obs];
$data_entrada=$_REQUEST[data_entrada];
$data_saida=$_REQUEST[data_saida];
$tecnico=$_REQUEST[tecnico];
$termo=$_REQUEST[termo];
$exames=$_REQUEST[exames];
$camada=$_REQUEST[camada];
$estado_chassis=$_REQUEST[estado_chassis];
$chassis=$_REQUEST[chassis];
$estado_camada_pic=$_REQUEST[estado_camada_pic];
$moldura=$_REQUEST[moldura];
$obs_moldura=$_REQUEST[obs_moldura];
$tipo_fundo=$_REQUEST[tipo_fundo];
$estado_fundo=$_REQUEST[estado_fundo];
$estado_suporte=$_REQUEST[estado_suporte];
$tratamento=$_REQUEST[tratamento];

//
set_time_limit(0);

function insere_atualiza_seq() {
   $seq=$_REQUEST['seq_restauro']; //sequencial passado no formulario.
   global $db;
   if ($seq == '') $seq= 0;

   $sql2="SELECT seq_restauro, data_entrada from restauro where tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and seq_restauro=$seq and restauro <> '$_REQUEST[id]' and tipo=2 and interna='E'";
   $db->query($sql2);
   $res=$db->dados();

   if($res<> '')
   {echo "<script>alert('A obra com Nº de Registro: $_REQUEST[tombo] - controle: $_REQUEST[controle] - Restauração: $_REQUEST[seq_restauro] já se encontra cadastrada!')</script>";
    $seq=-1;}

   $where_atualiza='';
   if($_REQUEST[id]!='')
   {$where_atualiza=" and restauro <> '$_REQUEST[id]'";}	  
   $sql3="select seq_restauro, data_inicio, data_entrada from restauro where tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and tipo=2 and interna='E' $where_atualiza order by seq_restauro asc";
   $db->query($sql3);
   while($res=$db->dados()) 
   {
      if ($res['data_inicio']<>'0000-00-00 00:00:00') 
      {
         $vet[$res['seq_restauro']]=$res['data_inicio'];
      }else{
         $vet[$res['seq_restauro']]=$res['data_entrada'];
      }
   }
 
   $vet[$_REQUEST['seq_restauro']] =explode_data($_REQUEST['data_entrada']);
   ksort($vet);
   reset($vet);
   $dt_ant ='0000-00-00';
   $tot=count($vet); 
   foreach($vet as $dt)
        {
          // echo $dt."<br>";
	   if($dt<$dt_ant && $dt<>'')    { 
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
	$sql="DELETE from pintura where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	$sql="DELETE from restauro_fotografia where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	echo "<script>alert('Exclusão realizada com sucesso');</script>";
	echo "<script>location.href='alteracao_restauro.php'</script>";
}
else {
$sql="select * from restauro as a,pintura as b where (a.restauro=b.restauro) and a.restauro=$_REQUEST[id]";
 $db->query($sql);
 $res=$db->dados();
 $seq_restauro=$res['seq_restauro'];
 $_REQUEST[ir]=$res['ir'];
 //restauro
 $obra=$res['obra'];$interna=$res['interna'];$controle=$res['controle'];$nome_objeto=$res['nome_objeto'];$autor=$res['autor'];$titulo=$res['titulo'];$tombo=$res['tombo'];
 $altura_obra=$res['altura'];$largura_obra=$res['largura'];$tecnica=$res['tecnica'];$colecao=$res['colecao'];$obs=$res['obs'];
 $data_entrada=formata_data($res['data_entrada']);$data_inicio=formata_data($res['data_inicio']);$data_saida=formata_data($res['data_saida']);
 $tecnico=$res['tecnico'];$documento=$res['documento'];
 //pintura
 $assinatura=$res['assinatura'];$exames=$res['exames'];$camada_prot=$res['camada_prot'];$estado_camada=$res['estado_camada'];
 $camada_pic=$res['camada_pic'];$carac_camada_pic=$res['carac_camada_pic'];$estado_camada_pic=$res['estado_camada_pic'];
 $suporte=$res['suporte'];$estado_suporte=$res['estado_suporte'];$fundo=$res['fundo'];$tipo_fundo=$res['tipo_fundo'];
 $estado_fundo=$res['estado_fundo'];$chassis=$res['chassis'];$estado_chassis=$res['estado_chassis'];$moldura=$res['moldura'];
 $obs_moldura=$res['obs_moldura'];$tratamento=$res['tratamento'];$estado_camada=$res['estado_camada'];

   if($data_entrada == '00/00/0000')
	$data_entrada= '';
   
   if($data_inicio == '00/00/0000')
	$data_inicio= '';
   
   if($data_saida == '00/00/0000')
	$data_saida= '';
}
}
?>
  </tr>
<form name="form" method="post" onSubmit='return valida();' enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="166" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Restauro (pintura)</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Exames</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Camadas</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Tratamento</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>Imagens</span></a></div></td>
	  <td width="60" align="center" style="border-bottom: 1px solid #34689A;">&nbsp;<?  { echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"; } ?></td>
     </td>
    </tr>
      <td colspan="6" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="315" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
              <div id="quadro1" class="divi1" style="display: ; width:540px; ">
			          <table width="97%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;Tipo:</font></div></td>
                      <td width="16%" class="texto_bold"> <input name="interna" type="text"  class="combo_cadastro"  readonly="1" value="<? echo "Não Acervo"; ?>" id="interna" size="12"></td>
                      <td width="25%" class="texto_bold"><input name="documento" type="checkbox" class="combo_cadastro" id="documento" value="S" <? if($documento=='S') echo "checked"?>>
Documento</td>
                      <td width="41%" class="texto_bold">IR:
                      <input name="ir" type="text" class="combo_cadastro"  id="ir" value="<? echo $_REQUEST[ir]?>" size="5"></td>
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
                    <td colspan="2"><div align="right">Parte:</div></td>
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
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Parte:</div></td>
                      <td colspan="3">altura:
                        <input name="altura_obra" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="altura_obra" value="<? echo number_format($altura_obra,2,',','.'); ?>" size="4">
cm &nbsp;&nbsp;&nbsp;&nbsp;largura:
<input name="largura_obra" type="text" class="combo_cadastro" id="largura_obra" onChange="return testavalor(this);" value="<? echo number_format($largura_obra,2,',','.'); ?>" size="4">
cm</td>
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
				 <div id="quadro2" class="divi1" style="display:; width:540px; height:300px ">           	
                      <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                        <tr>

                      <td width="300" colspan="3" class="texto_bold">Termos: 
                        <select name="termos1" id='termo' class="combo_cadastro" onChange="Add('exames',this.form.termos1.options[this.form.termos1.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_pintura_exames order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select>
                              <p>Exames:<br>
                                  <textarea name="exames" cols="80" rows="13" wrap="VIRTUAL" class="combo_cadastro" id="exames"><? echo $exames  ?></textarea>
                                  <br>              
                              </p>
                           </td>
                        </tr>
                      </table>
              </div>
                <!-- ABA 2 -->
              <div id="quadro3" class="divi1" style="display:; width:540px; height:300px">
                    <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="3" class="texto_bold"><div>Selecione a camada :
                          <select name="camadas" class="combo_cadastro" id="camadas"  
					  onChange="troca_camadas(this.form.camadas.options[this.form.camadas.selectedIndex].value)">
                            <option value='#'></option>
			    <option value="C">Chassis</option>
                            <option value="S">Suporte</option>
                            <option value="F">Fundo de prepara&ccedil;&atilde;o</option>
                            <option value="M">Moldura</option>
                            <option value="PI">Pict&oacute;rica</option>
                            <option value="P">Prote&ccedil;&atilde;o</option>
                              </select></div></td>
                    </tr>

                      <?//////////// CHASSI ///////////////?>
                    <tr>
                      <td colspan="3" class="texto_bold">
                          <div id="camada_chassis">
                             Caracter&iacute;sticas:<br>
                             <textarea name="chassis" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="chassis">
                              <? echo $chassis ?></textarea>
                             <br>
                             <br>
                              Estado de conservação:<br>
                             <textarea name="estado_chassis" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="estado_chassis">
                             <? echo $estado_chassis ?></textarea>
                          </div>
                      </td>
                    </tr>
                    <?//////////// CAMADA PICTÓRICA ///////////////?>
                    <tr>
                      <td colspan="3" class="texto_bold">
                         <div id="camada_pict">
                            Caracter&iacute;sticas:<br>
                            <textarea name="carac_camada_pic" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="carac_camada_pic">
                            <? if ( $camada_pic <> "" ) {echo $camada_pic.":   ".$carac_camada_pic; $camada_pic="";}else {echo $carac_camada_pic;}?></textarea>
                            <br>
                            <br>
                            Estado de conservação:<br>
                            <textarea name="estado_camada_pic" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="estado_camada_pic">
                            <? echo $estado_camada_pic ?></textarea>
                          </div>
                      </td>
                    </tr>

                    <?//////////// CAMADA MOLDURA ///////////////?>
                    <tr>
                      <td colspan="3" class="texto_bold">
                         <div id="camada_moldura">
                             Caracter&iacute;sticas:<br>
                            <textarea name="moldura" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="moldura">
                            <? echo $moldura; ?></textarea>
                            <br>
                            <br>
                            Estado de conservação: <br>
                            <textarea name="obs_moldura" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="obs_moldura">
                            <? echo $obs_moldura ?></textarea>
                          </div>
                       </td>
                    </tr>


                    <?//////////// CAMADA FUNDO DE PREPARAÇÃO ///////////////?>

                    <tr>
                      <td colspan="3" class="texto_bold">
                         <div id='camada_fundo'>
                            Caracter&iacute;sticas:<br>
                            <textarea name="fundo" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="fundo">
                            <? if ($tipo_fundo <> "") {echo $tipo_fundo.":   ".$fundo; $tipo_fundo="";} else {echo $fundo;}?></textarea>
                          
                            Estado de conservação: <br>
                            <textarea name="estado_fundo" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="estado_fundo">
                            <? echo $estado_fundo; ?></textarea>
                          </div>
                       </td>
                    </tr>


                    <tr>
                       <td colspan="3" class="texto_bold">
                        <div id='camada_pro'>
                             Caracter&iacute;sticas:
                             <textarea name="camada_prot" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="camada_prot">
                             <? echo $camada_prot;?></textarea> Estado de conservação:<br>
		<textarea name="estado_camada" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="estado_camada">
                             <? echo $estado_camada; ?></textarea>
                      </div>
	      </td>
                    </tr>

                  <?//////////// PARTE ///////////////?>

                    <tr>
                      <td colspan="3" class="texto_bold">
	            <div id='camada_sup'>
		Caracter&iacute;sticas:<br>
                            <textarea name="suporte" cols="100" align="left" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="suporte">
                            <? echo $suporte ?></textarea>
                             <br>
                             <br>
		  Estado de conservação:
 		  <textarea name="estado_suporte" cols="100" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="estado_suporte">
                               <? echo $estado_suporte ?></textarea>
                           </div>
                        </td>
                    </tr>

                </table>
              </div>  		      <!-- ABA 4 : -->         
			        <div id="quadro4" class="divi1" style="display:; width:540px; height:300px ">
                    <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td width="300" colspan="3" class="texto_bold">Termos para Tratamento: 
                        <select name="termos" id='termos' class="combo_cadastro" onChange="Add('tratamento',this.form.termos.options[this.form.termos.selectedIndex].value);">
                          <option value='' selected></option>
                          <? $sql="select distinct(termo) from termo_pintura_tratamento order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">Tratamento:<br>
                        <textarea name="tratamento" cols="80" rows="13" wrap="VIRTUAL" class="combo_cadastro" id="tratamento"><? echo $tratamento ?></textarea></td>
                    </tr>
                </table>
  		      </div>                 
			 <!-- ABA 5 : -->
		     <div id="quadro5" class="divi1" style="display:; width:540px; ">
				 <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                   <tr> </tr>
                   <tr>
                     <? if($_REQUEST['id']<>''){ 
					echo "<iframe name='abas' align='middle' src='restauro_imagem.php?id=$_REQUEST[id]&op=$_REQUEST[op]' width='520' height='380' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} else { ?>
                   <tr>
                     <td align="center" class="texto_bold" style="color:#333333;">&Eacute; necess&aacute;rio
                       salvar para incluir uma fotografia. </td>
                   </tr>
                   <? } ?>
                 </table>
		      </div>
			</td>
          </tr>
        </table>
          <table width="540" id="rodape" border="0" style="background-color: #f2f2f2;">
            <tr>
              <td width="83">&nbsp;</td>
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

   $sql="UPDATE restauro set
   ir='$_REQUEST[ir]',
   seq_restauro='$seq',
   controle='$_REQUEST[controle]',
   autor='$_REQUEST[autor]',
   titulo='$_REQUEST[titulo]',
   tombo='$_REQUEST[tombo]',
   altura='".formata_valor(trim($_REQUEST[altura_obra]))."',
   largura='".formata_valor(trim($_REQUEST[largura_obra]))."',
   tecnica='$_REQUEST[tecnica]',
   tecnico='$tecnico',
   colecao='$_REQUEST[colecao]',
   obs='$_REQUEST[obs]',
   data_entrada='".explode_data($_REQUEST[data_entrada])."',
   data_inicio='".explode_data($_REQUEST[data_inicio])."',
   data_saida='".explode_data($_REQUEST[data_saida])."'
   where restauro='$_REQUEST[id]'";

 $db->query($sql);
//
  $sql2="UPDATE pintura set
  assinatura='$_REQUEST[assinatura]',
  exames='$_REQUEST[exames]',
  camada_prot='$_REQUEST[camada_prot]',
  documento='$_REQUEST[documento]',
  estado_camada='$_REQUEST[estado_camada]',
  camada_pic='$camada_pic',
  carac_camada_pic='$_REQUEST[carac_camada_pic]',
  estado_camada_pic='$_REQUEST[estado_camada_pic]',
  suporte='$_REQUEST[suporte]',
  estado_suporte='$_REQUEST[estado_suporte]',
  fundo='$_REQUEST[fundo]',
  tipo_fundo='$_REQUEST[tipo_fundo]',
  estado_fundo='$_REQUEST[estado_fundo]',
  chassis='$_REQUEST[chassis]',
  tipo_fundo='$tipo_fundo',
  estado_chassis='$_REQUEST[estado_chassis]',
  moldura='$_REQUEST[moldura]',
  obs_moldura='$_REQUEST[obs_moldura]',
  tratamento='$_REQUEST[tratamento]'
                 where restauro='$_REQUEST[id]'";
 
 $db->query($sql2);
 echo "<script>location.href='restauracao_pintura_externa?id=$_REQUEST[id]'</script>";
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
  $sql="INSERT INTO restauro(seq_restauro,ir,obra,interna,parte,controle,tipo,autor,titulo,tombo,altura,largura,tecnica,colecao,obs,
  data_entrada,data_inicio,data_saida,tecnico,propriedade)
  values('$seq','$_REQUEST[ir]','0','E','0','$_REQUEST[controle]','2','$_REQUEST[autor]','$_REQUEST[titulo]','$_REQUEST[tombo]',
 '".formata_valor(trim($_REQUEST[altura_obra]))."','".formata_valor(trim($_REQUEST[largura_obra]))."','$_REQUEST[tecnica]','$_REQUEST[colecao]','$_REQUEST[obs]',
  '".explode_data($_REQUEST[data_entrada])."','".explode_data($_REQUEST[data_inicio])."','".explode_data($_REQUEST[data_saida])."','$tecnico','N')";
 
  $db->query($sql);
  $idrest=$db->lastid();
 

 $sql3="INSERT INTO pintura(restauro,documento,assinatura,exames,camada_prot,estado_camada,camada_pic,carac_camada_pic,estado_camada_pic,suporte,
 estado_suporte,fundo,tipo_fundo,estado_fundo,chassis,estado_chassis,moldura,obs_moldura,tratamento)
 values('$idrest','$_REQUEST[documento]','$_REQUEST[assinatura]','$_REQUEST[exames]','$_REQUEST[camada_prot]','$_REQUEST[estado_camada]','$_REQUEST[camada_pic]',
 '$_REQUEST[carac_camada_pic]','$_REQUEST[estado_camada_pic]','$_REQUEST[suporte]','$_REQUEST[estado_suporte]','$_REQUEST[fundo]',
 '$_REQUEST[tipo_fundo]','$_REQUEST[estado_fundo]','$_REQUEST[chassis]','$_REQUEST[estado_chassis]','$_REQUEST[moldura]',
 '$_REQUEST[obs_moldura]','$_REQUEST[tratamento]')";
 $db->query($sql3);
 echo "<script>location.href='restauracao_pintura_externa?id=$idrest'</script>";
   }
 }
}
?>