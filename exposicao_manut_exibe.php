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

document.location=('exposicao_manut_exibe.php?page='+ i+ 'id=<?echo $expid?>' );
}}

function valida() {
	for (i=0; i<document.form1.length; i++) {
		var tempobj= document.form1.elements[i];
		if (tempobj.type=='text' && tempobj.value!='') {
			return true;
		}
	}
	if (document.form1.prazo.checked || document.form1.ausente.checked)
		return true;
	alert('Informe pelo menos um parâmetro.');
	return false;
}
</script>  

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">


       <?
	include("classes/classe_padrao.php");
        include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
	$db1=new conexao();
	$db1->conecta();
        $expid= $_REQUEST['id'];
        $tipo="obra";       
	$sql="SELECT txt_legado,dt_inicial,dt_final,tipo,nome,instituicao,periodo,cidade,estado,pais FROM exposicao where exposicao=".$_REQUEST[id];
 	$db->query($sql);
        $row=$db->dados();
        $exposel=$row[nome]; 

        if($_REQUEST['enviar']<>'') {
                 $dt_ref=seta_data($_REQUEST[dt_inicial]);
	   if ($dt_ref == '')
	      $dt_ref= "0000-00-00";
           $dt_ref2=seta_data($_REQUEST[dt_final]);
	   if ($dt_ref2 == '')
	      $dt_ref2= "0000-00-00";
           $sql2= "UPDATE exposicao set 
	   tipo='$_REQUEST[tipo]',
	   dt_inicial='$dt_ref',
	   dt_final='$dt_ref2',
	   nome='$_REQUEST[nome]',
	   instituicao='$_REQUEST[instituicao]',
	   pais='$_REQUEST[pais]',
	   cidade='$_REQUEST[cidade]',
	   estado='$_REQUEST[estado]',
	   periodo='$_REQUEST[periodo]',
	   txt_legado='$_REQUEST[txtlegado]' where exposicao='$expid'";
	   $db->query($sql2);
	 echo"<script>alert('Alteração realizada com sucesso.')</script>";
	 echo "<script>location.href='exposicao_manut.php?acao=1';</script>";  
          }
     
	?>

<body>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
         <td valign="top"><form name="form1" method="get" onSubmit='true' action="exposicao_manut_exibe.php">
                 <tr>
                    <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
                       
                     
                       <tr class="texto_bold">
                          <td><div align="right">Tipo:</div></td>
                          <td width="10%">
                             <select name="tipo" class="combo_cadastro">
		                <option value=''></option>
                                <option value="C" <? if($row[tipo]=='C') echo "Selected" ?>>Coletiva</option>
                                <option value="I" <? if($row[tipo]=='I') echo "Selected" ?>>Individual</option>
                             </select>
                          </td>
                          <td width="29%" nowrap>Data início
                             <input name="dt_inicial" type="text" class="combo_cadastro" id="dt_inicial" value="<? echo formata_data($row[dt_inicial]) ?>" size="10" maxlength="10">
			      Data fim
                	     <input name="dt_final" type="text" class="combo_cadastro" id="dt_final" value="<? echo formata_data($row[dt_final]) ?>" size="10" maxlength="10">
                          </td>
                       </tr>

                       <tr class="texto_bold">
                          <td><div align="right">Nome:</div></td>
                          <td colspan="2"><input name="nome" type="text" class="combo_cadastro" id="nome" value='<? echo htmlentities($row['nome'], ENT_QUOTES); ?>' size="69"></td>
                       </tr>

                       <tr class="texto_bold">
                          <td><div align="right">Institui&ccedil;&atilde;o</div></td>
                          <td colspan="2"><input name="instituicao" type="text" class="combo_cadastro" id="instituicao" value="<? echo htmlentities($row['instituicao'], ENT_QUOTES); ?>" size="69" maxlength="255"></td>
                       </tr>
                       <tr class="texto_bold">
                         <td><div align="right">Pa&iacute;s:</div></td>


                            <td colspan="2"><select name="pais" class="combo_cadastro" id="pais">
                               <? 
			          $sql="SELECT distinct pais,nome from pais order by nome asc"; 
				  $db1->query($sql);
				  echo "<option value='0' ></option>";
				  while($res=$db1->dados())
			          {
			        ?>
                                <option value="<? echo $res[0] ;?>" <? if($row['pais']==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
                                 <? } ?>
                                </select></td>
                       </tr>

                       <tr class="texto_bold">
                          <td><div align="right">Cidade: </div></td>
                          <td colspan="2"><input name="cidade" type="text" class="combo_cadastro" id="cidade" value="<? echo htmlentities($row['cidade'], ENT_QUOTES); ?>" size="49" maxlength="100">
                          &nbsp;Estado:
                          <select name="estado" class="combo_cadastro" id="estado" >
                          <? 
					  $sql="SELECT distinct estado,uf  from estado order by uf asc";
					  $db1->query($sql);
					  echo "<option value='0' ></option>";
					  while($res2=$db1->dados())
					  { 
					  ?>
                            <option value="<? echo $res2[0];?>" 
                            <? if($row['estado']==$res2[0]) echo "Selected" ?>><? echo $res2['uf']; ?></option>
                               <? } ?>
                         </select></td>

                       </tr>   
                        <tr class="texto_bold">
                          <td><div align="right">Per&iacute;odo:</div></td>
                        <td colspan="2"><input name="periodo" type="text" class="combo_cadastro" id="periodo" value="<? echo htmlentities($row['periodo'], ENT_QUOTES); ?>" size="69" maxlength="150"></td>
                        </tr>
                        
 
                       <tr class="texto_bold">
		          <? if ($row[txt_legado]<>'') { ?>
                             <td><div align="right"></div></td>
                             <td colspan=2>
                                <textarea cols="60" rows="4" name="legado" class="combo_cadastro" style="border: 1px dashed;" readonly>
                                   <? echo $row[txt_legado]; ?>
                                </textarea>                   
                                <img src="imgs/icons/ic_ok.gif" style="cursor:pointer;" border="0" title="Apagar texto do Sistema Donato 2..4" onClick="if (confirm('Tem certeza que deseja apagar definitivamente o texto?')) {document.form1.txtlegado.value=''; document.form1.legado.style.display='none'; this.style.display='none'; document.getElementById('arealegado').innerHTML='<font style=color:#223366;>O texto será apagado quando a exposição for gravada.</font>';}">
			     </td>
		           <? } else { ?>
                              <td>&nbsp;</td>
		           <? } ?>
                           <td valign="top" align="right"><input name="enviar" type="submit" class="botao" id="enviar" value="Gravar"></td>
                       </tr>
                       <tr class="texto_bold">
                          <td colspan="3"><div align="right">

                            <div align="left"><? echo "<a href=\"javascript:history.back();\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
                         </div></td>
                       </tr>

		       <input type="hidden" name="txtlegado" value="<? echo $row[txt_legado]; ?>">
		       <input type="hidden" name="<? echo $parametro; ?>" value="<? echo $valor; ?>">
		       <input type="hidden" name="op" value="<? echo $op; ?>">
		       <input type="hidden" name="id" value="<? echo $expid; ?>">


              </form>
	   </td>
        </tr>
     </table>
     </table>
  </table>
</body>
</html>