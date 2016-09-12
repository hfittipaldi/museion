<?
//@ Cadastro de Usuarios do Donato
require("./classe_padrao.php");

//if(isset($acao)=='cadastrar')
//{
/*
$sql="INSERT INTO usuario('nome','login','senha','dianiver','mesniver') 
values('".$_REQUEST['nome']."','".$_REQUEST['login']."','".$_REQUEST['senha']."','".$_REQUEST['dianiver']."','".$_REQUEST['mesniver']."')";
echo $sql;	
*/
$sql="INSERT INTO usuario('nome','login','senha','dianiver','mesniver') values('manuela','manu','abc123','23','08')";

$db=new conexao();
$db->conecta();
$db->query($sql);
echo "<script>alert('Cadastro efetuado com sucesso!')</script>";
echo "<script>location.href='cadastro_usuario.php'</script>";
//}

?>
