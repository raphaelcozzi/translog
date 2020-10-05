<?php
function valida_privilegios($id_secao)
{
	/* Metodo para validacao de permissao por area */
	if (!in_array($_SESSION['privilegios']["area_" . $id_secao . ""], $_SESSION['privilegios'])) header("Location: index.php?module=home&method=main");
	else {
		if ($_SESSION['privilegios']["area_" . $id_secao . ""]["ler"] == 0) {
			header("Location: index.php?module=home&method=main");
		}
		if ($_SESSION['privilegios']["area_" . $id_secao . ""]["escrever"] == 0) $_SESSION['botao_inserir'] = 0;
		else $_SESSION['botao_inserir'] = 1;

		if ($_SESSION['privilegios']["area_" . $id_secao . ""]["alterar"] == 0) $_SESSION['botao_alterar'] = 0;
		else $_SESSION['botao_alterar'] = 1;

		if ($_SESSION['privilegios']["area_" . $id_secao . ""]["excluir"] == 0) $_SESSION['botao_excluir'] = 0;
		else $_SESSION['botao_excluir'] = 1;
	}
}

function email($to, $subject, $message, $anexo = "")
{
	require_once('class.phpmailer.php');

	$mail = new phpmailer();

	$mail->Encoding      = "8bit";
	$mail->CharSet       = "iso-8859-1";
	$mail->Sender        = SENDER_EMAIL;
	$mail->FromName = NOME_EMAIL;
	$mail->Host          = HOST_EMAIL;
	$mail->Helo          = "EHLO";
	$mail->SMTPAuth      = AUTH_EMAIL;
	$mail->Username      = USER_EMAIL;
	$mail->Password      = SENHA_EMAIL;
	$mail->Port          = PORT_EMAIL;
	$mail->AddReplyTo(SENDER_EMAIL, NOME_EMAIL);
	$mail->Mailer = "smtp";
	$mail->IsHTML(true);
	$mail->AddAddress($to);
	$mail->Subject = $subject;
	$mail->Body    = $message;

	if ($anexo != "") $mail->AddAttachment($anexo);

	if (!$mail->Send()) die("erro no envio!");
}

function blockrequest($param)
{
	/*
				Retira todas as tags html da string;
				Retira qualquer isntrução SQL da string
			*/
			
								$str = strip_tags($param);

	$p1 = str_replace("INSERT", " ", $str);
	$p2 = str_replace("DELETE", " ", $p1);
	$p3 = str_replace("UPDATE", " ", $p2);
	$p4 = str_replace("TRUNCATE", " ", $p3);
	$p5 = str_replace("DUMP", " ", $p4);
	$p6 = str_replace("DROP", " ", $p5);

	$p7 = str_replace("<", " ", $p6);
	$p8 = str_replace(">", " ", $p7);
	$p9 = str_replace("'", "/'", $p8);
	$p10 = str_replace("id", "", $p9);
	$p11 = str_replace("id", "", $p10);
	$p12 = str_replace(" or ", "", $p11);
	$p13 = str_replace(" and ", "", $p12);
	$p14 = str_replace("<>", "", $p13);
	$p15 = str_replace("> 0", "", $p14);
	$p15 = str_replace("--", "", $p15);

	$str = $p15;

	return $str;
}

function dolog($acao)
{
	@session_start();
	$db = new db();

	$sql = "INSERT INTO log (id_usuario, acao, data) VALUES (" . $_SESSION['id'] . ", '" . $acao . "', NOW())";
	$db->query($sql, __LINE__, __FILE__);
	$db->next_record();
}

function get_lat($cidade, $pais)
{
	$cidade = str_replace(" ", "+", $cidade);
	$pais = str_replace(" ", "+", $pais);

	$json = $this->get_remote_data("https://nominatim.openstreetmap.org/search?q=" . $cidade . "&format=json");
	$json = json_decode($json);
	$json = $json[0];

	$latitude = $json->lat;

	return $latitude;
}

function get_lon($cidade, $pais)
{
	$cidade = str_replace(" ", "+", $cidade);
	$pais = str_replace(" ", "+", $pais);

	$json = $this->get_remote_data("https://nominatim.openstreetmap.org/search?q=" . $cidade . "&format=json");
	$json = json_decode($json);
	$json = $json[0];

	$longitude = $json->lon;

	return $longitude;
}

function url_get_contents($Url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);

	curl_close($ch);
	return $output;
}

function get_remote_data($url, $post_paramtrs = false, $curl_opts = [])
{
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
         //if parameters were passed to this function, then transform into POST method.. (if you need GET request, then simply change the passed URL)
	if ($post_paramtrs) {
		curl_setopt($c, CURLOPT_POST, TRUE);
		curl_setopt($c, CURLOPT_POSTFIELDS, (is_array($post_paramtrs) ? http_build_query($post_paramtrs) : $post_paramtrs));
	}
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
	$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:76.0) Gecko/20100101 Firefox/76.0";
	$headers[] = "Pragma: ";
	$headers[] = "Cache-Control: max-age=0";
	if (!empty($post_paramtrs) && !is_array($post_paramtrs) && is_object(json_decode($post_paramtrs))) {
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Content-Length: ' . strlen($post_paramtrs);
	}
	curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($c, CURLOPT_MAXREDIRS, 10); 
         //if SAFE_MODE or OPEN_BASEDIR is set,then FollowLocation cant be used.. so...
	$follow_allowed = (ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;
	if ($follow_allowed) {
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	}
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
	curl_setopt($c, CURLOPT_REFERER, $url);
	curl_setopt($c, CURLOPT_TIMEOUT, 60);
	curl_setopt($c, CURLOPT_AUTOREFERER, true);
	curl_setopt($c, CURLOPT_ENCODING, '');
	curl_setopt($c, CURLOPT_HEADER, !empty($extra['return_array']));
         //set extra options if passed
	if (!empty($curl_opts))
	foreach ($curl_opts as $key => $value) curl_setopt($c, constant($key), $value);
	$data = curl_exec($c);
	if (!empty($extra['return_array'])) {
		preg_match("/(.*?)\r\n\r\n((?!HTTP\/\d\.\d).*)/si", $data, $x);
		preg_match_all('/(.*?): (.*?)\r\n/i', trim('head_line: ' . $x[1]), $headers_, PREG_SET_ORDER);
		foreach ($headers_ as $each) {
			$header[$each[1]] = $each[2];
		}
		$data = trim($x[2]);
	}
	$status = curl_getinfo($c);
	curl_close($c);
         // if redirected, then get that redirected page
	if ($status['http_code'] == 301 || $status['http_code'] == 302) { 
            //if we FOLLOWLOCATION was not allowed, then re-get REDIRECTED URL
            //p.s. WE dont need "else", because if FOLLOWLOCATION was allowed, then we wouldnt have come to this place, because 301 could already auto-followed by curl  :)
		if (!$follow_allowed) {
               //if REDIRECT URL is found in HEADER
			if (empty($redirURL)) {
				if (!empty($status['redirect_url'])) {
					$redirURL = $status['redirect_url'];
				}
			}
               //if REDIRECT URL is found in RESPONSE
			if (empty($redirURL)) {
				preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
				if (!empty($m[2])) {
					$redirURL = $m[2];
				}
			}
               //if REDIRECT URL is found in OUTPUT
			if (empty($redirURL)) {
				preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
				if (!empty($m[1])) {
					$redirURL = $m[1];
				}
			}
               //if URL found, then re-use this function again, for the found url
			if (!empty($redirURL)) {
				$t = debug_backtrace();
				return call_user_func($t[0]["function"], trim($redirURL), $post_paramtrs);
			}
		}
	}
         // if not redirected,and nor "status 200" page, then error..
	elseif ($status['http_code'] != 200) {
		$data = "ERRORCODE22 with $url<br/><br/>Last status codes:" . json_encode($status) . "<br/><br/>Last data got:$data";
	}
         //URLS correction
	$answer = (!empty($extra['return_array']) ? array('data' => $data, 'header' => $header, 'info' => $status) : $data);
	return $answer;
}

function gets3files($refdms)
{
	$arquivos = array();

	$s3Client = S3Client::factory(array('key' => AWS_S3_KEY, 'secret' => AWS_S3_SECRET));

	$response = $s3Client->listObjects(array('Bucket' => AWS_S3_BUCKET, 'MaxKeys' => 1000, 'Prefix' => 'navio/' . $refdms . "/"));
	$files = $response->getPath('Contents');
	$request_id = array();

	unset($files[0]);

	foreach ($files as $file) {
		$filename = $file['Key'];
		array_push($arquivos, $filename);
	}

	return $arquivos;
}

function getJson($url)
{
	$dmstoken = getDmsToken();

	$username = "DWSYS";
	$password = "dwsys@2020";
	$token = "HJFpvTcWkq7QxnCc65BMYrMa";
            
           // $params = array('HTTP_DMSTOKEN' => base64_encode($token));

	$header = array(
		'Content-Type' => 'application/json',
		'DMSTOKEN' => base64_encode($token),
		'Authorization' => 'Baerer ' . $dmstoken
	);
	$response =  $this->request("GET", $url, $header);

	return json_decode($response, true);
}

      // method should be "GET", "PUT", etc..
function request($method, $url, $header)
{
	$opts = array(
		'http' => array(
			'method' => $method,
		),
	);

          // serialize the header if needed
	if (!empty($header)) {
		$header_str = '';
		foreach ($header as $key => $value) {
                 
                // if($key != "0")
			$header_str .= "$key: $value\r\n";
		}
		$header_str .= "\r\n";
		$opts['http']['header'] = $header_str;
	}

	$context = stream_context_create($opts);

	@$data = file_get_contents($url, false, $context);
	/*         
var_dump($data);
$error = error_get_last();
var_dump($error);
die();
         
*/       // $data = $this->curl_get_contents($url);

	return $data;
}

function curl_get_contents($url)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

function file_get_html()
{
	$dom = new simple_html_dom;
	$args = func_get_args();
	$dom->load(call_user_func_array('curl_get_contents', $args), true);
	return $dom;
}

function s3_upload_multiple($field_name, $index, $dir = "", $rotation = 0)
{
	require_once 'S3.php';

	$clientS3 = S3Client::factory(
		array(
			'key'    => AWS_S3_KEY,
			'secret' => AWS_S3_SECRET
		)
	);
          
          //$nomeArquivoRand = substr(md5(md5(time()).rand(6,9)),0,30);

	$tmpfile = $_FILES[$field_name]['tmp_name'][$index];
	$file = str_replace(" ", "", $_FILES[$field_name]['name'][$index]);

	if (defined('AWS_S3_URL')) {
		$nomeArquivoOriginal = explode(".", $file);
		$nomeArquivo = $nomeArquivoOriginal[0];
		$extensao = $nomeArquivoOriginal[1];

		$exists = $clientS3->doesObjectExist(AWS_S3_BUCKET, "documents/" . $dir . $file);

		if ($exists) $finalFileName = $nomeArquivo . "_" . time() . "." . $extensao;
		else $finalFileName = $file;
            
            
         //   $finalFileName = $nomeArquivoRand.".".$extensao;

		if ($rotation != 0) {
			$source = imagecreatefromjpeg($_FILES[$field_name]['tmp_name'][$index]);
			$rotate = imagerotate($source, ($rotation - 90), 0);

			$filename = tempnam(sys_get_temp_dir(), "foo");
			imagejpeg($rotate, $filename);

			$response = $clientS3->putObject(
				array(
					'Bucket' => AWS_S3_BUCKET,
					'Key'    => "documents/" . $dir . $finalFileName,
					'SourceFile' => $filename,
				)
			);
		} else {
			$response = $clientS3->putObject(
				array(
					'Bucket' => AWS_S3_BUCKET,
					'Key'    => "documents/" . $dir . $finalFileName,
					'SourceFile' => $_FILES[$field_name]['tmp_name'][$index],
				)
			);
		}

		$s3_path = $response['ObjectURL'];

		unlink($tmpfile);
	}

	return $s3_path;
}

function get_post_action($name)
{
	$params = func_get_args();

	foreach ($params as $name) {
		if (isset($_POST[$name])) {
			return $name;
		}
	}
}

function s3_upload_dynamic($file_name, $file_patch, $dir = "")
{
	require_once 'S3.php';

	$clientS3 = S3Client::factory(
		array(
			'key'    => AWS_S3_KEY,
			'secret' => AWS_S3_SECRET
		)
	);
         
       //   $nomeArquivoRand = substr(md5(md5(time()).rand(6,9)),0,30);

	if (defined('AWS_S3_URL')) {
		$nomeArquivoOriginal = explode(".", $file_name);
		$nomeArquivo = $nomeArquivoOriginal[0];
		$extensao = $nomeArquivoOriginal[1];

		$exists = $clientS3->doesObjectExist(AWS_S3_BUCKET, "documents/" . $dir . $file_name);

		if ($exists) $finalFileName = $nomeArquivo . "_" . time() . "." . $extensao;
		else $finalFileName = $file_name;
               
            
           // $finalFileName = $nomeArquivoRand.".".$extensao;

		$response = $clientS3->putObject(
			array(
				'Bucket' => AWS_S3_BUCKET,
				'Key'    => "documents/" . $dir . $finalFileName,
				'SourceFile' => $file_patch,
			)
		);

		$s3_path = $response['ObjectURL'];
	}

	return $s3_path;
}



//
// 
// Fuções de schema para montagem dinâmica
//  
//    

function montaForm($form)
{
   $db = new db();
   $db2 = new db();
   
   
   $sql = "SELECT * FROM schema_".$form." WHERE exibir = 1 AND status = 1 ORDER BY ordem ASC";
   $db->query($sql,__LINE__,__FILE__);
   $db->next_record();
   for($l = 0; $l < $db->num_rows(); $l++)
   {
      
      // Campos do tipo text, number, file, tel, email, password e hidden
      if($db->f("campo_type") != 3 && $db->f("campo_type") != 7 && $db->f("campo_type") != 8 && $db->f("campo_type") != 9  && $db->f("campo_type") != 12 )
      {
      
         $sql2 = "SELECT nome AS type_nome FROM schema_types WHERE id = ".$db->f("campo_type")." ";
         $db2->query($sql2,__LINE__,__FILE__);
         $db2->next_record();

         $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="'.$db2->f("type_nome").'" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if(strlen($db->f("campo_value")) > 0)
                      $form_content .= ' value="'.$db->f("campo_value").'" ';

                   if(strlen($db->f("campo_min")) > 0)
                      $form_content .= ' min="'.$db->f("campo_min").'" ';

                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
      }
      
      // Campos do tipo date
      if($db->f("campo_type") == 3)
      {
         
         
         $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="date" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))"  maxlength="10" '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if(strlen($db->f("campo_value")) > 3)
                      $form_content .= ' value="'.$db->f("campo_value").'" ';


                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
         
         
      }
      
      // Campos do tipo radio
      if($db->f("campo_type") == 8)
      {
         

         $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="radio" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if(strlen($db->f("campo_value")) > 3)
                      $form_content .= ' value="'.$db->f("campo_value").'" ';

                   if(strlen($db->f("campo_checked")) > 3)
                      $form_content .= ' checked="'.$db->f("campo_checked").'" ';

                   if(strlen($db->f("campo_selected")) > 3)
                      $form_content .= ' selected="'.$db->f("campo_selected").'" ';

                   

                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
         
         
      }
      
      // Campos do tipo checkbox
      if($db->f("campo_type") == 12)
      {
         
           $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="checkbox" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if(strlen($db->f("campo_value")) > 3)
                      $form_content .= ' value="'.$db->f("campo_value").'" ';

                   if(strlen($db->f("campo_checked")) > 3)
                      $form_content .= ' checked="'.$db->f("campo_checked").'" ';

                   if(strlen($db->f("campo_selected")) > 3)
                      $form_content .= ' selected="'.$db->f("campo_selected").'" ';

                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
       
         
         
      }
      // Campos do tipo textarea
      if($db->f("campo_type") == 9)
      {
         
         $form_content .= '<div class="form-group">
                              <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                              <div class="col-md-4">
                                 <textarea class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'" rows="'.$db->f("campo_rows").'" ';
         
         

                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';
         
         
         $form_content .= '>'.$db->f("campo_value").'</textarea>
                                  <span class="help-block"></span>
                              </div>
                          </div>';
         
      }
      
      $db->next_record();
   }
   
   return $form_content;
}

function montaSelect($form, $options, $id_campo)
{
   $db = new db();
   $db2 = new db();
   
   
   $sql = "SELECT * FROM schema_".$form." WHERE exibir = 1 AND status = 1 AND campo_type = 7 AND id = ".$id_campo." LIMIT 1";
   $db->query($sql,__LINE__,__FILE__);
   $db->next_record();
         
         $form_content .= '<div class="form-group">
               <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
               <div class="col-md-4">
                  <div class="input-group">
                     <select name="'.$db->f("campo_name").'" id="'.$db->f("campo_id").'"  class="'.$db->f("campo_class").'" ';
         
                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';
         
         
         $form_content .= '>
                        '.$options.'
                     </select>
                  </div>
               </div>
            </div>';
         
         
   
   return $form_content;
}

function montaGrid($grid_id, $listagem, $grid_nome)
{
   $db = new db();
   $db2 = new db();
   
   $grid = '<table class="table table-striped table-bordered table-hover" id="'.$grid_id.'">
               <thead>
                  <tr>';
   
   
   $sql = "SELECT label_coluna FROM schema_grid_".$grid_nome." WHERE exibir = 1 ORdER BY ordem ASC ";
   $db->query($sql,__LINE__,__FILE__);
   $db->next_record();
   for($l = 0; $l < $db->num_rows(); $l++)
   {
      $grid .= '<th>'.$db->f("label_coluna").'</th>';

      $db->next_record();
   }

      $grid .= '</tr>
           </thead>
           <tbody>
              '.$listagem.'
           </tbody>
        </table>';

   return $grid;
}

function montaFormEdita($form, $idRegistro)
{
   $db = new db();
   $db2 = new db();
   $db3 = new db();
   
   
   $sql = "SELECT * FROM schema_".$form." WHERE exibir = 1 AND status = 1 ORDER BY ordem ASC";
   $db->query($sql,__LINE__,__FILE__);
   $db->next_record();
   for($l = 0; $l < $db->num_rows(); $l++)
   {
      
      // Campos do tipo text, number, file, tel, email, password e hidden
      if($db->f("campo_type") != 3 && $db->f("campo_type") != 7 && $db->f("campo_type") != 8 && $db->f("campo_type") != 9  && $db->f("campo_type") != 12 )
      {
      
         $sql2 = "SELECT nome AS type_nome FROM schema_types WHERE id = ".$db->f("campo_type")." ";
         $db2->query($sql2,__LINE__,__FILE__);
         $db2->next_record();

         
         $sql3 = "SELECT ".$db->f("coluna")." AS campo_value FROM  ".$db->f("tabela")." WHERE id = ".$idRegistro." ";
         $db3->query($sql3,__LINE__,__FILE__);
         $db3->next_record();
         
         $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="'.$db2->f("type_nome").'" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if($db3->num_rows() > 0)
                      $form_content .= ' value="'.$db3->f("campo_value").'" ';


                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
      }
      
      // Campos do tipo date
      if($db->f("campo_type") == 3)
      {
         
         
         $sql3 = "SELECT ".$db->f("coluna")." AS campo_value FROM  ".$db->f("tabela")." WHERE id = ".$idRegistro." ";
         $db3->query($sql3,__LINE__,__FILE__);
         $db3->next_record();
         
         $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="date" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))"  maxlength="10" '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if($db3->num_rows() > 0)
                      $form_content .= ' value="'.$db3->f("campo_value").'" ';


                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
         
         
      }
      
      // Campos do tipo radio
      if($db->f("campo_type") == 8)
      {
         
         $sql3 = "SELECT ".$db->f("coluna")." AS campo_value FROM  ".$db->f("tabela")." WHERE id = ".$idRegistro." ";
         $db3->query($sql3,__LINE__,__FILE__);
         $db3->next_record();

         $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="radio" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if($db3->num_rows() > 0)
                      $form_content .= ' value="'.$db3->f("campo_value").'" ';

                   if(strlen($db->f("campo_checked")) > 3)
                      $form_content .= ' checked="'.$db->f("campo_checked").'" ';

                   if(strlen($db->f("campo_selected")) > 3)
                      $form_content .= ' selected="'.$db->f("campo_selected").'" ';

                   

                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
         
         
      }
      
      // Campos do tipo checkbox
      if($db->f("campo_type") == 12)
      {
         
         $sql3 = "SELECT ".$db->f("coluna")." AS campo_value FROM  ".$db->f("tabela")." WHERE id = ".$idRegistro." ";
         $db3->query($sql3,__LINE__,__FILE__);
         $db3->next_record();
         
         
           $form_content .= '<div class="form-group">
                  <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                  <div class="col-md-4">
                     <input type="checkbox" class="'.$db->f("campo_class").'" name="'.$db->f("campo_name").'"  '.$db->f("campo_required").' '; 

                   if(strlen($db->f("campo_placeholder")) > 3)
                      $form_content .= ' placeholder="'.$db->f("campo_placeholder").'" ';


                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';

                   if($db3->num_rows() > 0)
                      $form_content .= ' value="'.$db3->f("campo_value").'" ';


                   if(strlen($db->f("campo_checked")) > 3)
                      $form_content .= ' checked="'.$db->f("campo_checked").'" ';

                   if(strlen($db->f("campo_selected")) > 3)
                      $form_content .= ' selected="'.$db->f("campo_selected").'" ';

                  $form_content .= '>
                     <span class="help-block"></span>
                  </div>
               </div>';
       
         
         
      }
      // Campos do tipo textarea
      if($db->f("campo_type") == 9)
      {
         $sql3 = "SELECT ".$db->f("coluna")." AS campo_value FROM  ".$db->f("tabela")." WHERE id = ".$idRegistro." ";
         $db3->query($sql3,__LINE__,__FILE__);
         $db3->next_record();

         
         $form_content .= '<div class="form-group">
                              <label class="col-md-3 control-label">'.$db->f("campo_label").'</label>
                              <div class="col-md-4">
                                 <textarea name="'.$db->f("campo_name").'" rows="'.$db->f("campo_rows").'" ';
         
         

                   if(strlen($db->f("campo_onclick")) > 3)
                      $form_content .= ' onClick="'.$db->f("campo_onclick").'" ';


                   if(strlen($db->f("campo_onchange")) > 3)
                      $form_content .= ' onChange="'.$db->f("campo_onchange").'" ';


                   if(strlen($db->f("campo_onmouseover")) > 3)
                      $form_content .= ' onMouseover="'.$db->f("campo_onmouseover").'" ';

                   if(strlen($db->f("campo_onmouseout")) > 3)
                      $form_content .= ' onMouseout="'.$db->f("campo_onmouseout").'" ';


                   if(strlen($db->f("campo_onblur")) > 3)
                      $form_content .= ' onBlur="'.$db->f("campo_onblur").'" ';

                   if(strlen($db->f("campo_style")) > 3)
                      $form_content .= ' style="'.$db->f("campo_style").'" ';
         
         
         $form_content .= '>'.$db3->f("campo_value").'</textarea>
                                  <span class="help-block"></span>
                              </div>
                          </div>';
         
      }
      
      $db->next_record();
   }
   
   return $form_content;
}


function generatePassword ($length = 8)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }
}


function make_combo($query , $name_field , $id_field , $selected_id, $first_option = "")
{
    $db = new db();
    $db->query($query,__LINE__,__FILE__);
    $db->next_record();

    if ($first_option != "")
        $combo .= '<option value=0>'.$first_option;
    for ($i = 0 ; $i < $db->num_rows() ; $i++)
    {
        if ($db->f($id_field) == $selected_id)
            $selected = "selected";
        else
            $selected = "";
        $combo .= '<option '.$selected.' value="'.$db->f($id_field).'">'.$db->f($name_field);
    $db->next_record();
    }
    
    return $combo;
}

?>