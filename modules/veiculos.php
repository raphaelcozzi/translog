<?php
require_once("modules/home.php");                                                                      

	class veiculos extends home                                                                             
    {              

		function main()
		{
			@session_start();
                        
			if($_SESSION['id'] != $_SESSION['boss'])
			$this->valida_privilegios();
         
                     $_SESSION['page_title'] = "Veículos";
			
			$db = new db();
			$db2 = new db();

			$sql = "SELECT veiculos_tipos.nome AS tipo, 
                     veiculos_marcas.nome AS marca, 
                     veiculos.placa AS placa, 
                     veiculos.photo AS photo, 
                     veiculos.id AS id FROM veiculos,  veiculos_tipos, veiculos_marcas 
                     WHERE veiculos.id_tipo = veiculos_tipos.id 
                     AND veiculos.id_marca = veiculos_marcas.id 
                     ORDER BY veiculos.id DESC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id = $db->f("id");			
				$tipo = $db->f("tipo");			
				$marca = $db->f("marca");			
				$placa = $db->f("placa");			
				$photo = $db->f("photo");			
            
                           $entregador = "- Nenhum fixo -";
                        
                           $sql2 = "SELECT entregadores.nome AS entregador FROM entregadores, entregadores_veiculos_fixos WHERE entregadores.id = entregadores_veiculos_fixos.id_entregador AND entregadores_veiculos_fixos.id_veiculo = ".$id." ";
                           $db2->query($sql2,__LINE__,__FILE__);
                           $db2->next_record();
                           if($db2->f("entregador"))
                           {
                              $entregador = $db2->f("entregador");
                           }

				$listagem .= '<tr> 
										<td>'.$placa.'</td>
										<td>'.$marca.'</td>
										<td>'.$tipo.'</td> 
										<td>'.$entregador.'</td> 
										<td><img src="'.ABS_LINK.''.$photo.'" width="150"></td> 
										<td><a href="index.php?module=veiculos&method=edita&id='.$db->f("id").'" >Editar</a></td>
										<td><a href="index.php?module=veiculos&method=exclui&id='.$db->f("id").'" onclick="return(confirm(\'Confirma excluir o veiculo '.$db->f("nome").' ? \'))">Excluir</a></td>										
									</tr>';
				
				
				
				
				$db->next_record();
			}

      
      
             $grid_user = montaGrid("sample_1",$listagem,"veiculos");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid_user",$grid_user);
		$GLOBALS["base"]->template->set_var("btn_novo",$btn_novo);
													
		$GLOBALS["base"]->write_design_specific('veiculos.tpl' , 'main');                       
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
		
	function novo()
	{
		@session_start();
		$db = new db();

            if($_SESSION['id'] != $_SESSION['boss'])
                $this->valida_privilegios();
         
               $_SESSION['page_title'] = "Novo Veículo";

         
         
         
                     $sql = "select id, nome from veiculos_tipos";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_tipos = "<option value='0' selected>SELECIONE</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_tipos .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $tipo)
					$listagem_tipos .= "selected='selected'";
				
				$listagem_tipos .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}


                      $sql = "select id, nome from veiculos_marcas";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_marcas = "<option value='0' selected>SELECIONE</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_marcas .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $marca)
					$listagem_marcas .= "selected='selected'";
				
				$listagem_marcas .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}
        
                      $sql = "select id, nome from veiculos_combustiveis";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_combustiveis = "<option value='0' selected>SELECIONE</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_combustiveis .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $combustivel)
					$listagem_combustiveis .= "selected='selected'";
				
				$listagem_combustiveis .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}

         
                     if(!isset($id_veiculo))
                        $id_veiculo = 0;
         
                      $sql = "select id_entregador from entregadores_veiculos_fixos WHERE id_veiculo = ".$id_veiculo." ";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();
                     if($db->num_rows() > 0)
                        $entregador = $db->f("id_entregador");
         
		
                      $sql = "select id, nome from entregadores";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_entregadores = "<option value='0' selected>- Nenhum Fixo -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_entregadores .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $entregador)
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}


               $form = montaForm("veiculonovo");
               
               $tipos = montaSelect("veiculonovo",$listagem_tipos,1); 
               $marcas = montaSelect("veiculonovo",$listagem_marcas,2); 
               $combustiveis = montaSelect("veiculonovo",$listagem_combustiveis,6);
               $entregadores = montaSelect("veiculonovo",$listagem_entregadores,8);
      

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		$GLOBALS["base"]->template->set_var('form',$form);

              $GLOBALS["base"]->template->set_var('modelo',$modelo);
		$GLOBALS["base"]->template->set_var('placa',$placa);
		$GLOBALS["base"]->template->set_var('ano',$ano);
 		$GLOBALS["base"]->template->set_var('km_inicial',$km_inicial);
 		$GLOBALS["base"]->template->set_var('obs',$obs);
 		$GLOBALS["base"]->template->set_var('numero_documento',$numero_documento);
      
		$GLOBALS["base"]->template->set_var('tipos',$tipos);
		$GLOBALS["base"]->template->set_var('marcas',$marcas);
		$GLOBALS["base"]->template->set_var('combustiveis',$combustiveis);
		$GLOBALS["base"]->template->set_var('entregadores',$entregadores);
      
		$GLOBALS["base"]->template->set_var('BTN_SALVAR' , BTN_SALVAR);
		$GLOBALS["base"]->template->set_var('BTN_CANCELAR' , BTN_CANCELAR);  
		$GLOBALS["base"]->write_design_specific('veiculos.tpl' , 'novo');                                            
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
		$db2 = new db();
	
		$id_tipo = blockrequest($_REQUEST['id_tipo']);
		$id_marca = blockrequest($_REQUEST['id_marca']);
		$modelo = blockrequest($_REQUEST['modelo']);
		$placa = blockrequest($_REQUEST['placa']);
		$ano = blockrequest($_REQUEST['ano']);
		$id_combustivel = blockrequest($_REQUEST['id_combustivel']);
		$km_inicial = blockrequest($_REQUEST['km_inicial']);
		$id_entregador = blockrequest($_REQUEST['id_entregador']);
		$photo = $_FILES['photo'];
		$photo_documento = $_FILES['photo_documento'];
		$id_entregador = blockrequest($_REQUEST['id_entregador']);
		$obs = blockrequest($_REQUEST['obs']);
		$numero_documento = blockrequest($_REQUEST['numero_documento']);
		$validade_documento = blockrequest($_REQUEST['validade_documento']);

	
		
	
            $sql = "INSERT INTO veiculos
                        (id_tipo,
                        id_marca,
                        modelo,
                        placa,
                        ano,
                        id_combustivel,
                        numero_documento,
                        obs,
                        validade_documento,
                        status,
                        dataCadastro,
                        km_inicial)
                        VALUES (".$id_tipo.",
                        ".$id_marca.",
                        '".$modelo."',
                        '".$placa."',
                        '".$ano."',
                        ".$id_combustivel.",
                        '".$numero_documento."',
                        '".addslashes($obs)."',
                        '".$validade_documento."',
                        1,
                        NOW(),
                        '".$km_inicial."')";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();

            $id_veiculo = $db->get_last_insert_id("veiculos","id");
            
            
            if($id_entregador != "0")
            {
                     $sql = "INSERT INTO entregadores_veiculos_fixos
                  (id_entregador,
                  id_veiculo)
                  VALUES (".$id_entregador.",
                  ".$id_veiculo.")";
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
            }
            
            if(isset($_FILES['photo']['name']))
            {
               // Pega extensão do arquivo
               preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["photo"]["name"], $ext);
               // Gera um nome único para a imagem
               $arquivo = md5(uniqid(time())) . "." . $ext[1];
               // Caminho de onde a imagem ficará
               $imagem_dir = "files/".$arquivo;
               $arquivo = $imagem_dir;
               // Faz o upload da imagem
               if($ext[1] != "")
               {
                  move_uploaded_file($_FILES["photo"]["tmp_name"], $imagem_dir);

                  $sql = "UPDATE veiculos SET photo = '".$arquivo."' WHERE id = ".$id_veiculo." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }

            if(isset($_FILES['photo_documento']['name']))
            {
               // Pega extensão do arquivo
               preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["photo_documento"]["name"], $ext);
               // Gera um nome único para a imagem
               $arquivo = md5(uniqid(time())) . "." . $ext[1];
               // Caminho de onde a imagem ficará
               $imagem_dir = "files/".$arquivo;
               $arquivo = $imagem_dir;
               // Faz o upload da imagem
               if($ext[1] != "")
               {
                  move_uploaded_file($_FILES["photo_documento"]["tmp_name"], $imagem_dir);

                  $sql = "UPDATE veiculos SET photo_documento = '".$arquivo."' WHERE id = ".$id_veiculo." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }
            
            

            
            $this->notificacao("Veículo cadastrado com sucesso!", "green");
            header("Location: " . ABS_LINK . "/veiculos");
            
	   }
      
      function edita()
      {
         
		@session_start();
		$db = new db();

            if($_SESSION['id'] != $_SESSION['boss'])
                $this->valida_privilegios();
         
               $_SESSION['page_title'] = "Detalhes do Veículo";

			$id_veiculo = blockrequest($_REQUEST['id']);	
         
         
         $sql = "SELECT
                  id_tipo,
                  id_marca,
                  modelo,
                  placa,
                  ano,
                  id_combustivel,
                  photo,
                  photo_documento,
                  numero_documento,
                  obs,
                  validade_documento,
                  status,
                  dataCadastro,
                  km_inicial
                  FROM veiculos 
                  WHERE id = ".$id_veiculo." ";
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
                  
                  $id_tipo = $db->f("id_tipo");
                  $id_marca = $db->f("id_marca");
                  $ano = $db->f("ano");
                  $placa = $db->f("placa");
                  $modelo = $db->f("modelo");
                  $id_combustivel = $db->f("id_combustivel");
                  $photo = $db->f("photo");
                  $photo_documento = $db->f("photo_documento");
                  $numero_documento = $db->f("numero_documento");
                  $obs = $db->f("obs");
                  $validade_documento = $db->f("validade_documento");
                  $status = $db->f("status");
                  $dataCadastro = $db->f("dataCadastro");
                  $km_inicial = $db->f("km_inicial");
         
                  
                  $sql = "SELECT id_entregador FROM entregadores_veiculos_fixos WHERE id_veiculo = ".$id_veiculo." LIMIT 1 ";
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
                  
                  $id_entregador = $db->f("id_entregador");
         
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

         
         
         
                     $sql = "select id, nome from veiculos_tipos";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_tipos = "<option value='0' selected>SELECIONE</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_tipos .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $id_tipo)
					$listagem_tipos .= "selected='selected'";
				
				$listagem_tipos .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}


                      $sql = "select id, nome from veiculos_marcas";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_marcas = "<option value='0' selected>SELECIONE</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_marcas .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $id_marca)
					$listagem_marcas .= "selected='selected'";
				
				$listagem_marcas .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}
        
                      $sql = "select id, nome from veiculos_combustiveis";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_combustiveis = "<option value='0' selected>SELECIONE</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_combustiveis .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $id_combustivel)
					$listagem_combustiveis .= "selected='selected'";
				
				$listagem_combustiveis .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}

         
                     if(!isset($id_veiculo))
                        $id_veiculo = 0;
         
                      $sql = "select id_entregador from entregadores_veiculos_fixos WHERE id_veiculo = ".$id_veiculo." ";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();
                     if($db->num_rows() > 0)
                        $entregador = $db->f("id_entregador");
         
		
                      $sql = "select id, nome from entregadores";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_entregadores = "<option value='0' selected>- Nenhum Fixo -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_entregadores .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $id_entregador)
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}


               $form = montaForm("veiculonovo");
               
               $tipos = montaSelect("veiculonovo",$listagem_tipos,1); 
               $marcas = montaSelect("veiculonovo",$listagem_marcas,2); 
               $combustiveis = montaSelect("veiculonovo",$listagem_combustiveis,6);
               $entregadores = montaSelect("veiculonovo",$listagem_entregadores,8);
      

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
   
		$GLOBALS["base"]->template->set_var('form',$form);
      
      
		$GLOBALS["base"]->template->set_var('ano',$ano);
		$GLOBALS["base"]->template->set_var('numero_documento',$numero_documento);
		$GLOBALS["base"]->template->set_var('obs',$obs);
		$GLOBALS["base"]->template->set_var('validade_documento',$validade_documento);
		$GLOBALS["base"]->template->set_var('km_inicial',$km_inicial);
		$GLOBALS["base"]->template->set_var('placa',$placa);
		$GLOBALS["base"]->template->set_var('modelo',$modelo);
		$GLOBALS["base"]->template->set_var('obs',$obs);
      
		$GLOBALS["base"]->template->set_var('id',$id_veiculo);
      
      
		$GLOBALS["base"]->template->set_var('tipos',$tipos);
		$GLOBALS["base"]->template->set_var('marcas',$marcas);
		$GLOBALS["base"]->template->set_var('combustiveis',$combustiveis);
		$GLOBALS["base"]->template->set_var('entregadores',$entregadores);
      
      
		$GLOBALS["base"]->template->set_var('photo',$photo);
		$GLOBALS["base"]->template->set_var('photo_documento',$photo_documento);
      
		$GLOBALS["base"]->write_design_specific('veiculos.tpl' , 'edita');                                            
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                               
      }
      
      function update()
      {
		@session_start();
		$db = new db();

	   $id_veiculo = blockrequest($_REQUEST['id']);	
      
      
		$db = new db();
		$db2 = new db();
	
		$id_tipo = blockrequest($_REQUEST['id_tipo']);
		$id_marca = blockrequest($_REQUEST['id_marca']);
		$modelo = blockrequest($_REQUEST['modelo']);
		$placa = blockrequest($_REQUEST['placa']);
		$ano = blockrequest($_REQUEST['ano']);
		$id_combustivel = blockrequest($_REQUEST['id_combustivel']);
		$km_inicial = blockrequest($_REQUEST['km_inicial']);
		$id_entregador = blockrequest($_REQUEST['id_entregador']);
		$photo = $_FILES['photo'];
		$photo_documento = $_FILES['photo_documento'];
		$id_entregador = blockrequest($_REQUEST['id_entregador']);
		$obs = blockrequest($_REQUEST['obs']);
		$numero_documento = blockrequest($_REQUEST['numero_documento']);
		$validade_documento = blockrequest($_REQUEST['validade_documento']);
         
         
               $sql = "UPDATE veiculos
                     SET id_tipo = 'id_tipo',
                       id_marca = 'id_marca',
                       modelo = 'modelo',
                       placa = 'placa',
                       ano = 'ano',
                       id_combustivel = 'id_combustivel',
                       photo = 'photo',
                       photo_documento = 'photo_documento',
                       numero_documento = 'numero_documento',
                       obs = 'obs',
                       validade_documento = 'validade_documento',
                       STATUS = 'status',
                       dataCadastro = 'dataCadastro',
                       km_inicial = 'km_inicial'
                     WHERE id =".$id_veiculo." ";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();
      
      
               $sql = "DELETE FROM entregadores_veiculos_fixos WHERE id_veiculo = ".$id_veiculo." ";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();
     
      
            
            if($id_entregador != "0")
            {
                     $sql = "INSERT INTO entregadores_veiculos_fixos
                  (id_entregador,
                  id_veiculo)
                  VALUES (".$id_entregador.",
                  ".$id_veiculo.")";
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
            }
            
            if(isset($_FILES['photo']['name']))
            {
               // Pega extensão do arquivo
               preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["photo"]["name"], $ext);
               // Gera um nome único para a imagem
               $arquivo = md5(uniqid(time())) . "." . $ext[1];
               // Caminho de onde a imagem ficará
               $imagem_dir = "files/".$arquivo;
               $arquivo = $imagem_dir;
               // Faz o upload da imagem
               if($ext[1] != "")
               {
                  move_uploaded_file($_FILES["photo"]["tmp_name"], $imagem_dir);

                  $sql = "UPDATE veiculos SET photo = '".$arquivo."' WHERE id = ".$id_veiculo." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }

            if(isset($_FILES['photo_documento']['name']))
            {
               // Pega extensão do arquivo
               preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["photo_documento"]["name"], $ext);
               // Gera um nome único para a imagem
               $arquivo = md5(uniqid(time())) . "." . $ext[1];
               // Caminho de onde a imagem ficará
               $imagem_dir = "files/".$arquivo;
               $arquivo = $imagem_dir;
               // Faz o upload da imagem
               if($ext[1] != "")
               {
                  move_uploaded_file($_FILES["photo_documento"]["tmp_name"], $imagem_dir);

                  $sql = "UPDATE veiculos SET photo_documento = '".$arquivo."' WHERE id = ".$id_veiculo." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }
            
            

            
            $this->notificacao("Veículo cadastrado com sucesso!", "green");
            header("Location: " . ABS_LINK . "/veiculos");
      
      }
	   
      
}                                                                                                     





?>