<?
include_once("seguranca.php");
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$sql="insert into obra(num_registro) values($_REQUEST[num])";
$db->query($sql);
echo"<script>location.href='cadastrobra.php?num=$_REQUEST[num]'</script>";
//header("Location:cadastrobra.php?num=$_REQUEST[num]");
//Necessario para insercao previa do registro num_registro
?>
