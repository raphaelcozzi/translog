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
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Relatório de Entrega</span>
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
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Relatório Financeiro</span>
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
