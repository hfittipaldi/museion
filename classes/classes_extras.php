<?
require(classe_padrao.php);
class linha_cor{ 
    var $cores, $linha; 

    function linha_cor(){ 
        $this->linha = 0;     
    } 

    function adicionar_cor($cor){ 
        $this->cores[] = $cor; 
    } 

    function exibir_cor(){ 
        $cor = $this->linha%count($this->cores); 
        $this->linha++; 
        return $this->cores[$cor]; 
    } 
}
class teste extends conexao
{
 var $db;
 //$db=new conexao();
 //$db->conecta();
 
function montalinks()
{
//global $db;

$path=$_SERVER['PHP_SELF'];
$extensao=basename($path);
$sql="select item from menu_item where chamada='".trim($extensao)."'";
$db->query($sql);
$res=$db->dados();
$valor=$res[0];
 $j=1;
   while($j<=strlen($valor))
   {
      $p=substr($valor,0,$j);
	  $sql="select nome from menu_item where item='$p'";
	  $db->query($sql);
	  $res=$db->dados();
	  $comb="$res[0]";
	  if($j==strlen($valor))
	  {
	   $comb.="";
	  }
	  else{
	   $comb.="&nbsp;/&nbsp;";
	   }
	   echo $comb;
$j++;
 }
}
}
//montalinks();
	
?>