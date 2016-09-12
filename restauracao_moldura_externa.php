<?  include_once("seguranca.php"); ?>
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


var ult_seq= -9999;
var ult_inicio= 0;
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
	 //Data_entrada
        if (elemento.name == "data_entrada"){
          if(!IsEmpty(elemento)) 
		  {
			 if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data de Entrada inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
        } 
		  else {
             campo = elemento;
             mensagem = "Data de entrada não pode ser vazia (dd/mm/aaaa) \n\n" + mensagem;
		  }
		  continue;
       }
	//Data_Inicio 
	if (elemento.name == "data_inicio"){
          if(!IsEmpty(elemento)) 
		  {
			 if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data de Inicio inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
            continue;
             }
		  
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
     }	  //fecha loop do for

	 if (mensagem != ""){
        alert(mensagem);
        campo.focus();
        return false;
     } else {
	 	if (ult_seq != -9999) {
			maior= datamaiorigual(document.form.data_entrada.value,ult_inicio);
			if (document.form.seq_restauro.value > ult_seq) {
				if (maior == 2) {
					alert('Dados não conferem com o último restauro:\n\nRestauração = '+ult_seq+'\nData de entrada = '+ult_inicio);
					return false;
				}
			} else if (document.form.seq_restauro.value < ult_seq) {
				if (maior == 1) {
					alert('Dados não conferem com o último restauro:\n\nRestauração = '+ult_seq+'\nData de entrada = '+ult_inicio);
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


function inicia_modelo($tipo) { 
  if ($tipo=='1') document.getElementById("modelo1").checked= true;
  else document.getElementById("modelo1").checked= false;
  if ($tipo=='2') document.getElementById("modelo2").checked= true;
  else document.getElementById("modelo2").checked= false;    
  return true;
 }

function abrepop2(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-50)+',top='+((window.screen.height/2)-50)+',width=400,height=250, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
   {      win.window.focus();
    }
 return true;
}

function muda_modelo($val) {

if ($val=='3')
{
      if (document.getElementById("tem_ornamento").checked==true)
         { 
           document.getElementById("orna_restmold").style.display= '';
          }else{
            document.getElementById("orna_restmold").style.display= 'none';
         }

      if (document.getElementById("tem_acabamento").checked==true)
         { 
           document.getElementById("acab_restmold").style.display= '';
          }else{
            document.getElementById("acab_restmold").style.display= 'none';
         }

}
 
   if ($val=='1')
      
     { 
       if (document.getElementById("modelo1").checked==true)
         { 
            document.form.dmodelo1.value=1;
         }else{
            document.form.dmodelo1.value=0;
         }
        if (document.getElementById("modelo2").checked==true)
         { 
            document.form.dmodelo2.value=1;
          }else{
            document.form.dmodelo2.value=0;
          }
      }	
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
<body onLoad='document.getElementById("wait").style.display="none"; ajustaAbas(<? echo $aba ?>);inicia_modelo(<?echo $_REQUEST['tipo2'];?>);'>
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

 function ret_nome($idnome)
   {
    if ($idnome<>"")
    {
      global $db;
      $sql="select nome from usuario where usuario=$idnome";

      $db->query($sql);
      $nome=$db->dados();
      return $nome[0];
     }
   }


include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
set_time_limit(0);
$filtro=$_REQUEST['filtro'];
$chama=$_REQUEST['chama'];

$_REQUEST[tombo]=$_REQUEST['pNum_registro'];
$moldura=$_REQUEST['moldura'];
$mold_registro=$_REQUEST['mold_registro'];
$tipo2=$_REQUEST['tipo2'];
$orna_restmold=$_REQUEST[orna_restmold];
$sup_restmold=$_REQUEST[sup_restmold];
$acab_restmold=$_REQUEST[acab_restmold];
$op=$_REQUEST[op];
$op_restauro=$_REQUEST[op_restauro];
$id=$_REQUEST[id];


if ($tipo2==1){$tipo2_2='I';}else{$tipo2_2='E';}
if ($moldura>0) $op="update";



///////////////////////////INSERE A MOLDURA: MOLD_REGISTRO VAI SER IGUAL A MOLDURA///////////////////////

  if ($_REQUEST[op]=='insert')
   {
     if ( $_REQUEST[mold_registro]=='')
     {      
        $sql="insert into moldura(parte, obra, catalogado, data_catalog1)values('0','0','$_SESSION[susuario]',now())";
        $db->query($sql);
        $mold=$db->lastid();
        $mold_registro=$mold;
        $moldura=$mold;


        $sql="Update moldura set mold_registro='$mold_registro' where moldura='$_REQUEST[mold_registro]'"; 
        $db->query($sql);
 
        $op='update';      
        $_REQUEST[op_restauro]='insert'; 
     
        echo "<script>location.href='restauracao_moldura_externa.php?op=update&op_restauro=insert&tipo2=$tipo2&form=restauro&obra=0&moldura=$moldura&mold_registro=$mold_registro&chama=$chama'</script>";
    }else{
       $sql="select * from moldura where mold_registro=$_REQUEST[mold_registro]";        
       $db->query($sql);
       $mold=$db->dados();
       $op='update';
       $moldura=$mold[moldura];      
       $_REQUEST[op_restauro]='insert'; 
       echo "<script>location.href='restauracao_moldura_externa.php?op=update&op_restauro=insert&tipo2=$tipo2&form=restauro&obra=0&moldura=$_REQUEST[moldura]&mold_registro=$_REQUEST[mold_registro]&chama=$chama'</script>";

    }
   }


///////////////////////////////////////////////////////////////////////////////////////////////////////////

function cria_seq_externa()
{
// No caso do insert
 global $db;
   $sql="SELECT max(seq_restauro) as valor from restauro where moldura = '$_REQUEST[moldura]' and tipo=4 and interna='E'";
   $db->query($sql);
   $res=$db->dados(); 
   if($res['valor']==null){
    echo 1;}
  else{
    echo $res['valor']+1;}
}
function cria_seq()
{
// No caso do insert
 global $db;
   $sql="SELECT max(seq_restauro) as valor from restauro where tombo = '$_REQUEST[pNum_registro]' and controle='$_REQUEST[controle]' and tipo=4 and interna='I'";
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

   $sql2="SELECT seq_restauro, data_entrada from restauro where tombo='$_REQUEST[pNum_registro]' and controle='$_REQUEST[controle]' and seq_restauro=$seq and restauro <> '$_REQUEST[id]' and tipo=4 and interna='".$tipo2_2."'";
   $db->query($sql2);
   $res=$db->dados();
   

   if($res<> '')
   {echo "<script>alert('A obra com Nº de Registro: $_REQUEST[pNum_registro] $_REQUEST[controle] - Restauração: $_REQUEST[seq_restauro] já se encontra cadastrada!')</script>";
    $seq=-1;}

   $where_atualiza='';
   if($_REQUEST[id]!='')
   {$where_atualiza=" and restauro <> '$_REQUEST[id]'";}	  
   $sql3="select seq_restauro, data_entrada, data_entrada from restauro where tombo='$_REQUEST[pNum_registro]' and controle='$_REQUEST[controle]' and tipo=4 and interna='".$tipo2_2."' $where_atualiza order by seq_restauro asc";
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
///////////////////////////////////////



if($_REQUEST[id]<>'' || $_REQUEST['op']=='update')
{
if ($_REQUEST['op'] == 'del') {
	$sql="DELETE from restauro where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	$sql="DELETE from restauro_moldura where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	$sql="DELETE from restauro_fotografia where restauro = '$_REQUEST[id]'";
	$db->query($sql);
	echo "<script>alert('Exclusão realizada com sucesso');</script>";
	echo "<script>location.href='alteracao_restauro.php'</script>";
}
else {


if ($_REQUEST[op_restauro]=='update')
{


   $sql="select a.*,b.*, c.*,
              b.ornamento as orna_restmold, b.acabamento as acab_restmold, b.suporte as sup_restmold,
              c.ornamento as orna_mold, c.acabamento as acab_mold, c.suporte as sup_mold
              from restauro as a, restauro_moldura as b,  moldura as c 
             where (a.restauro=b.restauro) and (a.moldura=c.moldura) and a.restauro=$_REQUEST[id]";
   $db->query($sql);
   $res=$db->dados();
   $seq_restauro=$res['seq_restauro'];

  //////////////////////////////////
 /////////RESTAURO///////
 //////////////////////////////////
        
         $obra=$res['obra'];
      $interna=$res['interna'];
 $_REQUEST[ir]=$res['ir'];
     $controle=$res['controle'];
  $nome_objeto=$res['nome_objeto'];
        $autor=$res['autor'];
       $titulo=$res['titulo'];
        $tombo=$res['tombo'];
 $data_entrada=formata_data($res['data_entrada']);
  $data_inicio=formata_data($res['data_inicio']);
   $data_saida=formata_data($res['data_saida']);
      $tecnico=$res['tecnico'];
      $colecao=$res['colecao'];
  $propriedade=$res['propriedade'];

   ////////////////////////////////////////////////
 //////RESTAURO_MOLDURA/////////
 /////////////////////////////////////////////////
      $restauro=$res['restauro']; 
      $moldura=$res['moldura'];
   $assinatura=$res['assinatura'];
$conservacao=$res['estado_conservacao'];
   $tratamento=$res['tratamento'];
        $controle=$res['controle'];
 $num_regsitro=$res['num_regsitro'];
    $propriedade=$res['propriedade'];
$orna_restmold=$res['orna_restmold'];
 $sup_restmold=$res['sup_restmold'];
$acab_restmold=$res['acab_restmold'];

 



   /////////////////////////////////
 ////////MOLDURA//////////
 //////////////////////////////////

 $parte=$res['parte'];
 $material_tecnica=$res['material_tecnica'];
 $altura_interna=$res['altura_interna'];
 $largura_interna=$res['largura_interna'];
 $altura_externa=$res['altura_externa'];
 $largura_externa=$res['largura_externa'];
 $profundidade_externa=$res['profundidade_externa']; 
 $peso=$res['peso'];
 $formato=$res['formato'];
 $observacao=$res['observacao'];
 $observacao=$res['observacao'];
 $catalogado=ret_nome($res[catalogado]);
 $atualizado=ret_nome($res[atualizado]);
 $tem_ornamento=$res['tem_ornamento'];
 $tem_acabamento=$res['tem_acabamento'];
 $ornamento=$res['orna_mold'];
 $suporte=$res['sup_mold'];
 $acabamento=$res['acab_mold'];
 if ($res[catalogado] > 0  and $res[catalogado] <> '' ) $data_catalog1= convertedata($res[data_catalog1],'d/m/Y - h:i');
 if ($res[atualizado] > 0  and $res[atualizado] <> '' ) $data_catalog2= convertedata($res['data_catalog2'],'d/m/Y - h:i');
 


 

   if($data_entrada == '00/00/0000')
	$data_entrada= '';
   
   if($data_inicio == '00/00/0000')
	$data_inicio= '';
   
   if($data_saida == '00/00/0000')
	$data_saida= '';
}
}
}
$tecnico= $_SESSION['snome'];


     $sql="select * from moldura where moldura='$moldura'";
     $db->query($sql);
     $res=$db->dados();
     $mold_registro=$res[mold_registro];
     $_REQUEST[mold_registro]=$mold_registro;

     $parte=$res['parte'];
     $obra=$res[obra];
     $observacao=$res[observacao];
     $formato=$res[formato];
     $material_tecnica=$res[material_tecnica];
     $altura_interna=$res[altura_interna];
     $largura_interna=$res[largura_interna];
     $altura_externa=$res[altura_externa];
     $largura_externa=$res[largura_externa];
     $profundidade_externa=$res[profundidade_externa];
     $peso=$res[peso];
     $suporte=$res[suporte];
     $acabamento=$res[acabamento];
     $ornamento=$res[ornamento];
     $tem_ornamento = $res[tem_ornamento];
     $tem_acabamento = $res[tem_acabamento]; 
     $controle=$res[controle];
     $num_registro=$res[num_registro];
     $propriedade=$res[propriedade];
       $catalogado=ret_nome($res[catalogado]);
     $atualizado=ret_nome($res[atualizado]);

     if ($res[catalogado] > 0  and $res[catalogado] <> '' ) $data_catalog1= convertedata($res[data_catalog1],'d/m/Y - h:i');
     if ($res[atualizado] > 0    and $res[atualizado] <> '' ) $data_catalog2= convertedata($res['data_catalog2'],'d/m/Y - h:i');


?>
  </tr>
<form name="form" method="post"  onSubmit="return valida();inicia_modelo(<?echo $_REQUEST[tipo2];?>)"	action=""  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="166" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Restauro (moldura)</span></a></div></td>
      <td width="166" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Estado de conservação</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Tratamento</span></a></div></td>
      <td width="106" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Fotografia</span></a></div></td>
	  <td width="60" align="right" style="border-bottom: 1px solid #34689A;">&nbsp;<?                           
                             if ($chama=='')        {echo "<a href=\"inclusao_restauro.php?\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";}
                             if ($chama=='autor')   {echo "<a href=\"restauro_altera_autor.php?tipo2=$tipo2_2&tipo=4&autor=$filtro\">                             <img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";}
                             if ($chama=='titulo')  {echo "<a href=\"restauro_altera_titulo.php?titulo=$filtro&tipo2=$tipo2_2&tipo=4&op_restauro='update'\">      <img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";}
                             if ($chama=='registro'){echo "<a href=\"restauro_altera_num.php?num=$filtro&tipo2=$tipo2_2&tipo=4&op_restauro='update'\">            <img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";}
                             if ($chama=='ir')      {echo "<a href=\"restauro_altera_ir.php?ir=$filtro&tipo2=$tipo2_2&tipo=4&op_restauro='update'\">              <img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";}
                             ?></td>
    </tr>
      <td colspan="6" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="355" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
              <div id="quadro1" class="divi1" style="display: ; width:540px; ">
	     <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                   <tr width="98%">   

                       <td width="100%" align="right">       
                        </td> 
                           
                      </tr>                  
             </table>


	      <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                        <tr width="100%">
 
                    <td colspan="2" width="28%">
                         <div align="center">
                                <span class="texto">
                                 <font style="color:#9B9B9B">N&ordm; Moldura:</font>
                               </span>
                               <span class="texto">
                                  <font style="color:#9B9B9B"><? echo htmlentities($_REQUEST[mold_registro], ENT_QUOTES); ?></font>
  		   </span>
                           </div>
                       </td>
                          <td colspan="2" width="20%">
                             <div align="left">
                                <span class="texto">
                                   <input type="radio" name="modelo" disabled="true" id="modelo1" onClick="abrepop2('interna_externa_restauro.php?tipo=$tipo2');">Interna
                                </span>
                              </div>
                           </td>
                         <td colspan="2" width="20%">
                            <div align="left">
                               <span class="texto"> 
				 <input type="radio" name="modelo" disabled="true" id="modelo2" value="2" onClick="muda_modelo(1);">Externa
                               </span>
                            </div>
                        </td>
                      <td width="16%" class="texto_bold"><input name="propriedade" type="checkbox" class="combo_cadastro" id="propriedade" value="S" <? if($propriedade=='S') echo "checked"?>>do Museu</td>

                   </tr>		                     
              </table>
              <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                 <tr class="texto_bold">                      
                    <td width="20%"><div align="right">Material/T&eacute;cnica:</div></td>
                    <td align="left"><input name="material_tecnica" type="text" class="combo_cadastro" id="material_tecnica"  value="<? 
                                    echo htmlentities(trim($material_tecnica), ENT_QUOTES);
                             ?>" size="78">
                   </td>
               </tr>
              </table>


                 <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                      <tr class="texto_bold">                    
 	        <?
		// Obtém sequencial e data_início do último restauro para guardar no javascript; só será aplicado na inserção
		// (objetivo de reduzir a incidência de erros de validação e a consequente perda dos dados digitados)
		if ($_REQUEST[id] == '') {
			$sql="SELECT seq_restauro,data_inicio from restauro WHERE seq_restauro in (select max(seq_restauro) from restauro where tombo = '$_REQUEST[pNum_registro]') AND tombo = '$_REQUEST[pNum_registro]' AND tipo=4 AND interna='".$tipo2_2."'";
			$db->query($sql);
			$ultimo_restauro=$db->dados();
			$ultinicio= formata_data($ultimo_restauro['data_entrada']);
			echo "<script>ult_seq= ".$ultimo_restauro['seq_restauro']."; ult_inicio= '".$ultinicio."';</script>";                        
		        }?>
                    
                       <?if ($tipo2_2=='E'){?>
                          <td  width="25%"><div align="right">N&ordm; registro:</div></td>
                          <td align="left"><input name="num_registro" type="text" class="combo_cadastro"  id="tombo"  size="9" value="<? echo htmlentities(trim($num_registro), ENT_QUOTES); ?>">

                          <td width="20%"><div align="right">Controle:</div></td>                        
                          <td align="left"><input name="controle" type="text" class="combo_cadastro"  id="controle"  size="4" value="<? echo htmlentities(trim($controle), ENT_QUOTES); ?>">
                       <?}?>
                       <td width="20%"><div align="right">Restaura&ccedil;&atilde;o:</td>
                       <td align="left"><input name="seq_restauro" type="text" class="combo_cadastro"  id="seq_restauro" value="<? if($_REQUEST[id]!='') { echo $seq_restauro;} else { if ($tipo2_2=='E'){cria_seq_externa();}else{cria_seq();}}?>" size="2"></td>

                       <td width="20%"><div align="right">IR:</td>
                       <td align="left"><input name="ir" type="text" class="combo_cadastro" id="ir" value="<? echo $_REQUEST[ir] ?>"size="5"</td>
                                                   
  
                      </tr>
                    </table>





                    <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                  <tr class="texto">
                       <td colspan="2" width="100%"><div align="left">&nbsp;&nbsp;Dimensões (cm):</div></td>
                    </tr>
                    <tr class="texto_bold">
                       <td  colspan="0"  width="30%" class="texto_bold"><div align="right">Externas:</div></td>
                       <td  colspan="0" width="45%" align="right">Altura:&nbsp;&nbsp;<input name="altura_externa" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="altura_externa"  value="<? echo number_format($altura_externa,2,',','.'); ?>"  size="6"></td>
                       <td  colspan="0" width="15%">Largura:&nbsp;&nbsp;<input name="largura_externa" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="largura_externa"   value=" <? echo number_format($largura_externa,2,',','.'); ?>" size="6"></td>
                       <td  colspan="0" width="40%">Profundidade:&nbsp;&nbsp;<input name="profundidade_externa" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="profundidade_externa"  value=" <? echo number_format($profundidade_externa,2,',','.');?>" size="6"></td>
                    </tr>
                    <tr class="texto_bold">
                       <td colspan="0"  width="30%" class="texto_bold"><div align="right">Internas:</div></td>
                       <td  colspan="0" width="45%" align="right">Altura:&nbsp;&nbsp;<input name="altura_interna" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="altura_interna"  value=" <? echo number_format($altura_interna,2,',','.'); ?>" size="6"></td>
                       <td  colspan="0" width="15%">Largura:&nbsp;&nbsp;<input name="largura_interna" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="largura_interna"  value=" <? echo number_format($largura_interna,2,',','.'); ?>" size="6"></td>
                       <td  colspan="0" width="40%">&nbsp;</td>
                     </tr>
                    <tr class="texto_bold">
	          <td colspan="0"  width="20%" class="texto_bold"><div align="right">&nbsp;</div></td>
                        <td colspan="0" width="45%" align="right">Peso(kg):&nbsp;&nbsp;<input name="peso" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="peso"  value="<? echo number_format($peso,2,',','.'); ?>" size="6"></td>
                        <td colspan="0" width="40%"><span class="texto_bold"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Formato:&nbsp;&nbsp;</a><select name="formato" class="combo_cadastro" id="formato">
  			    <option value="" <? if($formato=='') echo "selected" ?>></option>
  			    <option value="C" <? if($formato=='C') echo "selected" ?>>Circular</option>
  			    <option value="I" <? if($formato=='I') echo "selected" ?>>Irregular</option>
  			    <option value="L" <? if($formato=='L') echo "selected" ?>>Los&acirc;ngico</option>
  			    <option value="O" <? if($formato=='O') echo "selected" ?>>Oval</option>
                            <option value="T" <? if($formato=='T') echo "selected" ?>>Triangular</option>
			 </select></span>
                      </td>
                   </tr>
                   </table>


                    <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                        <tr>
                           <td  width="60%" class="texto_bold" valign="top"><div align="right">&nbsp;&nbsp;&nbsp;Observação:</div></td>
                           <td><textarea name="observacao" cols="80" rows="3" wrap="VIRTUAL" class="combo_cadastro" id="observacao"><? echo $observacao ?></textarea></td>
                        </tr>
                      </table>

                    <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                      <tr width="100%">
                      <tr class="texto_bold">                      
                         <td width="20%"><div align="right">&nbsp;&nbsp;&nbsp;Atualizado por:</div></td>
                        <td width="50%"><div align="right"><input name="atualizado"  readonly="1" type="text" class="combo_cadastro" id="atualizado" value="<? echo  $atualizado ?>" size="45"></div></td>
                        <td width="10%"><div align="right">em:</div></td>
                        <td width="20%"><div align="right""><input name="data_catalog2"  readonly="1" type="text" class="combo_cadastro" id="data_catalog2" value="<? echo   $data_catalog2?>" size="15"></div></td>
                      </tr>
                      <tr class="texto_bold">                      
                         <td width="20%"><div align="right">&nbsp;&nbsp;&nbsp;Catalogado por:</div></td>
                        <td width="50%"><div align="right"><input name="catalogado"  readonly="1" type="text" class="combo_cadastro" id="catalogado" value="<? echo  $catalogado ?>" size="45"></div></td>
                        <td width="10%"><div align="right">em:</div></td>
                        <td width="20%"><div align="right"><input name="data_catalog1"  readonly="1" type="text" class="combo_cadastro" id="data_catalog1" value="<? echo  $data_catalog1 ?>" size="15"></div></td>
                      </tr>
                      </table>

                 </div>  



               
              <!-- ABA 2 : Estado de conservacao -->
              <div id="quadro2" class="divi1" style="display:; width:540px; ">

                    <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#f2f2f2">
                     <tr width="100%">
                        <tr class="texto_bold">                      
                         <td width="60%"><div align="right">&nbsp;&nbsp;&nbsp;Suporte:</div></td>
                        <td width="40%"><div align="right"><input name="sup_restmold" type="text" class="combo_cadastro" id="sup_restmold" value="<?  if ($sup_restmold==''){ echo  $suporte;}else{echo $sup_restmold;}?>" size="78"></div></td> 
                      </tr>
                      <tr class="texto_bold">                    
                         <td width="60%"><div align="right"><input type="checkbox" name="tem_ornamento" id="tem_ornamento" value="S" onClick="muda_modelo(3); this.focus();" <? if($tem_ornamento=='S') echo "checked" ?>>&nbsp;&nbsp; Ornamento:</div></td>
                         <?if($tem_ornamento=='S') {?><td width="40%" id="orna_restmold" style="display:yes; font-weight:normal;"><divalign="right"><input name="orna_restmold"   type="text" class="combo_cadastro" id="orna_restmold" value="<? if ($orna_restmold==''){ echo  $ornamento;}else{echo $orna_restmold;} ?>" size="78"></div></td>
                         <?}else{?><td width="40%" id="orna_restmold" style="display:none; font-weight:normal;"><div align="right"><input name="orna_restmold"   type="text" class="combo_cadastro" id="orna_restmold" value="<?if ($orna_restmold==''){ echo  $ornamento;}else{echo $orna_restmold;}?>" size="78"></div></td><?}?>

                      </tr>
                      <tr class="texto_bold">                      
                         <td width="60%"><div align="right"><input type="checkbox" name="tem_acabamento" id="tem_acabamento" value="S" onClick="muda_modelo(3); this.focus();" <? if ($tem_acabamento == 'S') echo "checked"; ?>>Acabamento:</div></td>
                         <?if($tem_acabamento=='S') {?><td width="40%"  id="acab_restmold" style="display:yes; font-weight:normal;"><div align="right"><input name="acab_restmold"  type="text" class="combo_cadastro" id="acab_restmold" value="<?  if ($acab_restmold==''){ echo  $acabamento;}else{echo $acab_restmold;} ?>" size="78"></div></td>
                        <?}else{?><td width="40%" id="acab_restmold" style="display:none; font-weight:normal;"><div align="right"><input name="acab_restmold"   type="text" class="combo_cadastro" id="acab_restmold" value="<?  if ($acab_restmold==''){ echo  $acabamento;}else{echo $acab_restmold;}?>" size="78"></div></td><?}?>
                       </tr>
                     </tr>
                     </table>
   

                     <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#f2f2f2">
                     <tr width="100%">
                        <td colspan="3" width="70%" class="texto_bold">&nbsp;&nbsp;&nbsp;
					 Termos de conserva&ccedil;&atilde;o:
			 <select name="termos" id='termos' class="combo_cadastro" onChange="Add('texto_estado',this.form.termos.options[this.form.termos.selectedIndex].value);">
					<option value=""></option>
					<? $sql="select distinct(termo) from termo_moldura_estado order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
					  <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                      <? } ?>
					  </select></td>
                    </tr>
                    </table>
 
                     <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#f2f2f2">
                     <tr width="100%" class="texto_bold">
                      <td width="83" valign="top" align="right">Estado:</td><td colspan="4" class="texto_bold"><textarea name="texto_estado" cols="83" rows="10" wrap="VIRTUAL" class="combo_cadastro" id="texto_estado"><? echo $conservacao ?></textarea></td>
                    </tr>
                  </table>

              </div>  
                       
			  <!-- ABA 3 : -->
              <div id="quadro3" class="divi1" style="display:; width:540px; ">
                <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#f2f2f2">
                  <tr>
                    <td colspan="3" width="30%" class="texto_bold">&nbsp;&nbsp;&nbsp;Termos
                        para Tratamento:</td>
                    <td width="70%" align="left" class="texto_bold">
					 <select name="termos2" id='termos2' class="combo_cadastro" onChange="Add('text_tratamento',this.form.termos2.options[this.form.termos2.selectedIndex].value);">
					<option value="" selected></option>
					<? $sql="select distinct(termo) from termo_moldura_tratamento order by termo asc";
					   $db->query($sql);
					   while($res=$db->dados()){
					 ?>
					  <option value="<? echo $res['termo'] ?>"><? echo $res['termo'] ?></option>
                      <? } ?>
				      </select></td>
                  </tr>
                  </table>

                  <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#f2f2f2">
                     <tr width="100%" class="texto_bold">
                   
                        <td width="83" valign="top" align="right">Tratamento:</td>
                              <td colspan="4" class="texto_bold"><textarea name="text_tratamento" cols="80" rows="10" wrap="VIRTUAL" class="combo_cadastro" id="text_tratamento"><? echo $tratamento ?></textarea>
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;Restaurador: 
                      <input name="assinatura" type="text" class="combo_cadastro" id="assinatura" value="<? echo htmlentities($assinatura, ENT_QUOTES); ?>" size="70">
                      <a href="javascript:;" onClick="abrepop('pop_restaurador.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a></p></td>
                    </tr>
                  </table>


                   <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                      <tr width="100%"><br>
                      <tr class="texto_bold">                      
                       <td colspan="2" class="texto_bold"><div align="right">Data de Entrada:</div></td>
                      <td class="texto_bold"><input name="data_entrada" type="text" class="combo_cadastro"  id="data_entrada" value="<? echo $data_entrada ?>" size="10">
			&nbsp; In&iacute;cio:&nbsp;
			<input name="data_inicio"  type="text" class="combo_cadastro" id="data_inicio" value="<? echo $data_inicio ?>" size="10">
			&nbsp;Sa&iacute;da:
			<input name="data_saida" type="text" class="combo_cadastro" id="data_saida"  value="<? echo $data_saida ?>" size="10"></td>
                    </tr>
                      </table>


               <table width="100%" id="rodape" border="0" style="background-color: #f2f2f2;">
                  <tr>
                   <td width="100%" align="center"><input align='middle' name="submit" style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?>" type="submit" class="botao" value="Gravar">
                     <input name="op" type="hidden" value="<? echo $op ?>">
                  </td>
                 </tr>
               </table>
              </div>
	      <!-- ABA 4 : -->
	         <div id="quadro4" class="divi1" style="display:; width:540px; ">
                  <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#f2f2f2">

                       <tr>
			 <? if($_REQUEST['id']<>''){ 
			       echo "<iframe name='abas' align='middle' src='restauro_imagem.php?id=$_REQUEST[id]&op=$_REQUEST[op]' width='520' height='340' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
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
// global $db,$msg_dest;
 
 $sql_fixo="SELECT a.material_tecnica as mat,a.altura_interna as alt,largura_interna as larg,altura_externa as imp_alt,largura_externa as imp_larg
			FROM moldura AS a, restauro AS b WHERE a.moldura=b.moldura AND b.restauro='$id_restauro'";
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
  		$texto.='Nº DE REGISTRO:'.$_REQUEST['pNum_registro']. '- Objeto: '.$_REQUEST['nome_objeto']. '- Sequencial:'.$_REQUEST['seq_restauro'].'\n';
  		$texto.='TÍTULO:'.$_REQUEST['titulo'].'\n';
  		$texto.='ALTERAÇÕES:\n';
  		$texto.=$msg_dest;
   		$dataInc= date("Y-m-d");
   		$assunto='Ficha de Restauro-Nº de registro:'.$_REQUEST['pNum_registro'].'';
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
 if($_REQUEST[altura_interna]=='')
  { $_REQUEST[altura_interna]='0.00';}
 if($_REQUEST[largura_interna]=='')
  { $_REQUEST[largura_interna]='0.00';}
 if($_REQUEST[altura_externa]=='')
  { $_REQUEST[altura_externa]='0.00';}
 if($_REQUEST[profundidade_externa]=='')
  { $_REQUEST[profundidade_externa]='0.00';}

      $tecnico= $_REQUEST['tecnico'];

          $sql="UPDATE restauro set 
            ir='$_REQUEST[ir]',
         tombo='$_REQUEST[tombo]',
   propriedade='$_REQUEST[propriedade]',
  seq_restauro='$seq',
       tecnica='$material_tecnica',
       tecnico='$tecnico',
           obs='$obs',
  data_entrada='".explode_data($_REQUEST[data_entrada])."',
   data_inicio='".explode_data($_REQUEST[data_inicio])."',
    data_saida='".explode_data($_REQUEST[data_saida])."'
where restauro='$_REQUEST[id]'";
   $db->query($sql);


  $sql="UPDATE restauro_moldura set 
           assinatura='$_REQUEST[assinatura]',
   estado_conservacao='$_REQUEST[texto_estado]',
           tratamento='$_REQUEST[text_tratamento]',
           acabamento='$_REQUEST[acab_restmold]',
              suporte='$_REQUEST[sup_restmold]',
            ornamento='$_REQUEST[orna_restmold]'
       where restauro='$_REQUEST[id]'";

   $db->query($sql);



  

$val_altura_externa=formata_valor_1($_REQUEST['altura_externa']);
$val_largura_externa=formata_valor_1($_REQUEST['largura_externa']);
$val_profundidade_externa=formata_valor_1($_REQUEST['profundidade_externa']);

$val_altura_interna=formata_valor_1($_REQUEST['altura_interna']);
$val_largura_interna=formata_valor_1($_REQUEST['largura_interna']);

$val_peso=formata_valor_1($_REQUEST['peso']);



  $sql2="UPDATE moldura set

     observacao='$_REQUEST[observacao]',
     formato='$_REQUEST[formato]',
     material_tecnica='$_REQUEST[material_tecnica]',
     altura_interna='$val_altura_interna',
     largura_interna='$val_largura_interna',
     altura_externa='$val_altura_externa',
     largura_externa='$val_largura_externa',
     profundidade_externa='$val_profundidade_externa',
     peso='$val_peso',
     num_registro='$_REQUEST[num_registro]',
     controle='$_REQUEST[controle]',
     propriedade='$_REQUEST[propriedade]',
     tem_ornamento='$_REQUEST[tem_ornamento]',
     tem_acabamento='$_REQUEST[tem_acabamento]'
     where moldura='$moldura'";
   
     $db->query($sql2);
     compara_valores($_REQUEST['id']); 

     echo "<script>location.href='restauracao_moldura_externa.php?op=update&op_restauro=update&id=$idrest&tipo2=$tipo2&moldura=$_REQUEST[moldura]&mold_registro=$_REQUEST[mold_registro]'</script>";
     exit(); 

   }
 }     
 else // se form um insert......
 {
  if($_REQUEST[tipo2]=='1')
  {
    $sql="select obra from obra where num_registro='$_REQUEST[pNum_registro]'";
    $db->query($sql);
    $res=$db->dados();
    $obra=$res[0];
    $interna='I';
//   compara_valores();
    }
 
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

 if($_REQUEST[altura_obra]=='')
  { $_REQUEST[altura_obra]='0.00';}
 if($_REQUEST[largura_obra]=='')
  { $_REQUEST[largura_obra]='0.00';}
 if($_REQUEST[altura_imagem]=='')
  { $_REQUEST[altura_imagem]='0.00';}
 if($_REQUEST[largura_imagem]=='')
  { $_REQUEST[largura_imagem]='0.00';}

	$tecnico= $_REQUEST['tecnico'];
  
$sql="INSERT INTO restauro(seq_restauro,ir,obra,interna,parte,controle,tipo,nome_objeto,autor,titulo,tombo,altura,largura,tecnica,colecao,
 obs,data_entrada,data_inicio,data_saida,tecnico,propriedade, moldura)
  values('$seq','$_REQUEST[ir]','0','$tipo2_2','0','$_REQUEST[controle]','4','$_REQUEST[nome_objeto]','$_REQUEST[autor]','$_REQUEST[titulo]','$_REQUEST[tombo]',
 '".formata_valor(trim($_REQUEST[altura_obra]))."','".formata_valor(trim($_REQUEST[largura_obra]))."','$_REQUEST[tecnica]','$_REQUEST[colecao]','$_REQUEST[obs]',
 '".explode_data($_REQUEST[data_entrada])."','".explode_data($_REQUEST[data_inicio])."','".explode_data($_REQUEST[data_saida])."','$tecnico','$_REQUEST[propriedade]','$_REQUEST[moldura]')"; 
 //Atualizacao do IR - Sobrepoe pelo ID do registro de Restauracao

  $db->query($sql);
  $idrest=$db->lastid();
  $id= $idrest;
  $_REQUEST[op_restauro]='update';
  
  $sql3="INSERT INTO restauro_moldura(restauro,assinatura,estado_conservacao, tratamento, acabamento, ornamento, suporte)
  values('$idrest','$_REQUEST[assinatura]','$_REQUEST[texto_estado]','$_REQUEST[text_tratamento]','$_REQUEST[acab_restmold]', '$_REQUEST[orna_restmold]', '$_REQUEST[sup_restmold]')";
  $db->query($sql3);
  compara_valores($idrest);


$val_altura_externa=formata_valor_1($_REQUEST['altura_externa']);
$val_largura_externa=formata_valor_1($_REQUEST['largura_externa']);
$val_profundidade_externa=formata_valor_1($_REQUEST['profundidade_externa']);

$val_altura_interna=formata_valor_1($_REQUEST['altura_interna']);
$val_largura_interna=formata_valor_1($_REQUEST['largura_interna']);

$val_peso=formata_valor_1($_REQUEST['peso']);
  $sql4="update moldura set
              material_tecnica='$_REQUEST[material_tecnica]',
              altura_interna='$val_altura_interna',
              largura_interna='$val_largura_interna',
	      altura_externa='$val_altura_externa',
              largura_externa='$val_largura_externa',
              profundidade_externa='$val_profundidade_externa',
              formato='$_REQUEST[formato]',
              peso='$val_peso',
              atualizado='$_SESSION[susuario]',
              data_catalog2=now(), 
              observacao='$_REQUEST[observacao]',

              num_registro='$_REQUEST[num_registro]',
              controle='$_REQUEST[controle]',
              propriedade='$_REQUEST[propriedade]',
              tem_ornamento='$_REQUEST[tem_ornamento]',
              tem_acabamento='$_REQUEST[tem_acabamento]'
              where moldura='$_REQUEST[moldura]'";
        $db->query($sql4);
   if ($_REQUEST[ir]<>'') echo "<script>location.href='restauracao_moldura_externa.php?chama=$chama&filtro=$filtro&op=update&op_restauro=update&id=$idrest&tipo2=$tipo2&pNum_registro=0&pId_parte=0&moldura=$_REQUEST[moldura]&mold_registro=$_REQUEST[mold_registro]'</script>";
     exit(); 

 
  }
  }
}
?>