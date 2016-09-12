<?
session_name("Donato");
session_start();
require("classes/classe_padrao.php");
$db=new conexao();
$db->conecta();

function efetua_login()
{  
  global $db;
  $sql="select nome,usuario from usuario as a where a.login='$_REQUEST[nome]' and a.senha='$_REQUEST[senha]'
  and a.status='S'";
$db->query($sql);
$conta=$db->contalinhas();
$total=$db->dados();
 if($conta>0)
  {
  
   $_SESSION['snome']=$total[0];
   $_SESSION['susuario']=$total[1];
   //session_register("snome");
   //session_register("susuario");
   header("Location: principal.php"); 
  }
 else
 {
   echo"<script>alert('Usuário não autorizado!')</script>";
   echo"<script>location.href='index.php'</script>";
}
}
 efetua_login();
?>



