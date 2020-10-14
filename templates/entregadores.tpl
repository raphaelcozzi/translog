<!-- BEGIN main -->
<script>
   function ordena()
   {
      return 0;
   }
</script>
<div class="row">
   <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div>
         <button class="btn green" onClick="location='index.php?module=entregadores&method=novo';"><i class="fa fa-plus"></i> Novo Entregador</button>
      </div>
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Listagem de Entregadores</span>
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
<!-- END main -->


<!-- BEGIN novo -->
<div class="portlet box blue-dark">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-truck"></i>Novo Entregador 
      </div>
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="index.php?module=entregadores&method=insere" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <div class="form-body">
            {veiculos}
            {form}
            {estados}
            {cidades}
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

<!-- BEGIN edita -->
<div class="portlet box blue-dark">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-truck"></i>Detalhes do Entregador 
      </div>
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="index.php?module=entregadores&method=update" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <input type="hidden" name="id" value="{id}">
         <div class="form-body">
            {veiculos}
            {form}
            {estados}
            {cidades}
            
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
<script>
   function ordena()
   {
      return 0;
   }
</script>
               
<!-- END edita -->

