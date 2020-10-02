<?php                                                                                                                            
require_once("modules/home.php");                                                                      


class cadastro extends home
{

	function main()
	{

		@session_start();
		$db = new db();

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

	   $sql = "SELECT * FROM cidades WHERE id_estados = 7";
	   $db->query($sql,__LINE__,__FILE__);
	   $db->next_record();
	
	   for($i = 0; $i < $db->num_rows(); $i++)
	   {
		   $listagem_cidade .= "<option value='".$db->f("id")."'>".$db->f("cidade")."</option>";
	
		   $db->next_record();
	
	   }

			$GLOBALS["base"]->template->set_var("ANALYTICS",ANALYTICS);
			$GLOBALS["base"]->template->set_var("TITULO_SISTEMA",TITULO_SISTEMA);
			$GLOBALS["base"]->template->set_var("listagem_cidade",$listagem_cidade);
			$GLOBALS["base"]->template->set_var("listagem_estado",$listagem_estado);
			$GLOBALS["base"]->write_design_specific('cadastro.tpl' , 'main');
			
	}
	
	function insere()
	{
		@session_start();
		
		$db = new db();

		$nome = $this->blockrequest($_REQUEST['nome']);
		$email = $this->blockrequest($_REQUEST['email']);
		$estado = $this->blockrequest($_REQUEST['estado']);
		$cidade = $this->blockrequest($_REQUEST['cidade']);
		$senha = $this->blockrequest($_REQUEST['senha']);
		$endereco = $this->blockrequest($_REQUEST['endereco']);
		$pais = $this->blockrequest($_REQUEST['pais']);
		
		
		$eventos_lote_atual = 1;
		$lancamentos_lote_atual = 1;
		
		$sql = "SELECT * FROM usuarios WHERE email = '".$email."' ";
                $db->query($sql,__LINE__,__FILE__);
                $db->next_record();
	    
		if($db->num_rows() > 0)
		{
			echo '<script language="javascript">alert("E-mail existente"); location="'.ABS_LINK.'/login";</script>';
			die();			
		}
	   
		

	   $sql = "INSERT INTO usuarios (nome, email, senha, estado, data_cadastro, status, cidade, alert_daily, eventos_lote, lancamentos_lote, endereco, pais) 
	   			VALUES ('".$nome."', '".$email."', MD5('".$senha."'), ".$estado.", NOW(), 5, ".$cidade.",0, ".$eventos_lote_atual.", ".$lancamentos_lote_atual.",'".$endereco."','".$pais."')";

	   $db->query($sql,__LINE__,__FILE__);
	   $db->next_record();
	   $id_usuario = $db->get_last_insert_id("usuarios","id");
	   
           $sql = "UPDATE usuarios SET usuario_master = ".$id_usuario." WHERE id = ".$id_usuario." LIMIT 1 "; 
	   $db->query($sql,__LINE__,__FILE__);
	   $db->next_record();
           
	   

		/* GERA A CHAVE DE VALIDAÇÃO */
		$key = substr(md5(md5(time()).rand(6,9)),0,30);
		
		
	   $sql = "INSERT INTO activation (thekey, used, id_usuario) VALUES ('".$key."', 0, ".$id_usuario.")";
	   $db->query($sql,__LINE__,__FILE__);
	   $db->next_record();
	   
	   
	   /* Envia um e-mail confirmando o cadastro */
	   
	   $msg = "Parab&eacute;ns, ".utf8_encode($nome).", agora voc&ecirc; j&aacute; pode utilizar o ".TITULO_SISTEMA."!<br>";
	   $msg .= "Guarde seus dados:<br><br>";
	   $msg .= "Login: ".$email;
	   $msg .= "<br>";
	   $msg .= "Senha: ".$senha;
	   $msg .= "<br>";
	   $msg .= "<br>";
	   $msg .= "Agora voc&ecirc; pode administrar suas finan&ccedil;as de forma simples e eficiente, gerenciando todas as suas contas, sejam elas contas correntes, contas poupan&ccedil;a, o dinheiro em sua carteira ou at&eacute; mesmo aquele seu cofre em forma de porquinho! Para isso basta se cadastrar gratuitamente e come&ccedil;ar a utilizar todas as ferramentas que criamos para facilitar ao m&aacute;ximo a o seu dia-a-dia. O ".TITULO_SISTEMA." conta com ferramentas exclusivas como listas de desejos e funcionalidades que foram criadas para que voc&ecirc; possa controlar o que mais importa para voc&ecirc;, seu dinheiro, de forma r&aacute;pida simples e segura. ";	
	   $msg .= "<br>";
	   $msg .= "<br>";
	   $link = ABS_LINK."/index.php?module=cadastro&method=valid&email=".$email."&key=".trim($key);
	   
	   
	   $msg .= "<strong>Clique aqui para ativar seu cadastro: <a href='".$link."' target='_blank'>".ABS_LINK."/index.php?module=cadastro&method=valid&email=".$email."&key=".$key."</a></strong>";
	   $msg .= "<br>";
	   $msg .= "<br>";
	   $msg .= "Atenciosamente,<br>Equipe ".TITULO_SISTEMA."";
	   $msg .= "<br>";
	   $msg .= "Copyright 2016 - ".date("Y")." ".TITULO_SISTEMA."";
	   $msg .= "<br>";
	   $msg .= "<br>";
	   $msg .= ABS_LINK;


		$subject = "Confirme seu cadastro (beta) - ".TITULO_SISTEMA." ";
	
		email($email, $subject, $msg);
	   
	   header("Location: ".ABS_LINK."cadastro/confirm");
		
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
	
	function confirm()
	{

		echo $GLOBALS["base"]->write_design_specific('cadastro.tpl' , 'confirm');
		
	}
	
	function valid()
	{
		$db = new db();
		
		
		$key = $this->blockrequest($_REQUEST['key']);
		$email = $this->blockrequest($_REQUEST['email']);
		
		$key = str_replace(" ","",$key);

	   $sql = "SELECT id as id_usuario FROM usuarios WHERE email = '".$email."' LIMIT 1 ";
	   $db->query($sql,__LINE__,__FILE__);
	   $db->next_record();
	   $id_usuario = $db->f("id_usuario");

	   if($db->num_rows() > 0)
	   {
		

		   $sql = "SELECT * FROM activation WHERE (thekey = '".$key."') AND id_usuario = ".$id_usuario." AND used = 0 LIMIT 1";
		   $db->query($sql,__LINE__,__FILE__);
		   $db->next_record();

		   if($db->num_rows() > 0)
		   {


			   $sql = "UPDATE usuarios SET status = 1 WHERE id = ".$id_usuario." LIMIT 1 ";
			   $db->query($sql,__LINE__,__FILE__);
			   $db->next_record();

			   $sql = "UPDATE activation SET used = 1, act_date = NOW() WHERE (thekey = '".$key."') AND id_usuario = ".$id_usuario." ";
			   $db->query($sql,__LINE__,__FILE__);
			   $db->next_record();
			   
				echo '<script language="javascript">alert("Seu cadastro foi ativado com sucesso!"); location="'.ABS_LINK.'/login'.'";
				</script>';
				die();
		
		   }
	   }
	}

}

?>