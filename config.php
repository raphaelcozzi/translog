<?php 
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
/* CONFIGURAÇÕES DE BANCO DE DADOS */
date_default_timezone_set('America/Sao_Paulo');
$baseUrl = "/dev/translog/";

$host = "localhost"; // servidor
$user = "root"; // usuario
$password = ""; // senha
$database = "translog"; // banco de dados
$dbdriver = "mysql"; // tipo do banco mysql



// Chave para acesso externo ao Json das imagens
define("EXT_KEY","52182344187793218157938748930643989076532663065648");


/* CONFIGURAÇÕES DE EMAIL PADRÃO */

define("USER_EMAIL","archasys@gmail.com"); // Email de autenticação
define("SENHA_EMAIL","trinityn3o@"); // Senha do email
define("HOST_EMAIL","ssl://smtp.gmail.com"); // Servidor de autenticação

define("SENDER_EMAIL","archasys@gmail.com"); // Remetente
define("NOME_EMAIL","Global Soft Union"); // Nome do remetente
define("PORT_EMAIL","465"); // Porta de autenticação
define("AUTH_EMAIL",true); // Autenticação no envio (true ou false)

/* CONFIGURAÇÕES GERAIS */

define("TITULO_SISTEMA","L4 Log Tracking"); /* Titulo do sistema/serviço */
define("HTTPS",0); /* HTTPS 1 ou 0 */
define("CONFIG_SCRIPT_PATH" , "/");
define("CONFIG_DEBUG" , 0); /* Debug ativo? */
define("CONFIG_ENVIRONMENT_FRAMESET" , 1);

if(isset($_SESSION['idioma']))
	define("CONFIG_LANG" , $_SESSION['idioma']); /* Idioma padrão do usuário */ 
else
	define("CONFIG_LANG" , "pt_br"); /* Idioma padrão do sistema */ 

define("LOADING_BAR" , 1); /* Barra de loading ativa ou não */
define("ACTIVE_GRANTEES" , 1); /* Permissionamento ativo ou não */
define("USE_AVATAR" , 1); /* Avatar de usuário ativo ou não */
define("DB_USED" , 1); /* MySql = 1 Oracle = 2 Sql Server = 3 */
define("MYSQL_SHOW_ERROR" , 1); /* Show mysql error? */


/* CÓDIGO DE RASTREIO DO GOOGLE ANALYTICS */

$analytics_code = "";


/*********************************************** NÃO MEXER A PARTIR DAQUI ************************************************/
$path = (getcwd());


define("ANALYTICS" , $analytics_code);
define("CONFIG_PATH" , $path);

if(HTTPS == 1)
define("ABS_LINK" , "https://".$_SERVER['HTTP_HOST'].$baseUrl);
else
define("ABS_LINK" , "http://".$_SERVER['HTTP_HOST'].$baseUrl);

/*MYSQL CONFIG*/
define("MYSQL_CONFIG_HOST"     , $host);
define("MYSQL_CONFIG_DATABASE" , $database);
define("MYSQL_CONFIG_USERNAME" , $user);
define("MYSQL_CONFIG_PASSWORD" , $password);


/*ORACLE CONFIG*/
define("ORACLE_CONFIG_HOST"     , $host);
define("ORACLE_CONFIG_DATABASE" , $database);
define("ORACLE_CONFIG_USERNAME" , $user);
define("ORACLE_CONFIG_PASSWORD" , $password);

/*SQL SERVER CONFIG*/
define("SQLSERVER_CONFIG_HOST"     , $host);
define("SQLSERVER_CONFIG_DATABASE" , $database);
define("SQLSERVER_CONFIG_USERNAME" , $user);
define("SQLSERVER_CONFIG_PASSWORD" , $password);

?>