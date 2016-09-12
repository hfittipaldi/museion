<?
/////////////////////////IMPORTANTE:////////////////////////////////
//Obs: Tem q passar o valor do Id da sessao atual para
//poder montar o menu de acordo com as preferencias de cada user!!!
/////////////////////////////////////////////////////////////////////
function carrega()
{
require_once("classes/classe_padrao.php");
$db= new conexao();
$db->conecta();
$sql="SELECT t1.* from  menu_item as t1,usuario as t2
 INNER join usuario_menu_item as t3 WHERE (t2.usuario=t3.usuario)AND (t1.item=t3.item) and t2.usuario='$_SESSION[susuario]'
  order by t1.posicao,t1.ordenacao "; 

//$sql="SELECT item,nome,chamada,posicao,ordenacao from menu_item ORDER BY posicao,ordenacao ASC";
$db->query($sql);
 
  while ($row=$db->dados()) 
  { 
  	//Verifica se o pai do menu_item em questão está habilitado; se não, ignora o item//
	  $vet_item[0]=1;
	  if($vet_item[($row['posicao'])]==1){
			$vet_item[($row['item'])]=1;
	
		    $item = "m" . $row['item'];

			$target="paginas";
				//target pra cair dentro do iframe
		    $pos=$row['posicao'];
			if($pos != "NULL")
			{
			  $pos = "m" . $pos;
			  ///
			  //Esta modificacao foi necessaria para que pudesse abrir uma nova janela no cadastro de obras,
			  //de modo que pudesse facilitar o cadastramento com um maior espaço disponível do que se fosse no iframe.
				  $click="''";
				  $chamada="'$row[chamada]'";
                                  //
                                  // Colocada a chamada do Cadastro de Obra com Publicação [pStatus=1] (PBL) PRD17
                                  //
				  if($row[chamada]=='principal2.php?acao=I&menu=obra'||$row[chamada]=='principal2.php?acao=I&menu=autor'||
                                                     $row[chamada]=='principal2.php?acao=A&menu=autor'||$row[chamada]=='principal2.php?acao=A&menu=obra'||
                                                     $row[chamada]=='principal2.php?acao=A&pLiberar=1&menu=obra' || $row[chamada]=='principal2.php?acao=I&pStatus=1&menu=obra'||
                                                     $row[chamada]=='principal2.php?acao=I&menu=obrareg'|| $row[chamada]=='principal2.php?acao=A&menu=obrareg')
				  { $target='self';}
				  if($row[chamada]=='graph_colmuseu.php' ){
				   $target='';
				   $chamada="'javascript:;'";
				//   $click="'window.open(\"$row[chamada]\",\"Grafico\",\");'";
   $click="'window.open(\"$row[chamada]\",\"Grafico\",\"left=\"+((window.screen.width/2)-390)+\",top=\"+((window.screen.height/2)-240)+\",width=780,height=480,scrollbars=no,resizable=no'\");'";
							
				   }
				  ///

				  echo"<script>oCMenu.makeMenu('$item','$pos','$row[nome]',$chamada,'$target','','','','','','','','','',$click)</script>";
			  }
			else{
			  echo"<script>oCMenu.makeMenu('$item','','$row[nome]','$row[chamada]','$target')</script>";}
		}
	  } // while
 } // function
 
carrega();
?>
