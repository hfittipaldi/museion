<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

<script>
function seta_foco()
{
    form1.estado_conserva.focus();
	return;
}
function valida()
{
 with(document.form1){
    if(estado_conserva.value==''){
	  alert('Preencha com o estado de conservação');
	  estado_conserva.focus();
	  return false;}
  }
}


function muda_modelo($val) {
 
   if ($val=='1')
      
     { 
         if (document.getElementById("termot").checked==true)
         { 
            document.form1.termot.value=1;
         }else{
            document.form1.termoc.value=0;
         }
        if (document.getElementById("termoc").checked==true)
         { 
            document.form1.termoc.value=1;
          }else{
            document.form1.termot.value=0;
         }
     }	        
}
</script>  
</head>

<body onload='seta_foco();'>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=$_REQUEST['conserva'];
$op=$_REQUEST['op'];
echo "Estrutura / Termo de Restauração .../ Moldura ";

?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida()">
<?
if(isset($val))
{ 
 if($op=='update')
 {
   $sql="SELECT a.* from termo_moldura as a where a.termo_moldura='$val'";
   $db->query($sql);
   $res=$db->dados();
  }
 if($op=='del')
 {
     $sql="DELETE from termo_moldura where termo_moldura='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='termo_moldura.php'</script>";
	 exit();
  }	 
}
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td>
            <div align="left"><? echo "<a href=\"termo_moldura.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"><div align="left"><br><br><br>&nbsp;Estado de conservação: &nbsp;              
              <input name="estado_conserva" type="text" class="combo_cadastro" id="estado_conserva" value="<? echo $res['termo'] ?>" size="55">
          </div></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" id="val" value="<? echo $val ?>">
	        <input name="op" type="hidden" id="op" value="<? echo $op ?>">
	        <input name="oculto" type="text" id="oculto" value="" style="display:none">
          </span></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;&nbsp; 
            <input name="mov" type="radio" class="texto_bold" value="S" <? if($res[tipo]=='S'){echo "checked";} ?>>
            Tratamento
            <input name="mov" type="radio" class="texto_bold" value="N" <? if($res[tipo]=='N'){echo "checked";} ?>>
            Conservação</td>
        </tr>
         <tr><td>&nbsp;&nbsp;</td></tr>
        </tr>
      </table>
      <table width="100%">
          <tr>
          <td><div align="center"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>
          </tr>
      </table>
      <br>
      <?

if($_REQUEST['enviar']<>'')
{

  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE termo_moldura set termo='$_REQUEST[termo]' , tipo='$_REQUEST[mov]'
	 where termo_moldura='$_REQUEST[termo_moldura]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='termo_moldura.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){

     $sql= "INSERT INTO termo_moldura(termo,tipo) values('".trim($_REQUEST[termo])."'".",'".trim($_REQUEST[mov])."')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='termo_moldura.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>