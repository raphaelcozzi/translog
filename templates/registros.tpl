<!-- BEGIN novo -->
<div class="portlet box blue-dark">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-truck"></i>Novo Registro de {tipo_registro} 
      </div>
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="index.php?module=registros&method=insere" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <input type="hidden" name="tipo" value="{tipo}">
         <div class="form-body">
            {entregadores}
            {veiculos}
            {diarias}
            {form}
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
<script>
   function ordena()
   {
      return 0;
   }
</script>
         
<!-- END novo -->

<!-- BEGIN entrega -->
<script>
   function ordena()
   {
      return 0;
   }
</script>

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
                                   <form action="index.php?module=registros&method=entrega" method="post" name="forms" class="form-horizontal" enctype="multipart/form-data">
                                      <input type="hidden" name="q" value="1">
                                                 <div class="row">
                                                    
                                                    
                                                 <div class="col-md-2">
                                                   Data Inicial: <input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_de" maxlength="10" class="form-control form-control-inline" id="data_de" value="{data_de}">
                                                 </div>                                      
                                                <div class="col-md-2">
                                                   Data Final:<input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_ate" maxlength="10" class="form-control form-control-inline" id="data_ate" value="{data_ate}">
                                                 </div>
                                                    

                                                <div class="col-md-2">
                                                   Entregador: <br><select name="id_entregador" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                      {listagem_entregadores}
                                                   </select>
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
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Relatório de Entrega - Período: {data_de_format} - {data_ate_format}</span>
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


<!-- END entrega -->

<!-- BEGIN financeiro -->
<script>
   function ordena()
   {
      return 0;
   }
</script>


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
                                   <form action="index.php?module=registros&method=financeiro" method="post" name="forms" class="form-horizontal" enctype="multipart/form-data">
                                      <input type="hidden" name="q" value="1">
                                                 <div class="row">
                                                    
                                                    
                                                 <div class="col-md-2">
                                                   Data Inicial: <input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_de" maxlength="10" class="form-control form-control-inline" id="data_de" value="{data_de}">
                                                 </div>                                      
                                                <div class="col-md-2">
                                                   Data Final:<input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_ate" maxlength="10" class="form-control form-control-inline" id="data_ate" value="{data_ate}">
                                                 </div>
                                                    

                                                <div class="col-md-2">
                                                   Entregador: <br><select name="id_entregador" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                      {listagem_entregadores}
                                                   </select>
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
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Relatório Financeiro - Período: {data_de_format} - {data_ate_format}</span>
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


<!-- END financeiro -->


<!-- BEGIN saidas -->
<script>
   function ordena()
   {
      return 0;
   }
</script>

<h2>Para registrar um retorno, escolha a saída referente a ele.</h2>
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
                                   <form action="index.php?module=registros&method=saidas" method="post" name="forms" class="form-horizontal" enctype="multipart/form-data">
                                      <input type="hidden" name="q" value="1">
                                                 <div class="row">
                                                    
                                                    
                                                 <div class="col-md-2">
                                                   Data Inicial: <input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_de" maxlength="10" class="form-control form-control-inline" id="data_de" value="{data_de}">
                                                 </div>                                      
                                                <div class="col-md-2">
                                                   Data Final:<input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_ate" maxlength="10" class="form-control form-control-inline" id="data_ate" value="{data_ate}">
                                                 </div>
                                                    

                                                <div class="col-md-2">
                                                   Entregador: <br><select name="id_entregador" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                      {listagem_entregadores}
                                                   </select>
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
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Registros de Saídas</span>
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


<!-- END saidas -->


<!-- BEGIN retornos -->
<script>
   function ordena()
   {
      return 0;
   }
</script>

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
                                   <form action="index.php?module=registros&method=retornos" method="post" name="forms" class="form-horizontal" enctype="multipart/form-data">
                                      <input type="hidden" name="q" value="1">
                                                 <div class="row">
                                                    
                                                    
                                                 <div class="col-md-2">
                                                   Data Inicial: <input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_de" maxlength="10" class="form-control form-control-inline" id="data_de" value="{data_de}">
                                                 </div>                                      
                                                <div class="col-md-2">
                                                   Data Final:<input type="date" placeholder="DD/MM/YYYY" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" name="data_ate" maxlength="10" class="form-control form-control-inline" id="data_ate" value="{data_ate}">
                                                 </div>
                                                    

                                                <div class="col-md-2">
                                                   Entregador: <br><select name="id_entregador" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                      {listagem_entregadores}
                                                   </select>
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
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Registros de Retornos</span>
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
{modals}

<!-- END retornos -->
