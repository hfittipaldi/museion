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
  ///
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

var ult_seq= -9999;
var ult_entrada= 0;
/// validacao do form
function valida(){
    var mensagem = "";
    var form  = document.form;
    var campo = "";
    var num_elementos =  form.elements.length;
     for (var i = num_elementos-1; i >= 0 ; i--){	  	   
     var elemento = form.elements[i];
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
          }
		  continue;
        }
     }	  //fecha loop do for

	 if (mensagem != ""){
        alert(mensagem);
        campo.focus();
        return false;
     } else {
	 	if (ult_seq != -9999) {
			maior= datamaiorigual(document.form.data_entrada.value,ult_entrada);
			if (document.form.seq_restauro.value > ult_seq) {
				if (maior == 2) {
					alert('Dados não conferem com o último restauro:\n\nRestauração = '+ult_seq+'\nData de entrada = '+ult_entrada);
					return false;
				}
			} else if (document.form.seq_restauro.value < ult_seq) {
				if (maior == 1) {
					alert('Dados não conferem com o último restauro:\n\nRestauração = '+ult_seq+'\nData de entrada = '+ult_entrada);
					return false;
				}
			}
		}
	 	return true;
	}
}

function datamaiorigual(dt1,dt2)
{
var hoje = new Date();
var ano = hoje.getYear();
if(ano >= 50 && ano <= 99)
ano = 1900 + ano
else
ano = 2000 + ano;

var pos1 = dt1.indexOf("/",0)
var dd = dt1.substring(0,pos1)
pos2 = dt1.indexOf("/", pos1 + 1)
var mm = dt1.substring(pos1 + 1,pos2)
var aa = dt1.substring(pos2 + 1,10)
if(aa.length < 4)
if(ano > 1999)
aa = (2000 + parseInt(aa,10))
else
aa = (1900 + parseInt(aa,10));
var data1 = new Date(parseInt(aa,10),parseInt(mm,10) - 1, parseInt(dd,10));
var pos1 = dt2.indexOf("/",0)
var dd = dt2.substring(0,pos1)
pos2 = dt2.indexOf("/", pos1 + 1)
var mm = dt2.substring(pos1 + 1,pos2)
var aa = dt2.substring(pos2 + 1,10)
if(aa.length < 4)
if(ano > 80 && ano <= 99)
aa = (1900 + parseInt(aa,10))
else
aa = (2000 + parseInt(aa,10));
var data2 = new Date(parseInt(aa,10),parseInt(mm,10) - 1,parseInt(dd,10));

if (data1 > data2)
return 1; 
else if(data1 < data2)
return 2;
else
return 0;
}

function abrepop(janela) {
 win=window.open(janela,'lista','left='+((window.screen.width/2)-175)+',top='+((window.screen.height/2)-150)+',width=350,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4) {
   win.window.focus();
 }
 return true;
}
//
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
<body onLoad='document.getElementById("wait").style.display="none"; ajustaAbas(<? echo $aba ?>);'>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
  </div>
  <div id="wait" align="center" class="texto" style="width:450px; height:420px; font-size:12px; font-weight:bold;">
		<br><br><br><br><br><br><br><br>
		&nbsp;&nbsp;<img src="imgs/icons/clock.gif"> &nbsp;&nbsp;Carregando...
  </div>
</th>
        <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
set_time_limit(0);

function cria_seq()
{
// No caso do insert
 global $db;
   $sql="SELECT max(seq_restauro) as valor from restauro where tombo = '$_REQUEST[pNum_registro]' and controle='$_REQUEST[controle]' and tipo=1 and interna='I'";
   $db->query($sql);
   $res=$db->dados(); 
   if($res['valor']==null){
    echo 1;}
  else{
    echo $res['valor']+1;}
} 

////////////////////////////////////
function insere_atualiza_seq() {
   $seq=$_REQUEST['seq_restauro']; //sequencial passado no formulario.
   global $db;
   if ($seq == '') $seq= 0;

   $sql2="SELECT seq_restauro, data_entrada from restauro where tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and seq_restauro=$seq and restauro <> '$_REQUEST[id]' and tipo=2 and interna='I'";
   $db->query($sql2);
   $res=$db->dados();

   if($res<> '')
   {echo "<script>alert('A obra com Nº de Registro: $_REQUEST[tombo] $_REQUEST[controle] - Restauração: $_REQUEST[seq_restauro] já se encontra cadastrada!')</script>";
    $seq=-1;}

   $where_atualiza='';
   if($_REQUEST[id]!='')
   {$where_atualiza=" and restauro <> '$_REQUEST[id]'";}	  
   $sql3="select seq_restauro, data_inicio, data_entrada from restauro where tombo='$_REQUEST[tombo]' and controle='$_REQUEST[controle]' and tipo=2 and interna='I' $where_atualiza order by seq_restauro asc";
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
///////////////////////////////////////

$tecnico= $_SESSION['snome'];

$sql="select controle,nome_objeto from parte where parte = '$_REQUEST[pId_parte]'";
$db->query($sql);
$res=$db->dados();
$controle=$res['controle'];
$nome_objeto=$res['nome_objeto'];

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
$sql="select * from restauro as a,papel as b where (a.restauro=b.restauro) and a.restauro=$_REQUEST[id]";
 $db->query($sql);
 $res=$db->dados();
 $seq_restauro=$res['seq_restauro'];
 $ir=$res['ir'];
 $restauro=$res['restauro'];$nome_objeto=$res['nome_objeto'];
 $obra=$res['obra'];$interna=$res['interna'];$controle=$res['controle']; $autor=$res['autor'];$titulo=$res['titulo'];$tombo=$res['tombo'];
 $altura_obra=$res['altura'];$largura_obra=$res['largura'];$tecnica=$res['tecnica'];$colecao=$res['colecao'];$obs=$res['obs'];
 $data_entrada=formata_data($res['data_entrada']);$data_inicio=formata_data($res['data_inicio']);$data_saida=formata_data($res['data_saida']);$tecnico=$res['tecnico'];
 $documento=$res['documento'];$altura_imagem=$res['alt_grav'];$largura_imagem=$res['larg_grav'];$estado=$res['estado'];
 $estado_saida=$res['estado_saida'];$suporte=$res['suporte'];$texto_estado=$res['texto_estado'];$ph_antes=$res['ph_antes'];
 $ph_depois=$res['ph_depois'];$texto_tratamento=$res['tratamento'];$ordem=$res['ordem'];$descricao=$res['descricao'];$tecnico=$res['tecnico'];

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
<form name="form" method="post"  onSubmit="return valida()"	action=""  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="166" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Restauro (papel)</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Cont.</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Tratamento</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Fotografia</span></a></div></td>
      <td width="60" align="center" style="border-bottom: 1px solid #34689A;">&nbsp;<?  { echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"; } ?></td>
    </tr>
      <td colspan="6" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="355" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
              <div id="quadro1" class="divi1" style="display: ; width:540px; ">
			          <table width="97%" border="0" cellpadding="3" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;Tipo:</font></div></td>
                      <td width="10%" class="texto_bold"> <input name="interna" type="text"  readonly="1" class="combo_cadastro"  value="<? echo "Acervo"; ?>" id="interna" size="7"></td>
                      <td width="35%" class="texto_bold"><input name="documento" type="checkbox" class="combo_cadastro" id="documento" value="S" <? if($documento=='S') echo "checked"?>>
Documento</td>
                      <td class="texto_bold">IR:
                      <input name="ir" type="text" class="combo_cadastro" id="ir" value="<? echo $ir ?>" size="5"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;Autor:</font></div></td>
	                      <td colspan="3"><input name="autor" type="text"  class="combo_cadastro" id="autor" size="75" 
					  value="<?  if($_REQUEST[tipo2]=='I' && $_REQUEST[id]==''){ $sql="SELECT a.nomeetiqueta,c.titulo,d.nome from autor as a INNER JOIN autor_obra as b on (a.autor=b.autor) INNER JOIN obra as c on (b.obra=c.obra) INNER JOIN colecao as d on (c.colecao=d.colecao) 
							where c.num_registro='$_REQUEST[pNum_registro]'";
						$db->query($sql);
                        $res=$db->dados();
                        $autor=$res[0];
						$titulo=$res[1];
						$colecao=$res[2];
						$tombo= $_REQUEST['pNum_registro'];
					  echo htmlentities($autor, ENT_QUOTES);} else{ echo htmlentities($autor, ENT_QUOTES);}?>">
</td>
                    </tr>
                    <tr class="texto_bold">
                    <td colspan="2"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;T&iacute;tulo:</font></div></td>
					<td colspan="3"><input name="titulo" type="text" readonly="1" class="combo_cadastro" id="titulo" size="75" value="<? echo htmlentities($titulo, ENT_QUOTES); ?>">
 </tr>
	<?
		// Obtém sequencial e data_entrada do último restauro para guardar no javascript; só será aplicado na inserção
		// (objetivo de reduzir a incidência de erros de validação e a consequente perda dos dados digitados)
		if ($_REQUEST[id] == '') {
			$sql="SELECT seq_restauro,data_entrada from restauro WHERE seq_restauro in (select max(seq_restauro) from restauro where tombo = '$tombo') AND tombo = '$tombo' AND tipo=1 AND interna='I'";
			$db->query($sql);
			$ultimo_restauro=$db->dados();
			$ultentrada= formata_data($ultimo_restauro['data_entrada']);
			echo "<script>ult_seq= ".$ultimo_restauro['seq_restauro']."; ult_entrada= '".$ultentrada."';</script>";
		}
	?>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;N&ordm; registro:</font></div></td>
                      <td colspan="3"><input name="tombo" type="text" class="combo_cadastro"   readonly="1" id="tombo"  size="12" value="<? echo htmlentities($tombo, ENT_QUOTES); ?>"> 
                       &nbsp; <font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;Controle:</font>                        
                      

                       <input name="controle"  class="combo_cadastro" id="controle"  readonly="1" size="5" type="text" value="<? echo htmlentities($controle, ENT_QUOTES); ?>"> 
                       &nbsp; Restaura&ccedil;&atilde;o:
                       <input name="seq_restauro" type="text" class="combo_cadastro"  id="seq_restauro" value="<? if($_REQUEST[id]!='') { echo $seq_restauro;} else { cria_seq();} ?>" size="2">
&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right"><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;Cole&ccedil;&atilde;o:</font></div></td>
                      <td colspan="3"><input name="colecao" type="text"  readonly="1" class="combo_cadastro" id="colecao" size="75" value="<? echo $colecao; ?>"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">T&eacute;cnica:</div></td>
                      <td colspan="3"><input name="tecnica" type="text" class="combo_cadastro" id="tecnica"  value="<? if($_REQUEST[tipo2]=='I' && $_REQUEST[id]==''){   $sql="SELECT a.material_tecnica,a.dim_parte_altura,a.dim_parte_largura,a.dim_aimp_altura,a.dim_aimp_largura 
                       FROM parte AS a WHERE a.parte=$_REQUEST[pId_parte]";
                     $db->query($sql);$res=$db->dados();$tecnica=$res[0];$altura_obra=$res[1];$largura_obra=$res[2];$altura_imagem=$res[3];$largura_imagem=$res[4]; echo htmlentities($tecnica, ENT_QUOTES);} else{echo htmlentities($tecnica, ENT_QUOTES);}?>" size="60"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right"><u>Dimens&otilde;es:</u></div></td>
                      <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;(Obra)</font>&nbsp;altura:
                        <input name="altura_obra" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="altura_obra" value="<? echo number_format($altura_obra,2,',','.'); ?>" size="4">
cm &nbsp;&nbsp;&nbsp;&nbsp;largura:
<input name="largura_obra" type="text" class="combo_cadastro" id="largura_obra" onChange="return testavalor(this);" value="<? echo number_format($largura_obra,2,',','.'); ?>" size="4">
cm</td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right"></div></td>
                      <td colspan="3"><font style="color:#9B9B9B">(&Aacute;rea impressa)</font>&nbsp;altura:
                        <input name="altura_imagem" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="altura_imagem" value="<? echo number_format($altura_imagem,2,',','.'); ?>" size="4">
cm &nbsp;&nbsp;&nbsp;&nbsp;largura:
<input name="largura_imagem" type="text" class="combo_cadastro" id="largura_imagem" onChange="return testavalor(this);" value="<? echo number_format($largura_imagem,2,',','.'); ?>"size="4">
cm</td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Observa&ccedil;&atilde;o:</div></td>
                      <td colspan="3"><textarea name="obs" cols="70" rows="3" wrap="VIRTUAL" class="combo_cadastro" id="obs"><? echo $obs ?></textarea></td>
                    </tr>
                </table>
               <br>
              </div>
                <!-- ABA 2 : Biografia -->
              <div id="quadro2" class="divi1" style="display:; width:540px; ">
                    <table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Suporte:</div></td>
                      <td width="82%" class="texto_bold"><input name="suporte" type="text" class="combo_cadastro" id="suporte" value="<? echo htmlentities($suporte, ENT_QUOTES); ?>" size="55"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">pH:</div></td>
                      <td class="texto_bold">&nbsp;&nbsp;&nbsp;antes:
                      <input name="ph_antes" type="text" class="combo_cadastro" id="ph_antes" value="<? echo $ph_antes ?>" size="4"> 
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;depois:
                      <input name="ph_depois" type="text" class="combo_cadastro" id="ph_depois" value="<? echo $ph_depois ?>" size="4"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Estado de conserva&ccedil;&atilde;o:</div></td>
                      <td class="texto_bold">&nbsp;&nbsp;&nbsp;antes:
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
                          <option value="<? echo $res[1] ?>" <? if($estado_saida==$res[1]) echo "Selected" ?>><? echo $res[0] ?></option>
                          <? } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Data de Entrada:</div></td>
                      <td class="texto_bold"><input name="data_entrada" type="text" class="combo_cadastro"  id="data_entrada" value="<? echo $data_entrada ?>" size="10">
&nbsp; In&iacute;cio:&nbsp;
<input name="data_inicio"  type="text" class="combo_cadastro" id="data_inicio" value="<? echo $data_inicio ?>" size="10">
&nbsp;Sa&iacute;da:
<input name="data_saida" type="text" class="combo_cadastro" id="data_saida"  value="<? echo $data_saida ?>" size="10"></td>
                    </tr>
                    <tr>

                      <td colspan="3" width="70%" class="texto_bold">
					 Termos
                          para estado de conserva&ccedil;&atilde;o:
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
                      <td colspan="4" class="texto_bold"><textarea name="texto_estado" cols="90" rows="8" wrap="VIRTUAL" class="combo_cadastro" id="texto_estado"><? echo $texto_estado ?></textarea></td>
                      </tr>
                </table>
              </div>                         
			  <!-- ABA 3 : -->
              <div id="quadro3" class="divi1" style="display:; width:540px; ">
                <table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#f2f2f2">
                  <tr>
                    <td colspan="2" class="texto_bold">Termos
                        para Tratamento:</td>
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
                    <p> Restaurador: 
                      <input name="tecnico" type="text" class="combo_cadastro" id="tecnico" value="<? echo htmlentities($tecnico, ENT_QUOTES); ?>" size="70">
                      <a href="javascript:;" onClick="abrepop('pop_tecnico.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a>                      </p></td>
                  </tr>
                </table>
              </div>
			   <!-- ABA 4 : -->
			 <div id="quadro4" class="divi1" style="display:; width:540px; height:250px ">
                			    <table width="95%"  height="1%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
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
              <td width="134"><input align='middle' name="submit" style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?>" type="submit" class="botao" value="Gravar">
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
//TOMBO=num_registro na tabela restauro!!!!
//Controle=parte ( nao confundir com o sequencial!!!)
//sequencial de entrada = incremento de quantas vezes aquela obra foi/nao restauro
//IR incremento
//tipo=papel=1/pintura=2
//tipo2=interna=I/externa=E
function compara_valores($id_restauro)
{
 global $db,$msg_dest;
 
 $sql_fixo="SELECT a.material_tecnica as mat,a.dim_parte_altura as alt,a.dim_parte_largura as larg,a.dim_aimp_altura as imp_alt,a.dim_aimp_largura as imp_larg 
			FROM parte AS a, restauro AS b WHERE a.parte=b.parte AND b.restauro='$id_restauro'";
 $db->query($sql_fixo);
 $res=$db->dados();
 $conteudo1=array($res['mat'],$res['alt'],$res['larg'],$res['imp_alt'],$res['imp_larg']);
 $conteudo2=array($_REQUEST['tecnica'],formata_valor(trim($_REQUEST['altura_obra'])),formata_valor(trim($_REQUEST['largura_obra'])),formata_valor(trim($_REQUEST['altura_imagem'])),formata_valor(trim($_REQUEST['largura_imagem'])));
 ///
 $sql_usu="SELECT responsavel, tecnico from colecao where nome = '$_REQUEST[colecao]'";
 $db->query($sql_usu);
 $usu_destino=$db->dados(); 
 $usu_responsavel=$usu_destino['responsavel'];
 $usu_tecnico=$usu_destino['tecnico'];
 ///
 reset($conteudo1);
 reset($conteudo2);
 $msg=array();
 reset($msg);
 $msg_dest='';
 if($conteudo1[0]!=$conteudo2[0]){
  $msg[]='Técnica original:'.$conteudo1[0].' -  Técnica atual:'.$conteudo2[0]. '\n';}
 if($conteudo1[1]!=$conteudo2[1]){
  $msg[]='Altura original:'.$conteudo1[1].'cm  -  Altura atual:'.$conteudo2[1].' cm \n';}
 if($conteudo1[2]!=$conteudo2[2]){
  $msg[]='Largura original:'.$conteudo1[2].' cm -  Largura atual:'.$conteudo2[2].' cm \n';}
  if($conteudo1[3]!=$conteudo2[3]){
  $msg[]='Altura da Imagem original:'.$conteudo1[3].' cm -  Altura da Imagem atual:'.$conteudo2[3].' cm \n';}
 if($conteudo1[4]!=$conteudo2[4]){
  $msg[]='Largura da Imagem original:'.$conteudo1[4].' cm - Largura da Imagem atual:'.$conteudo2[4].' cm \n ';}

if(count($msg)>0) // Se houver mudanças......
{
  for($i=0;$i<count($msg);$i++){ 
 $msg_dest.=$msg[$i];}
}

if ($usu_responsavel!='') {

	if($msg_dest!='')
	{
  		$texto.='Modificações de catalogação na Ficha de Restauro\n';
  		$texto.='Nº DE REGISTRO:'.$_REQUEST['tombo']. '- Sequencial:'.$_REQUEST['seq_restauro'].'\n';
  		$texto.='TÍTULO:'.$_REQUEST['titulo'].'\n';
  		$texto.='ALTERAÇÕES:\n';
  		$texto.=$msg_dest;
   		$dataInc= date("Y-m-d");
   		$assunto='Ficha de Restauro-Nº de registro:'.$_REQUEST['tombo'].'';
   		$sql= "INSERT INTO agenda(assunto,texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario) 
           		values('$assunto','$texto',now(),'0','$dataInc','$_SESSION[susuario]','$usu_responsavel')";
   		$db->query($sql);
		if ($usu_responsavel <> $usu_tecnico) {
	   		$sql= "INSERT INTO agenda(assunto,texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario) 
           		values('$assunto','$texto',now(),'0','$dataInc','$_SESSION[susuario]','$usu_tecnico')";
	   		$db->query($sql);
		}
  	}
} 
}
////
if($_REQUEST['submit']<>'')
{
 if($_REQUEST['id']<>'')
  {
  $seq= insere_atualiza_seq();
  if ($seq == -1) {
	// não faz nada
	echo "<script>alert('Restauração fora de ordem')</script>";
  }
  else {

   if($_REQUEST['data_entrada']=='')
   { $_REQUEST['data_entrada']='00/00/0000'; }
   
   if($_REQUEST['data_inicio']=='')
   { $_REQUEST['data_inicio']='00/00/0000'; }
   
  if($_REQUEST['data_saida']=='')
   { $_REQUEST['data_saida']='00/00/0000'; }
  //
 if($_REQUEST[altura_obra]=='')
  { $_REQUEST[altura_obra]='0.00';}
 if($_REQUEST[largura_obra]=='')
  { $_REQUEST[largura_obra]='0.00';}
 if($_REQUEST[altura_imagem]=='')
  { $_REQUEST[altura_imagem]='0.00';}
 if($_REQUEST[largura_imagem]=='')
  { $_REQUEST[largura_imagem]='0.00';}

	$tecnico= $_REQUEST['tecnico'];

   $sql="UPDATE restauro set 
   ir='$_REQUEST[ir]',
   seq_restauro='$seq',
   altura='".formata_valor(trim($_REQUEST[altura_obra]))."',
   largura='".formata_valor(trim($_REQUEST[largura_obra]))."',
   tecnica='$_REQUEST[tecnica]',
   tecnico='$tecnico',
   obs='$_REQUEST[obs]',
   data_entrada='".explode_data($_REQUEST[data_entrada])."',
   data_inicio='".explode_data($_REQUEST[data_inicio])."',
   data_saida='".explode_data($_REQUEST[data_saida])."'
   where restauro='$_REQUEST[id]'";
   $db->query($sql);
//
  $sql2="UPDATE papel set
  documento='$_REQUEST[documento]',
  alt_grav='$_REQUEST[altura_imagem]',
  larg_grav='$_REQUEST[largura_imagem]',
  estado='$_REQUEST[estado]',
  estado_saida='$_REQUEST[estado_saida]',
  suporte='$_REQUEST[suporte]',
  texto_estado='$_REQUEST[texto_estado]',
  ph_antes='$_REQUEST[ph_antes]',
  ph_depois='$_REQUEST[ph_depois]',
  tratamento='$_REQUEST[texto_tratamento]'
   where restauro='$_REQUEST[id]'";
   
 $db->query($sql2);
  compara_valores($_REQUEST['id']); 
 echo "<script>location.href='restauracao_papel_interna.php?id=$_REQUEST[id]'</script>";  
 exit(); 
  }
 }     
 else // se form um insert......
 {
  if($_REQUEST[tipo2]=='I')
  {
    $sql="select obra from obra where num_registro='$_REQUEST[pNum_registro]'";
    $db->query($sql);
	$res=$db->dados();
	$obra=$res[0];
	$interna='I';
//   compara_valores();
    }

 $seq=insere_atualiza_seq();
 if ($seq == -1) {
	// não faz nada
	echo "<script>alert('Restauração fora de ordem')</script>";
 }
 else {
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
 if($_REQUEST[altura_imagem]=='')
  { $_REQUEST[altura_imagem]='0.00';}
 if($_REQUEST[largura_imagem]=='')
  { $_REQUEST[largura_imagem]='0.00';}

	$tecnico= $_REQUEST['tecnico'];
  
 $sql="INSERT INTO restauro(seq_restauro,obra,interna,parte,controle,tipo,nome_objeto,autor,titulo,tombo,altura,largura,tecnica,colecao,
 obs,data_entrada,data_inicio,data_saida,tecnico,propriedade,ir)
  values('$seq','$obra','I','$_REQUEST[pId_parte]','$_REQUEST[controle]','1','$_REQUEST[nome_objeto]','$_REQUEST[autor]','$_REQUEST[titulo]','$_REQUEST[tombo]',
 '".formata_valor(trim($_REQUEST[altura_obra]))."','".formata_valor(trim($_REQUEST[largura_obra]))."','$_REQUEST[tecnica]','$_REQUEST[colecao]','$_REQUEST[obs]',
 '".explode_data($_REQUEST[data_entrada])."','".explode_data($_REQUEST[data_inicio])."','".explode_data($_REQUEST[data_saida])."','$tecnico','S','$_REQUEST[ir]')";
 

 //Atualizacao do IR - Sobrepoe pelo ID do registro de Restauracao
 $db->query($sql);
 $idrest=$db->lastid(); 
 //$sql2="UPDATE restauro set ir='$idrest' where restauro='$idrest' ";
 //$db->query($sql2);
 
  $sql3="INSERT INTO papel(restauro,documento,alt_grav,larg_grav,estado,estado_saida,suporte,texto_estado,ph_antes,ph_depois,tratamento)
  values('$idrest','$_REQUEST[documento]','".formata_valor(trim($_REQUEST[altura_imagem]))."','".formata_valor(trim($_REQUEST[largura_imagem]))."','$_REQUEST[estado]','$_REQUEST[estado_saida]',
  '$_REQUEST[suporte]','$_REQUEST[texto_estado]','$_REQUEST[ph_antes]','$_REQUEST[ph_depois]','$_REQUEST[texto_tratamento]')";
  $db->query($sql3);
  compara_valores($idrest);
  echo "<script>location.href='restauracao_papel_interna.php?id=$idrest'</script>";
  }
  }
}
?>