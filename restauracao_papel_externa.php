<?  include_once("seguranca.php");?>
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
	numAbas= 4;

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
 
 if(index==4){ 
     document.form.submit.style.display='none';
     document.getElementById('rodape').style.display="none";
	}
  else {
    document.getElementById('rodape').style.display="";
	document.form.submit.style.display="";
  }
}
//var monta=new Array();
function Add(i,parametro){
   if(parametro!=''){
  var item="\n- "+parametro+": ";
  document.getElementById(i).value+=item;
  }}
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
        if (elemento.name == "ir"){
          if(IsEmpty(elemento)) 
		  {
             campo = elemento;
             mensagem = "Informe o IR \n\n" + mensagem;
             alert(mensagem);
            return false;	
             
          }
         continue;
        }
       // continue;
     }	  //fecha loop do for
    
	 if (mensagem != ""){
        alert(mensagem);
        campo.focus();
        return false;
    } else {
	 
	return true;
   }
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
<body onLoad='ajustaAbas(<? echo $aba ?>); '>
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

 $seq_restauro=$_REQUEST[seq_restauro];
 $ir=$_REQUEST[ir];
 $restauro=$_REQUEST[restauro];
 $nome_objeto=$_REQUEST[nome_objeto];
 $obra=$_REQUEST[obra];
 $interna=$_REQUEST[interna];
 $controle=$_REQUEST[controle];
 $autor=$_REQUEST[autor];
 $titulo=$_REQUEST[titulo];
 $tombo=$_REQUEST[tombo];
 $altura_obra=$_REQUEST[altura_obra];
 $largura_obra=$_REQUEST[largura_obra];
 $tecnica=$_REQUEST[tecnica];
 $colecao=$_REQUEST[colecao];
 $obs=$_REQUEST[obs]; 
 $data_entrada=$_REQUEST[data_entrada];
 $data_inicio=$_REQUEST[data_inicio];
 $data_saida=$_REQUEST[data_saida];
 $tecnico=$_REQUEST[tecnico];
 $documento=$_REQUEST[documento];
 $altura_imagem=$_REQUEST[alt_imagem];
 $largura_imagem=$_REQUEST[larg_imagem];
 $estado=$_REQUEST[estado]; 
 $estado_saida=$_REQUEST[estado_saida];
 $suporte=$_REQUEST[suporte];
 $texto_estado=$_REQUEST[texto_estado];
 $ph_antes=$_REQUEST[ph_antes]; 
 $ph_depois=$_REQUEST[ph_depois];
 $texto_tratamento=$_REQUEST[texto_tratamento];
 $ordem=$_REQUEST[ordem];
 $descricao=$_REQUEST[descricao];
 $tecnico=$_REQUEST[tecnico];
 $propriedade=$_REQUEST[propriedade];


//
set_time_limit(0);

////////////////////////////////////
function insere_atualiza_seq() {
   $seq=$_REQUEST['seq_restauro']; //sequencial passado no formulario.
   global $db;
   if ($seq == '') $seq= 0;
   $sql2="SELECT seq_restauro, data_entrada from restauro where tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and seq_restauro=$seq and restauro <> '$_REQUEST[id]' and tipo=2 and interna='E'";
   $db->query($sql2);
   $res_pesq=$db->dados();

   if($res_pesq<> '')
   {
       echo "<script>alert('A obra com Nº de Registro: $_REQUEST[tombo] - controle: $_REQUEST[controle] - Restauração: $_REQUEST[seq_restauro] já se encontra cadastrada!')</script>";
       $seq=-1;
   }else{

   $where_atualiza='';
   if($_REQUEST[id]!='')
   {$where_atualiza=" and restauro <> '$_REQUEST[id]'";}	  
   $sql3="select seq_restauro, data_inicio, data_entrada from restauro where tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and tipo=2 and interna='E' $where_atualiza order by seq_restauro asc";
   $db->query($sql3);
   while($res_pesq=$db->dados()) 
   {
      if ($res_pesq['data_inicio']<>'0000-00-00 00:00:00') 
      {
         $vet[$res_pesq['seq_restauro']]=$res_pesq['data_inicio'];
      }else{
         $vet[$res_pesq['seq_restauro']]=$res_pesq['data_entrada'];
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
    }
    return $seq;
  }
//////////////////////////////////////
//
$tecnico= $_SESSION['snome'];

if($_REQUEST[id]<>'' || $_REQUEST['op']=='update')
{
if ($_REQUEST['op'] == 'del') {
	$sql="DELETE from restauro where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	$sql="DELETE from papel where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	$sql="DELETE from restauro_fotografia where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	echo "<script>alert('Exclusão realizada com sucesso');</script>";
	echo "<script>location.href='alteracao_restauro.php'</script>";
}
else {
$sql="select *from restauro as a,papel as b where (a.restauro=b.restauro) and a.restauro=$_REQUEST[id]";
  $db->query($sql);
 $res=$db->dados();
 $seq_restauro=$res['seq_restauro'];$ir=$res['ir']; $restauro=$res['restauro'];$nome_objeto=$res['nome_objeto'];$obra=$res['obra']; $interna=$res['interna']; $controle=$res['controle']; $autor=$res['autor'];$titulo=$res['titulo']; $tombo=$res['tombo'];$altura_obra=$res['altura'];
 $largura_obra=$res['largura'];$tecnica=$res['tecnica'];$colecao=$res['colecao'];$obs=$res['obs']; $data_entrada=formata_data($res['data_entrada']);$data_inicio=formata_data($res['data_inicio']);$data_saida=formata_data($res['data_saida']);$tecnico=$res['tecnico'];
 $documento=$res['documento'];$altura_imagem=$res['alt_grav'];$largura_imagem=$res['larg_grav'];$estado=$res['estado']; $estado_saida=$res['estado_saida'];$suporte=$res['suporte'];$texto_estado=$res['texto_estado'];$ph_antes=$res['ph_antes']; $ph_depois=$res['ph_depois'];$texto_tratamento=$res['tratamento'];$ordem=$res['ordem'];$descricao=$res['descricao'];$tecnico=$res['tecnico'];$propriedade=$res['propriedade'];

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
<form name="form" method="post" 	action="" onSubmit="return valida()"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="166" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Restauro (papel)</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Cont.</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Tratamento</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Fotografia</span></a></div></td>
	  <td width="60" align="center" style="border-bottom: 1px solid #34689A;">&nbsp;<? { echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"; } ?></td>
    </tr>
      <td colspan="6" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="365" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
              <div id="quadro1" class="divi1" style="display: ; width:540px; ">
			          <table width="97%" border="0" cellpadding="3" cellspacing="3"   bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;Tipo:</font></div></td>
                      <td width="14%" class="texto_bold"> <input name="interna" type="text"  class="combo_cadastro"  readonly="1" value="<? echo "Não Acervo";  ?>" id="interna" size="12"></td>
                      <td width="49%" class="texto_bold"><input name="documento" type="checkbox" class="combo_cadastro" id="documento" value="S" <? if($documento=='S') echo "checked"?>>
Documento &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IR:
                      <input name="ir" type="text" class="combo_cadastro"  id="ir" value="<? echo $ir ?>" size="5"></td>
                      <td width="20%" class="texto_bold"><input name="propriedade" type="checkbox" class="combo_cadastro" id="propriedade" value="S" <? if($propriedade=='S') echo "checked"?>>
Do Museu</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Autor:</div></td>
	                      <td colspan="3"><input name="autor" type="text" class="combo_cadastro" id="autor" size="75" value="<? echo htmlentities($autor, ENT_QUOTES); ?>">
</td>
                    </tr>
                    <tr class="texto_bold">
                    <td colspan="2"><div align="right">T&iacute;tulo:</div></td>
					<td colspan="3"><input name="titulo" type="text"  class="combo_cadastro" id="titulo" size="75" value="<? echo htmlentities($titulo, ENT_QUOTES); ?>">
 </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">N&ordm; registro:</div></td>
                      <td colspan="3"><input name="tombo" type="text" class="combo_cadastro"  id="tombo"  size="12" value="<? echo htmlentities($tombo, ENT_QUOTES); ?>">
&nbsp;                       Controle:                        
                      

                       <input name="controle"  class="combo_cadastro" id="controle"  size="5" type="text" value="<? echo htmlentities($controle, ENT_QUOTES); ?>"> 
                       &nbsp; Restaura&ccedil;&atilde;o:
                       <input name="seq_restauro" type="text" class="combo_cadastro"  id="seq_restauro" value="<? echo $seq_restauro; ?>" size="2">

                       <input name="nome_objeto" type="hidden" class="combo_cadastro" id="nome_objeto" value="<? echo htmlentities($nome_objeto, ENT_QUOTES); ?>" size="5"></td>
                      </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Cole&ccedil;&atilde;o:</div></td>
                      <td colspan="3"><input name="colecao" type="text"    class="combo_cadastro" id="colecao" size="75" value="<? echo $colecao?>"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">T&eacute;cnica:</div></td>
                      <td colspan="3"><input name="tecnica" type="text" class="combo_cadastro" id="tecnica"  value="<? echo htmlentities($tecnica, ENT_QUOTES); ?>" size="60"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right"><u>Dimens&otilde;es:</u></div></td>
                      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obra: &nbsp;altura:
                        <input name="altura_obra" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="altura_obra" value="<? echo number_format($altura_obra,2,',','.'); ?>" size="4">
cm &nbsp;&nbsp;&nbsp;&nbsp;largura:
<input name="largura_obra" type="text" class="combo_cadastro" id="largura_obra" onChange="return testavalor(this);" value="<? echo number_format($largura_obra,2,',','.'); ?>" size="4">
cm</td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right"></div></td>
                      <td colspan="3">Imagem: &nbsp;altura:
                        <input name="altura_imagem" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="altura_imagem" value="<? echo number_format($altura_imagem,2,',','.'); ?>" size="4">
cm &nbsp;&nbsp;&nbsp;&nbsp;largura:
<input name="largura_imagem" type="text" class="combo_cadastro" id="largura_imagem" onChange="return testavalor(this);"  value="<? echo number_format($largura_imagem,2,',','.'); ?>" size="4">
cm</td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Observa&ccedil;&atilde;o:</div></td>
                      <td colspan="3"><textarea name="obs" cols="70" rows="3" wrap="VIRTUAL" class="combo_cadastro" id="obs"><? echo $obs ?></textarea></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right"></div></td>
                      <td colspan="3" nowrap>&nbsp;</td>
                    </tr>
                </table>
                             </div>
                <!-- ABA 2 : Biografia -->
              <div id="quadro2" class="divi1" style="display:; width:540px; ">
                    <table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Suporte:</div></td>
                      <td width="90%" class="texto_bold"><input name="suporte" type="text" class="combo_cadastro" id="suporte" value="<? echo htmlentities($suporte, ENT_QUOTES); ?>" size="55"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">pH:</div></td>
                      <td class="texto_bold">antes:
                      <input name="ph_antes" type="text" class="combo_cadastro" id="ph_antes" value="<? echo $ph_antes ?>" size="4"> 
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;depois:
                      <input name="ph_depois" type="text" class="combo_cadastro" id="ph_depois" value="<? echo $ph_depois ?>" size="4"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Estado de conserva&ccedil;&atilde;o:</div></td>
                      <td class="texto_bold">antes:
                        <select name="estado" id='estado' class="combo_cadastro">
					<option value="0"></option>
					<? $sql="select distinct(descricao),estado_conserv from estado_conserv order by estado_conserv asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
					  <option value="<? echo $res[1] ?>"<? if($estado==$res[1]) echo "Selected" ?>><? echo $res[0] ?></option>
                      <? } ?>
					  </select>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;depois:
                      <select name="estado_saida" id='estado_saida' class="combo_cadastro">
                        <option value="0"></option>
                        <? $sql="select distinct(descricao),estado_conserv from estado_conserv order by estado_conserv asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                        <option value="<? echo $res[1] ?>"<? if($estado_saida==$res[1]) echo "Selected" ?>><? echo $res[0] ?></option>
                        <? } ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Data de Entrada:</div></td>
                      <td class="texto_bold"><input name="data_entrada" type="text" class="combo_cadastro" id="data_entrada" value="<? echo $data_entrada ?>" size="10">
&nbsp; In&iacute;cio:&nbsp;
<input name="data_inicio" type="text" class="combo_cadastro" id="data_inicio" value="<? echo $data_inicio ?>" size="10">
&nbsp;Sa&iacute;da:
<input name="data_saida" type="text" class="combo_cadastro" id="data_saida"  value="<? echo $data_saida ?>" size="10"></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="70%" class="texto_bold">Termos para estado de conserva&ccedil;&atilde;o:
                        <select name="termos" id='termos' class="combo_cadastro" onChange="Add('texto_estado',this.form.termos.options[this.form.termos.selectedIndex].value);">
                          <option value=""></option>
                          <? $sql="select distinct(termo) from termo_papel_estado order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
                          <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="4" class="texto_bold"><textarea name="texto_estado" cols="90" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="texto_estado"><? echo $texto_estado ?></textarea></td>
                      </tr>
                    <tr>
                      <td colspan="3" class="texto_bold">&nbsp;</td>
                      </tr>
                </table>
              </div>                         
			  <!-- ABA 3 : -->
              <div id="quadro3" class="divi1" style="display:; width:540px; ">
                <table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#f2f2f2">
                  <tr>
                    <td colspan="2" class="texto_bold"><div>Termos
                        para Tratamento:</div></td>
                    <td width="70%" class="texto_bold">
					 <select name="termos2" id='termos2' class="combo_cadastro" onChange="Add('texto_tratamento',this.form.termos2.options[this.form.termos2.selectedIndex].value);">
					<option value="" selected></option>
					<? $sql="select distinct(termo) from termo_papel_tratamento";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
					  <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                      <? } ?>
				      </select></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="texto_bold"><p>Tratamento:<br>
                        <textarea name="texto_tratamento" cols="90" rows="13" wrap="VIRTUAL" class="combo_cadastro" id="texto_tratamento"><? echo $texto_tratamento ?></textarea>
</p>
                      <p>Restaurador:&nbsp;                        
                        <input name="tecnico" type="text" class="combo_cadastro" id="tecnico" value="<? echo htmlentities($tecnico, ENT_QUOTES); ?>" size="70">
                        <a href="javascript:;" onClick="abrepop('pop_tecnico.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a> </p>
                    </td>
                  </tr>
                </table>
              </div>
			   <!-- ABA 4 : -->
			 <div id="quadro4" class="divi1" style="display:; width:540px; height:250px ">
                			    <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2" class="texto_bold">
                    <tr>
                      </tr>
                    <tr>
					<? if($_REQUEST['id']<>''){ 
					echo "<iframe name='abas' align='middle' src='restauro_imagem.php?id=$_REQUEST[id]&op=$_REQUEST[op]' width='520' height='380' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} else { ?>
                       <tr>
    	                  <td align="center" class="texto_bold" style="color:#333333;">É necessário
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
              <td width="134"><input align='middle' name="submit" type="submit" style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?>" class="botao" value="Gravar">                
                <input name="op" type="hidden" value="<? echo $op ?>">
                  <br>
              <br></td><td width="168">&nbsp;<br><br></td>
            </tr>
          </table>
  </table>
</form>
</body>
<? $seq=-1;

if($_REQUEST['submit']<>'' and $_REQUEST['ir']<>'')
{
 if($_REQUEST['id']<>'')
  {
     $seq= insere_atualiza_seq();
     if ($seq == -1) {
	// não faz nada
	echo "<script>alert('Restauração fora de ordem')</script>";
        exit;
     }else{  
        if($_REQUEST['data_entrada']=='') { $_REQUEST['data_entrada']='00/00/0000'; }   
        if($_REQUEST['data_inicio']=='')  { $_REQUEST['data_inicio']='00/00/0000'; }  
        if($_REQUEST['data_saida']=='')   { $_REQUEST['data_saida']='00/00/0000'; }
        if($_REQUEST[altura_obra]=='')    { $_REQUEST[altura_obra]='0.00';}
        if($_REQUEST[largura_obra]=='')   { $_REQUEST[largura_obra]='0.00';}
        if($_REQUEST[altura_imagem]=='')  { $_REQUEST[altura_imagem]='0.00';}
        if($_REQUEST[largura_imagem]=='') { $_REQUEST[largura_imagem]='0.00';}

        $tecnico= $_REQUEST['tecnico'];
   
        $sql="UPDATE restauro set seq_restauro='$seq', propriedade='$_REQUEST[propriedade]',ir='$_REQUEST[ir]', nome_objeto='$_REQUEST[nome_objeto]', autor='$_REQUEST[autor]',
              titulo='$_REQUEST[titulo]', tombo='$_REQUEST[tombo]',controle='$_REQUEST[controle]',altura='".formata_valor(trim($_REQUEST[altura_obra]))."',largura='".formata_valor(trim($_REQUEST[largura_obra]))."',
              tecnica='$_REQUEST[tecnica]',tecnico='$tecnico',colecao='$_REQUEST[colecao]',obs='$_REQUEST[obs]', data_entrada='".explode_data($_REQUEST[data_entrada])."', data_inicio='".explode_data($_REQUEST[data_inicio])."', data_saida='".explode_data($_REQUEST[data_saida])."'
              where restauro='$_REQUEST[id]'";   
        $db->query($sql);
  
        $sql2="UPDATE papel set documento='$_REQUEST[documento]', alt_grav='".formata_valor(trim($_REQUEST[altura_imagem]))."',larg_grav='".formata_valor(trim($_REQUEST[largura_imagem]))."',
               estado='$_REQUEST[estado]',estado_saida='$_REQUEST[estado_saida]', suporte='$_REQUEST[suporte]', texto_estado='$_REQUEST[texto_estado]', ph_antes='$_REQUEST[ph_antes]',
               ph_depois='$_REQUEST[ph_depois]', tratamento='$_REQUEST[texto_tratamento]'
               where restauro='$_REQUEST[id]'";
        $db->query($sql2);

        echo "<script>location.href='restauracao_papel_externa?id=$_REQUEST[id]'</script>";  
        exit(); 

      } //se $seq <> -1

 }else {// $_REQUEST['id'] == ''......
     $seq=-1;
     $seq=insere_atualiza_seq();
     if ($seq == -1) {//não faz nada
	echo "<script>alert('Restauração fora de ordem')</script>";
        exit();
     }else{
       if($_REQUEST['data_entrada']=='') { $_REQUEST['data_entrada']='00/00/0000'; }  
       if($_REQUEST['data_inicio']=='')  { $_REQUEST['data_inicio']='00/00/0000'; }   
       if($_REQUEST['data_saida']=='')   { $_REQUEST['data_saida']='00/00/0000'; }
       if($_REQUEST[altura_obra]=='')    { $_REQUEST[altura_obra]='0.00';}
       if($_REQUEST[largura_obra]=='')   { $_REQUEST[largura_obra]='0.00';}
       if($_REQUEST[altura_imagem]=='')  { $_REQUEST[altura_imagem]='0.00';}
       if($_REQUEST[largura_imagem]=='') { $_REQUEST[largura_imagem]='0.00';}
       $tecnico= $_REQUEST['tecnico'];
 
       $sql="INSERT INTO restauro(seq_restauro,obra,interna,parte,controle,tipo,nome_objeto,autor,titulo,tombo,altura,largura,tecnica,colecao,obs,
             data_entrada,data_inicio,data_saida,tecnico,propriedade,ir)
             values('$seq','0','E','0','$_REQUEST[controle]','1','$_REQUEST[nome_objeto]','$_REQUEST[autor]','$_REQUEST[titulo]','$_REQUEST[tombo]',
             '".formata_valor(trim($_REQUEST[altura_obra]))."','".formata_valor(trim($_REQUEST[largura_obra]))."','$_REQUEST[tecnica]','$_REQUEST[colecao]','$_REQUEST[obs]',
             '".explode_data($_REQUEST[data_entrada])."','".explode_data($_REQUEST[data_inicio])."','".explode_data($_REQUEST[data_saida])."','$tecnico','$_REQUEST[propriedade]','$_REQUEST[ir]')";

       $db->query($sql);
       $idrest=$db->lastid();
   
       $sql3="INSERT INTO papel(restauro,documento,alt_grav,larg_grav,estado,estado_saida,suporte,texto_estado,ph_antes,ph_depois,tratamento)
              values('$idrest','$_REQUEST[documento]','".formata_valor(trim($_REQUEST[altura_imagem]))."','".formata_valor(trim($_REQUEST[largura_imagem]))."','$_REQUEST[estado]','$_REQUEST[estado_saida]',
              '$_REQUEST[suporte]','$_REQUEST[texto_estado]','$_REQUEST[ph_antes]','$_REQUEST[ph_depois]','$_REQUEST[texto_tratamento]')";
       $db->query($sql3);
       echo "<script>location.href='restauracao_papel_externa?id=$idrest'</script>";  

     }// se $seq <> -1 ......

   }// $_REQUEST['id'] == ''......

}// se form um insert......
?>