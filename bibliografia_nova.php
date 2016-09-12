<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
 

       <?
          require("classes/classe_padrao.php");
          include("classes/funcoes_extras.php");
          $db=new conexao();
          $db->conecta();
          $dbreg=new conexao();
          $dbreg->conecta();
          $autoria=$_REQUEST[autoria];
          $referencia=$_REQUEST[referencia];
         ?>

</head>
<script>

function fecha_pop()
{
 setTimeout('window.close()',60000);
 return true;
}
function obtem_valor(qual) {
	if (qual.selectedIndex.selected != '') {
                document.location=('bibliografia_manut.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i&nome=<?echo $_REQUEST[nome]?>);


	}
}
function valida()
{
 with(document.form1)
 {
    if(autoria.value==''){
	  alert('Informe a autoria.');
	  autoria.focus();
	  return false;}
    if(descricao.value==''){
	  alert('É necessário preencher com a referência!');
	  descricao.focus();
	  return false;}
  }
}
</script>
<body onLoad="fecha_pop()";>

      
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

        <tr class="texto_bold" style="color: navy;" >
          <td><div align="right"><br>Autoria*:</div></td>
          <td colspan="2"><br><input name="autoria" type="text" class="combo_cadastro" id="autoria" value="<? echo htmlentities($_REQUEST['autoria'], ENT_QUOTES); ?>" size="80"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">ISBN:</div></td>
          <td colspan="2"><input name="isbn" type="text" class="combo_cadastro" id="isbn" value="<? echo htmlentities($_REQUEST['isbn'], ENT_QUOTES); ?>" size="40"> </td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Referência*:</div></td>
        <? if(($_REQUEST[op]=='insert')and ($res['referencia']=='')){?>
             <td width="50%" colspan="2"><input name="referencia" type="text" class="combo_cadastro" id="referencia" value='<?echo $_REQUEST[referencia]?>' size="80"></td>
        <? }else{?>
            <td width="50%" colspan="2"><input name="referencia" type="text" class="combo_cadastro" id="referencia" value='<? echo htmlentities($_REQUEST['referencia'], ENT_QUOTES); ?>' size="80"></td>
        <? }?>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Local:</div></td>
          <td width="50%" colspan="2"><input name="local" type="text" class="combo_cadastro" id="local" value='<? echo htmlentities($_REQUEST['local'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Editora:</div></td>
          <td width="50%" colspan="2"><input name="editora" type="text" class="combo_cadastro" id="editora" value='<? echo htmlentities($_REQUEST['editora'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Ano*:</div></td>
          <td width="50%" colspan="2"><input name="ano" type="text" class="combo_cadastro" id="ano" value='<? echo htmlentities($_REQUEST['ano'], ENT_QUOTES); ?>' size="5">
		 <em> (preencha com '0' para referência sem data)</em></td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr>
    	   <td>&nbsp; </td>
         </tr>
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
        <tr width="100%" class="texto_bold" style="color: navy;">          
            <br><td align="left" colspan="2">&nbsp;(*) Campos obrigatórios</td>
        </tr>
      </table>
  <?
     if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}

     if ($_REQUEST['cancelar']<>'')
        echo"<script>window.close()</script>";
     
     if ($_REQUEST['enviar']<>'')
     {
         if($_REQUEST[autoria]=='')  { 
            echo"<script>alert('Informe a autoria.')</script>"; 
         }else{
            if($_REQUEST[referencia]==''){ echo"<script>alert('É necessário preencher com a referência!')</script>";
            }else{
              $sql= "INSERT INTO bibliografia(referencia,isbn,autoria,txt_legado,local,editora,data,ano) 
	      values('$_REQUEST[referencia]','$_REQUEST[isbn]','$_REQUEST[autoria]','','$_REQUEST[local]','$_REQUEST[editora]','','$_REQUEST[ano]')";
	      $db->query($sql);
	      $idbib=$db->lastid(); //id da bibliografia
	      //Vinculo 
	      $sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	      $db->query($sql);
	      $nome=$db->dados();

              echo"<script>alert('Inclusão realizada com sucesso.')</script>";
              echo"<script>window.close()</script>";

            }
         }


      }
         
 

   
?>
</form>
</td>
  </tr>
</table>
</body>
</html>