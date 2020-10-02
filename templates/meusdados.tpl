<!-- BEGIN main -->
<div class="portlet light bordered">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-user"></i>Meus dados 
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
      <form action="index.php?module=meusdados&method=update_usuario"  method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
         <input type="hidden" name="senha_old" value="{senha}" />
         <div class="form-body">
            <div class="form-group">
               <label class="col-md-3 control-label">Nome</label>
               <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="" name="nome" value="{nome}">
                  <span class="help-block"> Nome do usu&aacute;rio. </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Email </label>
               <div class="col-md-4">
                  <div class="input-group">
                     <input type="email" name="email" class="form-control" placeholder="" value="{login}">                                                                   <span class="input-group-addon input-circle-right">
                     <i class="fa fa-envelope"></i>
                     </span>
                  </div>
                  <span class="help-block"> (Ser&aacute; o login) </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Senha</label>
               <div class="col-md-4">
                  <div class="input-group">
                     <input type="password" name="senha" class="form-control" placeholder="Senha" value="{senha}">
                     <span class="input-group-addon input-circle-right">
                     <i class="fa fa-key"></i>
                     </span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Confirme a Senha</label>
               <div class="col-md-4">
                  <div class="input-group">
                     <input type="password" name="senha2" class="form-control" placeholder="Repita a senha" value="{senha}">
                     <span class="input-group-addon input-circle-right">
                     <i class="fa fa-key"></i>
                     </span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Estado</label>
               <div class="col-md-4">
                  <div class="input-group">
                     <select name="estado" id="estados"  class="form-control">
                     {listagem_estado}
                     </select>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Cidade</label>
               <div class="col-md-4">
                  <div class="input-group">
                     <select name="cidade" id="cidades"  class="form-control">
                     {listagem_cidade}
                     </select>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Telefone</label>
               <div class="col-md-4">
                  <input type="text" class="form-control" placeholder="" name="telefone" value="{telefone}">
                  <span class="help-block"></span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Foto</label>
               <div class="col-md-4">
                  <img src="{avatar}" border="0" width="200" height="200" />
                  <input type="file" name="avatar" />
                  <span class="help-block"></span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Bio</label>
               <div class="col-md-4">
                  <textarea name="bio" rows="5" style="width:100%;" >{bio}</textarea>
                  <span class="help-block"></span>
               </div>
            </div>
         </div>
         <div class="form-actions">
            <div class="row">
               <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn green">{BTN_SALVAR}</button>
                  <button type="button" class="btn grey-salsa btn-outline">{BTN_CANCELAR}</button>
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
   $('#cidades').load('index.php?module=meusdados&method=ajax_cidade&estado='+$('#estados').val() );
   
   });
   });
   
</script>
<!-- END main -->