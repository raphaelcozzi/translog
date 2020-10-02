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
         <button class="btn green" onClick="location='index.php?module=usuarios&method=usuarionovo';">Novo <i class="fa fa-plus"></i></button>
      </div>
      <br>
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">Listagem de Usuários</span>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            {grid_user}
         </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
   </div>
</div>
<!-- END main -->


<!-- BEGIN edita_usuario -->
<script language="javascript">
   function changePermissions(idGrupo)
   {
      
      var itens = '{listagemGrupos}';
      var res = itens.split("|");
      var objeto; 
      var grupo; 
      var id_menu; 
      var permissao; 
      
      var inputs = $('input[type=checkbox]');
   
      inputs.attr('checked', false);
      inputs.prop('checked', false);      
      
      for(var i = 0; i < res.length; i++)
      {
         objeto = res[i].split(",");
         
         grupo = objeto[0];
         id_menu = objeto[1];
         permissao = objeto[2];
   
         if(grupo == idGrupo)
         {
            
            if(permissao == "1")
            {
               document.getElementById('produtos_'+id_menu).checked = true;
            }
            else
            {
               document.getElementById('produtos_'+id_menu).checked = false;
            }
         }
         
      }
   }
</script>
<div class="portlet box blue-dark">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-user"></i>Edit User 
      </div>
      <!--
         <div class="tools">
             <a href="javascript:;" class="collapse"> </a>
             <a href="#portlet-config" data-toggle="modal" class="config"> </a>
             <a href="javascript:;" class="reload"> </a>
             <a href="javascript:;" class="remove"> </a>
         </div>
         -->
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="index.php?module=usuarios&method=update" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <input type="hidden" name="id" value="{id}" />
         <input type="hidden" name="senha_old" value="{senha}" />
         <input type="hidden" name="exception" value="{excpt_value}" />
         <div class="form-body">
            {dados_user}
            {grupos}
            <div class="form-group">
               <label class="col-md-3 control-label">Access Levels</label>
               <div class="col-md-8">
                  {listagem_privilegios}
               </div>
            </div>
         </div>
         <div class="form-actions">
            <div class="row">
               <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn green">Save</button>
                  <button type="button" class="btn grey-salsa btn-outline">Cancel</button>
               </div>
            </div>
         </div>
      </form>
      <!-- END FORM-->
   </div>
</div>
<script type="text/javascript">
   /*
   $(document).ready(function(){
   $('#estados').change(function(){
   $('#cidades').load('index.php?module=meus_dados&method=ajax_cidade&estado='+$('#estados').val() );
   
   });
   });
   
   */    
</script>
<!-- END edita_usuario -->
<!-- BEGIN usuario_novo -->
<script language="javascript">
   
   function changePermissions(idGrupo)
   {
      
      var itens = '{listagemGrupos}';
      var res = itens.split("|");
      var objeto; 
      var grupo; 
      var id_menu; 
      var permissao; 
      
      var inputs = $('input[type=checkbox]');
   
      inputs.attr('checked', false);
      inputs.prop('checked', false);      
      
      for(var i = 0; i < res.length; i++)
      {
         objeto = res[i].split(",");
         
         grupo = objeto[0];
         id_menu = objeto[1];
         permissao = objeto[2];
   
         if(grupo == idGrupo)
         {
            
            if(permissao == "1")
            {
               document.getElementById('produtos_'+id_menu).checked = true;
            }
            else
            {
               document.getElementById('produtos_'+id_menu).checked = false;
            }
         }
         
      }
   }
</script>
<div class="portlet box blue-dark">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-user"></i>Novo Usuário 
      </div>
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="index.php?module=usuarios&method=insere" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <div class="form-body">
            {form}
            {grupos}
            <div class="form-group">
               <label class="col-md-3 control-label">Access Levels</label>
               <div class="col-md-8">
                  {listagem_privilegios}
               </div>
            </div>
         </div>
         <div class="form-actions">
            <div class="row">
               <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn green">Save</button>
                  <button type="button" class="btn grey-salsa btn-outline">Cancel</button>
               </div>
            </div>
         </div>
      </form>
      <!-- END FORM-->
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
   $('#estados').change(function(){
   $('#cidades').load('index.php?module=meus_dados&method=ajax_cidade&estado='+$('#estados').val() );
   
   });
   });
   
</script>
<!-- END usuario_novo -->

<!-- BEGIN grupos -->
<div class="row">
   <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div>
         <button class="btn green" onClick="location='index.php?module=usuarios&method=novoGrupo';">Create new user group <i class="fa fa-plus"></i></button>
      </div>
      <br>
        <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption font-dark">
               <i class="icon-list font-dark"></i>
               <span class="caption-subject bold uppercase">User Groups</span>
            </div>
            <div class="tools"> </div>
         </div>
         <div class="portlet-body">
            {grid_grupos}
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

<!-- END grupos -->


<!-- BEGIN novoGrupo -->
<script language="javascript">
   function changePermissions(idGrupo)
   {
      
      var itens = '{listagemGrupos}';
      var res = itens.split("|");
      var objeto; 
      var grupo; 
      var id_menu; 
      var permissao; 
      
      var inputs = $('input[type=checkbox]');
   
      inputs.attr('checked', false);
      inputs.prop('checked', false);      
      
      for(var i = 0; i < res.length; i++)
      {
         objeto = res[i].split(",");
         
         grupo = objeto[0];
         id_menu = objeto[1];
         permissao = objeto[2];
   
         if(grupo == idGrupo)
         {
            
            if(permissao == "1")
            {
               document.getElementById('produtos_'+id_menu).checked = true;
            }
            else
            {
               document.getElementById('produtos_'+id_menu).checked = false;
            }
         }
         
      }
   }
</script>
<div class="portlet box blue-dark">
<div class="portlet-title">
   <div class="caption">
      <i class="fa fa-user"></i>New User Group 
   </div>
</div>
<div class="portlet-body form">
   <!-- BEGIN FORM-->
   <form action="index.php?module=usuarios&method=insereGrupo" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
      <div class="form-body">
         <div class="form-group">
            <label class="col-md-3 control-label">Name</label>
            <div class="col-md-4">
               <input type="text" class="form-control" placeholder="" name="nome">
               <span class="help-block"> User Group Name. </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Group Roles</label>
            <div class="col-md-8">
               {listagem_privilegios}
            </div>
         </div>
         <div class="form-actions">
            <div class="row">
               <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn green">Save</button>
                  <button type="button" class="btn grey-salsa btn-outline">Cancel</button>
               </div>
            </div>
         </div>
   </form>
   <!-- END FORM-->
   </div>
</div>
<!-- END novoGrupo -->
<!-- BEGIN editaGrupo -->
<script language="javascript">
   function changePermissions(idGrupo)
   {
      
      var itens = '{listagemGrupos}';
      var res = itens.split("|");
      var objeto; 
      var grupo; 
      var id_menu; 
      var permissao; 
      
      var inputs = $('input[type=checkbox]');
   
      inputs.attr('checked', false);
      inputs.prop('checked', false);      
      
      for(var i = 0; i < res.length; i++)
      {
         objeto = res[i].split(",");
         
         grupo = objeto[0];
         id_menu = objeto[1];
         permissao = objeto[2];
   
         if(grupo == idGrupo)
         {
            
            if(permissao == "1")
            {
               document.getElementById('produtos_'+id_menu).checked = true;
            }
            else
            {
               document.getElementById('produtos_'+id_menu).checked = false;
            }
         }
         
      }
   }
</script>
<div class="portlet box blue-dark">
<div class="portlet-title">
   <div class="caption">
      <i class="fa fa-user"></i>Edit User Group 
   </div>
</div>
<div class="portlet-body form">
   <!-- BEGIN FORM-->
   <form action="index.php?module=usuarios&method=updateGrupo" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
      <input type="hidden" name="id" value="{id}" />
      <div class="form-body">
         <div class="form-group">
            <label class="col-md-3 control-label">Name</label>
            <div class="col-md-4">
               <input type="text" class="form-control" placeholder="" name="nome" value="{nome}">
               <span class="help-block"> User Group Name. </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Group Roles</label>
            <div class="col-md-8">
               {listagem_privilegios}
            </div>
         </div>
         <div class="form-actions">
            <div class="row">
               <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn green">Save</button>
                  <button type="button" class="btn grey-salsa btn-outline">Cancel</button>
               </div>
            </div>
         </div>
   </form>
   <!-- END FORM-->
   </div>
</div>
<!-- END editaGrupo -->