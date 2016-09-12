<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>

</script>  
</head>

<body>      
<form name="form1" method="post" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$nome=$_REQUEST[nome];   
$whereNome="(referencia like '%$nome%') and";

if($_REQUEST['op']=='delbib')
{
 $sql="DELETE from bibliografia where bibliografia='$_REQUEST[id]'";
 $db->query($sql);

 echo"<script>alert('Exclusão realizada com sucesso')</script>";
 echo"<script>location.href='bibliografia_manut.php?acao=1';</script>";
 }


 if ($_REQUEST[op]=='del') {

    $sql="DELETE FROM bibliografia WHERE ".$whereNome." (bibliografia not in (select bibliografia from obra_bibliografia)) and
                                                    (bibliografia not in (select bibliografia from autor_bibliografia))";
    $db->query($sql);
    echo "<script>alert('Exclusão realizada com sucesso.');</script>";
    echo "<script>location.href='bibliografia_manut.php?acao=1';</script>";

   }



?>
</form>

</body>
</html>