<?php                                                                                                                                               
	if (DB_USED == 1)
		include('class.db_mysql.inc.php');
	elseif (DB_USED == 2)
		include('class.db_oracle.inc.php');

	class db_
	{
		var $Host;
		var $Database;
		var $User;
		var $Password;

		var $auto_stripslashes = False;
		var $Auto_Free     = 0;
		var $Debug         = 1;
		var $Halt_On_Error = 'yes';
		var $Seq_Table     = 'db_sequence';
		var $Record   = array();
		var $Row;
		var $Errno    = 0;
		var $Error    = '';
		var $xmlrpc = False;
		var $soap   = False;
		var $num_rows;
		var $rs   = array();

		function db_($database = '')
		{
			if ($database != '')
				$this->Database = $database;
		}

		
		function link_id()
		{
			return $this->Link_ID;
		}
		function query_id()
		{
			return $this->Query_ID;
		}
		function connect($Database = '', $Host = '', $User = '', $Password = '')
		{}
		function disconnect()
		{}
		function db_addslashes($str)
		{
			if (!isset($str) || $str == '')
			{
				return '';
			}

			if ( get_magic_quotes_gpc() )
			{
				$str = stripslashes($str);
			}

			return addslashes($str);
		}
		function to_timestamp($epoch)
		{}
		function from_timestamp($timestamp)
		{}
		function limit($start)
		{}
		function free()
		{}
		function query($Query_String, $line = '', $file = '')
		{
			if ($Query_String == '')
				return;
			$this->do_query($Query_String, $line, $file);
		}
		function limit_query($Query_String, $offset, $line = '', $file = '', $num_rows = '')
		{}
		function next_record()
		{}
		function seek($pos = 0)
		{}
		function transaction_begin()
		{
			return True;
		}
		function transaction_commit()
		{
			return True;
		}
		function transaction_abort()
		{
			return True;
		}
		function get_last_insert_id($table, $field)
		{}
		function lock($table, $mode='write')
		{}
		function unlock()
		{}
		function affected_rows()
		{}
		function num_rows()
		{}
		function num_fields()
		{}
		function nf()
		{
			return $this->num_rows();
		}
		function np()
		{
			print $this->num_rows();
		}
		function f($Name, $strip_slashes = False)
		{
			if ($strip_slashes || ($this->auto_stripslashes && ! $strip_slashes))
			{
				return stripslashes($this->Record[$Name]);
			}
			else
			{
				return $this->Record[$Name];
			}
		}
		function p($Name, $strip_slashes = True)
		{
			print $this->f($Name, $strip_slashes);
		}
		function nextid($seq_name)
		{}
		function metadata($table = '',$full = false)
		{
			/*
			 * Due to compatibility problems with Table we changed the behavior
			 * of metadata();
			 * depending on $full, metadata returns the following values:
			 *
			 * - full is false (default):
			 * $result[]:
			 *   [0]["table"]  table name
			 *   [0]["name"]   field name
			 *   [0]["type"]   field type
			 *   [0]["len"]    field length
			 *   [0]["flags"]  field flags
			 *
			 * - full is true
			 * $result[]:
			 *   ["num_fields"] number of metadata records
			 *   [0]["table"]  table name
			 *   [0]["name"]   field name
			 *   [0]["type"]   field type
			 *   [0]["len"]    field length
			 *   [0]["flags"]  field flags
			 *   ["meta"][field name]  index of field named "field name"
			 *   The last one is used, if you have a field name, but no index.
			 *   Test:  if (isset($result['meta']['myfield'])) { ...
			 */
		}
		function halt($msg, $line = '', $file = '')
		{}
		function table_names()
		{}
		function index_names()
		{
			return array();
		}
		function create_database($adminname = '', $adminpasswd = '')
		{}
		function prepare_sql_statement($query)
		{
		  if (($query == '') || (!$this->connect()))
	  	   {
			return(FALSE);
		   }
		  return(FALSE);
		}
        function query_prepared_statement($result_id, $parameters_array)
         {
		  if ((!$this->connect()) || (!$result_id))
	  	   {
			return(FALSE);
		   }
		  return(FALSE);
         }  
                
	}
?>
