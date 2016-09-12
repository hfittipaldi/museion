<? 
include_once("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<? 
 $db=new conexao();
 $db->conecta();
 $visit= login_visitante();
 $sql= "SELECT login,senha from usuario where login = '$visit'";
 $db->query($sql);
 $visit= $db->dados();
?>
<title><? echo  nome_instituicao() ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

body {
margin:0;
padding:0;
background:#ffffff;
text-align:center; /* hack para o IE */	
	}

</style>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v;
 
 }
}
function get_focus()
{
with(document.form1) {
 nome.focus()
 }
}
function valida()
{
 with(document.form1){
    if(nome.value==''){
	  alert('Digite seu login.');
	  nome.focus();
	  return false;}
  if(senha.value==''){
    alert('Digite sua senha');
	senha.focus();
   return false;  }
}}
function carrega()
{
  setTimeout('mostra_hide()',5000);
}
function mostra_hide()
{
  MM_showHideLayers('fazul2','','show','login','','show','donato','','show');
  if (self.document.form1.nome.value == '')
	  self.document.form1.nome.focus();
}
function entra()
{
 with(document.form1)
 submit();
}
function  acesso_visitante() {
	top.location.href= 'login.php?nome=<? echo $visit[login]; ?>&senha=<? echo $visit[senha]; ?>'
}
//-->
</script>
<link href="css/home.css" rel="stylesheet" type="text/css">
</head>

<body onMouseOver="MM_showHideLayers('fazul2','','show','login','','show','donato','','show')" 
onLoad="carrega();">
<div id="tudo">
 <table width="750" height="549"  border="0" cellpadding="0" cellspacing="0" background="imgs/fundo.jpg">
  <tr>
    <td align="center" valign="bottom">	  
	  <div id="fazul2"></div>
	  <div id="login">
	    <FORM name="form1" method='post' action="login.php" ><br><br><br><br><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="7%" scope="col"><div align="right"><span class="login">NOME DO USU&Aacute;RIO: </span></div></th>
            <th width="15%" class="login" scope="col">
                <div align="left">
                   &nbsp;
                   <input name="nome" type="text" class="combo_login" id="nome" size="30">
                </div></th>
            <th width="5%" align="right" scope="col"><span class="login">SENHA: &nbsp;</span></th>
            <th width="5%" scope="col"><div align="left">
              <input name="senha" type="password" class="combo_login" id="senha" size="8">
            </div></th>
            <th width="11%" align="center" scope="col"><a href="#" class="login" onClick="entra()">ENTRAR</a></th>
            <th width="11%" align="center" scope="col"><a href="#" class="visitante" onClick="acesso_visitante();">VISITANTE</a></th>
          </tr>
        </table></FORM>
		</div>
      <div id="donato"><img src="imgs/donato.gif" width="140" height="64" hspace="20" vspace="8"></div>
		<div id="museu"><? echo nome_instituicao(); ?></div>
		<div id="sombra"><? echo nome_instituicao(); ?></div>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="10%" scope="col"><div align="left"><a href="#"><img src="imgs/vitae_branco.gif" name="vitae" width="45" height="71" hspace="14" vspace="15" border="0" id="vitae"></a></div></th>
			<th width="8%" valign="bottom" scope="col"><img src="imgs/logo_mnba.gif" width="60" height="37" vspace="15" border="0"></th>
            <th width="58%" valign="bottom" scope="col"><div align="right"><img src="imgs/mnba.gif" name="mnba" width="129" height="20" vspace="14" id="mnba"></div></th>
            <th width="12%" valign="bottom" scope="col"><div align="right"><img src="imgs/logo_ibram.jpg" name="gov" hspace="14" vspace="14" id="gov"></div></th>
            <th width="12%" valign="bottom" scope="col"><div align="right"><img src="imgs/logo_gov.jpg" name="gov" hspace="14" vspace="14" id="gov"></div></th>
    
          </tr>
        </table>
      </td>
  </tr>
</table>
</div>
</body>
</html>

