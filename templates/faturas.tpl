<!-- BEGIN main -->
<script>
   function ordena()
   {
      return 0;
   }
</script>

<style type="text/css">
   .dt-buttons
   {
      display:none;
   }
   
</style>

<div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                            
                              <!--  <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase"></span>
                                    </div>
                                </div> -->
                                <div class="portlet-body">
                                   <form action="index.php?module=faturas&method=main" method="post" name="forms" class="form-horizontal" enctype="multipart/form-data">
                                      <input type="hidden" name="q" value="1">
                                                 <div class="row">
                                                    
                                                    
                                                 <div class="col-md-2">
                                                   Data Inicial: <input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_de" maxlength="10" class="form-control form-control-inline" id="data_de" value="{data_de}">
                                                 </div>                                      
                                                <div class="col-md-2">
                                                   Data Final:<input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_ate" maxlength="10" class="form-control form-control-inline" id="data_ate" value="{data_ate}">
                                                 </div>
                                                    
                                                 <div class="col-md-2"><br>
                                                   <button type="submit" class="btn green">Filtrar Resultados</button>
                                                     </div>       
                                                 
                                                 
                                                 </div>

                                                   
                                   </form>
                                   
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>


<div class="row">
   <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div>
         <a data-toggle="modal" href="#modal_fatura" onclick="javascript:void(0);" ><button class="btn green"><i class="fa fa-plus"></i> Nova Fatura</button></a> <a href="index.php?module=faturas&method=export&data_de={data_de}&data_ate={data_ate}" target="_blank" ><button class="btn red"><i class="fa fa-file"></i> Relatório de Faturas</button></a>
      </div>
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Listagem de Faturas</span>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            {grid}
         </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
   </div>
</div>
         
         
<div class="modal fade" id="modal_fatura" tabindex="-1" role="basic" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="height:auto !important;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Nova Fatura</h4>
                                                </div>
                                                <div class="modal-body" style="width:100%;"> 
                                                   <form action="index.php?module=faturas&method=insere" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
                                                   {situacoes}
                                          {form}                                            
                                                <div class="modal-footer">
                                                <center>   

                                                   <button type="submit" class="btn green" style="width:300px;">Salvar &rightarrow;</button><br><br>
                                                    </center>
                                                </form>
                                      
                                                   <button type="button" id="closemodal" class="btn dark btn-outline" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
</div>
                                                
                                                
                            
                                                
{modals}                                                
                                                
<!-- END main -->


<!-- BEGIN novo -->
<div class="portlet box blue-dark">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-truck"></i>Novo Veículo 
      </div>
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="index.php?module=veiculos&method=insere" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <div class="form-body">
            {tipos}
            {marcas}
            {combustiveis}
            {entregadores}
            {form}
            
            
         </div>
         <div class="form-actions">
            <div class="row">
               <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn green">Salvar</button>
               </div>
            </div>
         </div>
      </form>
      <!-- END FORM-->
   </div>
</div>
<!-- END novo -->

<!-- BEGIN edita -->
<div class="portlet box blue-dark">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-truck"></i>Detalhes do Veículo 
      </div>
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="index.php?module=veiculos&method=update" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <input type="hidden" name="id" value="{id}">
         <div class="form-body">
            {tipos}
            {marcas}
            {combustiveis}
            {entregadores}
            {form}
            
            <div class="row">
               <div class="col-md-4 col-md-offset-3">
                  {photo}
               </div>
            </div>
               <br>
            <div class="row">
                <div class="col-md-4 col-md-offset-3">
                  {photo_documento}
               </div>
            </div>
            
         </div>
         <div class="form-actions">
            <div class="row">
               <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn green" style="width:300px;">Salvar</button>
               </div>
            </div>
         </div>
      </form>
      <!-- END FORM-->
   </div>
</div>
<!-- END edita -->

