<?php                                                                                                                                                                                                                                          
	class base_class
	{
		var $template;
		var $db_main;
		var $debug = 1;

		function base_class()
		{
			$this->template = new template();
			$this->db_main = new db();
		}
		function show_error_msg($msg , $error , $errno, $line, $file)
		{
			$GLOBALS["base"]->template = new template();
			echo $GLOBALS["base"]->write_design_specific('error.tpl' , 'error_msg' , 0);

			//ERRO APARECE PRO USUARIO RAPHAEL
			if (MYSQL_SHOW_ERROR)
				echo $this->make_sql_error_mail($msg , $error , $errno, $line, $file);
		}
		function make_sql_error_mail($msg , $error , $errno, $line, $file)
		{
			$path_list = '';
			for($i = 0 ; $i < count($_SESSION["path_de_navegacao"]) ; $i++)
			{
				$path_list .= '<tr>
								<td align=right valign=top nowrap><strong>'.($i + 1).' : </strong></td>
								<td align=left  valign=top nowrap>'.$_SESSION["path_de_navegacao"][$i].'</td>
							</tr>';
			}

			$msg_body = '
			<br>
			<table border=0 cellpadding=0 cellspacing=2>
				<tr>
					<td colspan=2 align=center valign=top>Erro disparado no portal em '.date("Y-m-d H:i:s").'</td>
				<tr>
				<tr>
					<td colspan=2><hr></td>
				</tr>
				<tr>
					<td colspan=2><strong>Dados do Erro</strong></td>
				</tr>
				<tr>
					<td colspan=2><hr></td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>SERVER_NAME : </strong></td>
					<td>'.$_SERVER["SERVER_NAME"].'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>SERVER_ADDR : </strong></td>
					<td>'.$_SERVER["SERVER_ADDR"].'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>SERVER_PORT : </strong></td>
					<td>'.$_SERVER["SERVER_PORT"].'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>REMOTE_ADDR : </strong></td>
					<td>'.$_SERVER["REMOTE_ADDR"].'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>HTTP_USER_AGENT : </strong></td>
					<td>'.$_SERVER["HTTP_USER_AGENT"].'</td>
				</tr>

				<tr>
					<td align=right valign=top nowrap><strong>Error Number : </strong></td>
					<td>'.$errno.'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>Error Message : </strong></td>
					<td>'.$msg.'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>Error Description : </strong></td>
					<td>'.$error.'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>URL : </strong></td>
					<td>'.$_SERVER["REQUEST_URI"].'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>LINE : </strong></td>
					<td>'.$line.'</td>
				</tr>
				<tr>
					<td align=right valign=top nowrap><strong>FILE : </strong></td>
					<td>'.$file.'</td>
				</tr>
				<tr>
					<td colspan=2><hr></td>
				</tr>
				<tr>
					<td colspan=2 nowrap><strong>PATH DE NAVEGAÇÂO</strong></td>
				</tr>
				<tr>
					<td colspan=2><hr></td>
				</tr>
				'.$path_list.'
				<tr>
					<td colspan=2><hr></td>
				</tr>
				<tr>
					<td colspan=2 nowrap><strong>COOKIES DO USUÁRIO</strong></td>
				</tr>
				<tr>
					<td colspan=2><hr></td>
				</tr>';
			while (list ($name, $value) = each ($_COOKIE)) 
				$msg_body .= '
					<tr>
						<td align=right valign=top nowrap><strong>'.$name.' : </strong></td>
						<td>'.$value.'</td>
					</tr>';
			$msg_body .= '</table>';

			return $msg_body;

		}

		//FUNÇÕES DE TEMPLATES/DESIGN
		function write_design_specific($template_name , $block_name , $return_type = 0 , $template_var = "")
		{
            if ($template_var == "")
                $template = $this->template;

			$this->template->set_file(array('specific' => $template_name));
			$this->template->set_block('specific',$block_name,$block_name);
            if ($return_type == 0)
                print $this->template->pparse('out',$block_name);
            else
    			return $this->template->pparse('out',$block_name);
		}
		function echo_mysql_debug()
		{
			if (MYSQL_DEBUG || $_SESSION["MYSQL_DEBUG"] == 1)
				echo '<div style="clear:both">
						<table width="100%" border=1>
							<tr>
								<td>file</td>
								<td>line</td>
								<td>rows</td>
								<td>query</td>
							</tr>'.$GLOBALS["sql_debug"].'
						</table>
					</div>';
		}
		//FUNÇÕES DE TEMPLATES/DESIGN
		

		
		//FUNÇÕES RELACIONADAS A CONVERSÕES DE DINHEIRO
        function format_money_locale_to_db($value)
        {
            $value = str_replace('.' , '' , $value);
            $value = str_replace(',' , '.' , $value);
            return $value;
        }
        function format_money_formal_locale_from_db($value)
        {
            //setlocale(LC_MONETARY, 'pt_BR');
            return number_format($value , 2 , ',' , '.');
        }
        function format_money_simple_locale_from_db($value)
        {
            $value = str_replace(',' , '' , $value);
            $value = str_replace('.' , ',' , $value);
            return $value;
        }
		//FUNÇÕES RELACIONADAS A CONVERSÕES DE DINHEIRO


		
        //IUD FUNCTIONS
		function make_insert($table , $obj , $array_fields , $identity_field, $debug = 0)
		{
			
			$plick = "";
			$query = "insert into ".$table."(";
			for ($i = 0 ; $i < count($array_fields) ; $i++)
			{
				$query.= $array_fields[$i];
				if ($i < count($array_fields) - 1)
					$query.= " , ";
			}
			$query.= ") values (";

			for ($i = 0 ; $i < count($array_fields) ; $i++)
			{
				$field_value = eval('return $obj->'.$array_fields[$i].';');
				$plick = "'";
				$field_value = str_replace("'" , "`" , $field_value);
				$query.= $plick.trim($field_value).$plick;
				if ($i < count($array_fields) - 1)
					$query.= " , ";
			}
			$query.= ")";

            if ($debug == 1)
    			echo $query;
            if ($debug == 2)
            {
    			echo $query;
    			die;
            }
            			
			
			$db = new db();
			$db->query($query,__LINE__,__FILE__);

			return $db->get_last_insert_id("pmo_responsavel_aval_rs", "responsavel_aval_rs_id");

		}
		function make_update($table , $obj , $array_fields , $field_id , $debug = 0)
		{
			$query = " update ".$table." set";
			$plick = "'";
			for ($i = 0 ; $i < count($array_fields) ; $i++)
			{
				$field_value = eval('return $obj->'.$array_fields[$i].';');
				$field_value = str_replace("'" , "`" , $field_value);
				$query.= " ".$array_fields[$i]." = ".$plick.$field_value.$plick;
				if ($i < count($array_fields) - 1)
					$query.= " , ";
			}
			$query.= " where ".$field_id." = ".trim(eval('return $obj->'.$field_id.';'));

            if ($debug == 1)
    			echo $query;
            if ($debug == 2)
            {
    			echo $query;
    			die;
            }

			$db = new db();
			$db->query($query,__LINE__,__FILE__);
			$db->query("commit;" , __LINE__,__FILE__);
		}
		function make_delete($table , $field_id , $delete_id)
		{
			$db = new db();
			$query = " delete 
						 from ".$table."
						where ".$table.".".$field_id." = ".$delete_id;
			$db->query($query,__LINE__,__FILE__);
		}
        //IUD FUNCTIONS
		
        
		
		//FUNCOES GENERICAS
        function make_combo($combo_nome , $query , $name_field , $id_field , $selected_id, $onChange_js = "" , $first_option = "")
        {
			$db = new db();
			$db->query($query,__LINE__,__FILE__);
			$db->next_record();

            $combo = '<select name='.$combo_nome.' id='.$combo_nome.' OnChange="'.$onChange_js.'">';
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
            $combo .= '</select>';
            return $combo;
        }
        function make_combo_number($combo_nome , $start_value , $end_value , $selected_value , $first_value = "" , $first_text = "" , $onChange_js = "" , $class = "")
        {
            $combo  = '<select class="'.$class.'" name="'.$combo_nome.'" id="'.$combo_nome.'" OnChange="'.$onChange_js.'">';

            if ($first_text != "")
                $combo .= '<option value="'.$first_value.'">'.$first_text;
                
            for ($i = $start_value ; $i <= $end_value ; $i++)
            {
                if ($i == $selected_value)
                    $selected = "selected";
                else
                    $selected = "";
                $combo .= '<option '.$selected.' value="'.$i.'">'.$i;
            }
            $combo .= '</select>';
            return $combo;
        }
		function get_readable_file_size($size)
		{
			$bytes = array('B','KB','MB','GB','TB');
			foreach($bytes as $val) 
			{
				if($size > 1024)
				{
					$size = $size / 1024;
				} else {
					break;
				}
			}
			return round($size, 2)." ".$val;
		}
		function get_dia_semana($int_dia)
		{
			switch ($int_dia)
			{
			case 0:
				return "Domingo";
				break;
			case 1:
				return "Segunda-feira";
				break;
			case 2:
				return "Terça-feira";
				break;
			case 3:
				return "Quarta-feira";
				break;
			case 4:
				return "Quinta-feira";
				break;
			case 5:
				return "Sexta-feira";
				break;
			case 6:
				return "Sábado";
				break;
			}
		}
		function get_mes($month)
        {
            switch ($month)
            {
                case "1" :
                    return "Janeiro";
                    break;
                case "2" :
                    return "Fevereiro";
                    break;
                case "3" :
                    return "Março";
                    break;
                case "4" :
                    return "Abril";
                    break;
                case "5" :
                    return "Maio";
                    break;
                case "6" :
                    return "Junho";
                    break;
                case "7" :
                    return "Julho";
                    break;
                case "8" :
                    return "Agosto";
                    break;
                case "9" :
                    return "Setembro";
                    break;
                case "10" :
                    return "Outubro";
                    break;
                case "11" :
                    return "Novembro";
                    break;
                case "12" :
                    return "Dezembro";
                    break;
            }

        }		
		//FUNCOES GENERICAS

		function zero_antes($string)
		{
		  if($string < 10 )
			$string = "0$string";
			return $string;
		}

		
		function my_ucwords($string){ 
		
			$invalid_characters = array('"', 
										'\(', 
										'\[', 
										'\/', 
										'<.*?>', 
										'<\/.*?>'); 
		
			foreach($invalid_characters as $regex){ 
				$string = preg_replace('/('.$regex.')/','$1 ',$string); 
			} 
		
			$string=ucwords($string); 
		
			foreach($invalid_characters as $regex){ 
				$string = preg_replace('/('.$regex.') /','$1',$string); 
			} 
		
			return $string; 
		} 
		
		function title_case($title) { 
			$smallwordsarray = array( 
				'of','a','the','and','an','or','nor','but','is','if','then', 
		'else','when', 
				'at','from','by','on','off','for','in','out', 
		'over','to','into','with', 'e', 'de', 'da', 'di', 'do', 'por'
			); 
		
			$words = explode(' ', $title); 
			foreach ($words as $key => $word) 
			{ 
				if ($key == 0 or !in_array($word, $smallwordsarray)) 
				$words[$key] = $this->my_ucwords(strtolower($word)); 
			} 
		
			$newtitle = implode(' ', $words); 
			return $newtitle; 
		} 
		

		function strtoUpperCase($value) {
			define( "UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖŒØŠÙÚÛÜÝŽÞ" ); 
			define( "LC_CHARS", "àáâãäåæçèéêëìíîïðñòóôõöœøšùúûüýžþ" ); 

			return (strtoupper(strtr( $value, LC_CHARS, UC_CHARS )));
		}

		function strtoLowerCase($value) {
			define( "UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖŒØŠÙÚÛÜÝŽÞ" ); 
			define( "LC_CHARS", "àáâãäåæçèéêëìíîïðñòóôõöœøšùúûüýžþ" ); 

			return (strtolower(strtr( $value, UC_CHARS, LC_CHARS )));
		}
		


	}
?>
