<html>
<head>
<title>Bloco de Notas de Obra</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function fecha_pop()
{
 setTimeout('window.close()',60000);
 return true;
}
function cancela()
{
 document.form1.cancelar.submit=window.close();
return true;
}
</script>
<style type="text/css">
<!--
body {
	background-color: #ddddd5;
}
-->
</style></head>

<body>
<table width="259"  border="0" align="center" cellpadding="0" cellspacing="8" bgcolor="ddddd5" >
  <tr>
    <td width="243" valign="top"><form name="form1" method="post">
          <?
		include("classes/classe_padrao.php");
           	include("classes/funcoes_extras.php");
		$db=new conexao();
		$db->conecta();
                $obra=$_REQUEST[obra];
                $catalogador=1;
		$obra=1;
                if($_REQUEST[submit]<>'')
                {
			$texto=$_REQUEST[texto];
			$sql="update bloco_notas set texto=$texto where obra=$obra and catalogador=$catalogador";
			$db->query($sql); 
			echo"<script>window.close()</script>";
		}
		$sql="select count(*) as total from bloco_notas where obra=$obra and catalogador=$catalogador";
                $db->query($sql);
		$resp=$db->dados();
		$total=$resp['total'];
		if ($total < 1 ) {
			$sql="insert into bloco_notas (obra, catalogador,texto) values($obra, $catalogador,'')";
			$db->query($sql);
		}
		$sql="select texto from bloco_notas where obra=$obra and catalogador=$catalogador";
		$db->query($sql);
		$resp=$db->dados();
		$texto=$resp['texto'];
		echo"<TEXTAREA COLS=50 ROWS=15 NAME='texto'>";
                echo $texto;
		echo "</TEXTAREA>";

           ?>
   </td></tr>
   <td>
        <tr class="texto">
          <td colspan="2" align="center" class="texto">
            <div align="center">
              <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar" onClick="cancela()">
            </div></td>
          <td align="center" class="texto">
              <div align="center">
                <input name="submit" type="submit" class="botao" value="Confirmar" >
              </div></td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>

</table>
</body>
</html>