<?php
require_once("modules/home.php");                                                                      

	class entregadores extends home                                                                             
    {              

		function main()
		{
			@session_start();
                        
			if($_SESSION['id'] != $_SESSION['boss'])
			$this->valida_privilegios();
         
                     $_SESSION['page_title'] = "Entregadores";
			
			$db = new db();
			$db2 = new db();

			$sql = "SELECT entregadores.id AS id,
                     entregadores.nome AS nome,
                     entregadores.celular AS celular,
                     entregadores.photo AS foto 
                     FROM entregadores WHERE status = 1
                     ORDER BY entregadores.id DESC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id = $db->f("id");			
				$nome = $db->f("nome");			
				$celular = $db->f("celular");			
				$photo = $db->f("foto");			
            
                           $veiculo = "- Nenhum fixo -";
                           $photo_veiculo = '';
                           
                        
                           $sql2 = "SELECT veiculos.placa, veiculos.photo
                                          FROM
                                          entregadores_veiculos_fixos
                                          INNER JOIN veiculos 
                                          ON (entregadores_veiculos_fixos.id_veiculo = veiculos.id) 
                                          WHERE entregadores_veiculos_fixos.id_entregador = ".$id." ";
                           $db2->query($sql2,__LINE__,__FILE__);
                           $db2->next_record();
                           if($db2->num_rows() > 0)
                           {
                              $veiculo = $db2->f("placa");
                              $photo_veiculo = $db2->f("photo");
                           }
                           
                           
                           if(strlen($photo_veiculo) > 6)
                           {
                              $picture_veiculo = '<img src="'.ABS_LINK.''.$photo_veiculo.'" width="150">';
                           }
                           else
                           {
                              $picture_veiculo = '<img src="http://www.placehold.it/150x150/EFEFEF/AAAAAA&text=sem+foto">';
                           }
                           

                           if(strlen($photo) > 6)
                           {
                              $picture = '<img src="'.ABS_LINK.''.$photo.'" width="150">';
                           }
                           else
                           {
                              $picture = '<img src="http://www.placehold.it/150x150/EFEFEF/AAAAAA&text=sem+foto">';
                           }
                           
                           
				$listagem .= '<tr> 
										<td>'.$nome.'</td>
										<td>'.$celular.'</td>
										<td>'.$picture.'</td> 
										<td align="center">'.$veiculo.'<br>'.$picture_veiculo.'</td>
										<td><a href="index.php?module=entregadores&method=edita&id='.$db->f("id").'" >Editar</a></td>
										<td><a href="index.php?module=entregadores&method=exclui&id='.$db->f("id").'" onclick="return(confirm(\'Confirma excluir o entregador  '.$db->f("nome").' ? \'))">Excluir</a></td>										
									</tr>';
				
				
				
				
				$db->next_record();
			}

      
      
             $grid = montaGrid("sample_1",$listagem,"entregadores");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid",$grid);
		$GLOBALS["base"]->template->set_var("btn_novo",$btn_novo);
													
		$GLOBALS["base"]->write_design_specific('entregadores.tpl' , 'main');                       
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
         
               $_SESSION['page_title'] = "Novo Entregador";

         
         
                     $sql = "SELECT
                     veiculos.id AS id
                     , veiculos.placa AS placa
                     , veiculos.modelo AS modelo
                     , veiculos_marcas.nome AS marca
                     FROM
                     veiculos
                     INNER JOIN veiculos_marcas 
                     ON (veiculos.id_marca = veiculos_marcas.id)";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_veiculos = "<option value='0' selected>- Nenhum Fixo -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_veiculos .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $id_veiculo)
					$listagem_veiculos .= "selected='selected'";
				
				$listagem_veiculos .= ">".$db->f("marca")." ".$db->f("modelo")." ".$db->f("placa")."</option>";			
	
				$db->next_record();

			}

               $sql = "select * from estados";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();

               $listagem_estado = "<option value='0'>SELECIONE</option>";

               for($i = 0; $i < $db->num_rows(); $i++)
               {
                 $listagem_estado .= "<option value='".$db->f("id")."' ";

                 if($db->f("id") == $id_estado)
                    $listagem_estado .= "selected='selected'";

                 $listagem_estado .= ">".$db->f("estado")."</option>";			

                 $db->next_record();

               }

               $sql = "select * from cidades WHERE id_estados = 7";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();

               $listagem_cidades = "<option value='0'>SELECIONE</option>";

               for($i = 0; $i < $db->num_rows(); $i++)
               {
                 $listagem_cidades .= "<option value='".$db->f("id")."' ";

                 if($db->f("id") == $id_cidade)
                    $listagem_cidades .= "selected='selected'";

                 $listagem_cidades .= ">".$db->f("cidade")."</option>";			

                 $db->next_record();

               }
         


               $form = montaForm("entregadornovo");
               
               $veiculos = montaSelect("entregadornovo",$listagem_veiculos,3); 
               $estados = montaSelect("entregadornovo",$listagem_estado,10); 
               $cidades = montaSelect("entregadornovo",$listagem_cidades,9); 
      

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		$GLOBALS["base"]->template->set_var('form',$form);
      
		$GLOBALS["base"]->template->set_var('dados_bancarios',$dados_bancarios);
		$GLOBALS["base"]->template->set_var('veiculos',$veiculos);
		$GLOBALS["base"]->template->set_var('estados',$estados);
		$GLOBALS["base"]->template->set_var('cidades',$cidades);

            $GLOBALS["base"]->template->set_var('nome',$nome);
            $GLOBALS["base"]->template->set_var('email',$email);
            $GLOBALS["base"]->template->set_var('celular',$celular);
            $GLOBALS["base"]->template->set_var('rua',$rua);
            $GLOBALS["base"]->template->set_var('numero',$numero);
            $GLOBALS["base"]->template->set_var('complemento',$complemento);
            $GLOBALS["base"]->template->set_var('bairro',$bairro);
            $GLOBALS["base"]->template->set_var('entrada',$entrada);
            $GLOBALS["base"]->template->set_var('saida',$saida);
            $GLOBALS["base"]->template->set_var('nascimento',$nascimento);
            $GLOBALS["base"]->template->set_var('cpf',$cpf);
            $GLOBALS["base"]->template->set_var('rg',$rg);
            $GLOBALS["base"]->template->set_var('numero_cnh',$numero_cnh);
            $GLOBALS["base"]->template->set_var('validade_documento',$validade_documento);
            $GLOBALS["base"]->template->set_var('obs',$obs);


      
		$GLOBALS["base"]->write_design_specific('entregadores.tpl' , 'novo');                                            
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
              
              $photo = $_FILES['photo'];
		$photo_documento = $_FILES['photo_documento'];

      		$nome = blockrequest($_REQUEST['nome']);
		$email = blockrequest($_REQUEST['email']);
		$id_veiculo = blockrequest($_REQUEST['id_veiculo']);
		$celular = blockrequest($_REQUEST['celular']);
		$rua = blockrequest($_REQUEST['rua']);
		$numero = blockrequest($_REQUEST['numero']);
		$bairro = blockrequest($_REQUEST['bairro']);
		$id_cidade = blockrequest($_REQUEST['id_cidade']);
		$id_estado = blockrequest($_REQUEST['id_estado']);
		$entrada = blockrequest($_REQUEST['entrada']);
		$nascimento = blockrequest($_REQUEST['nascimento']);
		$complemento = blockrequest($_REQUEST['complemento']);
		$saida = blockrequest($_REQUEST['saida']);
		$cpf = blockrequest($_REQUEST['cpf']);
		$rg = blockrequest($_REQUEST['rg']);
		$numero_cnh = blockrequest($_REQUEST['numero_cnh']);
		$validade_documento = blockrequest($_REQUEST['validade_documento']);
		$obs = addslashes(blockrequest($_REQUEST['obs']));
		$dados_bancarios = addslashes(blockrequest($_REQUEST['dados_bancarios']));

           $sql = "INSERT INTO entregadores
               (nome,
               email,
               celular,
               nascimento,
               rua,
               numero,
               complemento,
               bairro,
               id_cidade,
               id_estado,
               cpf,
               rg,
               numero_cnh,
               obs,
               validade_documento,
               status,
               dataCadastro,
               entrada,
               saida, 
               dados_bancarios)
               VALUES ('".$nome."',
               '".$email."',
               '".$celular."',
               '".$nascimento."',
               '".$rua."',
               '".$numero."',
               '".$complemento."',
               '".$bairro."',
               ".$id_cidade.",
               ".$id_estado.",
               '".$cpf."',
               '".$rg."',
               '".$numero_cnh."',
               '".$obs."',
               '".$validade_documento."',
               1,
               NOW(),
               '".$entrada."',
               '".$saida."', 
               '".$dados_bancarios."')";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();

            $id_entregador = $db->get_last_insert_id("entregadores","id");
            
            
            if($id_veiculo != "0")
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

                  $sql = "UPDATE entregadores SET photo = '".$arquivo."' WHERE id = ".$id_entregador." LIMIT 1 ";				
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

                  $sql = "UPDATE entregadores SET photo_documento = '".$arquivo."' WHERE id = ".$id_entregador." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }
            
            

            
            $this->notificacao("Entregador cadastrado com sucesso!", "green");
            header("Location: " . ABS_LINK . "/entregadores");
            
	   }
      
      function edita()
      {
         
		@session_start();
		$db = new db();

            if($_SESSION['id'] != $_SESSION['boss'])
                $this->valida_privilegios();
         
               $_SESSION['page_title'] = "Detalhes do Entregador";

			$id_entregador = blockrequest($_REQUEST['id']);	
         
         
         $sql = "SELECT
                  nome,
                  email,
                  celular,
                  nascimento,
                  rua,
                  numero,
                  complemento,
                  bairro,
                  id_cidade,
                  id_estado,
                  cpf,
                  rg,
                  photo,
                  photo_documento,
                  numero_cnh,
                  obs,
                  dados_bancarios,
                  validade_documento,
                  entrada,
                  saida
                  FROM entregadores 
                  WHERE id = ".$id_entregador." ";
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
                  
                  $nome = $db->f("nome");
                  $email = $db->f("email");
                  $celular = $db->f("celular");
                  $nascimento = $db->f("nascimento");
                  $rua = $db->f("rua");
                  $numero = $db->f("numero");
                  $complemento = $db->f("complemento");
                  $bairro = $db->f("bairro");
                  $id_cidade = $db->f("id_cidade");
                  $id_estado = $db->f("id_estado");
                  $cpf = $db->f("cpf");
                  $rg = $db->f("rg");
                  $photo = $db->f("photo");
                  $photo_documento = $db->f("photo_documento");
                  $numero_cnh = $db->f("numero_cnh");
                  $obs = $db->f("obs");
                  $dados_bancarios = $db->f("dados_bancarios");
                  $validade_documento = $db->f("validade_documento");
                  $entrada = $db->f("entrada");
                  $saida = $db->f("saida");
         
                  
                  $sql = "SELECT id_veiculo FROM entregadores_veiculos_fixos WHERE id_entregador = ".$id_entregador." LIMIT 1 ";
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
                  
                  $id_veiculo = $db->f("id_veiculo");
         
         
                     $sql = "SELECT
                     veiculos.id AS id
                     , veiculos.placa AS placa
                     , veiculos.modelo AS modelo
                     , veiculos_marcas.nome AS marca
                     FROM
                     veiculos
                     INNER JOIN veiculos_marcas 
                     ON (veiculos.id_marca = veiculos_marcas.id)";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_veiculos = "<option value='0' selected>- Nenhum Fixo -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_veiculos .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $id_veiculo)
					$listagem_veiculos .= "selected='selected'";
				
				$listagem_veiculos .= ">".$db->f("marca")." ".$db->f("modelo")." ".$db->f("placa")."</option>";			
	
				$db->next_record();

			}

               $sql = "select * from estados";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();

               $listagem_estado = "<option value='0'>SELECIONE</option>";

               for($i = 0; $i < $db->num_rows(); $i++)
               {
                 $listagem_estado .= "<option value='".$db->f("id")."' ";

                 if($db->f("id") == $id_estado)
                    $listagem_estado .= "selected='selected'";

                 $listagem_estado .= ">".$db->f("estado")."</option>";			

                 $db->next_record();

               }

               $sql = "select * from cidades WHERE id_estados = 7";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();

               $listagem_cidades = "<option value='0'>SELECIONE</option>";

               for($i = 0; $i < $db->num_rows(); $i++)
               {
                 $listagem_cidades .= "<option value='".$db->f("id")."' ";

                 if($db->f("id") == $id_cidade)
                    $listagem_cidades .= "selected='selected'";

                 $listagem_cidades .= ">".$db->f("cidade")."</option>";			

                 $db->next_record();

               }
         


               $form = montaForm("entregadornovo");
               
               $veiculos = montaSelect("entregadornovo",$listagem_veiculos,3); 
               $estados = montaSelect("entregadornovo",$listagem_estado,10); 
               $cidades = montaSelect("entregadornovo",$listagem_cidades,9); 
      

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
      
		$GLOBALS["base"]->template->set_var('id',$id_entregador);

               $GLOBALS["base"]->template->set_var('form',$form);
      
		$GLOBALS["base"]->template->set_var('veiculos',$veiculos);
		$GLOBALS["base"]->template->set_var('estados',$estados);
		$GLOBALS["base"]->template->set_var('cidades',$cidades);

            $GLOBALS["base"]->template->set_var('nome',$nome);
            $GLOBALS["base"]->template->set_var('email',$email);
            $GLOBALS["base"]->template->set_var('celular',$celular);
            $GLOBALS["base"]->template->set_var('rua',$rua);
            $GLOBALS["base"]->template->set_var('numero',$numero);
            $GLOBALS["base"]->template->set_var('complemento',$complemento);
            $GLOBALS["base"]->template->set_var('bairro',$bairro);
            $GLOBALS["base"]->template->set_var('entrada',$entrada);
            $GLOBALS["base"]->template->set_var('saida',$saida);
            $GLOBALS["base"]->template->set_var('nascimento',$nascimento);
            $GLOBALS["base"]->template->set_var('cpf',$cpf);
            $GLOBALS["base"]->template->set_var('rg',$rg);
            $GLOBALS["base"]->template->set_var('numero_cnh',$numero_cnh);
            $GLOBALS["base"]->template->set_var('validade_documento',$validade_documento);
            $GLOBALS["base"]->template->set_var('obs',$obs);
            $GLOBALS["base"]->template->set_var('dados_bancarios',$dados_bancarios);
            
            
               if(strlen($photo) > 6)
               {
                  $photo = '<img src="'.ABS_LINK.''.$photo.'" width="400">';
               }
               else
               {
                  $photo = '<img src="http://www.placehold.it/400x400/EFEFEF/AAAAAA&text=sem+foto">';
               }
               
               if(strlen($photo_documento) > 6)
               {
                  $photo_documento = '<img src="'.ABS_LINK.''.$photo_documento.'" width="400">';
               }
               else
               {
                  $photo_documento = '<img src="http://www.placehold.it/400x400/EFEFEF/AAAAAA&text=sem+foto+de+CNH">';
               }
               
            
            
            $GLOBALS["base"]->template->set_var('photo',$photo);
            $GLOBALS["base"]->template->set_var('photo_documento',$photo_documento);
            

		$GLOBALS["base"]->write_design_specific('entregadores.tpl' , 'edita');                                            
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                               
      }
      
      function update()
      {
		@session_start();
		$db = new db();

	   $id_entregador = blockrequest($_REQUEST['id']);	
      
      
              $photo = $_FILES['photo'];
		$photo_documento = $_FILES['photo_documento'];

      		$nome = blockrequest($_REQUEST['nome']);
		$email = blockrequest($_REQUEST['email']);
		$id_veiculo = blockrequest($_REQUEST['id_veiculo']);
		$celular = blockrequest($_REQUEST['celular']);
		$rua = blockrequest($_REQUEST['rua']);
		$numero = blockrequest($_REQUEST['numero']);
		$bairro = blockrequest($_REQUEST['bairro']);
		$id_cidade = blockrequest($_REQUEST['id_cidade']);
		$id_estado = blockrequest($_REQUEST['id_estado']);
		$entrada = blockrequest($_REQUEST['entrada']);
		$nascimento = blockrequest($_REQUEST['nascimento']);
		$complemento = blockrequest($_REQUEST['complemento']);
		$saida = blockrequest($_REQUEST['saida']);
		$cpf = blockrequest($_REQUEST['cpf']);
		$rg = blockrequest($_REQUEST['rg']);
		$numero_cnh = blockrequest($_REQUEST['numero_cnh']);
		$validade_documento = blockrequest($_REQUEST['validade_documento']);
		$obs = addslashes(blockrequest($_REQUEST['obs']));
		$dados_bancarios = addslashes(blockrequest($_REQUEST['dados_bancarios']));
         
         
               $sql = "UPDATE entregadores
                              SET nome = '".$nome."',
                              email = '".$email."',
                              celular = '".$celular."',
                              nascimento = '".$nascimento."',
                              rua = '".$rua."',
                              numero = '".$numero."',
                              complemento = '".$complemento."',
                              bairro = '".$bairro."',
                              id_cidade = ".$id_cidade.",
                              id_estado = ".$id_estado.",
                              cpf = '".$cpf."',
                              rg = '".$rg."',
                              numero_cnh = '".$numero_cnh."',
                              obs = '".$obs."',
                              dados_bancarios = '".$dados_bancarios."',
                              validade_documento = '".$validade_documento."',
                              entrada = '".$entrada."',
                              saida = '".$saida."'
                              WHERE id = ".$id_entregador." ";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();
      
      
               $sql = "DELETE FROM entregadores_veiculos_fixos WHERE id_entregador = ".$id_entregador." ";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();
     
      
            
            if($id_veiculo != "0")
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

                  $sql = "UPDATE entregadores SET photo = '".$arquivo."' WHERE id = ".$id_entregador." LIMIT 1 ";				
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

                  $sql = "UPDATE entregadores SET photo_documento = '".$arquivo."' WHERE id = ".$id_entregador." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }
            
            

            
            $this->notificacao("Entregador atualizado com sucesso!", "green");
            header("Location: " . ABS_LINK . "/entregadores");
      
      }
	   
   function exclui()
   {
      
		@session_start();
		$db = new db();


            $id = blockrequest($_REQUEST['id']);
            
            
            
            $sql = "UPDATE  entregadores SET status = 0 WHERE id = ".$id." LIMIT 1 ";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();

      
            $this->notificacao("Entregador ecluído com sucesso!", "green");
            header("Location: " . ABS_LINK . "/entregadores");
   }
      
}                                                                                                     





?>