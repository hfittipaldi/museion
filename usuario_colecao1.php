<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function critica()
{
 colecao=self.document.form1.idcolecao;
  if(colecao.value==''){
    alert('Favor selecionar pelo menos uma coleção.');
 return false; }
}
</script>  
</head>

<body>      
<table width="528" height="60%"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
	<td width="512"><div align="left" class="tit_interno">
<? 
echo $_SESSION['lnk']." - Coleções";
?>
	</div></td>
  </tr>
  <tr>
    <td width="512" height="318" valign="top"><form name="form1" method="post" onSubmit="" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$op=$_REQUEST['op']; 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr class="texto_bold">
          <td width="100%"><div align="center"><br><br>Cole&ccedil;&otilde;es</div></td>
          <td width="50%"><span class="texto">
          </span></td>
        </tr>
        <tr class="texto_bold" align="center" >
        
          <td><span class="texto">
            <?
		
		   echo" <select name='idcolecao[]' id='idcolecao' size=10 style='z-index:1; WIDTH: 400px;'  multiple class='combo_cadastro' >";
		   ///Colecoes daquele membro
		   $sql2="select b.nome,b.colecao from (colecao as b,usuario as a) 
		   inner join usuario_colecao as c on(a.usuario=c.usuario)
		    and (b.colecao=c.colecao) where a.usuario ='$_REQUEST[usuario]'";
		   
		   $db->query($sql2);
		   while ($res=$db->dados())
		   {
		     $col[]=$res['nome'];
		   }
		   
		   $total= count($col);
		   if($col[0]=='')
		    $total=0;
			 
		   $sql="select DISTINCT a.nome,a.colecao from colecao as a ORDER by a.nome asc";
		   $db->query($sql);
		  
		   while($row=$db->dados())
		   {
		      $sel= '';
			 for ($i=1;$i<=$total;$i++) {
				 if ($row['nome'] == $col[$i-1]) {
					 $sel= "selected";
					 break;
				 }
		   }
		     echo "<option value='$row[colecao]' $sel >$row[nome]</option>";
             $res[]=$row[0];
	    }
		   ?>
          </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><br><div align="center"><span class="texto_bold">
              <input name="submit" type="submit" class="botao" id="submit" value="Gravar">
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
            <div align="left"><br><? echo "<a href=\"usuario.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
        </tr>
      </table>
      
<? 
if ($_REQUEST['submit']<>'') {
   if ($_REQUEST[idcolecao]<>"")
      { 
         global $db;
         $idcolecao=$_REQUEST[idcolecao];
      }
 if($_REQUEST[op]=='update')
 {
    $sql="DELETE from usuario_colecao where usuario=$_REQUEST[usuario]";
    $db->query($sql);
 if ($_REQUEST[idcolecao]<>"")
 {
     foreach($idcolecao as $valor){
        $sql="INSERT INTO usuario_colecao(usuario,colecao) values('$_REQUEST[usuario]','$valor')";
        $db->query($sql);
        }
 }
       echo "<script>alert('Atualização realizada com sucesso!')</script>";
       echo "<script>location.href='usuario.php'</script>";
	
 }
}
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
