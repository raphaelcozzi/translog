<?php                                                                                          

	/**
	* Database class for MySQL
	* @author NetUSE AG Boris Erdmann, Kristian Koehntopp
    * @author Dan Kuykendall, Dave Hall and others
	* @copyright Copyright (C) 1998-2000 NetUSE AG Boris Erdmann, Kristian Koehntopp
	* @copyright Portions Copyright (C) 2001-2004 Free Software Foundation, Inc. http://www.fsf.org/
	* @license http://www.fsf.org/licenses/lgpl.html GNU Lesser General Public License
	* @link http://www.sanisoft.com/phplib/manual/DB_sql.php
	* @package phpgwapi
	* @subpackage database
	* @version $Id: class.db_mysql.inc.php,v 1.30.2.3.2.12 2004/11/06 15:34:26 powerstat Exp $
	*/

	/**
	* Database class for MySQL
	* 
	* @package phpgwapi
	* @subpackage database
	*/

	require_once(CONFIG_PATH."/inc/base.php");


	class db extends db_
	{
        /**
         * @var string $type Connection type
         */
		var $type     = 'mysql';
		/**
		* API revision
		*
		* @internal This is an api revision, not a CVS revision
		* @access public
		*/
		var $revision = '1.2';

		/**
		* Constructor
		*
		* @param $query SQL query
		*/
		function db($database = '')
		{			
            if ($database != '')
	            $this->Database = $database;
	        else
           {
	         $this->Database = MYSQL_CONFIG_DATABASE;
            $this->Host     = MYSQL_CONFIG_HOST;
            $this->User     = MYSQL_CONFIG_USERNAME;
            $this->Password = MYSQL_CONFIG_PASSWORD;
            
           }
//            $this->db_($query);

		}

		/**
		 * Connect to database
		 * 
		 * @param string $Database Database name
		 * @param string $Host Database host
		 * @param string $User Database user
		 * @param string $Password Database users password
		 * @return resource Database connection_id
		 */
		function connect($Database = '', $Host = '', $User = '', $Password = '')
		{
			/* Handle defaults */
			if ($Database == '')
			{
				$Database = $this->Database;
			}
			if ($Host == '')
			{
				$Host     = $this->Host;
			}
			if ($User == '')
			{
				$User     = $this->User;
			}
			if ($Password == '')
			{
				$Password = $this->Password;
			}
         
         
			/* establish connection, select database */

			if (! $this->Link_ID)
			{
				if ($GLOBALS['phpgw_info']['server']['db_persistent'])
				{
					$this->Link_ID=mysqli_connect($Host, $User, $Password);
                                 mysqli_query($this->Link_ID, "SET NAMES 'utf8'");
                                 mysqli_query($this->Link_ID, 'SET character_set_connection=utf8');
                                 mysqli_query($this->Link_ID, 'SET character_set_client=utf8');
                                 mysqli_query($this->Link_ID, 'SET character_set_results=utf8');
				}
				else
				{
					$this->Link_ID=mysqli_connect($Host, $User, $Password);
                                 mysqli_query($this->Link_ID, "SET NAMES 'utf8'");
                                 mysqli_query($this->Link_ID, 'SET character_set_connection=utf8');
                                 mysqli_query($this->Link_ID, 'SET character_set_client=utf8');
                                 mysqli_query($this->Link_ID, 'SET character_set_results=utf8');
                                 
				}

				if (!$this->Link_ID)
				{
					$this->halt(($GLOBALS['phpgw_info']['server']['db_persistent']?'p':'')."connect($Host, $User, \$Password) failed.");
					return 0;
				}

				if (!@mysqli_select_db($this->Link_ID,$Database))
				{
					$this->halt("cannot use database ".$this->Database);
					$this->disconnect();
					return 0;
				}
			}
			return $this->Link_ID;
		}

		/**
		* Disconnect from database
		*
		* @return integer 1: successful; 0: already disconnected
		* @internal This only affects systems not using persistant connections
		*/
		function disconnect()
		{
			if($this->Link_ID <> 0)
			{
				@mysqli_close($this->Link_ID);
				$this->Link_ID = 0;
				return 1;
			}
			else
			{
				return 0;
			}
		}

        /**
         * Convert a unix timestamp to a rdms specific timestamp
         *
         * @param int unix timestamp
         * @return string rdms specific timestamp
         */
		function to_timestamp($epoch)
		{
			return date('Y-m-d H:i:s',$epoch);
		}

        /**
         * Convert a rdms specific timestamp to a unix timestamp
         *
         * @param string rdms specific timestamp
         * @return int unix timestamp
         */
		function from_timestamp($timestamp)
		{
			ereg('([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})',$timestamp,$parts);

			return mktime($parts[4],$parts[5],$parts[6],$parts[2],$parts[3],$parts[1]);
		}

        /**
         * Discard the current query result
         */
		function free()
		{
			@mysqli_free_result($this->Query_ID);
			$this->Query_ID = 0;
		}

        /**
         * Execute a query
         *
         * @param string $Query_String the query to be executed
         * @param mixed $line the line method was called from - use __LINE__
         * @param string $file the file method was called from - use __FILE__
         * @return integer Current result if sucesful and null if failed
         */
		function query($Query_String, $line = '', $file = '')
		{
			/* No empty queries, please, since PHP4 chokes on them. */
			/* The empty query string is passed on from the constructor,
			* when calling the class without a query, e.g. in situations
			* like these: '$db = new db_Subclass;'
			*/
			if ($Query_String == '')
			{
				return 0;
			}
			if (!$this->connect())
			{
				$this->Errno = @mysqli_errno($this->Link_ID);
				$this->Error = @mysqli_error($this->Link_ID);
				return 0; /* we already complained in connect() about that. */
			};

			# New query, discard previous result.
			if ($this->Query_ID)
			{
				$this->free();
			}

			$this->Query_ID = @mysqli_query($this->Link_ID, $Query_String);
			$this->Row   = 0;
			$this->Errno = mysqli_errno($this->Link_ID);
			$this->Error = mysqli_error($this->Link_ID);

			if (MYSQL_DEBUG || $_SESSION["MYSQL_DEBUG"] == 1)
			{
				$GLOBALS["sql_debug"] .= '
						<tr>
							<td valign=top>'.$line.'</td>
							<td valign=top>'.$file.'</td>
							<td nowrap valign=top>'.@mysqli_affected_rows($this->Link_ID).'</td>
							<td valign=top>'.$Query_String.'</td>
						</tr>
						';
			}
			
			if (! $this->Query_ID)
			{
				$this->halt("Invalid SQL: ".$Query_String, $line, $file);
				die;
			}

			# Will return nada if it fails. That's fine.
			return $this->Query_ID;
		}

        /**
         * Execute a query with limited result set
         *
         * @param string $Query_String the query to be executed
         * @param integer $offset row to start from
         * @param mixed $line the line method was called from - use __LINE__
         * @param string $file the file method was called from - use __FILE__
         * @param int $num_rows number of rows to return (optional), if unset will use $GLOBALS['phpgw_info']['user']['preferences']['common']['maxmatchs']
         * @return integer Current result if sucesful and null if failed
         */
		function limit_query($Query_String, $offset, $line = '', $file = '', $num_rows = 0)
		{
			$offset		= intval($offset);
			$num_rows	= intval($num_rows);

			if ($num_rows == 0)
			{
				$maxmatches = $GLOBALS['phpgw_info']['user']['preferences']['common']['maxmatchs'];
				$num_rows = (isset($maxmatches)?intval($maxmatches):15);
			}

			if ($offset == 0)
			{
				$Query_String .= ' LIMIT ' . $num_rows;
			}
			else
			{
				$Query_String .= ' LIMIT ' . $offset . ',' . $num_rows;
			}

			if ($this->Debug)
			{
				printf("Debug: limit_query = %s<br />offset=%d, num_rows=%d<br />\n", $Query_String, $offset, $num_rows);
			}

			return $this->query($Query_String, $line, $file);
		}

        /**
         * Move to the next row in the results set
         *
         * @return boolean was another row found?
         */
		function next_record()
		{
			if (!$this->Query_ID)
			{
				$this->halt('next_record called with no query pending.');
				return 0;
			}

			$this->Record = @mysqli_fetch_array($this->Query_ID);
			$this->Row   += 1;
			$this->Errno  = mysqli_errno($this->Link_ID);
			$this->Error  = mysqli_error($this->Link_ID);

			$stat = is_array($this->Record);
			if (!$stat && $this->Auto_Free)
			{
				$this->free();
			}
			return $stat;
		}

        /**
         * Move to position in result set
         *
         * @param integer $pos Required row (optional), default first row
         * @return integer 1 if sucessful or 0 if not found
         */
		function seek($pos = 0)
		{
			$status = @mysqli_data_seek($this->Query_ID, $pos);
			if ($status)
			{
				$this->Row = $pos;
			}
			else
			{
				$this->halt("seek($pos) failed: result has ".$this->num_rows()." rows");
				/* half assed attempt to save the day, 
				* but do not consider this documented or even
				* desireable behaviour.
				*/
				@mysqli_data_seek($this->Query_ID, $this->num_rows());
				$this->Row = $this->num_rows;
				return 0;
			}
			return 1;
		}

        /**
         * Find the primary key of the last insertion on the current db connection
         *
         * @param string $table name of table the insert was performed on
         * @param string $field the autoincrement primary key of the table
         * @return integer The id, -1 if failed
         */
		function get_last_insert_id($table, $field)
		{
			/* This will get the last insert ID created on the current connection.  Should only be called
			 * after an insert query is run on a table that has an auto incrementing field.  $table and
			 * $field are required, but unused here since it's unnecessary for mysql.  For compatibility
			 * with pgsql, the params must be supplied.
			 */

			if (!isset($table) || $table == '' || !isset($field) || $field == '')
			{
				return -1;
			}

			return @mysqli_insert_id($this->Link_ID);
		}

        /**
         * Lock a table
         *
         * @param string $table name of table to lock
         * @param string $mode type of lock required (optional), default write
         * @return boolean True if sucessful, False if failed
         */
		function lock($table, $mode='write')
		{
			$this->connect();

			$query = "lock tables ";
			if (is_array($table))
			{
				while (list($key,$value)=each($table))
				{
					if ($key == "read" && $key!=0)
					{
						$query .= "$value read, ";
					}
					else
					{
						$query .= "$value $mode, ";
					}
				}
				$query = substr($query,0,-2);
			}
			else
			{
				$query .= "$table $mode";
			}
			$res = @mysqli_query($this->Link_ID, $query);
			if (!$res)
			{
				$this->halt("lock($table, $mode) failed.");
				return 0;
			}
			return $res;
		}

        /**
         * Unlock a table
         *
         * @return boolean True if sucessful, False if failed
         */
		function unlock()
		{
			$this->connect();

			$res = @mysqli_query($this->Link_ID,"unlock tables");
			if (!$res)
			{
				$this->halt("unlock() failed.");
				return 0;
			}
			return $res;
		}


        /**
         * Get the number of rows affected by last update
         *
         * @return integer number of affected rows
         */
		function affected_rows()
		{
			return @mysqli_affected_rows($this->Link_ID);
		}

        /**
         * Number of rows in current result set
         *
         * @return integer number of rows
         */
		function num_rows()
		{
			return @mysqli_num_rows($this->Query_ID);
		}

        /**
         * Number of fields in current row
         *
         * @return integer number of fields
         */
		function num_fields()
		{
			return @mysqli_num_fields($this->Query_ID);
		}

		function field_name($field_index)
		{
			return @mysqli_field_name($this->Query_ID , $field_index);
			//return $this->mysql_field_name($field_index);
		}

		/**
         * Get the id for the next sequence
         *
         * @param string $seq_name Name of the sequence
         * @return integer sequence id
         */
		function nextid($seq_name)
		{
			$this->connect();

			if ($this->lock($this->Seq_Table))
			{
				/* get sequence number (locked) and increment */
				$q  = sprintf("select nextid from %s where seq_name = '%s'",
					$this->Seq_Table,
					$seq_name);
				$id  = @mysqli_query($this->Link_ID, $q);
				$res = @mysqli_fetch_array($id);

				/* No current value, make one */
				if (!is_array($res))
				{
					$currentid = 0;
					$q = sprintf("insert into %s values('%s', %s)",
						$this->Seq_Table,
						$seq_name,
						$currentid);
					$id = @mysqli_query($this->Link_ID, $q);
				}
				else
				{
					$currentid = $res["nextid"];
				}
				$nextid = $currentid + 1;
				$q = sprintf("update %s set nextid = '%s' where seq_name = '%s'",
					$this->Seq_Table,
					$nextid,
					$seq_name);
				$id = @mysqli_query($this->Link_ID, $q);
				$this->unlock();
			}
			else
			{
				$this->halt("cannot lock ".$this->Seq_Table." - has it been created?");
				return 0;
			}
			return $nextid;
		}

        /**
         * Get description of a table
         *
         * @param string $table name of table to describe
         * @param boolean $full optional, default False summary information, True full information
         * @return array Table meta data
         */
		function metadata($table='',$full=false)
		{
			$count = 0;
			$id    = 0;
			$res   = array();

			/* if no $table specified, assume that we are working with a query */
			/* result */
			if ($table)
			{
				$this->connect();
				$id = @mysqli_list_fields($this->Database, $table);
				if (!$id)
				{
					$this->halt("Metadata query failed.");
				}
			}
			else
			{
				$id = $this->Query_ID; 
				if (!$id)
				{
					$this->halt("No query specified.");
				}
			}
 
			$count = @mysqli_num_fields($id);

			/* made this IF due to performance (one if is faster than $count if's) */
			if (!$full)
			{
				for ($i=0; $i<$count; $i++)
				{
					$res[$i]['table'] = @mysql_field_table ($id, $i);
					$res[$i]['name']  = @mysql_field_name  ($id, $i);
					$res[$i]['type']  = @mysql_field_type  ($id, $i);
					$res[$i]['len']   = @mysql_field_len   ($id, $i);
					$res[$i]['flags'] = @mysql_field_flags ($id, $i);
				}
			}
			else
			{
				/* full */
				$res["num_fields"]= $count;

				for ($i=0; $i<$count; $i++)
				{
					$res[$i]['table'] = @mysql_field_table ($id, $i);
					$res[$i]['name']  = @mysql_field_name  ($id, $i);
					$res[$i]['type']  = @mysql_field_type  ($id, $i);
					$res[$i]['len']   = @mysql_field_len   ($id, $i);
					$res[$i]['flags'] = @mysql_field_flags ($id, $i);
					$res['meta'][$res[$i]['name']] = $i;
				}
			}

			/* free the result only if we were called on a table */
			if ($table)
			{
				@mysqli_free_result($id);
			}
			return $res;
		}

        /**
         * Error handler
         *
         * @param string $msg error message
         * @param integer $line line of calling method/function (optional)
         * @param string $file file of calling method/function (optional)
         */
		function halt($msg, $line = '', $file = '')
		{
			$this->Error = @mysqli_error($this->Link_ID);	// need to be BEFORE unlock,
			$this->Errno = @mysqli_errno($this->Link_ID);	// else we get its error or none
			
			if ($this->Link_ID)		// only if we have a link, else infinite loop
			{
				$this->unlock();	/* Just in case there is a table currently locked */
			}
			if ($this->Halt_On_Error == "no")
			{
				return;
			}
			$this->haltmsg($msg, $line, $file);

			if ($file)
			{
				printf("<br /><b>File:</b> %s",$file);
			}
			if ($line)
			{
				printf("<br /><b>Line:</b> %s",$line);
			}

			if ($this->Halt_On_Error != "report")
			{
				echo "<p><b>Session halted.</b>";
				//$GLOBALS['phpgw']->common->phpgw_exit(True);
			}
		}

        /** 
         * Display database error
         *
         * @param string $msg Error message
         */
		function haltmsg($msg, $line = '', $file = '')
		{
			$GLOBALS["base"]->show_error_msg($msg , $this->Error , $this->Errno, $line, $file);
			$halt_msg = 'Error Message : '.$msg.chr(10);
			if ($this->Errno != "0" && $this->Error != "()")
				$error_msg = 'Error Number : '.$this->Errno.chr(10).'Description : '.$this->Error.chr(10);
			$error_mail = $halt_msg.$error_msg;
		}

        /**
         * Get a list of table names in the current database
         *
         * @return array List of the tables
         */
		function table_names()
		{
			if (!$this->Link_ID)
			{
				$this->connect();
			}
			if (!$this->Link_ID)
			{
				return array();
			}
			$return = Array();
			$this->query("SHOW TABLES");
			$i=0;
			while ($info=@mysqli_fetch_row($this->Query_ID))
			{
				$return[$i]['table_name'] = $info[0];
				$return[$i]['tablespace_name'] = $this->Database;
				$return[$i]['database'] = $this->Database;
				$i++;
			}
			return $return;
		}

        /**
         * Create a new database
         *
         * @param string $adminname Name of database administrator user (optional)
         * @param string $adminpasswd Password for the database administrator user (optional)
         */
		function create_database($adminname = '', $adminpasswd = '')
		{
			$currentUser = $this->User;
			$currentPassword = $this->Password;
			$currentDatabase = $this->Database;

			if ($adminname != '')
			{
				$this->User = $adminname;
				$this->Password = $adminpasswd;
				$this->Database = "mysql";
			}
			$this->disconnect();
			$this->query("CREATE DATABASE $currentDatabase");
			$this->query("grant all on $currentDatabase.* to $currentUser@localhost identified by '$currentPassword'");
			$this->disconnect();

			$this->User = $currentUser;
			$this->Password = $currentPassword;
			$this->Database = $currentDatabase;
			$this->connect();
			/*return $return; */
		}
      
      function mysqli_field_name($result, $field_offset)
      {
          $properties = mysqli_fetch_field_direct($result, $field_offset);
          return is_object($properties) ? $properties->name : null;
      }      
	}
?>
