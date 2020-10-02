<?php
require_once("modules/home.php");                                                                      

	class usuarios extends home                                                                             
    {              

		function main()
		{
			@session_start();
                        
			if($_SESSION['id'] != $_SESSION['boss'])
			$this->valida_privilegios();
         
         $_SESSION['page_title'] = "Usuários";
			
			$db = new db();
			$db1 = new db();
			$db2 = new db();
			$db3 = new db();
			$db4 = new db();

			$sql = "SELECT
					usuarios.id as id
					, usuarios.nome
					, usuarios.email
					, usuarios_grupos.id_grupo as id_grupo
				FROM
					usuarios,
					usuarios_grupos
				WHERE usuarios.id = usuarios_grupos.id_usuario
            AND usuarios.usuario_master = ".$_SESSION['boss']."
            ORDER BY usuarios.nome ASC";
				
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			

			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id_usuario = $db->f("id");			
				$nome = $db->f("nome");			
				$email = $db->f("email");
            $idGrupo = $db->f("id_grupo");
				
				$sql2 = "SELECT nome FROM grupos WHERE id = ".$idGrupo." ";
            $db2->query($sql2,__LINE__,__FILE__);
            $db2->next_record();
            $grupo = $db2->f("nome");
            
            
				$usuarios_listagem .= '<tr> 
										<td>'.$nome.'</td>
										<td>'.$email.'</td>
										<td>'.$grupo.'</td> 
										<td><a href="index.php?module=usuarios&method=edita&id='.$db->f("id").'" >Edit</a></td>
										<td><a href="index.php?module=usuarios&method=exclui&id='.$db->f("id").'" onclick="return(confirm(\'Confirm delete user '.$db->f("nome").' ? \'))">Excluir</a></td>										
									</tr>';
				
				
				
				
				$db->next_record();
			}

		if($_SESSION['botao_inserir'] == 1)
			$btn_novo = '<input style="margin-left:-3px;" type="button" class="btn" onclick="location=\'index.php?module=usuarios&method=usuario_novo\'" value="Cadastrar novo usu&aacute;rio">';
		else
			$btn_novo = "";	
      
      
      $grid_user = montaGrid("sample_1",$usuarios_listagem,"usuarios");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid_user",$grid_user);
		$GLOBALS["base"]->template->set_var("btn_novo",$btn_novo);
													
		$GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'main');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           

			
		}

		function busca()
		{
			@session_start();
			$db = new db();
			$db1 = new db();
			$db2 = new db();
			$db3 = new db();
			$db4 = new db();

            if($_SESSION['id'] != $_SESSION['boss'])
                $this->valida_privilegios();
            
          $_SESSION['page_title'] = "Usuários";  

			$q = blockrequest($_REQUEST['q']);

			$sql = "SELECT
					usuarios.id as id
					, usuarios.nome
					, usuarios.email
					, usuarios_grupos.id_grupo as id_grupo
				FROM
					usuarios,
					usuarios_grupos
				WHERE usuarios.id = usuarios_grupos.id_usuario
				AND (usuarios.nome LIKE '%".$q."%' OR usuarios.email LIKE '%".$q."%')
            AND usuarios.usuario_master = ".$_SESSION['boss']."
			   ORDER BY usuarios.nome ASC";
					
				
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			

			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id_usuario = $db->f("id");			
				$nome = $db->f("nome");			
				$email = $db->f("email");
            $idGrupo = $db->f("id_grupo");
				
				$sql2 = "SELECT nome FROM grupos WHERE id = ".$idGrupo." ";
            $db2->query($sql2,__LINE__,__FILE__);
            $db2->next_record();
            $grupo = $db2->f("nome");
				
				
				$usuarios_listagem .= '<tr> 
										<td>'.$nome.'</td>
										<td>'.$email.'</td>
										<td>'.$grupo.'</td> 
										<td><a href="index.php?module=usuarios&method=edita&id='.$db->f("id").'" >Edit</a></td>
										<td><a href="index.php?module=usuarios&method=exclui&id='.$db->f("id").'" onclick="return(confirm(\'Confirm delete user '.$db->f("nome").' ? \'))">Delete</a></td>										
									</tr>';

					
				$db->next_record();
			}

		if($_SESSION['botao_inserir'] == 1)
			$btn_novo = '<input style="margin-left:-3px;" type="button" class="btn" onclick="location=\'index.php?module=usuarios&method=usuario_novo\'" value="Cadastrar novo usu&aacute;rio">';
		else
			$btn_novo = "";	

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("usuarios_listagem",$usuarios_listagem);
		$GLOBALS["base"]->template->set_var("btn_novo",$btn_novo);
													
		echo $GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'main');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           

			
		}
		
	function usuarionovo()
	{
		@session_start();
		$db = new db();
		$db1 = new db();
		$db2 = new db();
		$db3 = new db();
		$db4 = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
          $this->valida_privilegios();
         
         $_SESSION['page_title'] = "Novo Usuário";

			$grupo = blockrequest($_REQUEST['grupo']);	
         
         
                
		    $sql = "select * from estados";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();

			$listagem_estado = "<option value='7' selected>Rio de Janeiro</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_estado .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $estado)
					$listagem_estado .= "selected='selected'";
				
				$listagem_estado .= ">".$db->f("estado")."</option>";			
	
				$db->next_record();

			}


		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		
		if(ACTIVE_GRANTEES == 1)
		{
			
			$listagem_privilegios = '<div class="portlet">
		<div class="portlet-content nopadding">
          <table cellpadding="0" cellspacing="0" id="box-table-a" width="100%" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">Area</th>
                <th scope="col">Item</th>
                <th scope="col">Acesso</th>
              </tr>
            </thead>
            <tbody>'; 

			$sql = "SELECT * FROM areas ORDER BY descricao ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
		
			for($l = 0; $l < $db->num_rows(); $l++)
			{

            $listagem_privilegios .= '<tr>
                           <td colspan="3"><h3>'.$db->f("descricao").'</h3></td>
                          </tr>';
            
            $sql = "SELECT * FROM menu_itens WHERE id_area = ".$db->f("id")." ";
				$db2->query($sql,__LINE__,__FILE__);
				$db2->next_record();
				
            
            if(isset($_REQUEST['grupo']))
            {

               for($a = 0; $a < $db2->num_rows(); $a++)
               {



                  $listagem_privilegios .= '<tr>
                                 <td>'.$db->f("descricao").'</td>
                                 <td>'.$db2->f("descricao").'</td>
                                 <td width="120"><input type="checkbox" name="produtos[]" id="produtos_'.$db2->f("id").'" value="'.$db2->f("id").'"></td>
                                </tr>';



                  $db2->next_record();
               }
               
            }
            else
            {
               for($a = 0; $a < $db2->num_rows(); $a++)
               {



                  $listagem_privilegios .= '<tr>
                                 <td>'.$db->f("descricao").'</td>
                                 <td>'.$db2->f("descricao").'</td>
                                 <td width="120"><input type="checkbox" name="produtos[]" id="produtos_'.$db2->f("id").'" value="'.$db2->f("id").'"></td>
                                </tr>';



                  $db2->next_record();
               }
              
            }
	
				$db->next_record();
			}
			
				$listagem_privilegios .= '<tr class="footer">
											<td ></td>
											<td align="right">&nbsp;</td>
											<td align="right">
											</td>
										  </tr>
										</tbody>
									  </table>
									</div>
								  </div>';

		}
		else
			$listagem_privilegios = "";
			

      	$sql = "SELECT * FROM grupos ORDER BY nome ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			for($l = 0; $l < $db->num_rows(); $l++)
			{
            $listagem_grupos .= '<option value="'.$db->f("id").'" ';
            $listagem_grupos .= '>'.$db->f("nome").'</option>';           
   			
            $db->next_record();
         }


      $form = montaForm("usuarionovo");
      $grupos = montaSelect("usuarionovo",$listagem_grupos,7);  // campos do tipo select
      

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		$GLOBALS["base"]->template->set_var('form',$form);
		$GLOBALS["base"]->template->set_var('grupos',$grupos);
      
		$GLOBALS["base"]->template->set_var('listagem_privilegios',$listagem_privilegios);
		$GLOBALS["base"]->template->set_var("listagemGrupos",$this->listagrupos());
		$GLOBALS["base"]->template->set_var('BTN_SALVAR' , BTN_SALVAR);
		$GLOBALS["base"]->template->set_var('BTN_CANCELAR' , BTN_CANCELAR);  
		$GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'usuario_novo');                                            
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                               
		
	}

	function ajax_cidade()
	{
		
		@session_start();
		$db = new db();
	
		$idestado = $_GET['estado'];
	
	   $sql = "SELECT * FROM cidades WHERE id_estados = ".$idestado;
	   $db->query($sql,__LINE__,__FILE__);
	   $db->next_record();
	
	   for($i = 0; $i < $db->num_rows(); $i++)
	   {
		   echo "<option value='".$db->f("id")."'>".$db->f("cidade")."</option>";
	
		   $db->next_record();
	
	   }
	   
			
	}

	function insere()
	{
		
		@session_start();
		$db = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
         $this->valida_privilegios();
                
		$db = new db();
		$db1 = new db();
		$db2 = new db();
		$db3 = new db();
		$db4 = new db();
	
		$nome = blockrequest($_REQUEST['nome']);
		$email = blockrequest($_REQUEST['email']);
		$senha = blockrequest($_REQUEST['senha']);
		$telefone = blockrequest($_REQUEST['telefone']);

		$grupo = blockrequest($_REQUEST['grupo']);	

      
      
		
		$sql = "SELECT * FROM usuarios WHERE email = '".$email."' ";
		$db->query($sql,__LINE__,__FILE__);
		$db->next_record();
		
		if($db->num_rows() > 0)
		{
			header("Location: index.php?module=usuarios&method=main&msg=Email ja cadastrado, tente outro novamente.&tm=blue&mt=air");   
                           die(); 
                }
	   
		
	
		   $sql = "INSERT INTO usuarios (nome, email, senha, estado, data_cadastro, status, cidade, telefone, usuario_master, lancamentos_lote, eventos_lote) 
					VALUES ('".$nome."', '".$email."', MD5('".$senha."'), 7, NOW(), 1, 6779, '".$telefone."', ".$_SESSION['boss'].", 1, 1)";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			$id_usuario = $db->get_last_insert_id("usuarios","id");
			
			
			if(USE_AVATAR == 1)
			{


				if(isset($_FILES['avatar']['name']))
				{
	
					// Pega extensão do arquivo
					preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["avatar"]["name"], $ext);
			
					// Gera um nome único para a imagem
					$arquivo = md5(uniqid(time())) . "." . $ext[1];
			
					// Caminho de onde a imagem ficará
					$imagem_dir = "files/".$arquivo;

					$arquivo = $imagem_dir;
			
					// Faz o upload da imagem
					
					if($ext[1] != "")
					{
						move_uploaded_file($_FILES["avatar"]["tmp_name"], $imagem_dir);

						$sql = "UPDATE usuarios SET avatar = '".$arquivo."' WHERE id = ".$id_usuario." LIMIT 1 ";				
						$db->query($sql,__LINE__,__FILE__);
						$db->next_record();

					}
					


				}
				else
				{
					$arquivo = "";
				}
	
	
	
				
				
			}



			/* INSERE OS PRIVILÉGIOS DO USUÁRIO */
			
			if(ACTIVE_GRANTEES == 1)
			{
			
				$produtos = $_REQUEST['produtos'];
	
	
	
					$sql4 = "SELECT id FROM menu_itens";
					$db4->query($sql4,__LINE__,__FILE__);
					$db4->next_record();
				
					for($i = 0; $i < $db4->num_rows(); $i++)
					{
						$allow = 0;	
					
					
						if(in_array($db4->f("id"),$produtos))
							$allow = 1;
						
						
							$sql = "INSERT INTO privilegios 
							(id_menu, id_usuario, allow)
							VALUES (".$db4->f("id").", ".$id_usuario.", ".$allow.")";	
							$db->query($sql,__LINE__,__FILE__);
							$db->next_record();
	
							$db4->next_record();
	
				}
			}

         
         $id = blockrequest($_REQUEST['id']);	

         $sql = "INSERT INTO usuarios_grupos (id_grupo, id_usuario) VALUES (".$grupo.",".$id_usuario.") ";
         $db->query($sql,__LINE__,__FILE__);
         $db->next_record();
         
         dolog("Cadastrou o usuário: ".$nome);

         header("Location: index.php?module=usuarios&method=main&msg=Usuario cadastrado com sucesso!&tm=green&mt=air");   
		
	   }
	   
	   function edita()
	   {
			@session_start();
			$db = new db();
			$db1 = new db();
			$db2 = new db();
			$db3 = new db();
			$db4 = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
         valida_privilegios();
                        
         $_SESSION['page_title'] = "Editar Usuário";
                        
			$id = blockrequest($_REQUEST['id']);	
			
			if($_REQUEST['exception'] == "1")
			{
				if($_SESSION['id'] != $id )	
					header("Location: index.php?module=home&method=main&msg=Tentativa de acesso negada. Tente acessar apenas os seus dados.&tm=red&mt=air");
			}

			$sql = "SELECT nome,
							email,
							senha,
							telefone
					FROM usuarios
					WHERE id = ".$id."
               AND usuarios.usuario_master = ".$_SESSION['boss']." ";
                        
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			$nome = $db->f("nome");
			$email = $db->f("email");
			$senha = $db->f("senha");
			$telefone = $db->f("telefone");

         
         $sql4 = "SELECT id_grupo FROM usuarios_grupos WHERE id_usuario = ".$id." ";
			$db4->query($sql4,__LINE__,__FILE__);
			$db4->next_record();
         $grupo = $db4->f("id_grupo");
			

		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		
		if(ACTIVE_GRANTEES == 1 && !$_REQUEST['exception'])
		{
			$listagem_privilegios = '<div class="portlet">
					<div class="portlet-content nopadding">
					  <table cellpadding="0" cellspacing="0" id="box-table-a" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
						  <tr>
							<th scope="col">Area</th>
							<th scope="col">Item</th>
							<th scope="col">Accesso</th>
						  </tr>
						</thead>
						<tbody>'; 

			$sql = "SELECT * FROM areas ORDER BY descricao ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
		
			for($l = 0; $l < $db->num_rows(); $l++)
			{

            $listagem_privilegios .= '<tr>
                           <td colspan="3"><h3>'.$db->f("descricao").'</h3></td>
                          </tr>';
				
				$sql = "SELECT * FROM menu_itens WHERE id_area = ".$db->f("id")." ";
				$db2->query($sql,__LINE__,__FILE__);
				$db2->next_record();
				
	
				for($a = 0; $a < $db2->num_rows(); $a++)
				{
	
					$listagem_privilegios .= '<tr>
										<td>'.$db->f("descricao").'</td>
										<td>'.$db2->f("descricao").'</td>
										<td width="120"><input type="checkbox" id="produtos_'.$db2->f("id").'" name="produtos[]" value="'.$db2->f("id").'" ';

														
						$sql4 = "SELECT * FROM privilegios WHERE id_usuario = ".$id." AND allow = 1 AND id_menu = ".$db2->f("id")." ";
						$db4->query($sql4,__LINE__,__FILE__);
						$db4->next_record();
						if($db4->num_rows() > 0)
							$listagem_privilegios .= ' checked="checked" ';
						
						$listagem_privilegios .= '></td> 
													</tr> ';
					
					$db2->next_record();
				}
				$db->next_record();
			}
			
					$listagem_privilegios .= '<tr class="footer">
											<td></td>
											<td align="right">&nbsp;</td>
											<td align="right">
											</td>
										  </tr>
										</tbody>
									  </table>
									</div>
								  </div>';		
		}
		else
			$listagem_privilegios = "";


			$sql = "SELECT * FROM grupos ORDER BY nome ASC";

         $listagem_grupos = make_combo($sql, "nome", "id", $grupo);
         $dados_user = montaFormEdita("usuarionovo", $id);
         $grupos = montaSelect("usuarionovo",$listagem_grupos,7);
      
      
			$this->cabecalho();                                                                            
			$GLOBALS["base"]->template = new template();       
			
			if($_REQUEST['exception'] == 1)
				$GLOBALS["base"]->template->set_var("excpt_value",1);
			else
				$GLOBALS["base"]->template->set_var("excpt_value",0);
				

			if(USE_AVATAR == 1)
			{ 
				$sql = "SELECT avatar
					FROM usuarios
					WHERE id = ".$id." AND usuarios.usuario_master = ".$_SESSION['boss']." ";
				$db->query($sql,__LINE__,__FILE__);
				$db->next_record();
				
				$avatar = $db->f("avatar");
				
				
				if($avatar == "")
					$avatar = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=sem+foto';
					
				
				$GLOBALS["base"]->template->set_var("avatar",$avatar);
			}
         

			$GLOBALS["base"]->template->set_var("dados_user",$dados_user);
			$GLOBALS["base"]->template->set_var('BTN_SALVAR' , BTN_SALVAR);
			$GLOBALS["base"]->template->set_var('BTN_CANCELAR' , BTN_CANCELAR);  
			$GLOBALS["base"]->template->set_var("listagem_privilegios",$listagem_privilegios);
			$GLOBALS["base"]->template->set_var("nome",$nome);
			$GLOBALS["base"]->template->set_var("email",$email);
			$GLOBALS["base"]->template->set_var("senha",$senha);
			$GLOBALS["base"]->template->set_var("telefone",$telefone);
			$GLOBALS["base"]->template->set_var("grupos",$grupos);
			$GLOBALS["base"]->template->set_var("id",$id);

			$GLOBALS["base"]->template->set_var("listagemGrupos",$this->listagrupos());

         $GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'edita_usuario');                       
			$GLOBALS["base"]->template = new template();                                                  
			$this->footer();                                                                               
		   
	   }
	


		function update()
		{

			@session_start();
			$db = new db();
			$db4 = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
         $this->valida_privilegios();
                        
			$nome = blockrequest($_REQUEST['nome']);	
			$email = blockrequest($_REQUEST['email']);	
			$senha = blockrequest($_REQUEST['senha']);	
			$nome = blockrequest($_REQUEST['nome']);	
			$telefone = blockrequest($_REQUEST['telefone']);	
			$grupo = blockrequest($_REQUEST['grupo']);	

			$id = blockrequest($_REQUEST['id']);	
         
         $sql = "UPDATE usuarios_grupos SET id_grupo = ".$grupo." WHERE id_usuario = ".$id." " ;
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();

			$sql = "UPDATE usuarios
					SET nome = '".$nome."',
					email = '".$email."', ";
			
			if($_REQUEST['senha_old'] != $senha)		
					$sql .= " senha = MD5('".$senha."'),";
					
			$sql .= "status = 1,
					telefone = '".$telefone."'
					WHERE id = ".$id." AND usuarios.usuario_master = ".$_SESSION['boss']." ";
		
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();

			if(USE_AVATAR == 1)
			{


				if($_FILES['avatar']['name'] != "")
				{
	
					// Pega extensão do arquivo
					preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["avatar"]["name"], $ext);
			
					// Gera um nome único para a imagem
					$arquivo = md5(uniqid(time())) . "." . $ext[1];
			
					// Caminho de onde a imagem ficará
					$imagem_dir = "files/".$arquivo;
			
					// Faz o upload da imagem
					
					if($ext[1] != "")
					{
						move_uploaded_file($_FILES["avatar"]["tmp_name"], $imagem_dir);

						$sql = "UPDATE usuarios SET avatar = 'files/".$arquivo."' WHERE id = ".$id." LIMIT 1 ";				
						$db->query($sql,__LINE__,__FILE__);
						$db->next_record();
					}


				
					
				}

				
			}



			/* INSERE OS PRIVILÉGIOS DO USUÁRIO */
			
			if(ACTIVE_GRANTEES == 1 && $_REQUEST['exception'] != 1)
			{
	
	
				$sql = "DELETE FROM privilegios WHERE id_usuario = ".$id." ";	
				$db->query($sql,__LINE__,__FILE__);
				$db->next_record();
	
	
				/* INSERE OS PRIVILÉGIOS DO USUÁRIO */
				
				$produtos = $_REQUEST['produtos'];
	
	
	
					$sql4 = "SELECT id FROM menu_itens";
					$db4->query($sql4,__LINE__,__FILE__);
					$db4->next_record();
				
					for($i = 0; $i < $db4->num_rows(); $i++)
					{
						$allow = 0;	
					
					
						if(in_array($db4->f("id"),$produtos))
							$allow = 1;
						
						
							$sql = "INSERT INTO privilegios 
							(id_menu, id_usuario, allow)
							VALUES (".$db4->f("id").", ".$id.", ".$allow.")";	
							$db->query($sql,__LINE__,__FILE__);
							$db->next_record();
	
							$db4->next_record();
	
				}
			}


                     dolog("Editou o usuário: ".$nome);
			
			header("Location: index.php?module=usuarios&method=main&msg=Dados atualizados com sucesso!&tm=green&mt=air");	
		}
		
		function exclui()
		{
			@session_start();
			$db = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
                            $this->valida_privilegios();
                        
                        $id = blockrequest($_REQUEST['id']);	
                        
			$sql = "SELECT email FROM usuarios WHERE id = ".$id." AND usuario_master = ".$_SESSION['boss']." ";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
                     $emailUsuario = $db->f("email");
                        

			$sql = "DELETE FROM usuarios WHERE id = ".$id." AND usuario_master = ".$_SESSION['boss']." ";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();

			
			if(ACTIVE_GRANTEES == 1)
			{
				$sql = "DELETE FROM privilegios WHERE id_usuario = ".$id." ";	
				$db->query($sql,__LINE__,__FILE__);
				$db->next_record();
			}
                  
                     dolog("Excluiu o usuário: ".$emailUsuario);

			header("Location: index.php?module=usuarios&method=main&msg=Usuario Excluido com sucesso!&tm=green&mt=air");	
			
		}
      
      function blank()
      {
         $this->cabecalho();                                                                            
         $GLOBALS["base"]->template = new template();       
         $GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'blank');                                            
         $GLOBALS["base"]->template = new template();                                                  
         $this->footer();                                                                               
         
      }

		function listagrupos()
		{
			@session_start();
			$db = new db();
			$db2 = new db();
         
         
         $listagemGrupos = array();

         $sql = "SELECT id FROM grupos ORDER BY id ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
         for($i = 0; $i < $db->num_rows(); $i++)
         {

            $sql2 = "SELECT id_menu, allow FROM grupos_privilegios WHERE id_grupo = ".$db->f("id")." ORDER BY id_menu ASC";
            $db2->query($sql2,__LINE__,__FILE__);
            $db2->next_record();
            for($i2 = 0; $i2 < $db2->num_rows(); $i2++)
            {
               array_push($listagemGrupos, $db->f("id").",".$db2->f("id_menu").",".$db2->f("allow"));

               $db2->next_record();
            }

            
            $db->next_record();
         }

         $listagemFinalArray = array();
         
         for($i = 0; $i < count($listagemGrupos); $i++)
         {
            $listagem = $listagemGrupos[$i];

             array_push($listagemFinalArray,$listagem);
         }
         
         
         return implode($listagemFinalArray,"|");


      }
      
      function grupos()
      {
			@session_start();
                        
			if($_SESSION['id'] != $_SESSION['boss'])
			$this->valida_privilegios();
         
         $_SESSION['page_title'] = "Grupos de Usuários";
			
			$db = new db();

			$sql = "SELECT id, nome FROM grupos ORDER BY nome ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			

			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id_usuario = $db->f("id");			
				$nome = $db->f("nome");			
				
				
				$listagem .= '<tr> 
										<td>'.$nome.'</td>
										<td><a href="index.php?module=usuarios&method=editaGrupo&id='.$db->f("id").'" >Editar</a></td>
										<td><a href="index.php?module=usuarios&method=excluiGrupo&id='.$db->f("id").'" onclick="return(confirm(\'Deseja excluir o grupo '.$db->f("nome").' ? \'))">Excluir</a></td>										
									</tr>';
				
				
				
				
				$db->next_record();
			}
         /*
		if($_SESSION['botao_inserir'] == 1)
			$btn_novo = '<input style="margin-left:-3px;" type="button" class="btn" onclick="location=\'index.php?module=usuarios&method=usuario_novo\'" value="Cadastrar novo usu&aacute;rio">';
		else
			$btn_novo = "";	
      */
         
      $grid_grupos = montaGrid("sample_1",$listagem,"grupos");
         

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		$GLOBALS["base"]->template->set_var("grid_grupos",$grid_grupos);
		$GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'grupos');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           
         
      }
      
      function novoGrupo()
      {

			@session_start();
			$db = new db();
			$db2 = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
         $this->valida_privilegios();
         
         $_SESSION['page_title'] = "Novo Grupo de Usuários";
                        
                        
			$id = blockrequest($_REQUEST['id']);	

		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		
		if(ACTIVE_GRANTEES == 1)
		{
			
			$listagem_privilegios = '<div class="portlet">
		<div class="portlet-content nopadding">
          <table cellpadding="0" cellspacing="0" id="box-table-a" width="100%" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">Area</th>
                <th scope="col">Item</th>
                <th scope="col">Acess</th>
              </tr>
            </thead>
            <tbody>'; 

			$sql = "SELECT * FROM areas ORDER BY descricao ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
		
			for($l = 0; $l < $db->num_rows(); $l++)
			{
				
				$sql = "SELECT * FROM menu_itens WHERE id_area = ".$db->f("id")." ";
				$db2->query($sql,__LINE__,__FILE__);
				$db2->next_record();
				
            
            if(isset($_REQUEST['grupo']))
            {

               for($a = 0; $a < $db2->num_rows(); $a++)
               {



                  $listagem_privilegios .= '<tr>
                                 <td>'.$db->f("descricao").'</td>
                                 <td>'.$db2->f("descricao").'</td>
                                 <td width="120"><input type="checkbox" name="produtos[]" id="produtos_'.$db2->f("id").'" value="'.$db2->f("id").'"></td>
                                </tr>';



                  $db2->next_record();
               }
               
            }
            else
            {
               for($a = 0; $a < $db2->num_rows(); $a++)
               {



                  $listagem_privilegios .= '<tr>
                                 <td>'.$db->f("descricao").'</td>
                                 <td>'.$db2->f("descricao").'</td>
                                 <td width="120"><input type="checkbox" name="produtos[]" id="produtos_'.$db2->f("id").'" value="'.$db2->f("id").'"></td>
                                </tr>';



                  $db2->next_record();
               }
              
            }
            
	
				$db->next_record();
			}
			
				$listagem_privilegios .= '<tr class="footer">
											<td ></td>
											<td align="right">&nbsp;</td>
											<td align="right">
											</td>
										  </tr>
										</tbody>
									  </table>
									</div>
								  </div>';

		}
		else
			$listagem_privilegios = "";
         
         $this->cabecalho();                                                                            
         $GLOBALS["base"]->template = new template();       
   		$GLOBALS["base"]->template->set_var('listagem_privilegios',$listagem_privilegios);
         $GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'novoGrupo');                       
         $GLOBALS["base"]->template = new template();                                                  
         $this->footer();                                                                           
         
      }
      
      function insereGrupo()
      {
         @session_start();
         $db = new db();

            if($_SESSION['id'] != $_SESSION['boss'])
            $this->valida_privilegios();

         $db = new db();
         $db4 = new db();
 
         $nome = blockrequest($_REQUEST['nome']);

         $sql = "INSERT INTO grupos (nome) VALUES ('".$nome."') ";
         $db->query($sql,__LINE__,__FILE__);
         $db->next_record();

         $idGrupo = $db->get_last_insert_id("grupos","id");


            /* INSERE OS PRIVILÉGIOS DO USUÁRIO */

            if(ACTIVE_GRANTEES == 1)
            {

               $produtos = $_REQUEST['produtos'];

                  $sql4 = "SELECT id FROM menu_itens";
                  $db4->query($sql4,__LINE__,__FILE__);
                  $db4->next_record();

                  for($i = 0; $i < $db4->num_rows(); $i++)
                  {
                     $allow = 0;	


                     if(in_array($db4->f("id"),$produtos))
                        $allow = 1;


                        $sql = "INSERT INTO grupos_privilegios 
                        (id_menu, id_grupo, allow)
                        VALUES (".$db4->f("id").", ".$idGrupo.", ".$allow.")";	
                     
                        $db->query($sql,__LINE__,__FILE__);
                        $db->next_record();

                        $db4->next_record();

               }
            }


            header("Location: index.php?module=usuarios&method=grupos&msg=Grupo cadastrado com sucesso!&tm=green&mt=air");   

      }
      
      function excluiGrupo()
      {
			@session_start();
			$db = new db();
         
         /*
			if($_SESSION['id'] != $_SESSION['boss'])
            $this->valida_privilegios();
         */
                        
         $id = blockrequest($_REQUEST['id']);	

			$sql = "DELETE FROM grupos WHERE id = ".$id." ";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();

			
			if(ACTIVE_GRANTEES == 1)
			{
				$sql = "DELETE FROM grupos_privilegios WHERE id_grupo = ".$id." ";	
				$db->query($sql,__LINE__,__FILE__);
				$db->next_record();
			}

			header("Location: index.php?module=usuarios&method=grupos&msg=Grupo Excluido com sucesso!&tm=green&mt=air");	
         
      }
      
      function editaGrupo()
      {
			@session_start();
			$db = new db();
			$db2 = new db();
			$db4 = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
            $this->valida_privilegios();
         
         $_SESSION['page_title'] = "Editar Grupo de Usuários";

			$id = blockrequest($_REQUEST['id']);	
         
			$sql = "SELECT nome
					FROM grupos
					WHERE id = ".$id." ";
                        
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			$nome = $db->f("nome");


		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		// LISTAGEM DE PERMISSIONAMENTO
		
		if(ACTIVE_GRANTEES == 1 && !$_REQUEST['exception'])
		{
			$listagem_privilegios = '<div class="portlet">
					<div class="portlet-content nopadding">
					  <table cellpadding="0" cellspacing="0" id="box-table-a" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
						  <tr>
							<th scope="col">Area</th>
							<th scope="col">Item</th>
							<th scope="col">Access</th>
						  </tr>
						</thead>
						<tbody>'; 

			$sql = "SELECT * FROM areas ORDER BY descricao ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
		
			for($l = 0; $l < $db->num_rows(); $l++)
			{
				
				$sql = "SELECT * FROM menu_itens WHERE id_area = ".$db->f("id")." ";
				$db2->query($sql,__LINE__,__FILE__);
				$db2->next_record();
				
	
				for($a = 0; $a < $db2->num_rows(); $a++)
				{
	
					$listagem_privilegios .= '<tr>
										<td>'.$db->f("descricao").'</td>
										<td>'.$db2->f("descricao").'</td>
										<td width="120"><input type="checkbox" id="produtos_'.$db2->f("id").'" name="produtos[]" value="'.$db2->f("id").'" ';

														
						$sql4 = "SELECT * FROM grupos_privilegios WHERE id_grupo = ".$id." AND allow = 1 AND id_menu = ".$db2->f("id")." ";
						$db4->query($sql4,__LINE__,__FILE__);
						$db4->next_record();
						if($db4->num_rows() > 0)
							$listagem_privilegios .= ' checked="checked" ';
						
						$listagem_privilegios .= '></td> 
													</tr> ';
					
					$db2->next_record();
				}
				$db->next_record();
			}
			
					$listagem_privilegios .= '<tr class="footer">
											<td></td>
											<td align="right">&nbsp;</td>
											<td align="right">
											</td>
										  </tr>
										</tbody>
									  </table>
									</div>
								  </div>';		
		}
		else
			$listagem_privilegios = "";


      
			$this->cabecalho();                                                                            
			$GLOBALS["base"]->template = new template();       
			
			$GLOBALS["base"]->template->set_var("listagem_privilegios",$listagem_privilegios);
			$GLOBALS["base"]->template->set_var("nome",$nome);
			$GLOBALS["base"]->template->set_var("id",$id);
         $GLOBALS["base"]->write_design_specific('usuarios.tpl' , 'editaGrupo');                       
			$GLOBALS["base"]->template = new template();                                                  
			$this->footer();                                                                               
         
      }
      
      function updateGrupo()
      {
			@session_start();
			$db = new db();
			$db4 = new db();

			if($_SESSION['id'] != $_SESSION['boss'])
         $this->valida_privilegios();
                        
			$nome = blockrequest($_REQUEST['nome']);	

			$id = blockrequest($_REQUEST['id']);	
         

			$sql = "UPDATE grupos
					SET nome = '".$nome."' WHERE id = ".$id." ";
		
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();


			/* INSERE OS PRIVILÉGIOS DO USUÁRIO */
			
			if(ACTIVE_GRANTEES == 1 && $_REQUEST['exception'] != 1)
			{
	
	
				$sql = "DELETE FROM grupos_privilegios WHERE id_grupo = ".$id." ";	
				$db->query($sql,__LINE__,__FILE__);
				$db->next_record();
	
	
				/* INSERE OS PRIVILÉGIOS DO GRUPO */
				
				$produtos = $_REQUEST['produtos'];
	
					$sql4 = "SELECT id FROM menu_itens";
					$db4->query($sql4,__LINE__,__FILE__);
					$db4->next_record();
				
					for($i = 0; $i < $db4->num_rows(); $i++)
					{
						$allow = 0;	
					
					
						if(in_array($db4->f("id"),$produtos))
							$allow = 1;
						
                     $sql = "INSERT INTO grupos_privilegios 
                     (id_menu, id_grupo, allow)
                     VALUES (".$db4->f("id").", ".$id.", ".$allow.")";	
						
							$db->query($sql,__LINE__,__FILE__);
							$db->next_record();
	
							$db4->next_record();
	
				}
			}

			
			header("Location: index.php?module=usuarios&method=grupos&msg=Dados do grupo atualizados com sucesso!&tm=green&mt=air");	
         
      }
}                                                                                                     





?>