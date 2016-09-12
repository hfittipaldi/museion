<html>
<head>
<title>Lista de Estados:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('usuario.php?page='+ i);
}}
</script>

</head>

<body>
<table width="219"  border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td width="203" valign="top"><form name="form1" method="post">
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td height="24" bgcolor="#96ADBE" class="texto_bold"><div align="left"> &nbsp;Lista
              de &lt; Estados &gt;</div>            
            <div align="center"></div>            <div align="center"></div>            <div align="center"></div></td>
          </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="133%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCFF">
        <tr class="texto">
          <td colspan="4" align="" class="texto">
	          <div align="center">
          <?
		   include("classes/classe_padrao.php");
           include("classes/funcoes_extras.php");
           $db=new conexao();
           $db->conecta();
		   $sql="select DISTINCT uf,nome from estado ORDER by uf asc";
		   $db->query($sql);
		   echo" <select name='ufestado[]' id='ufestado' size='5' multiple class='combo_cadastro' >";
		   while($row=$db->dados())
		   {
		     echo "<option value='$row[uf]'>$row[uf]-$row[nome]</option>";
             $res[]=$row[0];
			}
        if($_REQUEST[submit]<>'')
             {
                $res=$_REQUEST[ufestado];
             for($i=0;$i<count($res);$i++)
			 {
                     $var=$res[$i];
                   if($i+1 <count($res))
                      $var.=",";
                      $k.=$var;
			   }
         
		       echo "<script>opener.window.document.frmautor.estadoatua.value='$k';</script>";
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
        <tr bgcolor="#336799" class="texto">
          <td colspan="4">               
            <div align="center"></div></td>
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

