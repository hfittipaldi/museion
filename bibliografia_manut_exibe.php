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
	$sql="SELECT * FROM bibliografia where bibliografia=".$_REQUEST[id];
 	$db->query($sql);
        $row=$db->dados();
        $exposel=$row[nome]; 


        if($_REQUEST['enviar']<>'') {
       $sql="UPDATE bibliografia set
	        isbn='$_REQUEST[isbn]',
	     autoria='$_REQUEST[autoria]',
	  referencia='$_REQUEST[referencia]',
	  sub_titulo='$_REQUEST[sub_titulo]',
	       local='$_REQUEST[local]',
	     editora='$_REQUEST[editora]',
	       notas='$_REQUEST[notas]',
	  ano=$_REQUEST[ano] where bibliografia='$expid'";


         $db->query($sql);
	 echo"<script>alert('Alteração realizada com sucesso.')</script>";
	 echo "<script>location.href='bibliografia_manut.php?acao=1';</script>";  
          }
     
	?>

<body>

<table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" bgcolor=#f2f2f2>
  <tr>
       <td width="100" height="10" valign="top"><form name="form1" method="post" onSubmit="return valida()" >

       <tr class="texto_bold" style="color: gray;" > 
           <em> Detalhes da referência bibliográfica nº <? echo htmlentities($row['bibliografia'], ENT_QUOTES); ?></em>
        </tr>

         <tr class="texto_bold" style="color: navy;" >
          <td><div align="right"><br>Autoria*:</div></td>
          <td colspan="2"><br><input name="autoria" type="text" class="combo_cadastro" id="autoria" value="<? echo htmlentities($row['autoria'], ENT_QUOTES); ?>" size="80"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">ISBN:</div></td>
          <td colspan="2"><input name="isbn" type="text" class="combo_cadastro" id="isbn" value="<? echo htmlentities($row['isbn'], ENT_QUOTES); ?>" size="40"> </td>
          <td>&nbsp;</td>
        </tr>


        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Referência*: </div></td>
          <td width="50%" colspan="2"><input name="referencia" type="text" class="combo_cadastro" id="referencia" value='<? echo htmlentities($row['referencia'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>

        <tr class="texto_bold" style="color: black;">
          <td width="15%"><div align="right">Sub-título: </div></td>
          <td width="50%" colspan="2"><input name="sub_titulo" type="text" class="combo_cadastro" id="subtitulo" value='<? echo htmlentities($row['sub_titulo'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>


        <tr class="texto_bold">
          <td width="15%"><div align="right">Local:</div></td>
          <td width="50%" colspan="2"><input name="local" type="text" class="combo_cadastro" id="local" value='<? echo htmlentities($row['local'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>


        <tr class="texto_bold">
          <td width="15%"><div align="right">Editora:</div></td>
          <td width="50%" colspan="2"><input name="editora" type="text" class="combo_cadastro" id="editora" value='<? echo htmlentities($row['editora'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>

        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Ano*:</div></td>
          <td width="50%" colspan="2"><input name="ano" type="text" class="combo_cadastro" 
                 id="ano" value='<? echo htmlentities($row['ano'], ENT_QUOTES); ?>' size="5">
		 <em> (preencha com '0' para referência sem data)</em></td>
          <td width="50%">&nbsp;</td>
        </tr> 

        <tr>
          <td colspan="2" class="texto_bold" valign="top"><div align="right">Notas:</div></td>
          <td colspan="3"><textarea name="notas" cols="80" rows="4" wrap="VIRTUAL" class="combo_cadastro" id="notas"><? echo $row[notas] ?></textarea></td>
        </tr>


        <tr class="texto_bold">
           <? if ($row[txt_legado]<>'') { ?>
              <td><div align="right"></div></td>
                 <td colspan=2>
                    <textarea cols="80" rows="3" name="legado" class="combo_cadastro" style="border: 1px dashed;" readonly>
                       <? echo $row[txt_legado]; ?>
                    </textarea>                  
		  </td>
		  <? } else { ?>
		  <? } ?>
          

          </tr>    	    
     
         <tr class="texto_bold" style="color: navy;">
        </tr>
                       <tr class="texto_bold">
                          <td colspan="3"><div align="right">

                            <div align="left"><? echo "<a href=\"javascript:history.back();\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div>
                            <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar"></td>
                           </div>
                         </td>
                       </tr>

		       <input type="hidden" name="txtlegado" value="<? echo $row[txt_legado]; ?>">
		       <input type="hidden" name="<? echo $parametro; ?>" value="<? echo $valor; ?>">
		       <input type="hidden" name="op" value="<? echo $op; ?>">
		       <input type="hidden" name="id" value="<? echo $expid; ?>">

         <tr class="texto_bold" style="color: navy;">
          <td colspan="2">&nbsp;(*) Campos obrigatórios</td>
          <td>&nbsp;</td>
        </tr>
   </table>
</body>
</td>
</tr>
</table>
</tr>
</table>

</html>