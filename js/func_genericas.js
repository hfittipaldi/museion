//// Funcoes genericas/////
function abre_url_combo(qual)
 {
  if (qual.selectedIndex.selected != '') {
 var campo = qual.value;
 if(campo.value==0)
document.location=('itens2.php');
else
document.location=('itens2.php?item='+ campo);
 }
}
function critica_in_or_up()//criticar o insert ou update do form
{
with(document.form1)
{
  if(item.value=='')
 {
    alert('Preencha campo item.')
    item.focus()
    return false;
 }
 if(item.value==0)
 {
    alert('Erro.Selecione um valor para item que seja >0')
    item.focus();
    return false; 
}
  if(nome.value=='')
  {
    alert('Preencha campo nome.')
    nome.focus()
    return false;
  }
 }   
}
