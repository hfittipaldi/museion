<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
 <?
 $id=$_REQUEST['id']; 
	if($id=='')
	{
	//Necessario para se nao houver Id corrente ficar desabilitado
	echo "É necessário salvar primeiramente a ficha para que esta funcionalidade esteja habilitada!";
	//exit;
	 }
	else
	{ 
	 $path=$_SERVER['PHP_SELF'];
	 $file='';
	 $caminho=basename($path,'.php');
	  if($caminho=='exposicao_teste2')
	  {
	    $file='exposicao1.php';
		$label='EXPOSIÇÃO';
	  }
	  else
	  {
	   $file='bibliografia1.php';
	   $label='BIBLIOGRAFIA'; 
	  }
	 }
	//Esse metodo evita ter que criar 2 arquivos diferentes para verficar se existe/nao 
	//bibliografia/exposicao cadastrada para o autor corrente.
	?>
<body>
<table width="452"  border="0" align="left" cellpadding="0" cellspacing="8" >
  <tr>
    <td width="436" valign="top"><form name="form1" method="post" action="<? echo $file ?>?op=insert&id=<? echo $_REQUEST['id']?>">
  
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCFF">
        <tr class="texto">
          <td width="44%"></td>
          <td width="21%"></td>
          <td width="21%"></td>
          <td width="14%"></td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="texto"><div align="center"><strong>AUTOR SEM
                <? echo $label ?> CADASTRADA! </strong></div></td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="texto">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="texto"><div align="center">Para incluir
            clique no bot&atilde;o abaixo:</div></td>
          </tr>
        <tr bgcolor="#ccccff" class="texto">
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr bgcolor="#ccccff" class="texto">
          <td colspan="4"><div align="center">
            <input name="Submit" type="submit" class="botao" value="Incluir">
            <input name="id" type="hidden" id="id" value="<? echo $_REQUEST[id] ?>">
</div></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <br>
        <p>&nbsp;</p>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
