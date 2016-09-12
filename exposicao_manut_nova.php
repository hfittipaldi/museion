<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>

function valida() {
 with(document.form1)
 {
 if ($_REQUEST['cancelar']<>''){
    if(tipo.value==''){
	  alert('Preencha com o tipo da exposição.');
	   return false;}
	 if(nome.value==''){
	   alert('Preencha com o nome da exposição.');
	    nome.focus();
	  return false;}
	if (!Validar_Campo_Data(dt_inicial,false)) {
		alert('Preencha corretamente o campo "data início"!'); dt_inicial.focus(); return false;
	}
	if (!Validar_Campo_Data(dt_final,false)) {
		alert('Preencha corretamente o campo "data fim"!'); dt_final.focus(); return false;
	}
    }
  }
}
function abrepop(janela)
{
	win=window.open(janela,'lista','left='+((window.screen.width/2)-175)+',top='+((window.screen.height/2)-175)+',width=350,height=350, scrollbars=yes, resizable=no');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}



</script>  
</head>

<body>      
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$dbreg=new conexao();
$dbreg->conecta();

$exposicao=$_REQUEST[nome];

$movid= $_REQUEST['movid'];
$obrid= $_REQUEST['obrid'];
$autid= $_REQUEST['autid'];
$id= $_REQUEST['id'];
$op= $_REQUEST['op'];


if ($_REQUEST['cancelar']<>'')
        echo"<script>window.close()</script>";


if($_REQUEST['enviar']<>'') 
{
   
   $dt_ref=seta_data($_REQUEST[dt_inicial]);
   if ($dt_ref == '') $dt_ref= "0000-00-00";

   $dt_ref2=seta_data($_REQUEST[dt_final]);
   if ($dt_ref2 == '') $dt_ref2= "0000-00-00";

   $sql= "INSERT into exposicao(tipo,dt_inicial,dt_final,nome,instituicao,pais,cidade,estado,periodo,txt_legado) 
       values('$_REQUEST[tipo]','$dt_ref','$dt_ref2','$_REQUEST[nome]','$_REQUEST[instituicao]','$_REQUEST[pais]','$_REQUEST[cidade]',
       '$_REQUEST[estado]','$_REQUEST[periodo]','')";

   $db->query($sql);
   $lastid= $db->lastid();

   echo"<script>alert('Inclusão realizada com sucesso.')</script>";
   echo"<script>window.close()</script>";

}


?>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1">

   <?echo "<span class='tit_interno'>$_SESSION[lnk]"." / Incluir"."</span>";?>
   <tr bgcolor="#ddddd5">
      <td  whidth="100%" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="300%"  height="1"></td>
   </tr>  

  <tr>
    <td width="512" height="318" valign="top">
       <form name="form1" method="post" onSubmit="return valida()" >
         <table width="103%"  border="0" cellpadding="0" cellspacing="4">
          <br>


   
        <tr class="texto_bold">
          <td width="15%">
               <div align="left" style="color: gray;">
	       <? if ($id <> '') { ?><b>Nº da Exposição: </b><? echo $id."<br>&nbsp;"; } ?></div>
	   </td>
	  <td width="35%">&nbsp;</td>
          </tr>

        <tr class="texto_bold">
          <td><div align="right">Tipo:</div></td>
          <td width="10%">
             <select name="tipo" class="combo_cadastro">
                <option value=''></option>
                <option value="C" <? if($row[tipo]=='C') echo "Selected" ?>>Coletiva</option>
                <option value="I" <? if($row[tipo]=='I') echo "Selected" ?>>Individual</option>
             </select>
          </td>
          <td width="50%" nowrap>Data início
            <input name="dt_inicial" type="text" class="combo_cadastro" id="dt_inicial" value="<? echo formata_data($row[dt_inicial]) ?>" size="10" maxlength="10">
			Data fim
			<input name="dt_final" type="text" class="combo_cadastro" id="dt_final" value="<? echo formata_data($row[dt_final]) ?>" size="10" maxlength="10">
            </td>
              <td width="35%">&nbsp;</td>
           </tr>

       

        <tr class="texto_bold">
          <td><div align="right">Nome:</div></td>

          <? if ($row['nome']==''){?>
             <td colspan="2"><input name="nome" type="text" class="combo_cadastro" id="nome" value='<? echo $exposicao; ?>' size="69"></td>
          <? }else{echo 'exposicao:'.$exposicao;?>

             <td colspan="2"><input name="nome" type="text" class="combo_cadastro" id="nome" value='<? echo htmlentities($row['nome'], ENT_QUOTES); ?>' size="69"></td>
          <? }?>
            <td width="35%">&nbsp;</td>
        </tr>

       

        <tr class="texto_bold">
          <td><div align="right">Institui&ccedil;&atilde;o</div></td>
          <td colspan="2"><input name="instituicao" type="text" class="combo_cadastro" id="instituicao" value="<? echo htmlentities($row['instituicao'], ENT_QUOTES); ?>" size="69" maxlength="255"></td>
           <td width="35%">&nbsp;</td>
        </tr>

       

        <tr class="texto_bold">
          <td><div align="right">Pa&iacute;s:</div></td>
          <td colspan="2">
             <select name="pais" class="combo_cadastro" id="pais">
            <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
              <option value="<? echo $res[0] ;?>" <? if($row['pais']==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
               <? } ?>
             </select>
           </td> 
              <td width="35%">&nbsp;</td>
        </tr>
 
      


        <tr class="texto_bold">
          <td><div align="right">Cidade: </div></td>
          <td colspan="2"><input name="cidade" type="text" class="combo_cadastro" id="cidade" value="<? echo htmlentities($row['cidade'], ENT_QUOTES); ?>" size="49" maxlength="100">
              &nbsp;Estado:
              <select name="estado" class="combo_cadastro" id="estado" >
              <? 
					  $sql="SELECT distinct estado,uf  from estado order by uf asc";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res2=$db->dados())
					  { 
					  ?>
             <option value="<? echo $res2[0];?>" <? if($row['estado']==$res2[0]) echo "Selected" ?>><? echo $res2['uf']; ?></option>
             <? } ?>
           </select>
          </td>
          <td width="35%">&nbsp;</td>
        </tr>


        <tr class="texto_bold">
          <td><div align="right">Per&iacute;odo:</div></td>
          <td colspan="2"><input name="periodo" type="text" class="combo_cadastro" id="periodo" value="<? echo htmlentities($row['periodo'], ENT_QUOTES); ?>" size="69" maxlength="150"></td>
          <td width="35%">&nbsp;</td>
       
        </tr>

        <tr><td width="35%">&nbsp;</td></tr>
        <tr><td width="35%">&nbsp;</td></tr>



        <tr class="texto_bold" style="color: navy;">
          <td colspan="1">&nbsp;</td>
          <td colspan="1" valign="top"><div align="center"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar" >
          </span></div></td>

          <td colspan="1" valign="top"><div align="center"><span class="texto_bold">
              <input name="cancelar" type="submit" class="botao" id="enviar" value="Cancelar" >
          </span></div></td>


          <td>&nbsp;</td>
        </tr>

      

        <tr class="texto_bold">
          <td colspan="3"><div align="right"></div></td>
        </tr>
        </table>

</form>
</td>
  </tr>
</table>
</body>
</html>