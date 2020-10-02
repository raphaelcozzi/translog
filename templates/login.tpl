<!-- BEGIN login -->
<!DOCTYPE html>
<!--[if IE 8]> 
<html lang="en" class="ie8 no-js">
   <![endif]-->
   <!--[if IE 9]> 
   <html lang="en" class="ie9 no-js">
      <![endif]-->
      <!--[if !IE]><!-->
      <html lang="en">
         <!--<![endif]-->
         <!-- BEGIN HEAD -->
         <head>
            <meta charset="utf-8" />
            <title>{TITULO_SISTEMA}</title>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="width=device-width, initial-scale=1" name="viewport" />
            <meta content="" name="description" />
            <meta content="" name="author" />
            <base href="{ABS_LINK}" />
            <!-- BEGIN GLOBAL MANDATORY STYLES -->
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
            <!-- END GLOBAL MANDATORY STYLES -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL STYLES -->
            <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
            <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
            <!-- END THEME GLOBAL STYLES -->
            <!-- BEGIN PAGE LEVEL STYLES -->
            <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
            <!-- END PAGE LEVEL STYLES -->
            <!-- BEGIN THEME LAYOUT STYLES -->
            <!-- END THEME LAYOUT STYLES -->
            <link rel="shortcut icon" href="favicon.ico" />
         </head>
         <!-- END HEAD -->
         <body class=" login">
            <!-- BEGIN LOGO -->
            <div class="logo">
               <a href="index.php">
               <img src="images/logo-big.png" alt="" /> </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN LOGIN -->
            <div class="content">
               <!-- BEGIN LOGIN FORM -->
               <form class="login-form" action="index.php?module=login&method=logar" method="post" name="forms_cad" onSubmit="return(validaLogin())">
                  <h3 class="form-title font-green">L4 Log</h3>
                  <div class="alert alert-danger display-{alertaDisplay}">
                     <button class="close" data-close="alert"></button>
                     <span> {msg_error}</span>
                  </div>
                  <div class="form-group">
                     <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                     <label class="control-label visible-ie8 visible-ie9">Login</label>
                     <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="login" value="{login_field}" /> 
                  </div>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Password</label>
                     <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="senha" value="{senha_field}" /> 
                  </div>
                  
                  <div class="form-actions">
                     <button type="submit" class="btn green uppercase">{TX_ENTRAR}</button>
                     <label class="rememberme check mt-checkbox mt-checkbox-outline">
                     <input type="checkbox" name="remember" value="1" />{TX_LEMBRAR}
                     <span></span>
                     </label>
                     <a href="javascript:;" id="forget-password" class="forget-password">{TX_ESQUECEU_SENHA}</a>
                  </div>
                  <!--<div class="login-options">
                     <h4>{TX_ACESSE_USANDO}:</h4>
                     <ul class="social-icons">
                         <li>
                             <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                         </li>
                         <li>
                             <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                         </li>
                         <li>
                             <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                         </li>
                         <li>
                             <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                         </li>
                     </ul>
                     </div> -->
                  <!--<div class="create-account">
                     <p>
                         <a href="javascript:;" id="register-btn" class="uppercase">{TX_AINDA_NAO_POSSUO_CONTA}</a>
                     </p>
                     </div>-->
               </form>
               <!-- END LOGIN FORM -->
               <!-- BEGIN FORGOT PASSWORD FORM -->
               <form class="forget-form" action="index.php?module=login&method=send_pass"  method="post">
                  <input type="hidden" name="key" value="ss5Dd1s5g">
                  <h3 class="font-green">{TX_ESQUECEU_SENHA}</h3>
                  <p> {TX_REDEFINIR_SENHA} </p>
                  <div class="form-group">
                     <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> 
                  </div>
                  <div class="form-actions">
                     <button type="button" id="back-btn" class="btn green btn-outline" onClick="javascript:history.back();">{TX_VOLTAR}</button>
                     <button type="submit" class="btn btn-success uppercase pull-right">{BTN_SUBMIT}</button>
                  </div>
               </form>
               <!-- END FORGOT PASSWORD FORM -->
               <!-- BEGIN REGISTRATION FORM -->
               <form class="register-form" action="index.php?module=cadastro&method=insere" method="post">
                  <h3 class="font-green">{TX_CRIAR_NOVA_CONTA}</h3>
                  <p class="hint"> {TX_ENTRE_INFORMACOES}: </p>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Nome Completo</label>
                     <input class="form-control placeholder-no-fix" type="text" placeholder="Nome completo" name="nome" /> 
                  </div>
                  <div class="form-group">
                     <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                     <label class="control-label visible-ie8 visible-ie9">Email</label>
                     <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" /> 
                  </div>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Endere&ccedil;o</label>
                     <input class="form-control placeholder-no-fix" type="text" placeholder="Endere&ccedil;o" name="endereco" />
                  </div>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Estado</label>                    
                     <select name="estado"  id="estados" class="form-control" >
                     {listagem_estado}
                     </select>          
                  </div>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Cidade</label>
                     <!--<input class="form-control placeholder-no-fix" type="text" placeholder="City/Town" name="cidade" /> -->
                     <select id="cidades" name="cidade" class="form-control" >
                     {listagem_cidade}
                     </select>
                  </div>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Pa&iacute;s</label>
                     <select name="pais" class="form-control">
                        <option value="AF">Afghanistan</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia</option>
                        <option value="BA">Bosnia and Herzegowina</option>
                        <option value="BW">Botswana</option>
                        <option value="BV">Bouvet Island</option>
                        <option value="BR" selected>Brazil</option>
                        <option value="IO">British Indian Ocean Territory</option>
                        <option value="BN">Brunei Darussalam</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CX">Christmas Island</option>
                        <option value="CC">Cocos (Keeling) Islands</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CG">Congo</option>
                        <option value="CD">Congo, the Democratic Republic of the</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="CI">Cote d'Ivoire</option>
                        <option value="HR">Croatia (Hrvatska)</option>
                        <option value="CU">Cuba</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands (Malvinas)</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="TF">French Southern Territories</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea-Bissau</option>
                        <option value="GY">Guyana</option>
                        <option value="HT">Haiti</option>
                        <option value="HM">Heard and Mc Donald Islands</option>
                        <option value="VA">Holy See (Vatican City State)</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IR">Iran (Islamic Republic of)</option>
                        <option value="IQ">Iraq</option>
                        <option value="IE">Ireland</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KP">Korea, Democratic People's Republic of</option>
                        <option value="KR">Korea, Republic of</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Lao People's Democratic Republic</option>
                        <option value="LV">Latvia</option>
                        <option value="LB">Lebanon</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libyan Arab Jamahiriya</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MO">Macau</option>
                        <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia, Federated States of</option>
                        <option value="MD">Moldova, Republic of</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolia</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="AN">Netherlands Antilles</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="MP">Northern Mariana Islands</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palau</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PN">Pitcairn</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="QA">Qatar</option>
                        <option value="RE">Reunion</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russian Federation</option>
                        <option value="RW">Rwanda</option>
                        <option value="KN">Saint Kitts and Nevis</option>
                        <option value="LC">Saint LUCIA</option>
                        <option value="VC">Saint Vincent and the Grenadines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">Sao Tome and Principe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SK">Slovakia (Slovak Republic)</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SH">St. Helena</option>
                        <option value="PM">St. Pierre and Miquelon</option>
                        <option value="SD">Sudan</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="SY">Syrian Arab Republic</option>
                        <option value="TW">Taiwan, Province of China</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania, United Republic of</option>
                        <option value="TH">Thailand</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option value="US">United States</option>
                        <option value="UM">United States Minor Outlying Islands</option>
                        <option value="UY">Uruguay</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VE">Venezuela</option>
                        <option value="VN">Viet Nam</option>
                        <option value="VG">Virgin Islands (British)</option>
                        <option value="VI">Virgin Islands (U.S.)</option>
                        <option value="WF">Wallis and Futuna Islands</option>
                        <option value="EH">Western Sahara</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                        <option value="ZW">Zimbabwe</option>
                     </select>
                  </div>
                  <p class="hint"> Entre com as informa&ccedil;&otilde;es de acesso: </p>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Login</label>
                     <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Login" name="email" /> 
                  </div>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Password</label>
                     <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="senha" /> 
                  </div>
                  <div class="form-group">
                     <label class="control-label visible-ie8 visible-ie9">Re-type your password</label>
                     <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type your password" name="senha2" /> 
                  </div>
                  <div class="form-group margin-top-20 margin-bottom-20">
                     <label class="mt-checkbox mt-checkbox-outline">
                     <input type="checkbox" name="remember" value="1" />
                     <input type="checkbox" name="tnc" /> Eu concordo com os
                     <a href="index.php?module=login&method=termos">Termos de uso</a>
                     <span></span>
                     </label>
                     <div id="register_tnc_error"> </div>
                  </div>
                  <div class="form-actions">
                     <button type="button" id="register-back-btn" class="btn green btn-outline" onClick="javascript:history.back();">{TX_VOLTAR}</button>
                     <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">{BTN_SUBMIT}</button>
                  </div>
               </form>
               <!-- END REGISTRATION FORM -->
            </div>
            <div class="copyright"> 2010 - 2021 © {TITULO_SISTEMA}. </div>
            <!--[if lt IE 9]>
            <script src="assets/global/plugins/respond.min.js"></script>
            <script src="assets/global/plugins/excanvas.min.js"></script> 
            <![endif]-->
            <script language="javascript">
               function valida_cad()
               {
               
               	if(document.forms_cad.nome.value == "" || document.forms_cad.nome.value == " ")
               	{
               		alert("Preencha com seu nome");
               		return false;	
               	}
               
               	if(document.forms_cad.nome.value == false )
               	{
               		alert("Preencha com seu nome");
               		return false;	
               	}
               
               
               	if(document.forms_cad.email.value == "" || document.forms_cad.email.value == " ")
               	{
               		alert("Preencha com seu e-mail");
               		return false;	
               	}
               
               	if(document.forms_cad.email.value == false)
               	{
               		alert("Preencha com seu e-mail");
               		return false;	
               	}
               
               	if(document.forms_cad.senha.value == "" || document.forms_cad.senha.value == " " )
               	{
               		alert("Preencha com sua senha");
               		return false;	
               	}
               
               	if(document.forms_cad.senha.value == false)
               	{
               		alert("Preencha com sua senha");
               		return false;	
               	}
               
               	if(document.forms_cad.senha.value != document.forms_cad.senha2.value)
               	{
               		alert("As senhas digitadas estao diferentes");
               		return false;	
               	}
               
               	return true;	
               }
               
            </script>
            <script language="javascript">
               function validaLogin()
               {
                  
                  if(document.forms_cad.login.value == "" || document.forms_cad.login.value == " ")
                  {
                     alert("Fill your e-mail");
                     return false;	
                  }
               
                  if(document.forms_cad.value == false)
                  {
                     alert("Fill your e-mail");
                     return false;	
                  }
               
                  if(document.forms_cad.senha.value == "" || document.forms_cad.senha.value == " ")
                  {
                     alert("Fill your password");
                     return false;	
                  }
                  
                 
                  return true;
               }
               
               function envia_form()
               {
               
               if(document.login.login.value == "" || document.forms2.login.value == " ")
               {
               alert("Preencha com seu e-mail");
               return false;	
               }
               
               if(document.login.login.value == false)
               {
               alert("Preencha com seu e-mail");
               return false;	
               }
               
               if(document.login.senha.value == "" || document.forms2.senha.value == " ")
               {
               alert("Preencha com sua senha");
               return false;	
               }
               
               if(document.login.senha.value == false)
               {
               alert("Preencha com sua senha");
               return false;	
               }
               
               
               document.login.submit();	
               }
               
            </script>
            <script type="text/javascript">
               jQuery(document).ready(function(){
                   jQuery('#estados').change(function(){
                       jQuery('#cidades').load('index.php?module=cadastro&method=ajax_cidade&estado='+jQuery('#estados').val() );
               
                   });
               });
               
            </script>
            {ANALYTICS}
            <!-- BEGIN CORE PLUGINS -->
            <script src="assets/global/plugins/jquery-1.4.2.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <!-- END THEME LAYOUT SCRIPTS -->
         </body>
      </html>
      <!-- END login -->
      <!-- BEGIN confirm --><!DOCTYPE html>
      <!--[if IE 8]> 
      <html lang="en" class="ie8 no-js">
         <![endif]-->
         <!--[if IE 9]> 
         <html lang="en" class="ie9 no-js">
            <![endif]-->
            <!--[if !IE]><!-->
            <html lang="en">
               <!--<![endif]-->
               <!-- BEGIN HEAD -->
               <head>
                  <meta charset="utf-8" />
                  <title>{TITULO_SISTEMA}</title>
                  <meta http-equiv="X-UA-Compatible" content="IE=edge">
                  <meta content="width=device-width, initial-scale=1" name="viewport" />
                  <meta content="" name="description" />
                  <meta content="" name="author" />
                  <!-- BEGIN GLOBAL MANDATORY STYLES -->
                  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
                  <!-- END GLOBAL MANDATORY STYLES -->
                  <!-- BEGIN PAGE LEVEL PLUGINS -->
                  <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
                  <!-- END PAGE LEVEL PLUGINS -->
                  <!-- BEGIN THEME GLOBAL STYLES -->
                  <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
                  <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
                  <!-- END THEME GLOBAL STYLES -->
                  <!-- BEGIN PAGE LEVEL STYLES -->
                  <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
                  <!-- END PAGE LEVEL STYLES -->
                  <!-- BEGIN THEME LAYOUT STYLES -->
                  <!-- END THEME LAYOUT STYLES -->
                  <link rel="shortcut icon" href="favicon.ico" />
               </head>
               <!-- END HEAD -->
               <body class=" login">
                  <!-- BEGIN LOGO -->
                  <div class="logo">
                     <a href="index.html">
                     <img src="images/logo-big.png" alt="" /> </a>
                  </div>
                  <!-- END LOGO -->
                  <!-- BEGIN LOGIN -->
                  <div class="content">
                  </div>
               </body>
               {ANALYTICS}
               <!-- BEGIN CORE PLUGINS -->
               <script src="assets/global/plugins/jquery-1.4.2.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
               <!-- END CORE PLUGINS -->
               <!-- BEGIN PAGE LEVEL PLUGINS -->
               <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
               <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
               <!-- END PAGE LEVEL PLUGINS -->
               <!-- BEGIN THEME GLOBAL SCRIPTS -->
               <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
               <!-- END THEME GLOBAL SCRIPTS -->
               <!-- BEGIN PAGE LEVEL SCRIPTS -->
               <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
               <!-- END PAGE LEVEL SCRIPTS -->
               <!-- BEGIN THEME LAYOUT SCRIPTS -->
               <!-- END THEME LAYOUT SCRIPTS -->
               </body>
            </html>
            <!-- END confirm -->
            <!-- BEGIN termos -->
            <!DOCTYPE html>
            <!--[if IE 8]> 
            <html lang="en" class="ie8 no-js">
               <![endif]-->
               <!--[if IE 9]> 
               <html lang="en" class="ie9 no-js">
                  <![endif]-->
                  <!--[if !IE]><!-->
                  <html lang="en">
                     <!--<![endif]-->
                     <!-- BEGIN HEAD -->
                     <head>
                        <meta charset="utf-8" />
                        <title>{TITULO_SISTEMA}</title>
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta content="width=device-width, initial-scale=1" name="viewport" />
                        <meta content="" name="description" />
                        <meta content="" name="author" />
                        <!-- BEGIN GLOBAL MANDATORY STYLES -->
                        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
                        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
                        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
                        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
                        <!-- END GLOBAL MANDATORY STYLES -->
                        <!-- BEGIN PAGE LEVEL PLUGINS -->
                        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
                        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
                        <!-- END PAGE LEVEL PLUGINS -->
                        <!-- BEGIN THEME GLOBAL STYLES -->
                        <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
                        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
                        <!-- END THEME GLOBAL STYLES -->
                        <!-- BEGIN PAGE LEVEL STYLES -->
                        <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
                        <!-- END PAGE LEVEL STYLES -->
                        <!-- BEGIN THEME LAYOUT STYLES -->
                        <!-- END THEME LAYOUT STYLES -->
                        <link rel="shortcut icon" href="favicon.ico" />
                     </head>
                     <!-- END HEAD -->
                     <body class=" login">
                        <!-- BEGIN LOGO -->
                        <div class="logo">
                           <a href="index.html">
                           <img src="images/logo-big.png" alt="" /> </a>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN LOGIN -->
                        <div class="content" style="width:70%;">
                           <div class="form-actions">
                              <button type="button" id="back-btn" class="btn green btn-outline" onClick="javascript:history.back();">{TX_VOLTAR}</button>
                           </div>
                        </div>
                     </body>
                     {ANALYTICS}
                     <!-- BEGIN CORE PLUGINS -->
                     <script src="assets/global/plugins/jquery-1.4.2.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
                     <!-- END CORE PLUGINS -->
                     <!-- BEGIN PAGE LEVEL PLUGINS -->
                     <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
                     <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
                     <!-- END PAGE LEVEL PLUGINS -->
                     <!-- BEGIN THEME GLOBAL SCRIPTS -->
                     <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
                     <!-- END THEME GLOBAL SCRIPTS -->
                     <!-- BEGIN PAGE LEVEL SCRIPTS -->
                     <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
                     <!-- END PAGE LEVEL SCRIPTS -->
                     <!-- BEGIN THEME LAYOUT SCRIPTS -->
                     <!-- END THEME LAYOUT SCRIPTS -->
                     </body>
                  </html>
                  <!-- END termos -->
                  
<!-- BEGIN senhaenviada -->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{TITULO_SISTEMA}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
         <base href="{ABS_LINK}" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.php">
                <img src="images/logo-big.png" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
           
                <h3 class="form-title font-green"></h3>
                <div class="alert alert-danger display-{alertaDisplay}">
                    <button class="close" data-close="alert"></button>
                    <span> {msg_error}</span>
                </div>
                
                    <h3>Um email foi enviado para <strong>{email}</strong>, contendo o link para que sua senha seja redefinida.</h3>
                    
                <div class="form-actions">
                   <a href="login"><button type="button" style="width:100%;" class="btn green uppercase">Voltar</button></a>
                    
                </div>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            
            <!-- END REGISTRATION FORM -->
        <div class="copyright"> 2010 - 2020 © {TITULO_SISTEMA}. </div>
        <!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

    
{ANALYTICS}

        <!-- BEGIN CORE PLUGINS -->
          <script src="assets/global/plugins/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>

<!-- END senhaenviada -->


<!-- BEGIN novasenha -->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{TITULO_SISTEMA}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
         <base href="{ABS_LINK}" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.php">
                <img src="images/logo-big.png" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
           
                <h3 class="form-title font-green"></h3>
                <div class="alert alert-danger display-{alertaDisplay}">
                    <button class="close" data-close="alert"></button>
                    <span> {msg_error}</span>
                </div>
                
                    <h3>Sua nova senha foi redefinida com sucesso.<br>Um e-mail foi enviado para você contendo sua nova senha.<br>Para alterar, basta acesaar o seu perfil.</h3>
                    
                <div class="form-actions">
                   <a href="login"><button type="button" style="width:100%;" class="btn green uppercase">Voltar</button></a>
                    
                </div>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            
            <!-- END REGISTRATION FORM -->
        <div class="copyright"> 2010 - 2020 © {TITULO_SISTEMA}. </div>
        <!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

    
{ANALYTICS}

        <!-- BEGIN CORE PLUGINS -->
          <script src="assets/global/plugins/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>

<!-- END novasenha -->
                  