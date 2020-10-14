<?php
require_once("modules/home.php");                                                                      

	class registros extends home                                                                             
    {              

		function main()
		{

		}


      function novo()
	{
		@session_start();
		$db = new db();
		$db2 = new db();

            if($_SESSION['id'] != $_SESSION['boss'])
                $this->valida_privilegios();
         
               $_SESSION['page_title'] = "Novo Registro";

                     $id_entregador = 0;
                     $id_veiculo = 0;
               
                  $tipo = $_REQUEST['tipo'];
                  
                  if(isset($_REQUEST['id_saida']) && $tipo == "2")
                  {
                     $id_saida = $_REQUEST['id_saida'];
                     
                     
                     $sql = "SELECT id_entregador, id_veiculo FROM registros WHERE id = ".$id_saida." ";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();
                     if($db->num_rows() > 0)
                     {
                        $id_entregador = $db->f("id_entregador");
                        $id_veiculo = $db->f("id_veiculo");
                     }
                     
                  }
                  else
                  {
                     $id_saida = "0";
                  }
                  
                  if($tipo == "1")
                  {
                     $tipo_registro = "Saída";
                  }
         
                  if($tipo == "2")
                  {
                     $tipo_registro = "Retorno";
                  }

                  
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
                     

			$listagem_veiculos = "<option value='0' selected>- SELECIONE -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_veiculos .= "<option value='".$db->f("id")."' ";
            
                              $sql2 = "SELECT * FROM entregadores_veiculos_fixos WHERE id_veiculo = ".$db->f("id")." AND id_entregador = ".$id_entregador." ";
                              $db2->query($sql2,__LINE__,__FILE__);
                              $db2->next_record();
				
				if($db2->num_rows() > 0 || $id_veiculo == $db2->f("id_veiculo"))
					$listagem_veiculos .= "selected='selected'";
				
				$listagem_veiculos .=  ">".$db->f("marca")." ".$db->f("modelo")." ".$db->f("placa")."</option>";			
	
				$db->next_record();

			}

                      $sql = "select id, nome from entregadores";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_entregadores = "<option value='0' selected>- SELECIONE -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_entregadores .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $id_entregador)
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}

         

                      $sql = "select id, valor from diarias ORDER BY ordem ASC";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_diarias .= "<option value='".$db->f("valor")."' ";
				
				if($db->f("valor") == $diaria)
					$listagem_diarias .= "selected='selected'";
				
				$listagem_diarias .= ">".  $this->decimal_to_brasil_real($db->f("valor"))."</option>";			
	
				$db->next_record();

			}
         

                  if($tipo == "1")
                  {
                        $form = montaForm("registro");

                        $veiculos = montaSelect("registro",$listagem_veiculos,1); 
                        $entregadores = montaSelect("registro",$listagem_entregadores,2); 
                        $diarias = montaSelect("registro",$listagem_diarias,8); 
                  }

                  if($tipo == "2")
                  {
                        $form = montaForm("registro_retorno");

                        $veiculos = montaSelect("registro",$listagem_veiculos,1); 
                        $entregadores = montaSelect("registro",$listagem_entregadores,2); 
                  }
      

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		$GLOBALS["base"]->template->set_var('form',$form);

		$GLOBALS["base"]->template->set_var('tipo_registro',$tipo_registro);
		$GLOBALS["base"]->template->set_var('tipo',$tipo);

		$GLOBALS["base"]->template->set_var('id_saida',$id_saida);
      
		$GLOBALS["base"]->template->set_var('diarias',$diarias);
		$GLOBALS["base"]->template->set_var('veiculos',$veiculos);
		$GLOBALS["base"]->template->set_var('entregadores',$entregadores);

            $GLOBALS["base"]->template->set_var('nome',$nome);
            $GLOBALS["base"]->template->set_var('data_registro',date("Y-m-d"));
            $GLOBALS["base"]->template->set_var('hora_registro',date("H:i:s"));
            $GLOBALS["base"]->template->set_var('volumes',$volumes);
            $GLOBALS["base"]->template->set_var('obs',$obs);


      
		$GLOBALS["base"]->write_design_specific('registros.tpl' , 'novo');                                            
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                               
		
	}



	function insere()
	{
		
		@session_start();
		$db = new db();

            
            if(isset($_REQUEST['id_saida']) && $_REQUEST['id_saida'] != "0")
            {
               $id_saida = $_REQUEST['id_saida'];
            }
                
		$db = new db();
		$db2 = new db();

		$id_veiculo = blockrequest($_REQUEST['id_veiculo']);
		$id_entregador = blockrequest($_REQUEST['id_entregador']);
		$obs = addslashes(blockrequest($_REQUEST['obs']));
		$data_registro = blockrequest($_REQUEST['data_registro']);
		$hora_registro = blockrequest($_REQUEST['hora_registro']);
		$volumes = blockrequest($_REQUEST['volumes']);
		$tipo = blockrequest($_REQUEST['tipo']);
		$diaria = blockrequest($_REQUEST['diaria']);

           $sql = "INSERT INTO registros
                        (id_entregador,
                        id_veiculo,
                        data_registro,
                        volumes,
                        obs,
                        tipo,
                        hora_registro, dataCadastro, diaria)
                        VALUES (".$id_entregador.",
                        ".$id_veiculo.",
                        '".$data_registro."',
                        ".$volumes.",
                        '".$obs."',
                        ".$tipo.",
                        '".$hora_registro."', NOW(), '".$diaria."')";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();

            $id_registro = $db->get_last_insert_id("registros","id");
            
            // Se for um retorno
            if($tipo == "2")
            {
               $sql = "INSERT INTO registros_retornos (id_saida, id_retorno, dataCadastro) VALUES (".$id_saida.", ".$id_registro.", NOW())";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();
            }
            
            
            if($tipo == "1")
            {
               $this->notificacao("Registro efetuado com sucesso!", "green");
               header("Location: " . ABS_LINK . "registros/saidas");
            }
            
            if($tipo == "2")
            {
               $this->notificacao("Registro efetuado com sucesso!", "green");
               header("Location: " . ABS_LINK . "registros/retornos");
            }
            
	   }
      

	function ajax_entregador()
	{
		
		@session_start();
		$db = new db();
		$db2 = new db();
	
         	   $id_entregador = $_GET['entregador'];
	
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

			echo "<option value='0' selected>- SELECIONE -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				echo "<option value='".$db->f("id")."' ";
            
                              $sql2 = "SELECT * FROM entregadores_veiculos_fixos WHERE id_veiculo = ".$db->f("id")." AND id_entregador = ".$id_entregador." ";
                              $db2->query($sql2,__LINE__,__FILE__);
                              $db2->next_record();
				
				if($db2->num_rows() > 0)
					echo "selected='selected'";
				
				echo  ">".$db->f("marca")." ".$db->f("modelo")." ".$db->f("placa")."</option>";			
	
				$db->next_record();

			}
	   
	}
   
   function  entrega()
   {
			@session_start();
                        
   			if($_SESSION['id'] != $_SESSION['boss'])
            			$this->valida_privilegios();
         
                     $_SESSION['page_title'] = "Relatório de Entrega";
			
			$db = new db();
			$db2 = new db();
         
                     if(isset($_REQUEST['data_de']))
                     {
                        $data_de = $_REQUEST['data_de'];
                        $data_ate = $_REQUEST['data_ate'];
                     }
                     else
                     {
                        $data_de = date('Y-m-d', strtotime(date("Y-m-d"). ' - 15 days'));

                        $data_ate = date("Y-m-d");        
                     }
         
         

			$sql = "SELECT
                              registros.id AS id_registro
                            , registros.volumes AS volumes
                            , registros.obs AS obs
                           , entregadores.nome AS entregador
                           , veiculos.photo AS photo
                           , veiculos.placa AS placa
                           , veiculos.modelo AS modelo
                           , veiculos_marcas.nome AS marca
                           , DATE_FORMAT(registros.data_registro,'%d/%m/%Y') AS data_registro
                           , DATE_FORMAT(registros.hora_registro,'%H:%i') AS hora_registro
                           FROM
                           registros
                           INNER JOIN entregadores 
                               ON (registros.id_entregador = entregadores.id)
                           INNER JOIN veiculos 
                               ON (registros.id_veiculo = veiculos.id)
                           INNER JOIN veiculos_marcas 
                               ON (veiculos.id_marca = veiculos_marcas.id) WHERE  registros.data_registro BETWEEN '".$data_de."' AND '".$data_ate."' AND tipo = 1";
         
                            if(isset($_REQUEST['id_entregador']) && $_REQUEST['id_entregador'] != "0")
                            {
                               $sql .= " AND registros.id_entregador = ".$_REQUEST['id_entregador']." ";
                            }
                            
                            $sql .= " ORDER BY registros.id DESC";
                            
         
         
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id_registro = $db->f("id_registro");			
				$entregador = $db->f("entregador");			
				$marca = $db->f("marca");			
				$placa = $db->f("placa");			
				$modelo = $db->f("modelo");			
				$photo = $db->f("photo");			
				$data_registro = $db->f("data_registro");			
				$hora_registro = $db->f("hora_registro");			
				$volumes = $db->f("volumes");			
				$obs = $db->f("obs");			
           
                     
                           $entregue = $volumes;
                           $concluido = "Sim";
                           $cor = "000000";

            
                        $sql2 = "SELECT id_retorno FROM registros_retornos WHERE id_saida = ".$id_registro." ";
                        $db2->query($sql2,__LINE__,__FILE__);
                        $db2->next_record();
                        if($db2->num_rows() > 0)
                        {
                           $sql2 = "SELECT volumes FROM registros WHERE id = ".$db2->f("id_retorno")." ";
                           $db2->query($sql2,__LINE__,__FILE__);
                           $db2->next_record();
                           
                           $entregue = $volumes-$db2->f("volumes");
                        }   
                        
                        if($entregue < $volumes)
                        {
                           $concluido = "Não";
                           $cor = "ff0000";
                        }
                           
                           
            

				$listagem .= '<tr style="color:#'.$cor.';"> 
										<td>'.$entregador.'</td>
										<td>'.$placa.'/'.$marca.'/'.$modelo.'</td>
										<td>'.$volumes.'</td> 
										<td>'.$data_registro.'</td> 
										<td>'.$hora_registro.'</td> 
										<td>'.$concluido.'</td> 
										<td>'.$entregue.'</td> 
										<td>'.nl2br($obs).'</td> 
									</tr>';
				
				
				
				
				$db->next_record();
			}

      
                      $sql = "select id, nome from entregadores";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_entregadores = "<option value='0' selected>- TODOS -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_entregadores .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $_REQUEST['id_entregador'])
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}

            $date = new DateTime($data_de);
            $data_de_format =  $date->format('d/m/Y');

            $date = new DateTime($data_ate);
            $data_ate_format =  $date->format('d/m/Y');
         
             $grid = montaGrid("sample_1",$listagem,"financeiro");
      
             $grid = montaGrid("sample_1",$listagem,"entrega");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid",$grid);
      
		$GLOBALS["base"]->template->set_var("listagem_entregadores",$listagem_entregadores);

		$GLOBALS["base"]->template->set_var("data_de",$data_de);
		$GLOBALS["base"]->template->set_var("data_ate",$data_ate);
      
		$GLOBALS["base"]->template->set_var("data_de_format",$data_de_format);
		$GLOBALS["base"]->template->set_var("data_ate_format",$data_ate_format);

      
													
		$GLOBALS["base"]->write_design_specific('registros.tpl' , 'entrega');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           
      
   }
      
   function  financeiro()
   {
			@session_start();
                        
   			if($_SESSION['id'] != $_SESSION['boss'])
            			$this->valida_privilegios();
         
                     $_SESSION['page_title'] = "Relatório Financeiro";
			
			$db = new db();
			$db2 = new db();
			$db3 = new db();
			$db4 = new db();
         
                  
                     $valor_diaria = 150.00;
                     
                     if(isset($_REQUEST['data_de']))
                     {
                        $data_de = $_REQUEST['data_de'];
                        $data_ate = $_REQUEST['data_ate'];
                     }
                     else
                     {
                        $data_de = date('Y-m-d', strtotime(date("Y-m-d"). ' - 15 days'));

                        $data_ate = date("Y-m-d");        
                     }
         

			$sql = "SELECT entregadores.id AS id_entregador, 
                     entregadores.nome AS nome_entregador 
                     FROM entregadores ORDER BY entregadores.nome ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
                           $retornados = 0;
                           $entregues = 0;
            
				$id_entregador = $db->f("id_entregador");			
				$nome_entregador = $db->f("nome_entregador");		
            
                           $dias_trabalhados = 0;
                           $faltando_entregar = 0;

            
                        $sql2 = "SELECT COUNT(id) AS total, 
                        SUM(volumes) AS total_volumes,
                        id AS id_registro 
                        FROM registros WHERE id_entregador = ".$id_entregador."
                        AND tipo = 1
                        AND id IN(SELECT DISTINCT(id_saida) FROM registros_retornos)
                        AND data_registro BETWEEN '".$data_de."' AND '".$data_ate."' ";
                        
                        if(isset($_REQUEST['id_entregador']) && $_REQUEST['id_entregador'] != "0")
                        {
                           $sql2 .= " AND registros.id_entregador = ".$_REQUEST['id_entregador']." ";
                        }

                        $sql2 .= " GROUP BY EXTRACT(DAY FROM registros.data_registro)";
                        
                        
                        $db2->query($sql2,__LINE__,__FILE__);
                        $db2->next_record();
                        for($i2 = 0; $i2 < $db2->num_rows(); $i2++)
                        {
                                    $dias_trabalhados += $db2->f("total");



                                   $sql3 = "SELECT id_retorno FROM registros_retornos WHERE id_saida = ".$db2->f("id_registro")." ";
                                   $db3->query($sql3,__LINE__,__FILE__);
                                   $db3->next_record();
                                   if($db3->num_rows() > 0)
                                   {

                                      $sql3 = "SELECT volumes FROM registros WHERE id = ".$db3->f("id_retorno")." AND tipo = 2 ";
                                      $db3->query($sql3,__LINE__,__FILE__);
                                      $db3->next_record();
                                      $retornados += $db3->f("volumes");

                                   }

                           /*
                                if($db2->f("total_volumes") > 0)
                                   $entregues += $db2->f("total_volumes")-$retornados;
                           */
                                   
                                if($db2->f("total_volumes") > 0)
                                   $entregues += $db2->f("total_volumes");

                                     $sql4 = "SELECT diaria  FROM registros WHERE id = ".$db2->f("id_registro")." ";
                                      $db4->query($sql4,__LINE__,__FILE__);
                                      $db4->next_record();
                                      $valor_diaria = $db4->f("diaria");


                                          $db2->next_record();
                                }
                     
                     
                        
                        $apagar = $dias_trabalhados*$valor_diaria;
                        

				$listagem .= '<tr> 
										<td>'.$nome_entregador.'</td>
										<td>'.$dias_trabalhados.' </td> 
										<td>'.$entregues.'</td> 
										<td>R$ '.  $this->decimal_to_brasil_real($apagar).'</td> 
									</tr>';
				
				
				
				
				$db->next_record();
			}

      
                      $sql = "select id, nome from entregadores";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_entregadores = "<option value='0' selected>- TODOS -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_entregadores .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $_REQUEST['id_entregador'])
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}

            $date = new DateTime($data_de);
            $data_de_format =  $date->format('d/m/Y');

            $date = new DateTime($data_ate);
            $data_ate_format =  $date->format('d/m/Y');
         
             $grid = montaGrid("sample_1",$listagem,"financeiro");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid",$grid);
		$GLOBALS["base"]->template->set_var("listagem_entregadores",$listagem_entregadores);

		$GLOBALS["base"]->template->set_var("data_de",$data_de);
		$GLOBALS["base"]->template->set_var("data_ate",$data_ate);
      
		$GLOBALS["base"]->template->set_var("data_de_format",$data_de_format);
		$GLOBALS["base"]->template->set_var("data_ate_format",$data_ate_format);

      
		$GLOBALS["base"]->write_design_specific('registros.tpl' , 'financeiro');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           
      
      
   }
   
   function  saidas()
   {
			@session_start();
                        
   			if($_SESSION['id'] != $_SESSION['boss'])
            			$this->valida_privilegios();
         
                     $_SESSION['page_title'] = "Registros de Saídas";
			
			$db = new db();
			$db2 = new db();
         
                     if(isset($_REQUEST['data_de']))
                     {
                        $data_de = $_REQUEST['data_de'];
                        $data_ate = $_REQUEST['data_ate'];
                     }
                     else
                     {
                        $data_de = date('Y-m-d', strtotime(date("Y-m-d"). ' - 15 days'));

                        $data_ate = date("Y-m-d");        
                     }
         

			$sql = "SELECT
                              registros.id AS id_registro
                            , registros.volumes AS volumes
                           , entregadores.nome AS entregador
                           , veiculos.photo AS photo
                           , veiculos.placa AS placa
                           , veiculos.modelo AS modelo
                           , veiculos_marcas.nome AS marca
                           , DATE_FORMAT(registros.data_registro,'%d/%m/%Y') AS data_registro
                           , DATE_FORMAT(registros.hora_registro,'%H:%i') AS hora_registro
                           FROM
                           registros
                           INNER JOIN entregadores 
                               ON (registros.id_entregador = entregadores.id)
                           INNER JOIN veiculos 
                               ON (registros.id_veiculo = veiculos.id)
                           INNER JOIN veiculos_marcas 
                               ON (veiculos.id_marca = veiculos_marcas.id) WHERE tipo = 1 AND data_registro BETWEEN '".$data_de."' AND '".$data_ate."' ";
         
                            if(isset($_REQUEST['id_entregador']) && $_REQUEST['id_entregador'] != "0")
                            {
                               $sql .= " AND registros.id_entregador = ".$_REQUEST['id_entregador']." ";
                            }
                            
                            $sql .= " ORDER BY registros.id DESC";
         
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id_registro = $db->f("id_registro");			
				$entregador = $db->f("entregador");			
				$marca = $db->f("marca");			
				$placa = $db->f("placa");			
				$modelo = $db->f("modelo");			
				$photo = $db->f("photo");			
				$data_registro = $db->f("data_registro");			
				$hora_registro = $db->f("hora_registro");			
				$volumes = $db->f("volumes");			

				$listagem .= '<tr> 
										<td>'.$entregador.'</td>
										<td>'.$placa.'/'.$marca.'/'.$modelo.'</td>
										<td>'.$volumes.'</td> 
										<td>'.$data_registro.'</td> 
										<td>'.$hora_registro.'</td> 
                                                                  <td align="center">';
            
            
                              // Se já tiver retorno pra essa saída, não permite que registre uma nova
                                 
                                 $sql2 = "SELECT COUNT(id) AS total FROM registros_retornos WHERE id_saida = ".$id_registro." ";
                                 $db2->query($sql2,__LINE__,__FILE__);
                                 $db2->next_record();
                                 if($db2->f("total") == 0)
                                 {
                                       $listagem .= '<a href="index.php?module=registros&method=novo&id_saida='.$id_registro.'&tipo=2" ><button class="btn blue" >Registrar Retorno</button></a>';
                                 }
            
            
                                       $listagem .= '</td>
                                                                  <td align="center"><a href="index.php?module=registros&method=exclui&id='.$id_registro.'" onclick="return(confirm(\'Confirma excluir o registro?\'))"><i class="fa fa-trash"></i></a></td>
									</tr>';
				
				
				
				
				$db->next_record();
			}

      
                      $sql = "select id, nome from entregadores";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_entregadores = "<option value='0' selected>- TODOS -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_entregadores .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $_REQUEST['id_entregador'])
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}

            $date = new DateTime($data_de);
            $data_de_format =  $date->format('d/m/Y');

            $date = new DateTime($data_ate);
            $data_ate_format =  $date->format('d/m/Y');
      
             $grid = montaGrid("sample_1",$listagem,"saidas");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       

      		$GLOBALS["base"]->template->set_var("listagem_entregadores",$listagem_entregadores);

		$GLOBALS["base"]->template->set_var("data_de",$data_de);
		$GLOBALS["base"]->template->set_var("data_ate",$data_ate);
      
		$GLOBALS["base"]->template->set_var("data_de_format",$data_de_format);
		$GLOBALS["base"]->template->set_var("data_ate_format",$data_ate_format);


      
		$GLOBALS["base"]->template->set_var("grid",$grid);
													
		$GLOBALS["base"]->write_design_specific('registros.tpl' , 'saidas');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           
      
   }
   
   function  retornos()
   {
			@session_start();
                        
   			if($_SESSION['id'] != $_SESSION['boss'])
            			$this->valida_privilegios();
         
                     $_SESSION['page_title'] = "Registros de Retornos";
			
			$db = new db();
			$db2 = new db();
			$db3 = new db();
         
         
                     if(isset($_REQUEST['data_de']))
                     {
                        $data_de = $_REQUEST['data_de'];
                        $data_ate = $_REQUEST['data_ate'];
                     }
                     else
                     {
                        $data_de = date('Y-m-d', strtotime(date("Y-m-d"). ' - 15 days'));

                        $data_ate = date("Y-m-d");        
                     }

			$sql = "SELECT
                              registros.id AS id_registro
                            , registros.volumes AS volumes
                            , registros.obs AS obs
                            , registros.id_entregador AS id_entregador
                           , entregadores.nome AS entregador
                           , veiculos.photo AS photo
                           , registros.id_veiculo AS id_veiculo
                           , veiculos.placa AS placa
                           , veiculos.modelo AS modelo
                           , veiculos_marcas.nome AS marca
                           , DATE_FORMAT(registros.data_registro,'%Y-%m-%d') AS data_registro_raw
                           , DATE_FORMAT(registros.hora_registro,'%H:%i') AS hora_registro_raw
                           , DATE_FORMAT(registros.data_registro,'%d/%m/%Y') AS data_registro
                           , DATE_FORMAT(registros.hora_registro,'%H:%i') AS hora_registro
                           FROM
                           registros
                           INNER JOIN entregadores 
                               ON (registros.id_entregador = entregadores.id)
                           INNER JOIN veiculos 
                               ON (registros.id_veiculo = veiculos.id)
                           INNER JOIN veiculos_marcas 
                               ON (veiculos.id_marca = veiculos_marcas.id) WHERE tipo = 2  AND data_registro BETWEEN '".$data_de."' AND '".$data_ate."' ";
         
                            if(isset($_REQUEST['id_entregador']) && $_REQUEST['id_entregador'] != "0")
                            {
                               $sql .= " AND registros.id_entregador = ".$_REQUEST['id_entregador']." ";
                            }
                            
                            $sql .= " ORDER BY registros.id DESC";
         
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id_registro = $db->f("id_registro");			
				$entregador = $db->f("entregador");			
				$marca = $db->f("marca");			
				$placa = $db->f("placa");			
				$modelo = $db->f("modelo");			
				$photo = $db->f("photo");			
				$data_registro = $db->f("data_registro");			
				$hora_registro = $db->f("hora_registro");			
				$volumes = $db->f("volumes");			
				$obs = $db->f("obs");			
				$id_entregador = $db->f("id_entregador");			
				$id_veiculo = $db->f("id_veiculo");			
				$data_registro_raw = $db->f("data_registro_raw");			
				$hora_registro_raw = $db->f("hora_registro_raw");			

				$listagem .= '<tr> 
										<td>'.$entregador.'</td>
										<td>'.$placa.'/'.$marca.'/'.$modelo.'</td>
										<td>'.$volumes.'</td> 
										<td>'.$data_registro.'</td> 
										<td>'.$hora_registro.'</td> 
										<td>'.nl2br($obs).'</td> 
                                                                  <td align="center"> <a data-toggle="modal" href="#modal_'.$id_registro.'" onclick="javascript:void(0);" ><button class="btn blue" >Ver Saída</button></a></td>
                                                                  <td align="center"><a href="index.php?module=registros&method=exclui&id='.$id_registro.'" onclick="return(confirm(\'Confirma excluir o registro?\'))"><i class="fa fa-trash"></i></a></td>
									</tr>';
				
		               $form = montaForm("registro");
                     
                              $form =  str_replace("col-md-4", "col-md-9", $form);
                              
                              
                              $sql2 = "SELECT id_saida FROM registros_retornos WHERE id_retorno = ".$id_registro." ";
                              $db2->query($sql2,__LINE__,__FILE__);
                              $db2->next_record();
                              $id_saida = $db2->f("id_saida");
                              
			$sql2 = "SELECT
                             registros.volumes AS volumes_saida
                            , registros.obs AS obs_saida
                            , registros.id_entregador AS id_entregador
                           , entregadores.nome AS entregador
                           , DATE_FORMAT(registros.data_registro,'%Y-%m-%d') AS data_registro_raw_saida
                           , DATE_FORMAT(registros.hora_registro,'%H:%i') AS hora_registro_raw_saida
                           FROM
                           registros
                           INNER JOIN entregadores 
                               ON (registros.id_entregador = entregadores.id)
                           INNER JOIN veiculos 
                               ON (registros.id_veiculo = veiculos.id)
                           INNER JOIN veiculos_marcas 
                               ON (veiculos.id_marca = veiculos_marcas.id) WHERE tipo = 1  AND registros.id = ".$id_saida." ";
                              $db2->query($sql2,__LINE__,__FILE__);
                              $db2->next_record();

                              $data_registro_raw_saida = $db2->f("data_registro_raw_saida");
                              $hora_registro_raw_saida = $db2->f("hora_registro_raw_saida");
                              $volumes_saida = $db2->f("volumes_saida");
                              $obs_saida = $db2->f("obs_saida");
                              
                              
                              
                              
                             $form =  str_replace("{data_registro}", $data_registro_raw_saida, $form);
                             $form =  str_replace("{hora_registro}", $hora_registro_raw_saida, $form);
                             $form =  str_replace("{volumes}", $volumes_saida, $form);
                             $form =  str_replace("{obs}", $obs_saida, $form);
                             
                      
                             
                     $sql2 = "SELECT
                     veiculos.id AS id
                     , veiculos.placa AS placa
                     , veiculos.modelo AS modelo
                     , veiculos_marcas.nome AS marca
                     FROM
                     veiculos
                     INNER JOIN veiculos_marcas 
                     ON (veiculos.id_marca = veiculos_marcas.id)";
                     $db2->query($sql2,__LINE__,__FILE__);
                     $db2->next_record();
                     
                             
                    $listagem_veiculos_details = "<option value='0' selected>- SELECIONE -</option>";
			
			for($i2 = 0; $i2 < $db2->num_rows(); $i2++)
			{
				$listagem_veiculos_details .= "<option value='".$db2->f("id")."' ";
            
                              $sql3 = "SELECT * FROM entregadores_veiculos_fixos WHERE id_veiculo = ".$db2->f("id")." AND id_entregador = ".$id_entregador." ";
                              $db3->query($sql3,__LINE__,__FILE__);
                              $db3->next_record();
				
				if($db3->num_rows() > 0 || $id_veiculo == $db2->f("id_veiculo"))
					$listagem_veiculos_details .= "selected='selected'";
				
				$listagem_veiculos_details .=  ">".$db2->f("marca")." ".$db2->f("modelo")." ".$db2->f("placa")."</option>";			
	
				$db2->next_record();

			}

                     $sql2 = "select id, nome from entregadores";
                     $db2->query($sql2,__LINE__,__FILE__);
                     $db2->next_record();

			$listagem_entregadores_details = "<option value='0' selected>- SELECIONE -</option>";
			
			for($i2 = 0; $i2 < $db2->num_rows(); $i2++)
			{
				$listagem_entregadores_details .= "<option value='".$db2->f("id")."' ";
				
				if($db2->f("id") == $id_entregador)
					$listagem_entregadores_details .= "selected='selected'";
				
				$listagem_entregadores_details .= ">".$db2->f("nome")."</option>";			
	
				$db2->next_record();

			}

               
                           $veiculos = montaSelect("registro",$listagem_veiculos_details,1); 
                           $entregadores = montaSelect("registro",$listagem_entregadores_details,2); 
                           
                           
            
            
                           $modals .= '<div class="modal fade" id="modal_'.$id_registro.'" tabindex="-1" role="basic" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="height:auto !important;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Detalhes da Saída referente ao retorno</h4>
                                                </div>
                                                <div class="modal-body" style="width:100%;"> 
                                                   <form action="index.php?module=registros&methodmain" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
                                                   '.$entregadores.'
                                                      '.$veiculos.'<div>
                                          '.$form.'                                             
                                                <div class="modal-footer">
                                                <center>   

                                                 <!--  <button type="submit" class="btn green" style="width:300px;">Continuar &rightarrow;</button><br><br>-->
                                                    </center>
                                                </form>
                                      
                                                   <button type="button" id="closemodal" class="btn dark btn-outline" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>';
            
            
				
				$db->next_record();
			}

                            $sql = "select id, nome from entregadores";
                     $db->query($sql,__LINE__,__FILE__);
                     $db->next_record();

			$listagem_entregadores = "<option value='0' selected>- TODOS -</option>";
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$listagem_entregadores .= "<option value='".$db->f("id")."' ";
				
				if($db->f("id") == $_REQUEST['id_entregador'])
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}

            $date = new DateTime($data_de);
            $data_de_format =  $date->format('d/m/Y');

            $date = new DateTime($data_ate);
            $data_ate_format =  $date->format('d/m/Y');

      
             $grid = montaGrid("sample_1",$listagem,"retornos");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid",$grid);
		$GLOBALS["base"]->template->set_var("modals",$modals);
      
      		$GLOBALS["base"]->template->set_var("listagem_entregadores",$listagem_entregadores);

		$GLOBALS["base"]->template->set_var("data_de",$data_de);
		$GLOBALS["base"]->template->set_var("data_ate",$data_ate);
      
		$GLOBALS["base"]->template->set_var("data_de_format",$data_de_format);
		$GLOBALS["base"]->template->set_var("data_ate_format",$data_ate_format);

      
													
		$GLOBALS["base"]->write_design_specific('registros.tpl' , 'retornos');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           
      
   }
   
   function exclui()
   {
      
		@session_start();
		$db = new db();


            $id_registro = blockrequest($_REQUEST['id']);
            
            
            $sql = "SELECT tipo FROM registros WHERE id = ".$id." ";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();
            $tipo = $db->f("tipo");
            
            $sql = "DELETE FROM registros WHERE id = ".$id." LIMIT 1 ";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();

            $sql = "DELETE FROM registros_retornos WHERE id_saida = ".$id." OR id_retorno = ".$id." ";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();
      
      
            if($tipo == "1")
            {
               $this->notificacao("Registro excluído com sucesso!", "green");
               header("Location: " . ABS_LINK . "registros/saidas");
            }
            
            if($tipo == "2")
            {
               $this->notificacao("Registro excluído com sucesso!", "green");
               header("Location: " . ABS_LINK . "registros/retornos");
            }
   }
   
   
}                                                                                                     





?>