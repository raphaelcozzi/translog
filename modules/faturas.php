<?php
require_once("modules/home.php");                                                                      

	class faturas extends home                                                                             
    {              

		function main()
		{
			@session_start();
                        
			if($_SESSION['id'] != $_SESSION['boss'])
			$this->valida_privilegios();
         
                     $_SESSION['page_title'] = "Faturas";
			
			$db = new db();
			$db2 = new db();
         
                     if(isset($_REQUEST['data_de']))
                     {
                        $data_de = $_REQUEST['data_de'];
                        $data_ate = $_REQUEST['data_ate'];
                     }
                     else
                     {
                        $data_de = date('Y-m-d');

                        $data_ate = date("Y-m-d");        
                     }
         
         

			$sql = "SELECT faturas.id AS id, 
                                faturas.valor,
                                faturas.obs,
                                faturas.anexo,
                                faturas_situacoes.nome AS situacao,
                                DATE_FORMAT(faturas.data_emissao, '%d/%m/%Y') AS data_emissao, 
                                DATE_FORMAT(faturas.data_pagamento, '%d/%m/%Y') AS data_pagamento,
                                DATE_FORMAT(faturas.data_emissao, '%Y-%m-%d') AS data_emissao_raw, 
                                DATE_FORMAT(faturas.data_pagamento, '%Y-%m-%d') AS data_pagamento_raw
                                FROM faturas, faturas_situacoes
                                WHERE faturas.situacao = faturas_situacoes.id ";
                                
                       $sql .= " AND faturas.data_emissao BETWEEN '".$data_de."' AND '".$data_ate."'";

                     
                     $sql .= " ORDER BY faturas.id ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id = $db->f("id");			
				$situacao = $db->f("situacao");			
				$data_emissao = $db->f("data_emissao");			
				$data_pagamento = $db->f("data_pagamento");			
				$data_emissao_raw = $db->f("data_emissao_raw");			
				$data_pagamento_raw = $db->f("data_pagamento_raw");			
				$valor = $db->f("valor");			
				$obs = $db->f("obs");
                            $anexo= $db->f("anexo");
            

				$listagem .= '<tr> 
										<td>R$ '.$this->decimal_to_brasil_real($valor).'</td>
										<td>'.$data_emissao.'</td> 
										<td>'.$data_pagamento.'</td> 
										<td>'.$situacao.'</td> 
										<td>'.nl2br($obs).'</td> 
										<td><a href="'.$anexo.'" target="_blank"><i class="fa fa-download"></i></a></td> 
										<td><a data-toggle="modal" href="#modal_fatura_'.($i+100).'" onclick="javascript:void(0);" >Editar</a></td>										
										<td><a href="index.php?module=faturas&method=exclui&id='.$db->f("id").'" onclick="return(confirm(\'Confirma excluir a fatura ? \'))">Excluir</a></td>										
									</tr>';
            
            
                              $listagem_situacoes = "";

                              $sql2 = "select id, nome from faturas_situacoes ORDER BY id ASC";
                              $db2->query($sql2,__LINE__,__FILE__);
                              $db2->next_record();

                              for($i2 = 0; $i2 < $db2->num_rows(); $i2++)
                              {
                                 $listagem_situacoes .= "<option value='".$db2->f("id")."' ";

                                 if($db2->f("id") == $situacao)
                                    $listagem_situacoes .= "selected='selected'";

                                 $listagem_situacoes .= ">". $db2->f("nome")."</option>";			

                                 $db2->next_record();

                              }

                              $situacoes = montaSelect("faturanovo",$listagem_situacoes,4); 


                              $form = montaForm("faturanovo");

                              $form =  str_replace("col-md-4", "col-md-9", $form);

                              $form =  str_replace("{data_emissao}", $data_emissao_raw, $form);
                              $form =  str_replace("{data_pagamento}", $data_pagamento_raw, $form);
                              $form =  str_replace("{valor}", $this->decimal_to_brasil_real($valor), $form);
                              $form =  str_replace("{obs}", nl2br($obs), $form);

            
            
                              $modals .= '<div class="modal fade" id="modal_fatura_'.($i+100).'" tabindex="-1" role="basic" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="height:auto !important;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Detalhes da Fatura</h4>
                                                </div>
                                                <div class="modal-body" style="width:100%;"> 
                                                   <form action="index.php?module=faturas&method=update" method="post" name="editar"  class="form-horizontal" enctype="multipart/form-data">
                                                   <input type="hidden" name="id" value="'.$id.'">
                                                   '.$situacoes.'
                                          '.$form.'                                            
                                                <div class="modal-footer">
                                                <center>   

                                                   <button type="submit" class="btn green" style="width:300px;">Atualizar Informações &rightarrow;</button><br><br>
                                                    </center>
                                                </form>
                                      
                                                   <button type="button" id="closemodal" class="btn dark btn-outline" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div></div>';
				
				
				
				
				$db->next_record();
			}

      
         
               $form = montaForm("faturanovo");

               $form =  str_replace("col-md-4", "col-md-9", $form);
               
               $form =  str_replace("{data_emissao}", date("Y-m-d"), $form);
               $form =  str_replace("{data_pagamento}", "", $form);
               $form =  str_replace("{valor}", "", $form);
               $form =  str_replace("{obs}", "", $form);
               
         
                              $listagem_situacoes = "";

                              $sql2 = "select id, nome from faturas_situacoes ORDER BY id ASC";
                              $db2->query($sql2,__LINE__,__FILE__);
                              $db2->next_record();

                              for($i2 = 0; $i2 < $db2->num_rows(); $i2++)
                              {
                                 $listagem_situacoes .= "<option value='".$db2->f("id")."' ";

                                 if($db2->f("id") == $situacao)
                                    $listagem_situacoes .= "selected='selected'";

                                 $listagem_situacoes .= ">". $db2->f("nome")."</option>";			

                                 $db2->next_record();

                              }
               
               
               $situacoes = montaSelect("faturanovo",$listagem_situacoes,4); 
      
             $grid = montaGrid("sample_1",$listagem,"faturas");

		$this->cabecalho();                                                                            
		$GLOBALS["base"]->template = new template();       
		

		$GLOBALS["base"]->template->set_var("valor",$valor);
		$GLOBALS["base"]->template->set_var("data_emissao",date("Y-m-d"));
		$GLOBALS["base"]->template->set_var("data_pagamento",$data_pagamento);
		$GLOBALS["base"]->template->set_var("situacoes",$situacoes);
      
      
		$GLOBALS["base"]->template->set_var("data_de",$data_de);
		$GLOBALS["base"]->template->set_var("data_ate",$data_ate);
      
		$GLOBALS["base"]->template->set_var("modals",$modals);
      
              $GLOBALS["base"]->template->set_var("form",$form);
		$GLOBALS["base"]->template->set_var("grid",$grid);
		$GLOBALS["base"]->write_design_specific('faturas.tpl' , 'main');                       
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

		$db = new db();
		$db2 = new db();
	
		$valor = blockrequest($_REQUEST['valor']);
		$data_emissao = blockrequest($_REQUEST['data_emissao']);
		$data_pagamento = blockrequest($_REQUEST['data_pagamento']);
		$situacao = blockrequest($_REQUEST['situacao']);
		$obs = blockrequest($_REQUEST['obs']);
	
		

            $sql = "INSERT INTO faturas
            (valor,
            data_emissao,
            data_pagamento,
            situacao,
            dataCadastro, obs)
            VALUES ('".  $this->real_brasil_to_decimal($valor)."',
            '".$data_emissao."',
            '".$data_pagamento."',
            ".$situacao.",
            NOW(), '".addslashes($obs)."')";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();

            $id_fatura = $db->get_last_insert_id("faturas","id");
            
            
            
            if(isset($_FILES['anexo']['name']))
            {
               // Pega extensão do arquivo
               preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["anexo"]["name"], $ext);
               // Gera um nome único para a imagem
               $arquivo = md5(uniqid(time())) . "." . $ext[1];
               // Caminho de onde a imagem ficará
               $imagem_dir = "files/".$arquivo;
               $arquivo = $imagem_dir;
               // Faz o upload da imagem
               if($ext[1] != "")
               {
                  move_uploaded_file($_FILES["anexo"]["tmp_name"], $imagem_dir);

                  $sql = "UPDATE faturas SET anexo = '".$arquivo."' WHERE id = ".$id_fatura." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }
            
            
            
            $this->notificacao("Fatura cadastrada com sucesso!", "green");
            header("Location: " . ABS_LINK . "faturas");
            
	   }
      
      
	function update()
	{
		
		@session_start();
		$db = new db();

		$db = new db();
		$db2 = new db();
	
		$valor = blockrequest($_REQUEST['valor']);
		$data_emissao = blockrequest($_REQUEST['data_emissao']);
		$data_pagamento = blockrequest($_REQUEST['data_pagamento']);
		$situacao = blockrequest($_REQUEST['situacao']);
		$obs = blockrequest($_REQUEST['obs']);
      
		$id_fatura = blockrequest($_REQUEST['id']);
	
		
            $sql = "UPDATE faturas
                  SET valor = '".$this->real_brasil_to_decimal($valor)."',
                  data_emissao = '".$data_emissao."',
                  data_pagamento = '".$data_pagamento."',
                  situacao = ".$situacao.",
                  obs = '".addslashes($obs)."'
                  WHERE id = ".$id_fatura." ";
            
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();
            
            
            if(isset($_FILES['anexo']['name']))
            {
               // Pega extensão do arquivo
               preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|doc|xls|docx|xlsx|zip|rar){1}$/i", $_FILES["anexo"]["name"], $ext);
               // Gera um nome único para a imagem
               $arquivo = md5(uniqid(time())) . "." . $ext[1];
               // Caminho de onde a imagem ficará
               $imagem_dir = "files/".$arquivo;
               $arquivo = $imagem_dir;
               // Faz o upload da imagem
               if($ext[1] != "")
               {
                  move_uploaded_file($_FILES["anexo"]["tmp_name"], $imagem_dir);

                  $sql = "UPDATE faturas SET anexo = '".$arquivo."' WHERE id = ".$id_fatura." LIMIT 1 ";				
                  $db->query($sql,__LINE__,__FILE__);
                  $db->next_record();
               }
            }
            


            $this->notificacao("Fatura atualizada com sucesso!", "green");
            header("Location: " . ABS_LINK . "faturas");
            
	   }
	
	function exclui()
	{
		
		@session_start();
		$db = new db();

		$db = new db();
		$db2 = new db();
	
		$id_fatura = blockrequest($_REQUEST['id']);
		

            $sql = "DELETE FROM faturas WHERE id = ".$id_fatura." LIMIT 1";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();
            
            
            $this->notificacao("Fatura excluída com sucesso!", "green");
            header("Location: " . ABS_LINK . "faturas");
            
	   }
     
      
   function export()
   {
         include("3rd_party/MPDF60/mpdf.php");
         
         
            $report = '';
         
                              $_SESSION['page_title'] = "Relatório de Faturas";
			
			$db = new db();
			$db2 = new db();
			$db3 = new db();
			$db4 = new db();
         
                  
                     
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
                     
                     
         
                     $date = new DateTime($data_de);
                     $data_de_format =  $date->format('d/m/Y');

                     $date = new DateTime($data_ate);
                     $data_ate_format =  $date->format('d/m/Y');
         
         
                 $report .= '<table width="100%" border="0" style="border: 0px solid #e4e4e4; width:100%; font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:20px;" cellspacing="0" cellpadding="5" align="center">
                              <tr>
                                <td colspan="5"><img src="top_report_faturas.png" /></td>
                              </tr>
                           <tr>
                                <td colspan="5" align="center">'.$data_de_format.' at&eacute; '.$data_ate_format.'</td>
                              </tr>';                              
                 
                 
				$report .= '<tr style="background-color:#B0C934; font-family: Futura,Trebuchet MS,Arial,sans-serif; font-size:12px;"> 
										<td style="font-size:12px;">EMISSÃO</td> 
										<td style="font-size:12px;">PAGAMENTO</td> 
										<td style="font-size:12px;">SITUAÇÃO</td> 
										<td style="font-size:12px;">OBSERVAÇÕES</td> 
										<td style="font-size:12px;">VALOR</td>
									</tr>';
                        
                     
         

			$sql = "SELECT faturas.id AS id, 
                                faturas.valor,
                                faturas.obs,
                                faturas_situacoes.nome AS situacao,
                                DATE_FORMAT(faturas.data_emissao, '%d/%m/%Y') AS data_emissao, 
                                DATE_FORMAT(faturas.data_pagamento, '%d/%m/%Y') AS data_pagamento,
                                DATE_FORMAT(faturas.data_emissao, '%Y-%m-%d') AS data_emissao_raw, 
                                DATE_FORMAT(faturas.data_pagamento, '%Y-%m-%d') AS data_pagamento_raw
                                FROM faturas, faturas_situacoes
                                WHERE faturas.situacao = faturas_situacoes.id ";
                                
                       $sql .= " AND faturas.data_emissao BETWEEN '".$data_de."' AND '".$data_ate."'";

                     
                     $sql .= " ORDER BY faturas.id ASC";
			$db->query($sql,__LINE__,__FILE__);
			$db->next_record();
			
			for($i = 0; $i < $db->num_rows(); $i++)
			{
				$id = $db->f("id");			
				$situacao = $db->f("situacao");			
				$data_emissao = $db->f("data_emissao");			
				$data_pagamento = $db->f("data_pagamento");			
				$data_emissao_raw = $db->f("data_emissao_raw");			
				$data_pagamento_raw = $db->f("data_pagamento_raw");			
				$valor = $db->f("valor");			
				$obs = $db->f("obs");			
                        
                        
                        if($i % 2 == 0)
                           $corfundo = "ffffff";
                        else
                           $corfundo = "e4e4e4";

				$report .= '<tr style="background-color:#'.$corfundo.'"> 
										<td style="font-size:14px;">'.$data_emissao.'</td> 
										<td style="font-size:14px;">'.$data_pagamento.'</td> 
										<td style="font-size:14px;">'.$situacao.'</td> 
										<td style="font-size:14px;">'.$obs.'</td> 
										<td style="font-size:14px;">R$ '.  $this->decimal_to_brasil_real($valor).'</td> 
									</tr>';
				
				$totalGeral += $valor;
				
                 
                 
				
				$db->next_record();
			}

         
                 $report .= '<tr>
                                <td colspan="5"><img src="bg_top_report_pl_blue_total.png" /></td>
                              </tr>';
                 
                 $report .= '<tr>
                                <td colspan="5" style="font-size:14px;">'.nl2br($db->f("dados_bancarios")).'</td>
                              </tr>';
                 $report .= '<tr>
                                <td colspan="5" style="font-size:28px; height:40px;" align="right">R$ '.  $this->decimal_to_brasil_real($totalGeral).'</td>
                              </tr>';
                 
                 
                 
                 
                 $report .= '</table>';
                 
                 
         
         
         
               echo '<script language="javascript">document.getElementById("overover").style.display="none";</script>';


               //	$mpdf=new mPDF('c','A4-L','','',5,5,3,25,16,13); // LANDSCAPE
               $mpdf=new mPDF('c','A4','','',5,5,3,25,16,13);

               $mpdf->SetDisplayMode('fullpage');

               $mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

               $stylesheet = file_get_contents('mpdfstyletables.css');
               $mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

               $mpdf->WriteHTML($report,2);
               $mpdf->SetTitle ("Relatório de Faturas - L4LOG - ".date("d/m/Y"));

               $mpdf->Output('Relatório de Faturas - L4LOG.pdf',"I");
               exit;
 
   }
      
      
}                                                                                                     





?>