<?php

class login
{
	/** OS SEGUINTES DADOS DO USUÁRIO SÃO ARMAZENADOS EM SESSÕES:
	*
	*				$_SESSION['logged'] = "43628bbbb8613ac94fd61bd46aab5a45314s";
	*				$_SESSION['id']
	*				$_SESSION['nome']		
	*				$_SESSION['email']
	*				$_SESSION['alert_daily']
	*				$_SESSION['boss']
	*				$_SESSION['lancamentos_lote']		
	*				$_SESSION['grantees']		
	*				$_SESSION['idioma']		
    */
	
	
	function main()
	{
		$db = new db();

		@session_start();

		$sql = "select * from estados";
		$db->query($sql, __LINE__, __FILE__);
		$db->next_record();

		$listagem_estado = "<option value='7' selected>Rio de Janeiro</option>";

		for ($i = 0; $i < $db->num_rows(); $i++) {
			$listagem_estado .= "<option value='" . $db->f("id") . "' ";

			if ($db->f("id") == $estado) $listagem_estado .= "selected='selected'";

			$listagem_estado .= ">" . $db->f("estado") . "</option>";

			$db->next_record();
		}

		$sql = "SELECT * FROM cidades WHERE id_estados = 7";
		$db->query($sql, __LINE__, __FILE__);
		$db->next_record();

		for ($i = 0; $i < $db->num_rows(); $i++) {
			$listagem_cidade .= "<option value='" . $db->f("id") . "'>" . $db->f("cidade") . "</option>";

			$db->next_record();
		}
		$alertaDisplay = 'hide';

		$sql = "SELECT * FROM departamentos ORDER BY nome ASC";
		$db->query($sql, __LINE__, __FILE__);
		$db->next_record();

		for ($i = 0; $i < $db->num_rows(); $i++) {
			$listagem_departamentos .= "<option value='" . $db->f("id") . "'>" . $db->f("nome") . "</option>";

			$db->next_record();
		}

		$GLOBALS["base"]->template->set_var('login_field', $_REQUEST['login']);
		$GLOBALS["base"]->template->set_var('senha_field', $_REQUEST['senha']);

		$GLOBALS["base"]->template->set_var("listagem_departamentos", $listagem_departamentos);
		$GLOBALS["base"]->template->set_var("alertaDisplay", $alertaDisplay);

		$GLOBALS["base"]->template->set_var('ABS_LINK', ABS_LINK);
		$GLOBALS["base"]->template->set_var("TX_ENTRAR", TX_ENTRAR);
		$GLOBALS["base"]->template->set_var("TX_LEMBRAR", TX_LEMBRAR);
		$GLOBALS["base"]->template->set_var("TX_LOGIN", TX_LOGIN);
		$GLOBALS["base"]->template->set_var("TX_ESQUECEU_SENHA", TX_ESQUECEU_SENHA);
		$GLOBALS["base"]->template->set_var("TX_ACESSE_USANDO", TX_ACESSE_USANDO);
		$GLOBALS["base"]->template->set_var("TX_AINDA_NAO_POSSUO_CONTA", TX_AINDA_NAO_POSSUO_CONTA);
		$GLOBALS["base"]->template->set_var("TX_REDEFINIR_SENHA", TX_REDEFINIR_SENHA);
		$GLOBALS["base"]->template->set_var("TX_VOLTAR", TX_VOLTAR);
		$GLOBALS["base"]->template->set_var("TX_ESQUECEU_A_SENHA", TX_ESQUECEU_A_SENHA);
		$GLOBALS["base"]->template->set_var("TITULO_SISTEMA", TITULO_SISTEMA);
		$GLOBALS["base"]->template->set_var("TX_CRIAR_NOVA_CONTA", TX_CRIAR_NOVA_CONTA);
		$GLOBALS["base"]->template->set_var("TX_ENTRE_INFORMACOES", TX_ENTRE_INFORMACOES);
		$GLOBALS["base"]->template->set_var("BTN_SUBMIT", BTN_SUBMIT);
		$GLOBALS["base"]->template->set_var("ANALYTICS", ANALYTICS);
		$GLOBALS["base"]->template->set_var("listagem_cidade", $listagem_cidade);
		$GLOBALS["base"]->template->set_var("listagem_estado", $listagem_estado);
		$GLOBALS["base"]->template->set_var('msg_error', '');
		$GLOBALS["base"]->write_design_specific('login.tpl', 'login');
	}

	function logar()
	{
		/**
		*	Método principal de login ao sistema
		*/

												$db = new db();
		$db2 = new db();
		$db3 = new db();

		@session_start();

		$login = $_POST['login'];
		$senha = $_POST['senha'];
		$warehouse = $_POST['warehouse'];
		$id_warehouse_escolhido = $_POST['id_warehouse_escolhido'];

		$login = blockrequest($login);
		$senha = blockrequest($senha);
		$warehouse = blockrequest($warehouse);

		$sql = "SELECT id, nome FROM departamentos ORDER BY nome ASC";
		$db->query($sql, __LINE__, __FILE__);
		$db->next_record();

		for ($i = 0; $i < $db->num_rows(); $i++) {
			if (isset($_REQUEST['departamento']) && $departamento == $db->f("id")) {
				$_SESSION['departamento'] = $departamento;
				$_SESSION['id_departamento_escolhido'] = $departamento;
			}

			$listagem_departamentos .= "<option value='" . $db->f("id") . "'>" . $db->f("nome") . "</option>";

			$db->next_record();
		}
		$GLOBALS["base"]->template->set_var('listagem_departamentos', $listagem_departamentos);

		if ($warehouse == "0") {
			$msg = "Select a Warehouse Station";

			$GLOBALS["base"]->template->set_var('login_field', $_REQUEST['login']);
			$GLOBALS["base"]->template->set_var('senha_field', $_REQUEST['senha']);

			$GLOBALS["base"]->template->set_var("TX_ENTRAR", TX_ENTRAR);

			$GLOBALS["base"]->template->set_var("TX_ENTRAR", TX_ENTRAR);
			$GLOBALS["base"]->template->set_var("TX_LEMBRAR", TX_LEMBRAR);
			$GLOBALS["base"]->template->set_var("TX_ESQUECEU_SENHA", TX_ESQUECEU_SENHA);
			$GLOBALS["base"]->template->set_var("TX_VOLTAR", TX_VOLTAR);
			$GLOBALS["base"]->template->set_var("TX_REDEFINIR_SENHA", TX_REDEFINIR_SENHA);
			$GLOBALS["base"]->template->set_var("BTN_SUBMIT", BTN_SUBMIT);
			$GLOBALS["base"]->template->set_var("ANALYTICS", ANALYTICS);
			$GLOBALS["base"]->template->set_var("TITULO_SISTEMA", TITULO_SISTEMA);

			$GLOBALS["base"]->template->set_var('msg_error', $msg);
			$GLOBALS["base"]->write_design_specific('login.tpl', 'login');
			die();
		}

		if ($_POST['login'] && $_POST['senha']) {
			$sql = "SELECT * FROM usuarios
					WHERE ( email = '" . $login . "' AND senha = MD5('" . $senha . "')) AND (status = 1) limit 1";

			$db->query($sql, __LINE__, __FILE__);
			$db->next_record();

			if ($db->num_rows() > 0) {
				/* Guarda em sessão todos os parâmetros utéis do usuário */
																									$_SESSION['logged'] = "43628bbbb8613ac94fd61bd46aab5a45314s";
				$_SESSION['id'] = $db->f("id");
				$_SESSION['nome'] = $db->f("nome");
				$_SESSION['email'] = $db->f("email");
				$_SESSION['alert_daily'] = $db->f("alert_daily");
				$_SESSION['boss'] = $db->f("usuario_master");
				$_SESSION['idioma'] = $db->f("idioma");

				$_SESSION['eventos_lote'] = "_lote_" . $db->f("eventos_lote");

				if ($db->f("lancamentos_lote") != 1) $_SESSION['lancamentos_lote'] = "_lote_" . $db->f("lancamentos_lote");
				else $_SESSION['lancamentos_lote'] = "";

				if (ACTIVE_GRANTEES == 1) $this->gera_permissoes($_SESSION['id']); // Chama a função que define as áreas que o usuário tem acesso.

				$GLOBALS["base"]->template->set_var('msg_error', '');

				if ($db->f("avatar") == "") $avatar = 'http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=sem+imagem';
				else $avatar = $db->f("avatar");

				/*
					if(date("H") > 00 && date("H") < 12)
						$saudacao = "Bom dia";

					if(date("H") >= 12 && date("H") < 18)
						$saudacao = "Boa tarde";


					if(date("H") >= 18 && date("H") <= 23)
						$saudacao = "Boa noite";
                           */
            
																				$sql2 = "SELECT id_grupo FROM usuarios_grupos WHERE id_usuario = " . $db->f("id") . " ";
				$db2->query($sql2, __LINE__, __FILE__);
				$db2->next_record();
				if ($db2->f("id_grupo") == 1 || $db2->f("id_grupo") == 2) {
					$_SESSION['departamentos'] = '';

					$sql = "SELECT id FROM departamentos";
					$db->query($sql, __LINE__, __FILE__);
					$db->next_record();
					for ($i = 0; $i < $db->num_rows(); $i++) {
						$_SESSION['departamentos'] .= $db->f("id");
						if ($i < ($db->num_rows() - 1)) $_SESSION['departamentos'] .= ',';

						$db->next_record();
					}
				}

				$saudacao = "Bem-vindo, ";

				$this->notificacao($saudacao . ", " . $_SESSION['nome'] . " ", "green");
				header("Location: " . ABS_LINK);
			}
		}

		$msg = "Incorrect access data.";

		$sql = "select * from estados";
		$db->query($sql, __LINE__, __FILE__);
		$db->next_record();

		$listagem_estado = "<option value='7' selected>Rio de Janeiro</option>";

		for ($i = 0; $i < $db->num_rows(); $i++) {
			$listagem_estado .= "<option value='" . $db->f("id") . "' ";

			if ($db->f("id") == $estado) $listagem_estado .= "selected='selected'";

			$listagem_estado .= ">" . $db->f("estado") . "</option>";

			$db->next_record();
		}

		$sql = "SELECT * FROM cidades WHERE id_estados = 7";
		$db->query($sql, __LINE__, __FILE__);
		$db->next_record();

		for ($i = 0; $i < $db->num_rows(); $i++) {
			$listagem_cidade .= "<option value='" . $db->f("id") . "'>" . $db->f("cidade") . "</option>";

			$db->next_record();
		}

		$GLOBALS["base"]->template->set_var('login_field', $_REQUEST['login']);
		$GLOBALS["base"]->template->set_var('senha_field', $_REQUEST['senha']);

		$GLOBALS["base"]->template->set_var('ABS_LINK', ABS_LINK);
		$GLOBALS["base"]->template->set_var("TX_ENTRAR", TX_ENTRAR);
		$GLOBALS["base"]->template->set_var("TX_LEMBRAR", TX_LEMBRAR);
		$GLOBALS["base"]->template->set_var("TX_LOGIN", TX_LOGIN);
		$GLOBALS["base"]->template->set_var("TX_ESQUECEU_SENHA", TX_ESQUECEU_SENHA);
		$GLOBALS["base"]->template->set_var("TX_ACESSE_USANDO", TX_ACESSE_USANDO);
		$GLOBALS["base"]->template->set_var("TX_AINDA_NAO_POSSUO_CONTA", TX_AINDA_NAO_POSSUO_CONTA);
		$GLOBALS["base"]->template->set_var("TX_REDEFINIR_SENHA", TX_REDEFINIR_SENHA);
		$GLOBALS["base"]->template->set_var("TX_VOLTAR", TX_VOLTAR);
		$GLOBALS["base"]->template->set_var("TX_ESQUECEU_A_SENHA", TX_ESQUECEU_A_SENHA);
		$GLOBALS["base"]->template->set_var("TITULO_SISTEMA", TITULO_SISTEMA);
		$GLOBALS["base"]->template->set_var("TX_CRIAR_NOVA_CONTA", TX_CRIAR_NOVA_CONTA);
		$GLOBALS["base"]->template->set_var("TX_ENTRE_INFORMACOES", TX_ENTRE_INFORMACOES);
		$GLOBALS["base"]->template->set_var("BTN_SUBMIT", BTN_SUBMIT);

		$GLOBALS["base"]->template->set_var("alertaDisplay", $alertaDisplay);
		$GLOBALS["base"]->template->set_var("ANALYTICS", ANALYTICS);
		$GLOBALS["base"]->template->set_var("TITULO_SISTEMA", TITULO_SISTEMA);
		$GLOBALS["base"]->template->set_var("listagem_cidade", $listagem_cidade);
		$GLOBALS["base"]->template->set_var("listagem_estado", $listagem_estado);

		$GLOBALS["base"]->template->set_var('msg_error', $msg);
		$GLOBALS["base"]->write_design_specific('login.tpl', 'login');
	}

	function logout()
	{
		@session_start();

		unset($_SESSION['id']);
		unset($_SESSION['nome']);
		unset($_SESSION['email']);
		unset($_SESSION['logged']);
		unset($_SESSION['alert_daily']);
		unset($_SESSION['boss']);
		unset($_SESSION['idioma']);
		unset($_SESSION['grantees']);
		unset($_SESSION['departamento']);
		unset($_SESSION['id_departamento_escolhido']);

		session_destroy();

		header("Location: " . ABS_LINK . "/home");
	}

	function check_login()
	{
		@session_start();
		if ($_SESSION['id'] == 0 || !$_SESSION['id']) {
			header("Location: " . ABS_LINK . "login/logout");
		}
		if ($_SESSION['logged'] <> "43628bbbb8613ac94fd61bd46aab5a45314s" || !$_SESSION['logged']) {
			header("Location: " . ABS_LINK . "login");
		}
	}

	function gera_permissoes($func)
	{
		@session_start();

		$db = new db();
		
		// GUARDA A SESSÃO COM O ARRAY DE PERMISSÕES DAS ÁREAS DO ADMIN
		// GUARDA A SESSÃO COM O ARRAY DE PERMISSÕES DAS ÁREAS DO ADMIN
		// GUARDA A SESSÃO COM O ARRAY DE PERMISSÕES DAS ÁREAS DO ADMIN

		$sql_privilegios = "SELECT
							id_usuario
							,id_menu
							,allow
						FROM privilegios
						WHERE id_usuario = " . $func . " 
						order by id_menu asc";

		$db->query($sql_privilegios, __LINE__, __FILE__);
		$db->next_record();

		$_SESSION['grantees'] = array();

		for ($i = 0; $i < $db->num_rows(); $i++) {
			$_SESSION['grantees']["area_" . $db->f("id_menu")] = $db->f("allow");

			$db->next_record();
		}
	}

	function termos()
	{
		$GLOBALS["base"]->template->set_var("TX_VOLTAR", TX_VOLTAR);
		$GLOBALS["base"]->template->set_var("ANALYTICS", ANALYTICS);
		$GLOBALS["base"]->template->set_var('msg_error', '');
		$GLOBALS["base"]->write_design_specific('login.tpl', 'termos');
	}

	function notificacao($mensagem, $cor)
	{
		$_SESSION['msg'] = array("mensagem" => $mensagem, "tm" => $cor, "mt" => "air");
	}
   
       function send_pass()
      {
         
         $db = new db();


         if(isset($_REQUEST['key']) && $_REQUEST['key'] = "ss5Dd1s5g")
         {         
            /* Envia um e-mail com o link para redefinir a senha */
            
            $email = blockrequest($_REQUEST['email']);
            
            $sql = "SELECT COUNT(id) AS total, nome FROM usuarios WHERE email = '".$email."' ";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();
            if($db->f("total") > 0)
            {
               
               $nome = $db->f("nome");
               
               $randNumber = substr(md5(md5(time()).rand(6,9)),0,10);

               $sql = "UPDATE usuarios SET temp_key = '".$randNumber."' WHERE email = '".$email."' LIMIT 1";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();

               $linkRedefinir = ABS_LINK."/login/novasenha/".$randNumber."/".$email;

               $msg = "Ol&aacute;, ".$nome.", voc&ecirc; solicitou a redefini&ccedil;&atilde;o da sua senha.<br>";
               $msg .= "<br>";
               $msg .= "<br>";
               $msg .= "Para definir uma nova senha, clique no link a seguir, ou copie e cole no seu navegador.";
               $msg .= "<br>";
               $msg .= "<br>";
               $msg .= "<strong><a href=".$linkRedefinir.">".$linkRedefinir."</a></strong>";
               $msg .= "<br>";
               $msg .= "<br>";
               $msg .= "Caso n&atilde;o tenha solicitado redefinir sua senha, desconsidere este e-mail e altere a sua senha no seu perfil.";
               $msg .= "<br>";
               $msg .= "Atenciosamente,<br>Equipe ".TITULO_SISTEMA."";
               $msg .= "<br>";
               $msg .= "Copyright 2020 - ".date("Y")." ".TITULO_SISTEMA."";
               $msg .= "<br>";
               $msg .= "<br>";
               $msg .= ABS_LINK;


               $subject = "Redefinir sua senha - ".TITULO_SISTEMA." ";

               email($email, $subject, $msg);
               $GLOBALS["base"]->template->set_var('email' ,$email);     
               
               $_SESSION["email_solicitado"] = $email;

               header("Location: ".ABS_LINK."/login/senhaenviada");
            }
            else 
            {
               header("Location: ".ABS_LINK."/login");
               die();
            }
         }
         
      }
      
      function senhaenviada()
      {
         
         $db = new db();


         $email = $_SESSION["email_solicitado"];
         $GLOBALS["base"]->template->set_var('msg_error' , '');
            
		   $alertaDisplay = 'hide';
         
         
         
   		$GLOBALS["base"]->template->set_var('login_field' ,$_REQUEST['login']);
   		$GLOBALS["base"]->template->set_var('senha_field' ,$_REQUEST['senha']);
         

			$GLOBALS["base"]->template->set_var("alertaDisplay",$alertaDisplay);

         $GLOBALS["base"]->template->set_var('ABS_LINK' ,ABS_LINK);
			$GLOBALS["base"]->template->set_var("TX_ENTRAR",TX_ENTRAR);
			$GLOBALS["base"]->template->set_var("TX_LEMBRAR",TX_LEMBRAR);
			$GLOBALS["base"]->template->set_var("TX_LOGIN",TX_LOGIN);
			$GLOBALS["base"]->template->set_var("TX_ESQUECEU_SENHA",TX_ESQUECEU_SENHA);
			$GLOBALS["base"]->template->set_var("TX_ACESSE_USANDO",TX_ACESSE_USANDO);
			$GLOBALS["base"]->template->set_var("TX_AINDA_NAO_POSSUO_CONTA",TX_AINDA_NAO_POSSUO_CONTA);
			$GLOBALS["base"]->template->set_var("TX_REDEFINIR_SENHA",TX_REDEFINIR_SENHA);
			$GLOBALS["base"]->template->set_var("TX_VOLTAR",TX_VOLTAR);
			$GLOBALS["base"]->template->set_var("TX_ESQUECEU_A_SENHA",TX_ESQUECEU_A_SENHA);
			$GLOBALS["base"]->template->set_var("TITULO_SISTEMA",TITULO_SISTEMA);
			$GLOBALS["base"]->template->set_var("TX_CRIAR_NOVA_CONTA",TX_CRIAR_NOVA_CONTA);
			$GLOBALS["base"]->template->set_var("TX_ENTRE_INFORMACOES",TX_ENTRE_INFORMACOES);
			$GLOBALS["base"]->template->set_var("BTN_SUBMIT",BTN_SUBMIT);
			$GLOBALS["base"]->template->set_var("ANALYTICS",ANALYTICS);
            

   			$GLOBALS["base"]->template->set_var("TITULO_SISTEMA",TITULO_SISTEMA);
            $GLOBALS["base"]->template->set_var('email' ,$email);      
            $GLOBALS["base"]->template->set_var('ABS_LINK' ,ABS_LINK);
            $GLOBALS["base"]->template->set_var('msg' ,'');
			
            $GLOBALS["base"]->write_design_specific('login.tpl' , 'senhaenviada');
      }
      
      function novasenha()
      {
         
         $db = new db();


            $key = $_REQUEST["id"];
            $email = $_REQUEST["subid"];

            $sql = "SELECT COUNT(id) AS total, nome FROM usuarios WHERE email = '".$email."' AND temp_key = '".$key."' ";
            $db->query($sql,__LINE__,__FILE__);
            $db->next_record();
            if($db->f("total") > 0)
            {
               
               $nome = $db->f("nome");
               
               $novaSenha = substr(md5(md5(time()).rand(6,9)),0,10);
               
               $sql = "UPDATE usuarios SET senha = MD5('".$email."'), temp_key = ''  WHERE temp_key = '".$key."' AND email = '".$email."' LIMIT 1";
               $db->query($sql,__LINE__,__FILE__);
               $db->next_record();
               
               $msg = "Ol&aacute;, ".$nome.", sua senha foi redefinida com sucesso.<br>";
               $msg .= "<br>";
               $msg .= "<br>";
               $msg .= "Nova senha: ".$novaSenha;
               $msg .= "<br>";
               $msg .= "<br>";
               $msg .= "Caso n&atilde;o tenha solicitado redefinir sua senha, desconsidere este e-mail e altere a sua senha no seu perfil.";
               $msg .= "<br>";
               $msg .= "Atenciosamente,<br>Equipe ".TITULO_SISTEMA."";
               $msg .= "<br>";
               $msg .= "Copyright 2020 - ".date("Y")." ".TITULO_SISTEMA."";
               $msg .= "<br>";
               $msg .= "<br>";
               $msg .= ABS_LINK;


               $subject = "Sua senha foi redefinida com sucesso - ".TITULO_SISTEMA." ";

               email($email, $subject, $msg);
               
            }



            $GLOBALS["base"]->template->set_var('msg_error' , '');
			$GLOBALS["base"]->template->set_var("alertaDisplay",$alertaDisplay);

         $GLOBALS["base"]->template->set_var('ABS_LINK' ,ABS_LINK);
			$GLOBALS["base"]->template->set_var("TX_ENTRAR",TX_ENTRAR);
			$GLOBALS["base"]->template->set_var("TX_LEMBRAR",TX_LEMBRAR);
			$GLOBALS["base"]->template->set_var("TX_LOGIN",TX_LOGIN);
			$GLOBALS["base"]->template->set_var("TX_ESQUECEU_SENHA",TX_ESQUECEU_SENHA);
			$GLOBALS["base"]->template->set_var("TX_ACESSE_USANDO",TX_ACESSE_USANDO);
			$GLOBALS["base"]->template->set_var("TX_AINDA_NAO_POSSUO_CONTA",TX_AINDA_NAO_POSSUO_CONTA);
			$GLOBALS["base"]->template->set_var("TX_REDEFINIR_SENHA",TX_REDEFINIR_SENHA);
			$GLOBALS["base"]->template->set_var("TX_VOLTAR",TX_VOLTAR);
			$GLOBALS["base"]->template->set_var("TX_ESQUECEU_A_SENHA",TX_ESQUECEU_A_SENHA);
			$GLOBALS["base"]->template->set_var("TITULO_SISTEMA",TITULO_SISTEMA);
			$GLOBALS["base"]->template->set_var("TX_CRIAR_NOVA_CONTA",TX_CRIAR_NOVA_CONTA);
			$GLOBALS["base"]->template->set_var("TX_ENTRE_INFORMACOES",TX_ENTRE_INFORMACOES);
			$GLOBALS["base"]->template->set_var("BTN_SUBMIT",BTN_SUBMIT);
			$GLOBALS["base"]->template->set_var("ANALYTICS",ANALYTICS);

            $GLOBALS["base"]->template->set_var('email' ,$email);      
            $GLOBALS["base"]->template->set_var('ABS_LINK' ,ABS_LINK);
            $GLOBALS["base"]->template->set_var('msg' ,'');
			
            $GLOBALS["base"]->write_design_specific('login.tpl' , 'novasenha');
      }
  
   
}

?>