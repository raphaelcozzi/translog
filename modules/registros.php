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

               
                  $tipo = $_REQUEST['tipo'];
                  
                  if($tipo == "1")
                  {
                     $tipo_registro = "Saída";
                  }
         
                  if($tipo == "2")
                  {
                     $tipo_registro = "Retorno";
                  }

                     $id_entregador = 0;
                  
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
				
				if($db2->num_rows() > 0)
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
				
				if($db->f("id") == $entregador)
					$listagem_entregadores .= "selected='selected'";
				
				$listagem_entregadores .= ">".$db->f("nome")."</option>";			
	
				$db->next_record();

			}



               $form = montaForm("registro");
               
               $veiculos = montaSelect("registro",$listagem_veiculos,1); 
               $entregadores = montaSelect("registro",$listagem_entregadores,2); 
      

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		$GLOBALS["base"]->template->set_var('form',$form);

		$GLOBALS["base"]->template->set_var('tipo_registro',$tipo_registro);
		$GLOBALS["base"]->template->set_var('tipo',$tipo);

      
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

            if($_SESSION['id'] != $_SESSION['boss'])
                   $this->valida_privilegios();
                
		$db = new db();
		$db2 = new db();

		$id_veiculo = blockrequest($_REQUEST['id_veiculo']);
		$id_entregador = blockrequest($_REQUEST['id_entregador']);
		$obs = addslashes(blockrequest($_REQUEST['obs']));
		$data_registro = blockrequest($_REQUEST['data_registro']);
		$hora_registro = blockrequest($_REQUEST['hora_registro']);
		$volumes = blockrequest($_REQUEST['volumes']);
		$tipo = blockrequest($_REQUEST['tipo']);

           $sql = "INSERT INTO registros
                        (id_entregador,
                        id_veiculo,
                        data_registro,
                        volumes,
                        obs,
                        tipo,
                        hora_registro, dataCadastro)
                        VALUES (".$id_entregador.",
                        ".$id_veiculo.",
                        '".$data_registro."',
                        ".$volumes.",
                        '".$obs."',
                        ".$tipo.",
                        '".$hora_registro."', NOW())";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();

            $id_registro = $db->get_last_insert_id("registros","id");
            
            
            
            $this->notificacao("Registro efetuado com sucesso!", "green");
            header("Location: " . ABS_LINK . "/home");
            
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
                               ON (veiculos.id_marca = veiculos_marcas.id)";
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
										<td>'.$concluido.'</td> 
										<td>'.$volumes.'</td> 
										<td><img src="'.ABS_LINK.''.$photo.'" width="150"></td> 
									</tr>';
				
				
				
				
				$db->next_record();
			}

      
      
             $grid = montaGrid("sample_1",$listagem,"entrega");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid",$grid);
													
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
                               ON (veiculos.id_marca = veiculos_marcas.id)";
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
										<td>'.$data_registro.' </td> 
										<td>'.$volumes.'</td> 
										<td>'.$retornados.'</td> 
										<td>'.$apagar.'</td> 
									</tr>';
				
				
				
				
				$db->next_record();
			}

      
      
             $grid = montaGrid("sample_1",$listagem,"financeiro");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		
		$GLOBALS["base"]->template->set_var("grid",$grid);
													
		$GLOBALS["base"]->write_design_specific('registros.tpl' , 'financeiro');                       
		$GLOBALS["base"]->template = new template();                                                  
		$this->footer();                                                                           
      
      
   }
}                                                                                                     





?>