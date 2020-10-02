<?php           
	 @session_start();
	require_once(CONFIG_PATH."/config.php");
	require_once(CONFIG_PATH."/inc/base_functions.php");
	require_once(CONFIG_PATH."/inc/classes/class.db.inc.php");
	require_once(CONFIG_PATH."/inc/classes/class.template.inc.php");
	require_once(CONFIG_PATH."/inc/classes/class.base_class.inc.php");
	$GLOBALS["base"] = new base_class();

	//GUARDA EM SESSION QUAL O PATH DO USUARIO DENTRO DESSA SESSÃO PARA 
	//PODER GERAR O LOG DE ERRO MAIS COMPLETO
	if (!$_SESSION["path_de_navegacao"])
		$_SESSION["path_de_navegacao"] = array();
	array_push($_SESSION["path_de_navegacao"] , $_SERVER["REQUEST_URI"]);
?>