<!-- BEGIN main_home -->
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="index.php?module=registros&method=novo&tipo=1">
                                <div class="visual">
                                    <i class="fa fa-arrow-up"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        Registrar Saída
                                    </div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="index.php?module=registros&method=saidas">
                                <div class="visual">
                                    <i class="fa fa-arrow-down"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        Registrar Retorno
                                    </div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
   
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="index.php?module=registros&method=saidas">
                                <div class="visual">
                                    <i class="fa fa-arrow-up"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                       Saídas
                                    </div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="index.php?module=registros&method=retornos">
                                <div class="visual">
                                    <i class="fa fa-arrow-down"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                       Retornos
                                    </div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
   
</div>

<div class="row">
   <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Resumo do dia</span>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            {grid_resumo_dia}
         </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
   </div>
</div>
<div class="row">
   <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Registros de Saídas do dia</span>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            {grid_saidas}
         </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
   </div>
</div>
<div class="row">
   <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Registros de Retornos do dia</span>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            {grid_retornos}
         </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
   </div>
</div>

         
<script>
   function ordena()
   {
      return 0;
   }
   
</script>


<!-- END main_home -->


<!-- BEGIN cabecalho -->
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
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta content="" name="description" />
            <meta content="" name="author" />
            <base href="{ABS_LINK}" />
            <!-- BEGIN GLOBAL MANDATORY STYLES -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
            <!-- END GLOBAL MANDATORY STYLES -->
            <!-- BEGIN THEME GLOBAL STYLES -->
            <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
            <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
            <!-- END THEME GLOBAL STYLES -->
            <!-- BEGIN THEME LAYOUT STYLES -->
            <link href="assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" />
            <link href="assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
            <!-- END THEME LAYOUT STYLES -->
            <link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/global/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" />
            <link rel='stylesheet' type='text/css' href='assets/global/plugins/fullcalendar/fullcalendar.print.css' media='print' />
            <link href="assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
            <link rel="shortcut icon" href="favicon.ico" />
         </head>
         <!-- END HEAD -->
         <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
               <!-- BEGIN HEADER INNER -->
               <div class="page-header-inner ">
                  <!-- BEGIN LOGO -->
                  <div class="page-logo">
                     <a href="home">
                     <img src="images/logo-light.png" alt="logo" class="logo-default" style="margin-top:20px;" /> </a>
                     <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                     </div>
                  </div>
                  <!-- END LOGO -->
                  <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                  <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                  <!-- END RESPONSIVE MENU TOGGLER -->
                  <!-- BEGIN PAGE TOP -->
                  <div class="page-top">
                     <!-- BEGIN HEADER SEARCH BOX -->
                     <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
                     <!-- END HEADER SEARCH BOX -->
                     <!-- BEGIN TOP NAVIGATION MENU -->
                     <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                           <li class="separator hide"> </li>
                           <!-- BEGIN NOTIFICATION DROPDOWN -->
                           <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                           <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                              <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                              <i class="icon-envelope-open"></i>
                              {total_pending_notifications} 
                              </a>
                              <ul class="dropdown-menu">
                                 <li class="external">
                                    <h3>
                                       <span class="bold">{total_pending_notifications} notifica&ccedil;&otilde;es</span> novas
                                    </h3>
                                    <!-- <a href="page_user_profile_1.html">ver tudo</a>-->
                                 </li>
                                 <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 450px;" data-handle-color="#637283">
                                       {html_notifications}
                                    </ul>
                                 </li>
                              </ul>
                           </li>
                           <!-- END NOTIFICATION DROPDOWN -->
                           <li class="separator hide"> </li>
                           <!-- BEGIN USER LOGIN DROPDOWN -->
                           <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                           <li class="dropdown dropdown-user dropdown-dark">
                              <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                 <span class="username username-hide-on-mobile"> {usuario_nome} </span>
                                 <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                 {avatar} 
                              </a>
                              <ul class="dropdown-menu dropdown-menu-default">
                                 <li>
                                    <a href="meusdados">
                                    <i class="icon-user"></i> Profile </a>
                                 </li>
                                 <li class="divider"> </li>
                                 <li>
                                    <a href="login/logout">
                                    <i class="icon-key"></i> Logout </a>
                                 </li>
                              </ul>
                           </li>
                           <!-- END USER LOGIN DROPDOWN -->
                           <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                           <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                     </div>
                     <!-- END TOP NAVIGATION MENU -->
                  </div>
                  <!--<div style="float:left; margin-top: 0px;"><h2>TITULO CABCEÇALHO</h2></div>-->           
                  <!-- END PAGE TOP -->
               </div>
               <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
            <div class="page-sidebar-wrapper">
               <div class="page-sidebar navbar-collapse collapse">
                  <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                     {menu}
                  </ul>
               </div>
               <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
               <!-- BEGIN PAGE HEAD-->
               <div class="page-head">
                  <!-- BEGIN PAGE TITLE -->
                  <div class="page-title">
                     <h1>
                        {page_title}
                        <!-- <small>blank page layout</small> -->
                     </h1>
                  </div>
               </div>
               <!-- END PAGE HEAD-->
               <!-- BEGIN PAGE BREADCRUMB -->
               <ul class="page-breadcrumb breadcrumb">
                  {breadcrumbs}
               </ul>
               <!-- END PAGE BREADCRUMB -->
               {msg}               
               <!-- END cabecalho -->
               
               
               <!-- BEGIN footer -->
              <div class="kc_fab_wrapper" ></div>
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER_ -->
            <div class="page-footer">
               <div class="page-footer-inner"> 2010 - {anoatual} &copy; {TITULO_SISTEMA}.
               </div>
               <div class="scroll-to-top">
                  <i class="icon-arrow-up"></i>
               </div>
            </div>
            <!-- END FOOTER_ -->
            <!--[if lt IE 9]>
            <script src="assets/global/plugins/respond.min.js"></script>
            <script src="assets/global/plugins/excanvas.min.js"></script> 
            <![endif]-->
            <!-- BEGIN CORE PLUGINS -->
            <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
            <script src="assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
            <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
            <!-- END THEME LAYOUT SCRIPTS -->
            <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
            <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
            <script src="assets/pages/scripts/table-datatables-colreorder.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
            <script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
            <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
            <script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
            <script src="assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
            <script src="assets/pages/scripts/form-dropzone.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
            <script src="assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
            <script src="assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
            <!-- <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>-->
            <script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
            <script src="assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
            <script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
            <script src="assets/global/scripts/jquery.maskMoney.js" type="text/javascript"></script>
            <script src="assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
            <link href="3rd_party/jquery.signature.css" rel="stylesheet">
            <script type="text/javascript" src="3rd_party/jquery.ui.touch-punch.min.js"></script>
            <script>
               
               function MascaraDecimal(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
                var sep = 0;
                var key = '';
                var i = j = 0;
                var len = len2 = 0;
                var strCheck = '0123456789';
                var aux = aux2 = '';
                var whichCode = (window.Event) ? e.which : e.keyCode;
                if (whichCode == 13) return true;
                key = String.fromCharCode(whichCode); // Valor para o código da Chave
                if (strCheck.indexOf(key) == -1) return false; // Chave inválida
                len = objTextBox.value.length;
                for(i = 0; i < len; i++)
                    if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
                aux = '';
                for(; i < len; i++)
                    if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
                aux += key;
                len = aux.length;
                if (len == 0) objTextBox.value = '';
                if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
                if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
                if (len > 2) {
                    aux2 = '';
                    for (j = 0, i = len - 3; i >= 0; i--) {
                        if (j == 3) {
                            aux2 += SeparadorMilesimo;
                            j = 0;
                        }
                        aux2 += aux.charAt(i);
                        j++;
                    }
                    objTextBox.value = '';
                    len2 = aux2.length;
                    for (i = len2 - 1; i >= 0; i--)
                    objTextBox.value += aux2.charAt(i);
                    objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
                }
                return false;
               }
               
               function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
                var sep = 0;
                var key = '';
                var i = j = 0;
                var len = len2 = 0;
                var strCheck = '0123456789';
                var aux = aux2 = '';
                var whichCode = (window.Event) ? e.which : e.keyCode;
                if (whichCode == 13 || whichCode == 8 || whichCode == 0) return true;
                key = String.fromCharCode(whichCode); // Valor para o cï¿½digo da Chave
                if (strCheck.indexOf(key) == -1) return false; // Chave invï¿½lida
                len = objTextBox.value.length;
                for(i = 0; i < len; i++)
                    if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
                aux = '';
                for(; i < len; i++)
                    if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
                aux += key;
                len = aux.length;
                if (len == 0) objTextBox.value = '';
                if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
                if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
                if (len > 2) {
                    aux2 = '';
                    for (j = 0, i = len - 3; i >= 0; i--) {
                        if (j == 3) {
                            aux2 += SeparadorMilesimo;
                            j = 0;
                        }
                        aux2 += aux.charAt(i);
                        j++;
                    }
                    objTextBox.value = '';
                    len2 = aux2.length;
                    for (i = len2 - 1; i >= 0; i--)
                    objTextBox.value += aux2.charAt(i);
                    objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
                }
                return false;
               }
               
               
               
               $(function(){
                $("#upload_link").on('click', function(e){
                    e.preventDefault();
                    $("#uploadavatar:hidden").trigger('click');
                });
               
                $("#upload_link2").on('click', function(e){
                    e.preventDefault();
                    $("#uploadavatar:hidden").trigger('click');
                });
               
                $("#upload_link3").on('click', function(e){
                    e.preventDefault();
                    $("#uploadavatar2:hidden").trigger('click');
                });
               
                $("#upload_link4").on('click', function(e){
                    e.preventDefault();
                    $("#uploadavatar2:hidden").trigger('click');
                });
               
                  {avatarsJs2}
                  
               $("#upload_link_1a").on('click', function(e){e.preventDefault(); $("#uploadavatar_1a:hidden").trigger('click');});
               $("#upload_link_2a").on('click', function(e){e.preventDefault(); $("#uploadavatar_2a:hidden").trigger('click');});
               $("#upload_link_3a").on('click', function(e){e.preventDefault(); $("#uploadavatar_3a:hidden").trigger('click');});
               $("#upload_link_4a").on('click', function(e){e.preventDefault(); $("#uploadavatar_4a:hidden").trigger('click');});
               
               });        
               
               
               
               
               /*
               document.getElementById("uploadavatar").onchange = function () {
                var reader = new FileReader();
               
                reader.onload = function (e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("theavatar").src = e.target.result;
                };
               
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
               };
               
               
               document.getElementById("uploadavatar2").onchange = function () {
                var reader = new FileReader();
               
                reader.onload = function (e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("theavatar2").src = e.target.result;
                };
               
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
               };
               
               */
               
               
               
!function(t){t.kc||(t.kc=new Object),t.kc.fab=function(n,a,i){var o=this;o.$el=t(n),o.el=n,o.$el.data("kc.fab",o);var l,e;o.init=function(){if(("undefined"==typeof a||null===a)&&(a=[{url:null,bgcolor:"red",icon:"+"},{url:"http://www.example.com",bgcolor:"orange",icon:"+"},{url:"http://www.example.com",bgcolor:"yellow",icon:"+"}]),o.links=a,o.links.length>0){main_btn=o.links[0],color_style=main_btn.color?"color:"+main_btn.color+";":"",bg_color_style=main_btn.bgcolor?"background-color:"+main_btn.bgcolor+";":"",main_btn_dom="<button data-link-href='"+(main_btn.url?main_btn.url:"")+"' data-link-target='"+(main_btn.target?main_btn.target:"")+"'' class='kc_fab_main_btn' style='"+bg_color_style+"'><span style='"+color_style+"'>"+main_btn.icon+"</span></button>",sub_fab_btns_dom="",o.links.shift();for(var n=0;n<o.links.length;n++)color_style=o.links[n].color?"color:"+o.links[n].color+";":"",bg_color_style=o.links[n].bgcolor?"background-color:"+o.links[n].bgcolor+";":"",sub_fab_btns_dom+="<div><button data-link-href='"+(o.links[n].url?o.links[n].url:"")+"' data-link-target='"+(o.links[n].target?o.links[n].target:"")+"' class='sub_fab_btn' style='"+bg_color_style+"'><span style='"+color_style+"'>"+o.links[n].icon+"</span></button></div>";sub_fab_btns_dom="<div class='sub_fab_btns_wrapper'>"+sub_fab_btns_dom+"</div>",o.$el.append(sub_fab_btns_dom).append(main_btn_dom)}else"undefined"==typeof console&&(window.console={log:function(t){alert(t)}}),console.log("Invalid links array param");o.options=t.extend({},t.kc.fab.defaultOptions,i),l=o.$el.find(".kc_fab_main_btn"),e=o.$el.find(".sub_fab_btns_wrapper"),l.click(function(n){t(this).attr("data-link-href").length>0&&(t(this).attr("data-link-target")?window.open(t(this).attr("data-link-href"),t(this).attr("data-link-target")):window.location.href=t(this).attr("data-link-href")),e.toggleClass("show"),t(".kc_fab_overlay").length>0?(t(".kc_fab_overlay").remove(),l.blur()):t("body").append('<div class="kc_fab_overlay" ></div>'),0===t(this).find(".ink").length?t(this).prepend("<span class='ink'></span>"):(t(this).find(".ink").remove(),t(this).prepend("<span class='ink'></span>")),ink=t(this).find(".ink"),ink.height()||ink.width()||(d=Math.max(t(this).outerWidth(),t(this).outerHeight()),ink.css({height:d,width:d})),x=n.pageX-t(this).offset().left-ink.width()/2,y=n.pageY-t(this).offset().top-ink.height()/2,ink.css({top:y+"px",left:x+"px"}).addClass("animate")}),e.find(".sub_fab_btn").on("mousedown",function(){t(this).attr("data-link-href").length>0&&(t(this).attr("data-link-target")?window.open(t(this).attr("data-link-href"),t(this).attr("data-link-target")):window.location.href=t(this).attr("data-link-href"))}),l.focusout(function(){e.removeClass("show"),overlay=t(".kc_fab_overlay"),overlay.remove()})},o.init()},t.kc.fab.defaultOptions={},t.fn.kc_fab=function(n,a){return this.each(function(){new t.kc.fab(this,n,a)})}}(jQuery);

   $(document).ready(function(){
               

      
   $('#id_estado').change(function(){
      
   $('#id_cidade').load('index.php?module=entregadores&method=ajax_cidade&estado='+$('#id_estado').val() );
   
   });
               
   $('#id_entregador').change(function(){
      
   $('#id_veiculo').load('index.php?module=registros&method=ajax_entregador&entregador='+$('#id_entregador').val() );
   
   });
                
                
               
     var links_a = [
        {
            "bgcolor":"#0088CC",
            "icon":"+"
        },
        {
            "url":"index.php?module=registros&method=novo&tipo=1",
            "bgcolor":"green",
            "color":"#fffff",
            "icon":"<i class='fa fa-arrow-circle-up'></i>",
            "title":"Saída"
        },
        {
            "url":"index.php?module=registros&method=saidas",
            "bgcolor":"red",
            "color":"white",
            "icon":"<i class='fa fa-arrow-circle-down'></i>",
            "title":"Retorno"
        }
    ];
    
     $('.kc_fab_wrapper').kc_fab(links_a);
                
                
               });
               
     
     
            </script><!-- BEGIN HEAD -->
            
            <style type="text/css">
.kc_fab_overlay{
  z-index: 9998;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10;
  background-color: rgba(255,255,255,0.5); /*dim the background*/
}
.kc_fab_wrapper{
  z-index: 9999;
  width:80px;
  height:240px;
  position:fixed;
  right:10px;
  bottom:0px;
}
.sub_fab_btns_wrapper{
  right:0;
  bottom:95px; /* aqui */
  position:absolute;
  display:none;
  opacity: 0;
  -webkit-transition: opacity 0.3s ease-in;
       -moz-transition: opacity 0.3s ease-in;
        -ms-transition: opacity 0.3s ease-in;
         -o-transition: opacity 0.3s ease-in;
            transition: opacity 0.3s ease-in;
}
.sub_fab_btns_wrapper.show{
  display:block;
  opacity: 1;
}
.sub_fab_btns_wrapper button{
  width:60px;
  height:60px;
  border-radius:100% !important; 
  background:#F44336;
  margin-bottom:10px; 
  margin-right:16px; 
  padding:0;
  border:none;
  outline:none;
  color:#FFF;
  font-size: 19px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  transition:.3s;  
}
button.kc_fab_main_btn{
  background-color:#F44336;
  width:60px;
  height:60px;
  border-radius:100% !important;
  background:#F44336;
  right:16px;
  bottom:36px;
  position:absolute;
  margin-right:0;
  margin-bottom:0;
  padding:0;
  border:none;
  outline:none;
  color:#FFF;
  font-size:36px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  transition:.3s;  
  -webkit-tap-highlight-color: rgba(0,0,0,0);
}
.kc_fab_main_btn span{
  transition:.5s;  
}
.kc_fab_main_btn:hover span{

}
.kc_fab_main_btn:focus {
  transform:scale(1.1);
  transform:rotate(45deg);
  -ms-transform: rotate(45deg);
    -webkit-transform: rotate(45deg);

}



.ink {
  display: block;
  position: absolute;
  background:rgba(255, 255, 255, 0.3);
  border-radius: 100% !important;
  -webkit-transform:scale(0);
     -moz-transform:scale(0);
       -o-transform:scale(0);
          transform:scale(0);

}

.animate {
  -webkit-animation:ripple 0.65s linear;
   -moz-animation:ripple 0.65s linear;
    -ms-animation:ripple 0.65s linear;
     -o-animation:ripple 0.65s linear;
        animation:ripple 0.65s linear;

}

@-webkit-keyframes ripple {
    100% {opacity: 0; -webkit-transform: scale(2.5);}
}
@-moz-keyframes ripple {
    100% {opacity: 0; -moz-transform: scale(2.5);}
}
@-o-keyframes ripple {
    100% {opacity: 0; -o-transform: scale(2.5);}
}
@keyframes ripple {
    100% {opacity: 0; transform: scale(2.5);}
}
</style>   

         </body>
      </html>
      <!-- END footer -->
      <!-- BEGIN cabecalho_deslogado -->
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
                  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
                  <!-- END GLOBAL MANDATORY STYLES -->
                  <!-- BEGIN THEME GLOBAL STYLES -->
                  <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
                  <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
                  <!-- END THEME GLOBAL STYLES -->
                  <!-- BEGIN THEME LAYOUT STYLES -->
                  <link href="assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" />
                  <link href="assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
                  <!-- END THEME LAYOUT STYLES -->
                  <link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
                  <link href="assets/global/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" />
                  <link rel='stylesheet' type='text/css' href='assets/global/plugins/fullcalendar/fullcalendar.print.css' media='print' />
                  <link href="assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
                  <link rel="shortcut icon" href="favicon.ico" />
               </head>
               <!-- END HEAD -->
               <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
                  <!-- BEGIN HEADER -->
                  <div class="page-header navbar navbar-fixed-top">
                     <!-- BEGIN HEADER INNER -->
                     <div class="page-header-inner ">
                        <!-- BEGIN LOGO -->
                        <div class="page-logo">
                           <a href="home">
                           <img src="images/logo-light.png" alt="logo" class="logo-default" style="margin-top:0px;"  /> </a>
                           <div class="menu-toggler sidebar-toggler hide">
                              <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                           </div>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                        <!-- END RESPONSIVE MENU TOGGLER -->
                        <!-- BEGIN PAGE TOP -->
                        <div class="page-top">
                           <!-- BEGIN HEADER SEARCH BOX -->
                           <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
                           <!-- END HEADER SEARCH BOX -->
                           <!-- BEGIN TOP NAVIGATION MENU -->
                           <div class="top-menu">
                              <ul class="nav navbar-nav pull-right">
                                 <li class="separator hide"> </li>
                                 <!-- BEGIN NOTIFICATION DROPDOWN -->
                                 <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                 <!-- END NOTIFICATION DROPDOWN -->
                                 <li class="separator hide"> </li>
                                 <!-- BEGIN USER LOGIN DROPDOWN -->
                                 <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                 <!-- END USER LOGIN DROPDOWN -->
                                 <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                                 <!-- END QUICK SIDEBAR TOGGLER -->
                              </ul>
                           </div>
                           <!-- END TOP NAVIGATION MENU -->
                        </div>
                        <!--<div style="float:left; margin-top: 0px;"><h2>TITULO CABEÇALHO</h2></div>-->           
                        <!-- END PAGE TOP -->
                     </div>
                     <!-- END HEADER INNER -->
                  </div>
                  <!-- END HEADER -->
                  <!-- BEGIN HEADER & CONTENT DIVIDER -->
                  <div class="clearfix"> </div>
                  <!-- END HEADER & CONTENT DIVIDER -->
                  <!-- BEGIN CONTAINER -->
                  <div class="page-container">
                  <div class="page-sidebar-wrapper">
                     <div class="page-sidebar navbar-collapse collapse">
                     </div>
                     <!-- END SIDEBAR -->
                  </div>
                  <!-- END SIDEBAR -->
                  <!-- BEGIN CONTENT -->
                  <div class="page-content-wrapper">
                  <!-- BEGIN CONTENT BODY -->
                  <div class="page-content">
                  <!-- BEGIN PAGE HEAD-->
                  <div class="page-head">
                     <!-- BEGIN PAGE TITLE -->
                     <div class="page-title">
                        <h1>
                           {page_title}
                           <!-- <small>blank page layout</small> -->
                        </h1>
                     </div>
                  </div>
                  <!-- END PAGE HEAD-->
                  <!-- BEGIN PAGE BREADCRUMB -->
                  <!-- END PAGE BREADCRUMB -->
                  <!-- END cabecalho_deslogado -->