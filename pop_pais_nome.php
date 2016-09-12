<html>
<head>
<title>Lista de Países:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

</head>

<body>
<table width="150"  border="0" align="center" cellpadding="0" cellspacing="8" bgcolor="cccccc" >
  <tr>
    <td width="143" valign="top"><form name="form1" method="post">
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td height="24" bgcolor="#96ADBE" class="texto_bold"> <div align="left">&nbsp; Pa&iacute;ses</div></td></tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  W border="0" cellpadding="0" cellspacing="2" bgcolor="#cccccc" h>
        <tr class="texto">
          <td colspan="4" align="" class="texto">
	          <div align="left">
          <?
		   include("classes/classe_padrao.php");
           include("classes/funcoes_extras.php");
           $db=new conexao();
           $db->conecta();
		   $sql="SELECT DISTINCT(nome) from pais order by nome asc";
		   $db->query($sql);
		   echo" <select name='nome' id='nome' size='5' multiple class='combo_cadastro'  >";
		   while($row=$db->dados())
		   {
		     echo "<option value='$row[nome]'>$row[nome]</option>";
             $res[]=$row[0];
			}
        if($_REQUEST[submit]<>'')
             {
                $res=$_REQUEST['nome'];
         
		       echo "<script>opener.window.document.frmautor.$_REQUEST[pais].value='$res';</script>";
			   echo"<script>window.close()</script>";
		}
		   ?>
              </div></td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"></td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"><input name="submit" type="submit" class="botao" value="ok" ></td>
          </tr>
        <tr class="texto">
          <td width="50%"></td>
          <td width="26%"></td>
          <td width="12%"></td>
          <td width="12%"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <span class="texto">       </span>
       <p>
     <input name="usuario" type="hidden" id="usuario" value="<? echo $usuario ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
		  <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>

