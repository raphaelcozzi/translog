<!-- BEGIN main -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <meta name="description" content="Controle financeiro de seu dinheiro, controle online suas financas">
      <meta name="keywords" content="controle financeiro online, controle financeiro, dinheiro, administrar financas, controle dinheiro, online">
      <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
      <title>{TITULO_SISTEMA}</title>
      <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
      <script type="text/javascript">
         $(document).ready(function(){
             $('#estados').change(function(){
                 $('#cidades').load('index.php?module=cadastro&method=ajax_cidade&estado='+$('#estados').val() );
         
             });
         });
         
      </script>
      <script language="javascript">
         function valida()
         {
         
         	if(document.forms.nome.value == "" || document.forms.nome.value == " ")
         	{
         		alert("Preencha com seu nome");
         		return false;	
         	}
         
         	if(document.forms.nome.value == false )
         	{
         		alert("Preencha com seu nome");
         		return false;	
         	}
         
         
         	if(document.forms.email.value == "" || document.forms.email.value == " ")
         	{
         		alert("Preencha com seu e-mail");
         		return false;	
         	}
         
         	if(document.forms.email.value == false)
         	{
         		alert("Preencha com seu e-mail");
         		return false;	
         	}
         
         	if(document.forms.senha.value == "" || document.forms.senha.value == " " )
         	{
         		alert("Preencha com sua senha");
         		return false;	
         	}
         
         	if(document.forms.senha.value == false)
         	{
         		alert("Preencha com sua senha");
         		return false;	
         	}
         
         	if(document.forms.senha.value != document.forms.senha2.value)
         	{
         		alert("As senhas digitadas estao diferentes");
         		return false;	
         	}
         
         	return true;	
         }
         
      </script>
      <!-- ANALYTICS -->
      <!-- ANALYTICS -->
   </head>
   <body bgcolor="#ffffff" style="background:url(images/bggg.jpg); margin-top:0px;">
      <table border="0" cellpadding="0" cellspacing="0" width="1000" align="center">
         <!-- fwtable fwsrc="layout.png" fwpage="Page 1" fwbase="layout.jpg" fwstyle="Dreamweaver" fwdocid = "1614252937" fwnested="0" -->
         <tr>
            <td><img src="images/spacer.gif" width="315" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="68" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="276" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="188" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="105" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
         </tr>
         <tr>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2"><img name="layout_r1_c3" src="images/layout_r1_c3.png" width="276" height="274" border="0" id="layout_r1_c3" alt="" /></td>
            <td colspan="2" align="center">
            </td>
            <td rowspan="4">&nbsp;</td>
            <td><img src="images/spacer.gif" width="1" height="61" border="0" alt="" /></td>
         </tr>
         <tr>
            <td colspan="2">&nbsp;</td>
            <td><img src="images/spacer.gif" width="1" height="213" border="0" alt="" /></td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td valign="top"><img name="layout_r3_c2" src="images/layout_r3_c2.png" width="68" height="135" border="0" id="layout_r3_c2" alt="" /></td>
            <td colspan="2" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#FFF; font-size:14px; font-weight:bold;">
               <!-- FORMULARIO -->
               <form action="index.php?module=cadastro&method=insere" method="post" name="forms" onsubmit="return(valida())">
                  <table border="0">
                     <tr>
                        <td>Nome<br /> <input type="text" name="nome" size="60" style="font-size:12px; color:#333; font-family:tahoma; border-style:solid; border-width:1px; border-color:#000;" />
                        </td>
                     </tr>
                     <tr>
                        <td>E-mail <br /><input type="text" name="email" size="60" style="font-size:12px; color:#333; font-family:tahoma; border-style:solid; border-width:1px; border-color:#000;" />
                        </td>
                     </tr>
                     <tr>
                        <td align="right" style="padding-right:80px;">
                           O e-mail ser&aacute; seu login.
                        </td>
                     <tr>
                        <td><br />
                        </td>
                     </tr>
                     <tr>
                        <td>Estado
                           <br /> 
                           <label for="select"></label>
                           <select name="estado"  id="estados" style="font-size:12px; color:#333; font-family:tahoma; border-style:solid; border-width:1px; border-color:#000; width:140px;">
                           {listagem_estado}
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td>Cidade    <br /> 
                           <select id="cidades" name="cidade" style="font-size:12px; color:#333; font-family:tahoma; border-style:solid; border-width:1px; border-color:#000;" >
                           {listagem_cidade}
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <br /><br />
                        </td>
                     </tr>
                     <tr>
                        <td>Senha <br /><input type="password" name="senha" size="45" style="font-size:12px; color:#333; font-family:tahoma; border-style:solid; border-width:1px; border-color:#000;" />
                        </td>
                     </tr>
                     <tr>
                        <td>Confirme a senha <br /><input type="password" name="senha2" size="45" style="font-size:12px; color:#333; font-family:tahoma; border-style:solid; border-width:1px; border-color:#000;" />
                        </td>
                     </tr>
                     <tr>
                        <td align="right">
                           <br />
                           <div style="float:right; margin-right:23px;">
                              <input type="image" src="images/btn_login_2.jpg" border="0" />
                           </div>
                        </td>
                     </tr>
                  </table>
               </form>
               <!-- FORMULARIO -->
            </td>
            <td>&nbsp;</td>
            <td><img src="images/spacer.gif" width="1" height="135" border="0" alt="" /></td>
         </tr>
         <tr>
            <td colspan="5"><img name="layout_r4_c1" src="images/cad.png" usemap="#layout_r4_c1Map"  width="895" height="186" border="0" id="layout_r4_c1" alt="" /></td>
            <td><img src="images/spacer.gif" width="1" height="186" border="0" alt="" /></td>
         </tr>
         <tr>
            <td colspan="6"><img name="layout_r5_c1" src="images/layout_r5_c1.jpg" width="1000" height="105" border="0" id="layout_r5_c1" alt="" /></td>
            <td><img src="images/spacer.gif" width="1" height="105" border="0" alt="" /></td>
         </tr>
      </table>
   </body>
</html>
<!-- END main -->
<!-- BEGIN confirm -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <meta name="description" content="Controle financeiro de seu dinheiro, controle online suas financas">
      <meta name="keywords" content="controle financeiro online, controle financeiro, dinheiro, administrar financas, controle dinheiro, online">
      <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
      <title>{TITULO_SISTEMA}</title>
      <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
      <script type="text/javascript">
         $(document).ready(function(){
             $('#estados').change(function(){
                 $('#cidades').load('index.php?module=cadastro&method=ajax_cidade&estado='+$('#estados').val() );
         
             });
         });
         
      </script>
      <script language="javascript">
         function valida()
         {
         
         	if(document.forms.nome.value == "" || document.forms.nome.value == " ")
         	{
         		alert("Preencha com seu nome");
         		return false;	
         	}
         
         	if(document.forms.nome.value == false )
         	{
         		alert("Preencha com seu nome");
         		return false;	
         	}
         
         
         	if(document.forms.email.value == "" || document.forms.email.value == " ")
         	{
         		alert("Preencha com seu e-mail");
         		return false;	
         	}
         
         	if(document.forms.email.value == false)
         	{
         		alert("Preencha com seu e-mail");
         		return false;	
         	}
         
         	if(document.forms.senha.value == "" || document.forms.senha.value == " " )
         	{
         		alert("Preencha com sua senha");
         		return false;	
         	}
         
         	if(document.forms.senha.value == false)
         	{
         		alert("Preencha com sua senha");
         		return false;	
         	}
         
         	if(document.forms.senha.value != document.forms.senha2.value)
         	{
         		alert("As senhas digitadas estao diferentes");
         		return false;	
         	}
         
         	return true;	
         }
         
      </script>
      <script type="text/javascript">
         var _gaq = _gaq || [];
         _gaq.push(['_setAccount', 'UA-2256567-3']);
         _gaq.push(['_trackPageview']);
         
         (function() {
           var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
           ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
           var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
         })();
         
      </script>
   </head>
   <body bgcolor="#ffffff" style="background:url(images/bggg.jpg); margin-top:0px;">
      <table border="0" cellpadding="0" cellspacing="0" align="center">
         <!-- fwtable fwsrc="layout.png" fwpage="Page 1" fwbase="layout.jpg" fwstyle="Dreamweaver" fwdocid = "1614252937" fwnested="0" -->
         <tr>
            <td><img src="images/spacer.gif" width="68" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="276" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="188" height="1" border="0" alt="" /></td>
            <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
         </tr>
         <tr>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2" align="center" style="padding-left:60px; padding-left:200px;"><img name="layout_r1_c3" src="images/layout_r1_c3.png" width="276" height="274" border="0" id="layout_r1_c3" alt="" /></td>
            <td colspan="2" align="center">
            </td>
         </tr>
         <tr>
            <td colspan="2">&nbsp;</td>
         </tr>
         <tr>
            <td valign="top"></td>
            <td colspan="2" align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#FFF; font-size:14px; font-weight:bold;">
               <div style="width:700px; padding-left:140px;">
                  <h3>Cadastro efetuado com sucesso!</h3>
                  <h3>Um e-mail com seus dados foi enviado para você. Confirme seu cadastro</h3>
                  Agora você pode administrar suas finanças de forma simples e eficiente, gerenciando todas as suas contas, sejam elas contas correntes, contas poupança, o dinheiro em sua carteira ou até mesmo aquele seu cofre em forma de porquinho! Para isso basta se cadastrar gratuitamente e começar a utilizar todas as ferramentas que criamos para facilitar ao máximo a o seu dia-a-dia. O {TITULO_SISTEMA} conta com ferramentas exclusivas como listas de desejos e funcionalidades que foram criadas para que você possa controlar o que mais importa para você, seu dinheiro, de forma rápida simples e segura. 
                  <br /><br />
                  <a href="index.php?module=login&method=main_login"><img src="images/btn_e.png" border="0" /></a>
               </div>
            </td>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td colspan="4">
            </td>
         </tr>
         <tr>
            <td colspan="4" align="center"><br /><img name="layout_r5_c1" src="images/layout_r5_c1.jpg" width="1000" height="105" border="0" id="layout_r5_c1" alt="" /></td>
            <td><img src="images/spacer.gif" width="1" height="105" border="0" alt="" /></td>
         </tr>
      </table>
   </body>
</html>
<!-- END confirm -->