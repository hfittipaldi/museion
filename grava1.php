<html>
<?
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db1=new conexao();
$db1->conecta();
$db2=new conexao();
$db2->conecta();
$teste='teste123';
?>
//Criacao de Formulario
<form name=teste method=post>
	<table border=1>
	<tr>
<?
	$codigo=$_GET['codReg'];
	$nomeT=$_GET['nomeReg'];
	$sexoT=$_GET['sexoReg'];
	//if ($codigo<>'') {
	//	$sql="select * from tabela where codigo=".$codigo;
	//	$db->query($sql);
	//	$linha=$db->dados();
	//	$nomeT=$linha['nome'];
	//	$sexoT=$linha['sexo'];
        //}
?>
		<td>Codigo</td><td><input type=text name=codigo value= <?echo $codigo ?> ></td>              
 	</tr>
	<tr>
		<td>Nome</td><td><input type=text name=nome value=" <?echo $nomeT ?> "></td>
	</tr>
	<tr>
		<td>Sexo</td>
		<td><select name=sexo>
			<?
			$sqlSexo="select * from sexo";
			$db2->query($sqlSexo);
			while ($sexo=$db2->dados())
			{
				echo "<option value=".$sexo['codigo'];
				if ($sexoT==$sexo['codigo']) {
					echo " selected";
				}
				echo ">";
				echo $sexo['descricao'];
				echo "</option>";
			}
			?>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<input type=submit name=inclui value="Grava">
                	<input type=submit name=altera value="Altera">
			<input type=submit name=deleta value="Exclui">
		</td>
	</tr>
	</table>
</form>
</body>

<?
$sql='';
$codigo=$_REQUEST['codigo'];
$nome=$_REQUEST['nome'];
$sexo=$_REQUEST['sexo'];

echo "Incluir: ".$_REQUEST['inclui']."<br>";
echo "Alterar: ".$_REQUEST['altera']."<br>";
echo "Excluir: ".$_REQUEST['deleta']."<br>";

if($_REQUEST['inclui']<>'')
{
	$sql="insert into tabela (codigo, nome, sexo) values (".$codigo.", '".$nome."', '".$sexo."')";
}

if($_REQUEST['altera']<>'')
{

      $sql="update tabela set nome='".$nome."', sexo='".$sexo."' where codigo=".$codigo;

}


if($_REQUEST['deleta']<>'')
{

	$sql="delete from tabela where codigo=".$codigo;
}

echo "<br>".$sql."<br>";
if ($sql<>'')
{
	$db->query($sql);
}

echo "<br><table border=1>";
echo "<tr><td>C&oacute;digo</td><td>Nome da Pessoa</td><td>Sexo</td></tr>";
$sql1="select * from tabela order by codigo";
$db1->query($sql1);
while($linha=$db1->dados()) 
{
	
	echo "<tr>";
	echo "<td>";
	echo "<a href=http://127.0.0.1/donato/grava.php?codReg=".$linha['codigo']."&nomeReg=".$linha['nome']."&sexoReg=".$linha['sexo'].">".$linha['codigo']."</a>";
        echo $sexo['codigo'];     
        echo "</td>";
	echo "<td>".$linha['nome']."</td>";
	
	$codigoID=$linha['codigo'];
 	$sqlSexo="select descricao from sexo where codigo='".$linha['sexo']."'";
	$db2->query($sqlSexo);
	$sexo=$db2->dados();
	echo "<td>".$sexo['descricao']."</td>";

	echo "</tr>";
}
echo "</table>";

?>
</html>
