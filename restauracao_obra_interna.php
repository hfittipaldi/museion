<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

</head>
</html>
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
	numAbas=7;

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
function Add(i,parametro){
   if(parametro!=''){
  var item="\n- "+parametro+": ";
  document.getElementById(i).value+=item;
  }}
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
//
// (PBL - 1) Vetor para armazenar as restaurações existentes - Ver código PHP no corpo do programa (PBL - 3)
//
var vetorRest=new Array();
//
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
       
        return false;
     } else return true;
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
<body onLoad='document.getElementById("wait").style.display="none"; ajustaAbas(<? echo $aba ?>); esconde_camadas();'>
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
$db_colecao=new conexao();
$db_colecao->conecta();
$dbr=new conexao();
$dbr->conecta();
$db1=new conexao();
$db1->conecta();
$dbr1=new conexao();
$dbr1->conecta();
$op1=$_REQUEST[op];
$tipo2=$_REQUEST[tipo2];
$pNum_registro=$_REQUEST[pNum_registro];
$tombo=$pNum_registro;
$pId_parte=$_REQUEST[pid_parte];
$controle=$_REQUEST[controle];
$titulo=$_REQUEST[titulo];
$data_inicio=$_REQUEST[data_inicio];
$data_entrada=$_REQUEST[data_entrada];

if ($_REQUEST[id] <>'')
{
  $sql="select obra from restauro where restauro='".$_REQUEST[id]."'";
  $db->query($sql);
  $res=$db->dados(); 
  $_REQUEST[pObra]=$res[0];
  $sql="select num_registro from obra where obra='".$_REQUEST[pObra]."'";
  $db->query($sql);
  $res=$db->dados(); 
  $_REQUEST[pNum_registro]=$res[0];
  $pNum_registro=$_REQUEST[pNum_registro];
}

$sql="select obra,num_registro, colecao from obra where num_registro='".$pNum_registro."'";
$db->query($sql);
$res=$db->dados(); 
$_REQUEST[obra]=$res[0];
$_REQUEST[num_registro]=$res[1];
$_REQUEST[colecao]=$res[2]; $colecao=$_REQUEST[colecao];
//
set_time_limit(0);

function cria_seq()
{
// No caso do insert
 global $db;
   $sql="SELECT max(seq_restauro) as valor 
         from restauro 
             where tombo = '$_REQUEST[pNum_registro]' 
                         and controle = '$_REQUEST[controle]' 
                                and tipo=3 and interna='I'";
   $db->query($sql);
   $res=$db->dados(); 
   if($res['valor']==null){
    echo 1;}
  else{
    echo $res['valor']+1;}
} 
function insere_atualiza_seq() {
   $seq=$_REQUEST['seq_restauro']; //sequencial passado no formulario.  
   global $db;
   if ($seq == '') $seq= 0;

   $sql2="SELECT seq_restauro, data_entrada from restauro where tombo='$_REQUEST[pNum_registro]' and controle='$_REQUEST[controle]' and seq_restauro=$seq and restauro <> '$_REQUEST[id]' and tipo=3 and interna='I'";
   
   $db->query($sql2);
   $res=$db->dados();
   

   if($res<> '')
   {echo "<script>alert('A obra com Nº de Registro: $_REQUEST[pNum_registro] $_REQUEST[controle] - Restauração: $_REQUEST[seq_restauro] já se encontra cadastrada!')</script>";
    $seq=-1;}

   $where_atualiza='';
   if($_REQUEST[id]!='')
   {$where_atualiza=" and restauro <> '$_REQUEST[id]'";}	  
   $sql3="select seq_restauro, data_entrada, data_inicio from restauro where tombo='$_REQUEST[pNum_registro]' and controle='$_REQUEST[controle]' and tipo=3 and interna='I' $where_atualiza order by seq_restauro asc";
   $db->query($sql3);
   while($res=$db->dados()) 
   {
      if ($res['data_entrada']<>'0000-00-00 00:00:00') 
      {
         $vet[$res['seq_restauro']]=$res['data_entrada'];
      }else{
         $vet[$res['seq_restauro']]=$res['data_inicio'];
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

$sql="select obra,controle,nome_objeto from parte where parte = '$_REQUEST[pId_parte]'";

$db->query($sql);
$res=$db->dados();
$controle=$res['controle'];
$nome_objeto=$res['nome_objeto'];
$obraparte=$res['obra'];
$op=$_REQUEST['op'];
$chama=$_REQUEST['chama'];

$estado_cons_obra=$_REQUEST['estado_cons_obra'];
$tratamento_obra=$_REQUEST['tratamento_obra'];


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
	echo "<script>location.href='inclusao_restauro.php'</script>";
}
else {
 $sql="select a.*,b.* from restauro as a,restauro_obra as b where (a.restauro=b.restauro) and a.restauro=$_REQUEST[id]";
 $db->query($sql);
 $res=$db->dados();
 $seq_restauro=$res['seq_restauro'];

   //////////////////////////////////
 ////////////RESTAURO////////////////
 //////////////////////////////////
             $obra=$res['obra'];
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
             //$_REQUEST[tecnica]=$res['tecnica'];
 $tecnica_detalhe=$res['tecnica_detalhe'];
 $requisito_detalhe=$res['requisito_detalhe'];
          if ($res['colecao'] <>''){ $colecao_nome=$res['colecao'];}
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
     $requisito_detalhe=$res['requisito_detalhe'];
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
</tr>
  <br>
  <tr>  </tr>
<form name="form" method="post" onSubmit='return valida();' enctype="multipart/form-data">

  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="95" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Ficha tecnica</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Obra</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Base</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Estrutura</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>Pátina</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba6" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(6);"><div class="texto" id="abas"><a href="javascript:;" id="link6" onClick="ajustaAbas(6);" onMouseDown="this.click();"><span>Imagem</span></a></div></td>
      <td width="95" align="center" valign="bottom" id="aba7" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(7);"><div class="texto" id="abas"><a href="javascript:;" id="link7" onClick="ajustaAbas(7);" onMouseDown="this.click();"><span>Restaurações</span></a></div></td>
    </tr>

      <td colspan="7" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="310" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
              <div id="quadro1" class="divi1" style="display:; width:540px;">
			          <table width="97%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><font style="color:#9B9B9B"><div align="right">Tipo:</div></font></td>
                      <td width="16%" class="texto_bold"><font style="color:#9B9B9B"><? echo "Acervo"; ?></font></td>
                      <td width="41%" class="texto_bold">IR:
                      <input name="ir" type="text" class="combo_cadastro" id="ir" value="<? echo $_REQUEST[ir] ?>" size="5"></td>
                      <td width="5%">
                         <?if ($op=="update"){?>
                         <div align="left"><? echo "<a href=\"alteracao_restauro.php?tipo=3&autor=$autor\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"?></td>
                       <?  }else{ ?>
                         <div align="left"><? echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"?></td>
                        <?  } ?>

                    </td>
                  </tr>

                    <tr>
                      <td colspan="2" class="texto_bold"><font style="color:#9B9B9B"><div align="right">Autor:</div></font></td>
	                      <td colspan="3" class="texto_bold"><font style="color:#9B9B9B"><?  if($_REQUEST[tipo2]=='I' && $_REQUEST[id]==''){ 
                                               $sql="SELECT a.nomeetiqueta,c.titulo,d.nome, c.colecao from autor as a INNER JOIN autor_obra as b on (a.autor=b.autor) INNER JOIN obra as c on (b.obra=c.obra) INNER JOIN colecao as d on (c.colecao=d.colecao) 
					             where c.num_registro='$_REQUEST[pNum_registro]'";
					       $db->query($sql);
                       		               $res=$db->dados();
                        		       $autor=$res[0];
					       $titulo=$res[1];
					      // $colecao=$res[2];
                                              // $_REQUEST['colecao']=$colecao;
                                               
						
					  echo htmlentities($autor, ENT_QUOTES);} else{ echo htmlentities($autor, ENT_QUOTES);}$_REQUEST[autor]=$autor;?></font>
                                         
		</td>
                    </tr>
                    <tr class="texto_bold">
                       <td colspan="2"><font style="color:#9B9B9B"><div align="right">T&iacute;tulo:</div></font></td>
	         <td colspan="3" class="texto_bold"><font style="color:#9B9B9B"><? echo htmlentities($titulo, ENT_QUOTES); $_REQUEST[titulo]=$titulo;?></font></td>
                     </tr>
                     <tr class="texto_bold">
                       <td colspan="2"><font style="color:#9B9B9B"><div align="right">Objeto:</div></font></td>
	         <td colspan="3" class="texto_bold"><font style="color:#9B9B9B"><? echo htmlentities($nome_objeto, ENT_QUOTES); $_REQUEST[nome_objeto]=$nome_objeto;?></font>
                     </tr>
	       <?
		// Obtém sequencial e data_início do último restauro para guardar no javascript; só será aplicado na inserção
		// (objetivo de reduzir a incidência de erros de validação e a consequente perda dos dados digitados)
		if ($_REQUEST[id] == '') {
			$sql="SELECT seq_restauro,data_entrada from restauro WHERE seq_restauro in (select max(seq_restauro) from restauro where tombo = '$tombo') AND tombo = '$tombo' and tipo=3 and interna='I'";

                  			$db->query($sql);
			$ultimo_restauro=$db->dados();
			$ultentrada= formata_data($ultimo_restauro['data_entrada']);
      			echo "<script>ult_seq= ".$ultimo_restauro['seq_restauro']."; ult_entrada= '".$ultentrada."';</script>";
                        //
                        // (PBL - 3) Cria vetor em JavaScript com as restauracoes existentes - Ver PBL - 1 e PBL - 2
                        //
                        $sql="select seq_restauro, data_entrada from restauro where tombo='$tombo' and tipo=3 and interna='I'";
                        $db->query($sql);
                        while ($res=$db->dados()) {
                            $sequencial=$res[seq_restauro];
                            $dataentra=formata_data($res[data_entrada]);
                            echo "<script>vetorRest[".$sequencial."]='".$dataentra."';</script>";
                        }

		}
	?>
                    <tr class="texto_bold">
                      <td colspan="2"><font style="color:#9B9B9B"><div align="right">N&ordm; registro:</div></font></td>
                      <td colspan="3"><font style="color:#9B9B9B"><? echo htmlentities($_REQUEST[pNum_registro], ENT_QUOTES); ?>
 &nbsp; Controle:
&nbsp;&nbsp;&nbsp;<? echo htmlentities($controle, ENT_QUOTES);$_REQUEST[controle]=$controle; ?></font>
&nbsp;&nbsp;&nbsp;Restaura&ccedil;&atilde;o: &nbsp;
 <input name="seq_restauro" type="text" class="combo_cadastro"  id="seq_restauro" value="<? if($_REQUEST[id]!='') { echo $seq_restauro;} else { cria_seq();} ?>" size="2">
</td>	
                    </tr>
                    <tr class="texto_bold">
<?
   $sql_colecao="SELECT nome from colecao where  colecao='".$colecao."'";
   $db_colecao->query($sql_colecao);
   $res_colecao=$db_colecao->dados();
?>
                      <td colspan="2"><font style="color:#9B9B9B"><div align="right">Cole&ccedil;&atilde;o:</div></font></td>
                      <td colspan="3"><font style="color:#9B9B9B"><? echo $res_colecao[nome]; ?></font></td>
                    </tr>


                     <tr class="texto_bold">
                      <td colspan="2"><div align="right">T&eacute;cnica:</div></td>
                      <td colspan="3"><input name="tecnica" type="text" class="combo_cadastro" id="tecnica"  value="<? 
                            if($_REQUEST[tipo2]=='I' && $_REQUEST[id]=='')
                               { 
                                 $sql="SELECT a.material_tecnica,
                                               
                                                 a.dim_parte_altura,
                                                    a.dim_parte_largura,
                                                      a.dim_parte_profund,
                                                         a.dim_parte_peso,
                                                            a.dim_base_altura,
                                                               a.dim_base_largura,
                                                                  a.dim_base_profund,
                                                                     a.dim_base_peso,
                                                                      a.dim_aimp_altura,
                                                                         a.dim_aimp_largura,
                                                                           a.dim_parte_diametro,
                                                                               a.dim_base_diametro 

                                 FROM parte AS a WHERE a.parte=$_REQUEST[pId_parte]";
                                 $db->query($sql);
                                              $res=$db->dados();
                                          $tecnica=$res[0];
                                     // $altura_obra=$res[1];
                                     $largura_obra=$res[2];
                                $profundidade_obra=$res[3];
                                        $peso_obra=$res[4];
                                      $altura_base=$res[5];
                                     $largura_base=$res[6];
                                $profundidade_base=$res[7];
                                        $peso_base=$res[8];
                                    $altura_imagem=$res[9];
                                   $largura_imagem=$res[10];
                                    $diametro_obra=$res[11]; 
                                    $diametro_base=$res[12]; 
                                   if($altura_obra=='')  $altura_obra=$res[1];
                                   if($_REQUEST[largura_obra]=='') $_REQUEST[largura_obra]=$largura_obra;
                                   if($_REQUEST[profundidade_obra]=='') $_REQUEST[profundidade_obra]=$profundidade_obra;
                                   if($_REQUEST[peso_obra]=='') $_REQUEST[peso_obra]=$peso_obra;
                                   if($_REQUEST[altura_base]=='') $_REQUEST[altura_base]=$altura_base;
                                   if($_REQUEST[largura_base]=='') $_REQUEST[largura_base]=$largura_base;
                                   if($_REQUEST[profundidade_base]=='') $_REQUEST[profundidade_base]=$profundidade_base;
                              	   if($_REQUEST[peso_base]=='') $_REQUEST[peso_base]=$peso_base;
                              	   if($_REQUEST[altura_imagem]=='') $_REQUEST[altura_imagem]=$altura_imagem;
                              	   if($_REQUEST[largura_imagem]=='') $_REQUEST[largura_imagem]=$largura_imagem;
                              	   if($_REQUEST[diametro_obra]=='') $_REQUEST[diametro_obra]=$diametro_obra;
                              	   if($_REQUEST[diametro_base]=='') $_REQUEST[diametro_base]=$diametro_base;
                              	   if($_REQUEST[tecnica]=='') $_REQUEST[tecnica]=$tecnica;
                                    
                                 echo htmlentities($tecnica, ENT_QUOTES);
                               } else
                                    {
                                      echo htmlentities($tecnica, ENT_QUOTES);
                                    }?>" size="60">
                       </td>
                    </tr>
                  
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Detalhe de material/técnica:
                        <br>
                        <br>
                        <br>                        
                      </div></td>
                      <td colspan="3"><textarea name="tecnica_detalhe" cols="65" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="tecnica_detalhe"><? if  ($tecnica_detalhe == "" ) {echo $tecnica;}else{echo $tecnica_detalhe;}?></textarea></td>
                    </tr>


                        <!-- DIMENSOES : --> 
                      <tr class="texto_bold">
                      <td colspan="2" valign="top"><div valign="top" align="right"><font style="color:#9B9B9B">(Dimens&otilde;es da obra)</font></div></td>
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
                      <td colspan="2" valign="top"><div valign="top" align="right"><font style="color:#9B9B9B">(Dimens&otilde;es da base)</font></div></td>
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
                     <td colspan="2"><div align="right">Montagem:
                        <br>
                        <br>
                        <br>  
                        </div>
                         </td>
                      
                      <td colspan="3">
                        <?                             

                            if($requisito_detalhe=='')  {  
                            $sql="SELECT requisito_detalhe from obra where num_registro='$_REQUEST[pNum_registro]'";
                              $db->query($sql); 
                            $res=$db->dados(); 
                            $requisito_detalhe=$res['requisito_detalhe']; 
                              } 
                         ?>
                         <textarea name="requisito_detalhe" cols="65" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="requisito_detalhe"><?echo $requisito_detalhe?></textarea>
                          <em>(Requisitos de manutenção, manuseio e montagem)</em> 
                       </td>
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
<input name="data_inicio"  type="text" class="combo_cadastro" id="data_inicio" value="<? echo $data_inicio ?>" size="10">
&nbsp;Sa&iacute;da:
<input name="data_saida" type="text" class="combo_cadastro" id="data_saida"  value="<? echo $data_saida ?>" size="10"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Restaurador:</div></td>
                      <td colspan="3"><input name="tecnico" type="text" class="combo_cadastro" id="tecnico" value="<? echo htmlentities($tecnico, ENT_QUOTES); ?>" size="60">
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
                                                     $estado_cons_obra=$res['termo'] ;
                                               <option value="<? echo $res['termo'] ?>"><? echo$res['termo'] ?></option>

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
                    <table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="#f2f2f2">
                    <tr>
                      <td width="400" colspan="3" class="texto_bold">Estado de conservação: 
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
                      <td width="300" colspan="3" class="texto_bold">Tratamento:       
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
		  <div id="quadro5" class="divi1" style="display:; width:540px; height:150px ">
                    <table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="#f2f2f2">
                    <tr>
                      <td width="300" colspan="3" class="texto_bold">Estado de conservação: 
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
                      <td width="300" colspan="3" class="texto_bold">Tratamento:       
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
       <table width="540" id="rodape" border="0" style="background-color: #f2f2f2;">
            <tr>
              <td width="83">&nbsp;</td>
              <td width="149">&nbsp;</td>
              <td width="134"><input align='middle' name="submit" type="submit"  style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?> " class="botao" value="Gravar">
                <input name="op" type="hidden" value="<? echo $op ?>">
                <br>
              <br></td>
              <td width="168">&nbsp;<br><br></td>
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


		<!-- ABA 7 Lista de restauros : -->
		<div id="quadro7" class="divi1" style="display:; width:540px; ">
	          <table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="f2f2f2" class="texto_bold">
                   <tr>
                     <? $sqlr1="select obra, num_registro from obra where num_registro='$_REQUEST[pNum_registro]'";
                        $dbr1->query($sqlr1);
	                $resr1=$dbr1->dados();
	                $obrar1=$resr1[0];         
                      ?>        
                      <td><? echo "<iframe name='abas' align='middle' src='lista_obras_restauro.php?tipo=3&tombo=$_REQUEST[pNum_registro]&obra=$obrar1&parte=$_REQUEST[pId_parte]&tipo2=1' width='100%' height='300' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?></td>                  
                </table>
               </div>


  </table>
</form>
</body>
<? 

function compara_valores($id_restauro)
{
 global $db,$msg_dest,$db1;

 $sqltecnica="SELECT material_tecnica, requisito_detalhe FROM obra  where num_registro='$_REQUEST[pNum_registro]'";
 $db1->query($sqltecnica);
 $res1=$db1->dados();

 $nometecnica=$res1['material_tecnica'];
 $requisitodetalhe=$res1['requisito_detalhe']; 

 $sql_fixo="SELECT a.material_tecnica as mat,
                    a.dim_parte_altura as alt,
                   a.dim_parte_largura as larg, 
                   a.dim_parte_profund as prof, 
                   a.dim_parte_peso as pes,
                   a.dim_parte_diametro as dim,
                   a.dim_base_altura as basealt, 
                   a.dim_base_largura as baselarg, 
                   a.dim_base_profund as baseprof,
                   a.dim_base_peso as basepeso,
                   a.dim_base_diametro as basedim,
                   b.tecnica_detalhe as tecdet,                   
                  b.requisito_detalhe as requi
                   FROM parte AS a, restauro AS b 
	           WHERE a.parte=b.parte AND b.restauro='$id_restauro'";

 $db->query($sql_fixo);
 $res=$db->dados();
 $conteudo1=array($res['mat'],
                  $res['alt'],
                  $res['larg'],
                  $res['prof'],
                  $res['pes'],
                  $res['dim'],
                  $res['basealt'],
                  $res['baselarg'],
                  $res['baseprof'],
                  $res['basepeso'],
                  $res['basedim'],                 
                    $res['tecdet'],
                  $res['requi']);

 $conteudo2=array($_REQUEST['tecnica'],formata_valor(trim($_REQUEST['altura_obra'])),
                                       formata_valor(trim($_REQUEST['largura_obra'])),
                                       formata_valor(trim($_REQUEST['profundidade_obra'])),
                                       formata_valor(trim($_REQUEST['peso_obra'])),
                                       formata_valor(trim($_REQUEST['diametro_obra'])),
                                       formata_valor(trim($_REQUEST['altura_base'])), 
                                       formata_valor(trim($_REQUEST['largura_base'])),
                                       formata_valor(trim($_REQUEST['profundidade_base'])), 
                                       formata_valor(trim($_REQUEST['peso_base'])),
                                       formata_valor(trim($_REQUEST['diametro_base'])),
                                       $_REQUEST['tecnica_detalhe'],
                                       $requisitodetalhe);


if ($conteudo1[1]<1) {$conteudo1[1]='';}
if ($conteudo1[2]<1) {$conteudo1[2]='';}
if ($conteudo1[3]<1) {$conteudo1[3]='';}
if ($conteudo1[4]<1) {$conteudo1[4]='';}
if ($conteudo1[5]<1) {$conteudo1[5]='';}
if ($conteudo1[6]<1) {$conteudo1[6]='';}
if ($conteudo1[7]<1) {$conteudo1[7]='';}
if ($conteudo1[8]<1) {$conteudo1[8]='';}
if ($conteudo1[9]<1) {$conteudo1[9]='';}
if ($conteudo1[10]<1) {$conteudo1[10]='';}


 ///

 $sql_usu="SELECT responsavel, tecnico from colecao where nome = '$_REQUEST[colecao]'";
 $db->query($sql_usu);
 $usu_destino=$db->dados(); 
 $usu_responsavel=$usu_destino['responsavel'];
 $usu_tecnico=$usu_destino['tecnico'];if ($usu_responsavel==''){$usu_responsavel=0;}
 $_REQUEST['usu_responsavel']=$usu_responsavel;
 $_REQUEST['usu_tecnico']=$usu_tecnico;

  ///
 reset($conteudo1);
 reset($conteudo2);
 $msg=array();
 reset($msg);
 $msg_dest='';

 if($conteudo1[0]!=$conteudo2[0]){
  $msg[]='Técnica original:'.$conteudo1[0].' -  Técnica atual:'.$conteudo2[0]. '\n';}

 if($conteudo1[1]!=$conteudo2[1]){
  $msg[]='Altura original:'.$conteudo1[1].'cm -  Altura atual:'.$conteudo2[1].' cm \n';}

 if($conteudo1[2]!=$conteudo2[2]){
  $msg[]='Largura original:'.$conteudo1[2].' cm -  Largura atual:'.$conteudo2[2].' cm \n';}

 if($conteudo1[3]!=$conteudo2[3]){
  $msg[]='Profundidade original:'.$conteudo1[3].' cm -  Profundidade atual:'.$conteudo2[3].' cm \n';}

 if($conteudo1[4]!=$conteudo2[4]){
  $msg[]='Peso original:'.$conteudo1[4].' cm -  Peso atual:'.$conteudo2[4].' kg \n';}

 if($conteudo1[5]!=$conteudo2[5]){
  $msg[]='Diâmetro originall:'.$conteudo1[5].'  -  diâmetro atual:'.$conteudo2[5].' \n';}

 if($conteudo1[6]!=$conteudo2[6]){
  $msg[]='Altura da base original:'.$conteudo1[6].' cm -  Altura da base atual:'.$conteudo2[6].' cm \n';}

 if($conteudo1[7]!=$conteudo2[7]){
  $msg[]='Largura base original:'.$conteudo1[7].' cm -  Largura da base atual:'.$conteudo2[7].' cm \n';}

 if($conteudo1[8]!=$conteudo2[8]){
  $msg[]='Profundidade da base original:'.$conteudo1[8].' cm -  Profundidade da base atual:'.$conteudo2[8].' cm \n';}

 if($conteudo1[9]!=$conteudo2[9]){
  $msg[]='Peso da base original:'.$conteudo1[9].' cm -  Peso da base atual:'.$conteudo2[9].' kg \n';}

 if($conteudo1[10]!=$conteudo2[10]){
  $msg[]='Diâmetro da base original:'.$conteudo1[10].'  -  diâmetro da base atual:'.$conteudo2[10].' \n';}

 if($conteudo1[11]!=$conteudo2[11]){
  $msg[]='Tecnica original:'.$conteudo1[11].'  -  tecnica atual:'.$conteudo2[11].' \n';}

  if($conteudo1[12]!=$conteudo2[12]){
  $msg[]='Requisito original:'.$conteudo1[12].'  -  requisito atual:'.$conteudo2[12].' \n';}
 
if(count($msg)>0) // Se houver mudanças......
{
  for($i=0;$i<count($msg);$i++){ 
 $msg_dest.=$msg[$i];}
}
if($msg_dest!='')
{
  $texto.='Modificações de catalogação na Ficha de Restauro\n';
  $texto.='Nº DE REGISTRO:'.$_REQUEST['pNum_registro']. '- Objeto: '.$_REQUEST['nome_objeto']. '- Sequencial:'.$_REQUEST['seq_restauro'].'\n';
  $texto.='TÍTULO:'.$_REQUEST['titulo'].'\n';
  $texto.='ALTERAÇÕES:\n';
  $texto.=$msg_dest;

    $dataInc= date("Y-m-d");
   $assunto='Ficha de Restauro - Nº de registro: '.$_REQUEST['pNum_registro'].'';
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



if($_REQUEST['submit']<>'') 
{
 if ($_REQUEST['id']<>'')
  {
   $seq= insere_atualiza_seq();
    if ($seq == -1) {
	// não faz nada
       echo "<script>alert('2-Restauração fora de ordem')</script>";
    }else {
       if($_REQUEST['data_entrada']=='') { $_REQUEST['data_entrada']='00/00/0000'; }
       if($_REQUEST['data_inicio']=='')  { $_REQUEST['data_inicio']='00/00/0000'; }
       if($_REQUEST['data_saida']=='')   { $_REQUEST['data_saida']='00/00/0000'; }
       if($_REQUEST[altura_obra]=='')    { $_REQUEST[altura_obra]='0.00';}
       if($_REQUEST[largura_obra]=='')   { $_REQUEST[largura_obra]='0.00';}

       $tecnico= $_REQUEST['tecnico'];

       $sql="UPDATE restauro set ir='$_REQUEST[ir]',seq_restauro='$seq',altura='".formata_valor(trim($_REQUEST[altura_obra]))."',largura='".formata_valor(trim($_REQUEST[largura_obra]))."',
             peso='".formata_valor(trim($_REQUEST[peso_obra]))."',diametro='".formata_valor(trim($_REQUEST[diametro_obra]))."',altura_base='".formata_valor(trim($_REQUEST[altura_base]))."',
             largura_base='".formata_valor(trim($_REQUEST[largura_base]))."',peso_base='".formata_valor(trim($_REQUEST[peso_base]))."',diametro_base='".formata_valor(trim($_REQUEST[diametro_base]))."',
             profundidade='".formata_valor(trim($_REQUEST[profundidade_obra]))."',profundidade_base='".formata_valor(trim($_REQUEST[profundidade_base]))."',
             tecnica='$_REQUEST[tecnica]',tecnico='$tecnico',obs='$_REQUEST[obs]',tecnica_detalhe='$_REQUEST[tecnica_detalhe]',
             requisito_detalhe='$_REQUEST[requisito_detalhe]',data_entrada='".explode_data($_REQUEST[data_entrada])."',data_inicio='".explode_data($_REQUEST[data_inicio])."',
             data_saida='".explode_data($_REQUEST[data_saida])."',colecao='".$_REQUEST[colecao]."'
             where restauro='$_REQUEST[id]'";
       $db->query($sql);

       $sql2="UPDATE restauro_obra set assinatura='$_REQUEST[assinatura]',estado_cons_obra='$_REQUEST[estado_cons_obra]',tratamento_obra='$_REQUEST[tratamento_obra]',estado_cons_base='$_REQUEST[estado_cons_base]',
              tratamento_base='$_REQUEST[tratamento_base]',estado_cons_estrutura='$_REQUEST[estado_cons_estrutura]',tratamento_estrutura='$_REQUEST[tratamento_estrutura]',
              estado_cons_patina='$_REQUEST[estado_cons_patina]',tratamento_patina='$_REQUEST[tratamento_patina]'
             where restauro='$_REQUEST[id]'";
       $db->query($sql2);

      if ($_REQUEST['ir']<>'') compara_valores($_REQUEST['id']);
       echo"<script>location.href='restauracao_obra_interna.php?colecao=$_REQUEST[colecao]&pNum_registro=$_REQUEST[pNum_registro]&id=$_REQUEST[id]&op=update&tipo2=I&pId_parte=$_REQUEST[pId_parte]';</script>";
       exit();
    } //se $seq <> -1
 }  else {// $_REQUEST['id'] == ''......

  if($_REQUEST[tipo2]=='I')
  {
    $sql="select obra from obra where num_registro='$_REQUEST[pNum_registro]'";
    $db->query($sql);
	$res=$db->dados();
	$obra=$res[0];
	$interna='I';
	//if ($_REQUEST['ir']<>'') compara_valores();
  }

 $seq=insere_atualiza_seq();
 if ($seq == -1) {// não faz nada
    if ($_REQUEST['data_entrada']=='') {echo "<script>alert('Data de Entrada não pode ser vazia(dd/mm/aaaa).')</script>";}else{echo "<script>alert('Restauração fora de ordem.')</script>";}
     
  } else{  

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
     
    $sql="INSERT INTO restauro(seq_restauro,ir, obra,interna,parte,controle,nome_objeto,tipo,autor,titulo,tombo,
                                                altura,largura,tecnica,
                                                colecao,obs,data_entrada,data_inicio,data_saida,tecnico,propriedade,tecnica_detalhe,requisito_detalhe,
                                                  profundidade,peso,diametro, altura_base,largura_base,profundidade_base,peso_base,diametro_base)
    
         values('$seq','$_REQUEST[ir]','$obra','$interna','$_REQUEST[pId_parte]','$_REQUEST[controle]','$_REQUEST[nome_objeto]','3','$_REQUEST[autor]','$_REQUEST[titulo]','$_REQUEST[pNum_registro]',
         '".formata_valor(trim($_REQUEST[altura_obra]))."','".formata_valor(trim($_REQUEST[largura_obra]))."','$_REQUEST[tecnica]','$_REQUEST[colecao]','$_REQUEST[obs]',
         '".explode_data($_REQUEST[data_entrada])."','".explode_data($_REQUEST[data_inicio])."','".explode_data($_REQUEST[data_saida])."','$tecnico','S','$_REQUEST[tecnica_detalhe]','$_REQUEST[requisito_detalhe]',
         '".formata_valor(trim($_REQUEST[profundidade_obra]))."','".formata_valor(trim($_REQUEST[peso_obra]))."','".formata_valor(trim($_REQUEST[diametro_obra]))."','".formata_valor(trim($_REQUEST[altura_base]))."',
         '".formata_valor(trim($_REQUEST[largura_base]))."','".formata_valor(trim($_REQUEST[profundidade_base]))."','".formata_valor(trim($_REQUEST[peso_base]))."','".formata_valor(trim($_REQUEST[diametro_base]))."')";
    $db->query($sql);
    $idrest=$db->lastid();
 
    $sql3="INSERT INTO restauro_obra(restauro,assinatura,estado_cons_obra,tratamento_obra,estado_cons_base,tratamento_base,estado_cons_estrutura,tratamento_estrutura,estado_cons_patina,tratamento_patina)
    values('$idrest','$_REQUEST[assinatura]','$_REQUEST[estado_cons_obra]','$_REQUEST[tratamento_obra]','$_REQUEST[estado_cons_base]','$_REQUEST[tratamento_base]','$_REQUEST[estado_cons_estrutura]','$_REQUEST[tratamento_estrutura]','$_REQUEST[estado_cons_patina]','$_REQUEST[tratamento_patina]')";
    $db->query($sql3);
    $_REQUEST['op']="update";
    if ($_REQUEST['ir']<>'')compara_valores($idrest);
    echo"<script>location.href='restauracao_obra_interna.php?colecao=$_REQUEST[colecao]&pNum_registro=$_REQUEST[pNum_registro]&id=$idrest&op=update&tipo2=I&pId_parte=$_REQUEST[pId_parte]';</script>";
   }// se $seq <> -1 ......
 }
}
?>