<?php 
	class user_admin
	{
		var $user_admin_id;
		var $user_admin_name;
		var $user_admin_password;
		var $user_admin_email;

		function __construct()
		{
			$this->template = new template();
		}
		function verify_login()
		{
			$db = new db();
			$query = 'select * 
						from user_admin 
					   where user_admin_password = \''.$this->user_admin_password.'\'
					     and user_admin_email = \''.$this->user_admin_email.'\'';
			$query = 'select * 
						from usuarios_admin
					   where senha = \''.$this->user_admin_password.'\'
					     and usuario = \''.$this->user_admin_email.'\'';
			$db->query($query,__LINE__,__FILE__);
			$db->next_record();
			setcookie("user_admin.user_admin_email", $this->user_admin_email);

			if ($db->num_rows() > 0)
			{
				$this->user_admin_id = $db->f("user_admin_id");
				$this->user_admin_name = $db->f("user_admin_name");
				$this->user_admin_password = $db->f("user_admin_password");
				$this->user_admin_email = $db->f("user_admin_email");

				$this->user_admin_id = $db->f("id");
				$this->user_admin_name = $db->f("usuario");
				$this->user_admin_password = $db->f("senha");
				$this->user_admin_email = $db->f("email");
				return 1;
			} else {
				return 0;
			}

		}
		function fetch()
		{
			
			$array_fields = array(
						'user_admin_name',
						'user_admin_email',
						'user_admin_password'
						);
		
			$db = new db();
			$query = 'select user_admin.user_admin_name,
							 user_admin.user_admin_email,
							 user_admin.user_admin_password
						from user_admin
					   where user_admin_id = '.$this->user_admin_id;
			$db->query($query,__LINE__,__FILE__);
			$db->next_record();

			for ($i = 0 ; $i < count($array_fields) ; $i++)
				eval ('$this->'.$array_fields[$i].' = $db->f("'.$array_fields[$i].'") ; ');
		}
		function update($update_password = 0)
		{
			$array_fields = array();
			array_push($array_fields , 'user_admin_name');
			array_push($array_fields , 'user_admin_email');
			if ($update_password == 1)
				array_push($array_fields , 'user_admin_password');

			$GLOBALS["base"]->make_update("user_admin" , $this , $array_fields , "user_admin_id");
			return 1;
		}
		function delete()
		{
			$GLOBALS["base"]->make_delete("user_admin" , "user_admin_id" , $this->user_admin_id);
		}
		function insert()
		{
			$array_fields = array('user_admin_name' , 'user_admin_password' , 'user_admin_email');
			$this->user_admin_id = $GLOBALS["base"]->make_insert("user_admin" , $this , $array_fields , "user_admin_id");
		}
		function fetch_user_by_field($field_name)
		{
			$db = new db();
			$query = 'select * from user_admin where '.$field_name.' = \''.(eval('return $this->'.$field_name.';')).'\'';
			$db->query($query,__LINE__,__FILE__);
			$db->next_record();
			if ($db->num_rows() > 0)
			{
				$this->user_admin_id = $db->f("user_admin_id");
				$this->fetch();
				return 1; 
			} else {
				return 0; 
			}
		}
	}

?>