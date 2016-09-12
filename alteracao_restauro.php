<? include_once("seguranca.php") ?>           
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function valida()
{
 with(document.form1)
 {
    if(!tipo[0].checked && !tipo[1].checked && !tipo[3].checked && !tipo[4].checked){
     alert ('Selecione entre papel, pintura ou obra.');
	  return false;} 
	 if(busca.value==0){
	 alert('Selecione um item da caixa de seleção.');
	  return false;}
	 if(busca.value=='A'){
	   if(autor.value==''){
	     alert('Informe o nome do autor.');
		 autor.focus();
	     return false;}}
	if(busca.value=='T'){
	 if(titulo.value==''){
	    alert('Informe o título da obra.');
		titulo.focus();
		return false;}}
	if(busca.value=='N'){
	 if(numregistro.value==''){
	    alert('Informe o Nº do Registro.');
		numregistro.focus();
		return false;}}
	if(busca.value=='I'){
	 if(ir.value==''){
	    alert('Informe o IR');
		ir.focus();
		return false;}}
  }
}


function desabilita()
{
 document.form1.numregistro.style.display='none';
 document.getElementById('rotulo_numregistro').style.display='none';
 
 document.form1.autor.style.display='none';
 document.getElementById('rotulo_autor').style.display='none';

 document.form1.titulo.style.display='none';
 document.getElementById('rotulo_titulo').style.display='none';

 document.form1.numregistro.style.display='none';
 document.getElementById('rotulo_numregistro').style.display='none';
 document.getElementById('rotulo_numregistro2').style.display='none';

 document.form1.ir.style.display='none';
 document.getElementById('rotulo_ir').style.display='none';

 document.form1.moldura.style.display='none';
 document.getElementById('rotulo_moldura').style.display='none';

} 

</script>  
</head>
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$tipo=$_REQUEST[tipo];
///////////////
//TIPO
// 1: papel  2: pintura  3:obra 4:moldura
//tombo=num: " numero do registro.
/////////////////
$busca=$_REQUEST['busca'];
//Funcao usada para obter o id da tabela restauro sendo os parametros o tombo/IR.

  function buscaid($busca){
   global $db;
   if($busca=='N'){
    $sql="SELECT tombo from restauro where tombo like '$_REQUEST[numregistro]%' and tipo=$_REQUEST[tipo]";
	$db->query($sql);
	$id=$db->dados();
	if($id==''){ 
	echo "<script>alert('Registro não encontrado!')</script>";
	echo"<script>location.href='alteracao_restauro.php'</script>";}
	else{
	  return $_REQUEST[numregistro];}
	}
  elseif($busca=='I'){
      $sql="SELECT restauro from restauro where ir like '$_REQUEST[ir]%' and tipo=$_REQUEST[tipo]";
	  $db->query($sql);
	  $id=$db->dados();
	  	if($id==''){ 
	echo "<script>alert('Registro não encontrado!')</script>";
	echo"<script>location.href='alteracao_restauro.php'</script>";}
	else{
	    return $_REQUEST[ir];}
 }
}

function busca_tipo2()
{
 global $db;
 $sql="SELECT interna from restauro where ir like '$_REQUEST[ir]%' and tipo='$_REQUEST[tipo]'";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}
if($_REQUEST[submit]<>'')
{
  if($tipo=='1' ||$tipo=='2' ||$tipo=='3'||$tipo=='4')
 {
   switch($busca){
     case 'A':
       echo"<script>location.href='restauro_altera_autor.php?tipo=$_REQUEST[tipo]&autor=$_REQUEST[autor]'</script>";
	   break;
	 case 'T':
	   echo"<script>location.href='restauro_altera_titulo.php?tipo=$_REQUEST[tipo]&titulo=$_REQUEST[titulo]'</script>";
	   break;
	 case 'N':
           echo"<script>location.href='restauro_altera_num?op=update&tipo=$_REQUEST[tipo]&num=".buscaid($busca)."'</script>";
	   break;
	 case 'I':
           echo"<script>location.href='restauro_altera_ir?op=update&tipo=$_REQUEST[tipo]&ir=$_REQUEST[ir]'</script>";
	   break;	   
	 case 'M':
           echo"<script>location.href='restauro_altera_moldura?op=update&tipo=$_REQUEST[tipo]&moldura=$_REQUEST[moldura]'</script>";
	   break;	   
        }     
     }  
}	
?>
<body onLoad="desabilita()">      
<table width="524" height="50%"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="508" scope="col"><div align="left" class="tit_interno">
<? 
$op=$_REQUEST['op'];
montalinks();
$_SESSION['lnk']=$link;

?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onsubmit='return valida()' >
<table width="100%"  border="0" cellpadding="0" cellspacing="4" >
        <tr>
          <td colspan="4">
          </span></td>
        </tr>
        <tr>
          <td width="10%" class="texto_bold">&nbsp;</td>
          <td colspan="3" class="texto"><div align="left"><em>Informe inicialmente
              os par&acirc;metros de busca: <br></em></div><br></td>
          </tr>
        <tr>
          <td class="texto_bold"><div align="right">1)</div></td>
          <td colspan="2"><div align="left"><span class="texto_bold">
                <input name="tipo" type="radio" value="1">
                Papel &nbsp;
                <input name="tipo" type="radio" value="2">
    		Pintura &nbsp;
                <input name="tipo" type="radio" value="3">
                Objeto 3D
                <input name="tipo" type="radio" value="4">
    		Moldura &nbsp;
 		</span></div></td>
          <td width="19%">&nbsp;</td>
        </tr> 
        <tr>
          <td class="texto_bold"><div align="right">2)</div></td>
          <td colspan="3" nowrap>
            <div align="left">
 
              <select name="busca" class="combo_cadastro" id="busca"
			   onChange="
			   if (this.options[this.selectedIndex].value=='0'){
			     document.form1.autor.style.display='none';document.getElementById('rotulo_autor').style.display='none';
				 document.form1.titulo.style.display='none';document.getElementById('rotulo_titulo').style.display='none';
				 document.form1.numregistro.style.display='none';document.getElementById('numregistro').style.display='none';
				 document.getElementById('rotulo_numregistro2').style.display='none';
				 document.form1.ir.style.display='none';document.getElementById('rotulo_ir').style.display='none';}
			if (this.options[this.selectedIndex].value=='A'){
			     document.form1.autor.style.display='';document.getElementById('rotulo_autor').style.display='';document.form1.autor.focus();
				 document.form1.titulo.style.display='none';document.getElementById('rotulo_titulo').style.display='none';
				 document.form1.numregistro.style.display='none';document.getElementById('rotulo_numregistro').style.display='none';
				 document.getElementById('rotulo_numregistro2').style.display='none';
				 document.form1.ir.style.display='none';document.getElementById('rotulo_ir').style.display='none';}
			if (this.options[this.selectedIndex].value=='T'){
			     document.form1.titulo.style.display='';document.getElementById('rotulo_titulo').style.display='';document.form1.titulo.focus();
				 document.form1.autor.style.display='none';document.getElementById('rotulo_autor').style.display='none';
				 document.form1.numregistro.style.display='none';document.getElementById('rotulo_numregistro').style.display='none';
				 document.getElementById('rotulo_numregistro2').style.display='none';
				 document.form1.ir.style.display='none';document.getElementById('rotulo_ir').style.display='none';}
		    if (this.options[this.selectedIndex].value=='N'){
			     document.form1.numregistro.style.display='';document.getElementById('rotulo_numregistro').style.display='';
				 document.form1.numregistro.focus();document.getElementById('rotulo_numregistro2').style.display='';
				 document.form1.autor.style.display='none';document.getElementById('rotulo_autor').style.display='none';
				 document.form1.titulo.style.display='none';document.getElementById('rotulo_titulo').style.display='none';
				 document.form1.ir.style.display='none';document.getElementById('rotulo_ir').style.display='none';}
		     if (this.options[this.selectedIndex].value=='I'){
			     document.form1.ir.style.display='';document.getElementById('rotulo_ir').style.display='';document.form1.ir.focus();
				 document.form1.autor.style.display='none';document.getElementById('rotulo_autor').style.display='none';
				 document.form1.titulo.style.display='none';document.getElementById('rotulo_titulo').style.display='none';
				 document.getElementById('rotulo_numregistro2').style.display='none';
				 document.form1.numregistro.style.display='none';document.getElementById('rotulo_numregistro').style.display='none';}
		     if (this.options[this.selectedIndex].value=='M'){
			     document.form1.moldura.style.display='';document.getElementById('rotulo_moldura').style.display='';document.form1.moldura.focus();
				 document.form1.ir.style.display='none';document.getElementById('rotulo_ir').style.display='none';
				 document.form1.autor.style.display='none';document.getElementById('rotulo_autor').style.display='none';
				 document.form1.titulo.style.display='none';document.getElementById('rotulo_titulo').style.display='none';
				 document.getElementById('rotulo_numregistro2').style.display='none';
				 document.form1.numregistro.style.display='none';document.getElementById('rotulo_numregistro').style.display='none';}

				"> 
			      <option value="0" selected></option>
                  <option value="A">Autor</option>
                  <option value="T">T&iacute;tulo da Obra</option>
                  <option value="N">N&uacute;mero do Registro</option>
                  <option value="I">IR</option>
                  <option value="M">Moldura</option>

              </select> 
      
             
		      </div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3" rowspan="2"><label id="rotulo_autor" class="texto_bold" style="display:<? if ($busca=='0') echo "none"; ?>;">Autor:</label>
            <input name="autor" type="text" class="combo_texto" id="autor" value="<? echo $_REQUEST[autor] ?>" size="60">
			<label id="rotulo_numregistro" class="texto_bold" style="display:<? if ($busca=='0') echo "none"; ?>;">Nº de registro:</label>              
              <input name="numregistro" type="text" class="combo_texto" id="numregistro" value="<? echo $_REQUEST[numregistro] ?>" size="12">        
            <label id="rotulo_numregistro2" class="texto_bold" style="display:<? if ($busca=='0') echo "none"; ?>;">(sem o nº de controle)</label>              
            <br>
            <label id="rotulo_titulo" class="texto_bold" style="display:<? if ($busca=='0') echo "none"; ?>;">T&iacute;tulo:</label>
            <input name="titulo" type="text" class="combo_texto" id="titulo" value="<? echo $_REQUEST[titulo] ?>" size="60">

	    <label id="rotulo_ir" class="texto_bold" style="display:<? if ($busca=='0') echo "none"; ?>;">IR:</label>              
            <input name="ir" type="text" class="combo_texto" id="ir" value="<? echo $_REQUEST[ir] ?>" size="12">        

	    <label id="rotulo_moldura" class="texto_bold" style="display:<? if ($busca=='0') echo "none"; ?>;">Moldura:</label>              
            <input name="moldura" type="text" class="combo_texto" id="moldura" value="<? echo $_REQUEST[moldura] ?>" size="12">        
            </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="36%">
              <div align="right">
                <input type="text" name="textfield" style="display:none" >
              </div></td>
          <td width="37%"><div align="right">
            <input name="submit" type="submit" class="botao" value="Procurar">
          </div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
