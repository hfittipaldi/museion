<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>
</script>  
</head>

<body>      
<form name="form1" method="post" onSubmit='return valida();' >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$expid=$_REQUEST[id];
$nome=$_REQUEST[nome];   
$whereNome="(nome like '%$nome%') and";          

      if($_REQUEST[op]=='delexp') {
	   $sql= "DELETE from exposicao where exposicao = '$_REQUEST[id]'";
	   $db->query($sql);
           echo"<script>alert('Exclusão realizada com sucesso')</script>";
	   echo "<script>location.href='exposicao_manut.php?acao=1';</script>";

      }

      if ($_REQUEST[op] == 'del') {

         $sql="DELETE FROM exposicao WHERE ".$whereNome." (exposicao not in (select exposicao from obra_exposicao)) and
                                                    (exposicao not in (select exposicao from autor_exposicao)) and 
                                            (exposicao not in (select exposicao from movimentacao_exposicao))";

         $db->query($sql);
	 echo "<script>alert('Exclusão realizada com sucesso.');</script>";
	 echo "<script>location.href='exposicao_manut.php?acao=1';</script>";

       }



?>
</form>
</body>
</html>