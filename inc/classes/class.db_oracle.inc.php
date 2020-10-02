<?php                                                                                                                                                                                	/**
	* Database class for Oracle
	* @author Luis Francisco Gonzalez Hernandez
	* @copyright Copyright (C) 1998-2000 Luis Francisco Gonzalez Hernandez
	* @copyright Portions Copyright (C) 2001-2004 Free Software Foundation, Inc. http://www.fsf.org/
	* @license http://www.fsf.org/licenses/lgpl.html GNU Lesser General Public License
	* @link http://www.sanisoft.com/phplib/manual/DB_sql.php
	* @package phpgwapi
	* @subpackage database
	* @version $Id: class.db_oracle.inc.php,v 1.6.2.1.2.5 2004/11/06 15:34:26 powerstat Exp $
	*/

	/**
	* Database class for Oracle
	* 
	* @package phpgwapi
	* @subpackage database
	* @ignore
	*/
	class db extends db_
	{
		var $Remote = 1;

		var $ora_no_next_fetch = False;

        /**
         * @var string $type Connection type
         */
		var $type     = 'oracle';
		/**
		 * @var string $revision Api revision 
		 */
		var $revision = '1.2';

		/**
		* Constructor
		*
		* @param $query SQL query
		*/

		
		function db($query = '')
		{
			$this->Host     = $_SESSION["oracle_config_host"];
			$this->Database = $_SESSION["oracle_config_database"];
			$this->User     = $_SESSION["oracle_config_username"];
			$this->Password = $_SESSION["oracle_config_password"];
			$this->db_($query);
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

			if (! $this->Link_ID)
			{
				if($this->Debug)
				{
					printf('<br />Connecting to ' . $Database . "...<br />\n");
				}
				if($this->Remote)
				{
					if($this->Debug)
					{
						printf("<br />connect() $User/******@$Database.world<br />\n");
					}
					if($GLOBALS['phpgw_info']['server']['db_persistent'])
					{
						//$this->Link_ID = ora_plogon("$User/$Password@$Database","");
						//$this->Link_ID = oci_connect('hr', 'hrpwd',  '//localhost/XE');
						//$this->Link_ID = ora_plogon("$User/$Password@$Database","");
						/************** (comment by SSilk)
						this dosn't work on my system:
						$this->Link_ID = ora_plogon("$User@$Database.world","$Password");
						***************/
					}
					else
					{
						//$this->Link_ID = ora_logon("$User/$Password@$Database","");
						//$this->Link_ID = OCILogon ("$User/$Password@$Database","");
						$this->Link_ID = oci_connect($this->User, $this->Password,  '//'.$this->Host.'/XE');
						/************** (comment by SSilk)
						this dosn't work on my system:
						$this->Link_ID=ora_logon("$User@$Database.world","$Password");
						***************/
					}
				}
				else
				{
					if($this->Debug)
					{
						printf("<br />connect() $User, $Password <br />\n");
					}
					if($GLOBALS['phpgw_info']['server']['db_persistent'])
					{
						$this->Link_ID=ora_plogon("$User","$Password");
						/* (comment by SSilk: don't know how this could work, but I leave this untouched!) */
					}
					else
					{
						$this->Link_ID=ora_logon("$User","$Password");
					}
				}
				if($this->Debug)
				{
					printf("<br />connect() Link_ID: $this->Link_ID<br />\n");
				}
				if (!$this->Link_ID)
				{
					$this->halt('connect() Link-ID == false '
						. "($this->Link_ID), ora_".($GLOBALS['phpgw_info']['server']['db_persistent']?'p':'').'logon failed');
				}
				else
				{
					
					//echo 'commit on<p>';
					oci_commit($this->Link_ID);
					//ora_commiton($this->Link_ID);
				}
				if($this->Debug)
				{
					printf("<br />connect() Obtained the Link_ID: $this->Link_ID<br />\n");
				}
			}
		}

        /**
        * Execute a query
        *
        * @param string $Query_String the query to be executed
        * @param mixed $line the line method was called from - use __LINE__
        * @param string $file the file method was called from - use __FILE__
        * @return integer Current result if sucesful and null if failed
		* @internal In order to increase the # of cursors per system/user go edit the
		* @internal init.ora file and increase the max_open_cursors parameter. Yours is on
		* @internal the default value, 100 per user.
		* @internal We tried to change the behaviour of query() in a way, that it tries
		* @internal to safe cursors, but on the other side be carefull with this, that you
		* @internal don't use an old result.
		* @internal You can also make extensive use of ->disconnect()!
		* @internal The unused QueryIDs will be recycled sometimes.
        */
		function do_query($Query_String, $line = '', $file = '')
		{
			/* No empty queries, please, since PHP4 chokes on them. */
			if ($Query_String == '')
			{
				/* The empty query string is passed on from the constructor,
				* when calling the class without a query, e.g. in situations
				* like these: '$db = new DB_Sql_Subclass;'
				*/
				return 0;
			}

			//PARSE ALL FUNCTIONS RELATED TO ORACLE/MYSQL
			if (strpos($Query_String , "NOW()"))
				$Query_String = str_replace('NOW()', 'systimestamp' , $Query_String);
			if (strpos($Query_String , "SUBSTRING("))
				$Query_String = str_replace('SUBSTRING(', 'SUBSTR(' , $Query_String);
			if (strpos($Query_String , "IFNULL("))
				$Query_String = str_replace('IFNULL(', 'NVL(' , $Query_String);
			if (strpos($Query_String , "LIMIT"))
			{
				preg_match('/LIMIT [0-9]*[ ]*,[ ]*[0-9]*/', $Query_String, $matches);
				preg_match('/ [0-9]*[ ]*,/', $matches[0], $number_matches);
				$start = substr($number_matches[0] , 0 , strlen($number_matches[0] ) - 1);
				preg_match('/,[ ]*[0-9]*/', $matches[0], $number_matches);
				$end = substr($number_matches[0] , 1);

				$Query_String = str_replace($matches[0] , '' , $Query_String);
				$Query_String = '
								select * 
							      from ( select a.*, rownum rnum
								       from ( '.$Query_String.' ) a
								      where rownum <= '.($end + $start).' )
							     where rnum > '.$start;
			echo $Query_String.'<br>';
			}
			
			$this->connect();
			$this->lastQuery=$Query_String;


			/*
			if (!$this->Query_ID)
			{
				//$this->Query_ID = oci_parse() oci_open($this->Link_ID);
				$this->Query_ID = ora_open($this->Link_ID);
			}
			*/
			
			if($this->Debug)
			{
				printf("Debug: query = %s<br />\n", $Query_String);
				printf("<br />Debug: Query_ID: %d<br />\n", $this->Query_ID);
			}

			$this->Query_ID = oci_parse($this->Link_ID,$Query_String);
			if (!$this->Query_ID)
			{
				$this->Errno=oci_error($this->Query_ID);
				$this->Error=oci_error($this->Query_ID);
				$this->halt("<br />ora_parse() failed :<br />$Query_String<br /><small>Snap & paste this to sqlplus!</SMALL>");
			}

			if (!@oci_execute($this->Query_ID))
			{
				$this->Errno=oci_error($this->Query_ID);
				echo 'File : '.$file.'<br>';
				echo 'Line : '.$line.'<br>';
				echo 'Query : '.$Query_String.'<br>';
				echo 'Erro code : '.$this->Errno["code"].'<br>';
				echo 'Erro code : '.$this->Errno["message"].'<br>';
				die;
			}

			$this->Row=0;

			//verifica se foi uma query de selecao ou de inclusao/exclusao
			//seta a variavel de num_rows de acordo
			if (oci_num_rows($this->Query_ID) != 0)
			{
				$this->num_rows = oci_num_rows($this->Query_ID);
			} else {
				//aproveita e passa o resultado do recordset para o array de rs
				//nextrecord vai pegar desse rs e não do link da conexao
				$this->num_rows = oci_fetch_all($this->Query_ID, $this->rs);
			}

			if(!$this->Query_ID)
			{
				$this->halt('Invalid SQL: '.$Query_String);
			}

			return $this->Query_ID;
		}

        /**
         * Move to the next row in the results set
         *
         * @return boolean was another row found?
         */
		function next_record()
		{

			//alteração feita para pegar os valores direto do
			//objeto de rs populado antes na execucao da query

			foreach ($this->rs as $key => $val)
			{
				$this->Record[$key] = $this->rs[$key][$this->Row];
			}
			$this->Row++;
			return 1;
			die;
			
			
			if (!$this->no_next_fetch && 
				0 == oci_fetch($this->Query_ID))
			{
				if ($this->Debug)
				{
					printf("<br />next_record(): ID: %d,Rows: %d<br />\n",
					$this->Query_ID,$this->num_rows());
				}
				$this->Row +=1;

				$errno=ora_errorcode($this->Query_ID);
				if(1403 == $errno)
				{ # 1043 means no more records found
					$this->Errno = 0;
					$this->Error = '';
					$this->disconnect();
					$stat=0;
				}
				else
				{
					$this->Error=ora_error($this->Query_ID);
					$this->Errno=$errno;
					if($this->Debug)
					{
						printf('<br />%d Error: %s',
						$this->Errno,
						$this->Error);
					}
					$stat=0;
				}
			}
			else
			{
				$this->no_next_fetch=false;
				for($ix=0;$ix<oci_num_fields($this->Query_ID);$ix++)
				{
					$col=strtolower(oci_field_name($this->Query_ID,$ix));
					$value=oci_result($this->Query_ID,$ix);
					$this->Record[ "$col" ] = $value;
				}
				$stat=1;
			}
			return $stat;
		}

		/**
        * Move to position in result set
        *
        * @param integer $pos Required row (optional), default first row
        * @return integer 1 if sucessful or 0 if not found
		* @internal seek() works only for $pos - 1 and $pos
		* @internal Perhaps I make a own implementation, but my
		* @internal opinion is, that this should be done by PHP3
        */
		function seek($pos)
		{
			if($this->Row - 1 == $pos)
			{
				$this->no_next_fetch=true;
			}
			elseif ($this->Row == $pos )
			{
				## do nothing
			}
			else
			{
				$this->halt("Invalid seek(): Position is cannot be handled by API.<br />".
				"Difference too big. Wanted: $pos Current pos: $this->Row");
			}
			if($Debug)
			{
				echo "<br />Debug: seek = $pos<br />";
			}
			$this->Row=$pos;
		}

        /**
         * Lock a table
         *
         * @param string $table name of table to lock
         * @param string $mode type of lock required (optional), default write
         * @return boolean True if sucessful, False if failed
         */
		function lock($table, $mode = 'write')
		{
			if ($mode == 'write')
			{
				$result = ora_do($this->Link_ID, "lock table $table in row exclusive mode");
			}
			else
			{
				$result = 1;
			}
			return $result;
		}

        /**
         * Unlock a table
         *
         * @return boolean True if sucessful, False if failed
         */
		function unlock()
		{
			return ora_do($this->Link_ID, 'commit');
		}

        /**
         * Get description of a table
         *
         * @param string $table name of table to describe
         * @param boolean $full optional, default False summary information, True full information
         * @return array Table meta data
         */
		function metadata($table,$full=false)
		{
			$count = 0;
			$id    = 0;
			$res   = array();

			/*
			* Due to compatibility problems with Table we changed the behavior
			* of metadata();
			* depending on $full, metadata returns the following values:
			*
			* - full is false (default):
			* $result[]:
			*	 [0]['table']	table name
			*	 [0]['name']	 field name
			*	 [0]['type']	 field type
			*	 [0]['len']		field length
			*	 [0]['flags']	field flags ('NOT NULL', 'INDEX')
			*	 [0]['format'] precision and scale of number (eg. '10,2') or empty
			*	 [0]['index']	name of index (if has one)
			*	 [0]['chars']	number of chars (if any char-type)
			*
			* - full is true
			* $result[]:
			*	 ['num_fields'] number of metadata records
			*	 [0]['table']	table name
			*	 [0]['name']	 field name
			*	 [0]['type']	 field type
			*	 [0]['len']		field length
			*	 [0]['flags']	field flags ('NOT NULL', 'INDEX')
			*	 [0]['format'] precision and scale of number (eg. '10,2') or empty
			*	 [0]['index']	name of index (if has one)
			*	 [0]['chars']	number of chars (if any char-type)
			*	 ['meta'][field name]	index of field named 'field name'
			*	 The last one is used, if you have a field name, but no index.
			*	 Test:	if (isset($result['meta']['myfield'])) {} ...
			*/

			$this->connect();

			## This is a RIGHT OUTER JOIN: '(+)', if you want to see, what
			## this query results try the following:
			## $table = new Table; $db = new my_DB_Sql; # you have to make
			## # your own class
			## $table->show_results($db->query(see query vvvvvv))
			##
			$this->query("SELECT T.table_name,T.column_name,T.data_type,".
				"T.data_length,T.data_precision,T.data_scale,T.nullable,".
				"T.char_col_decl_length,I.index_name".
				" FROM ALL_TAB_COLUMNS T,ALL_IND_COLUMNS I".
				" WHERE T.column_name=I.column_name (+)".
				" AND T.table_name=I.table_name (+)".
				" AND T.table_name=UPPER('$table') ORDER BY T.column_id");

			$i=0;
			while ($this->next_record())
			{
				$res[$i]['table'] = $this->Record[table_name];
				$res[$i]['name']  = strtolower($this->Record[column_name]);
				$res[$i]['type']  = $this->Record[data_type];
				$res[$i]['len']   = $this->Record[data_length];
				if ($this->Record[index_name])
				{
					$res[$i]['flags'] = 'INDEX ';
				}
				$res[$i]['flags'] .= ( $this->Record['nullable'] == 'N') ? '' : 'NOT NULL';
				$res[$i]['format']= (int)$this->Record['data_precision'].','.
				(int)$this->Record[data_scale];
				if ('0,0'==$res[$i]['format'])
				{
					$res[$i]['format']='';
				}
				$res[$i]['index'] = $this->Record[index_name];
				$res[$i]['chars'] = $this->Record[char_col_decl_length];
				if ($full)
				{
					$j=$res[$i]['name'];
					$res['meta'][$j] = $i;
					$res['meta'][strtoupper($j)] = $i;
				}
				if ($full)
				{
					$res['meta'][$res[$i]['name']] = $i;
				}
				$i++;
			}
			if ($full)
			{
				$res['num_fields']=$i;
			}
			# $this->disconnect();
			return $res;
		}

        /**
        * Get the number of rows affected by last update
        *
        * @return integer number of affected rows
		* @internal THIS FUNCTION IS UNSTESTED!
        */
		function affected_rows()
		{
			if ($Debug)
			{
				echo '<br />Debug: affected_rows='. ora_numrows($this->Query_ID).'<br />';
			}
			return ora_numrows($this->Query_ID);
		}

        /**
        * Number of rows in current result set
        *
        * @return integer number of rows
		* @internal Known bugs: It will not work for SELECT DISTINCT and any
		* @internal other constructs which are depending on the resulting rows.
		* @internal So you *really need* to check every query you make, if it
		* @internal will work with it.
		* @internal Also, for a qualified replacement you need to parse the
		* @internal selection, cause this will fail: 'SELECT id, from FROM ...').
		* @internal 'FROM' is - as far as I know a keyword in Oracle, so it can
		* @internal only be used in this way. But you have been warned.
        */
		function num_rows()
		{
			return $this->num_rows;
			
			$curs=ora_open($this->Link_ID);

			## this is the important part and it is also the HACK!
			if (eregi("^[[:space:]]*SELECT[[:space:]]",$this->lastQuery) )
			{
				$from_pos = strpos(strtoupper($this->lastQuery),'FROM');
				$q = 'SELECT count(*) '. substr($this->lastQuery, $from_pos);

				ORA_parse($curs,$q);
				ORA_exec($curs);
				ORA_fetch($curs);
				if ($Debug)
				{
					echo '<br />Debug: num_rows='. ORA_getcolumn($curs,0).'<br />';
				}
				return(ORA_getcolumn($curs,0));
			}
			else
			{
				$this->halt("Last Query was not a SELECT: $this->lastQuery");
			}
		}

        /**
         * Number of fields in current row
         *
         * @return integer number of fields
         */
		function num_fields()
		{
			if ($Debug)
			{
				echo '<br />Debug: num_fields='. ora_numcols($this->Query_ID) . '<br />';
			}
			//return ora_numcols($this->Query_ID);
			return oci_num_fields($this->Query_ID);
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

			/* Independent Query_ID */
			$Query_ID = ora_open($this->Link_ID);

			if(!@ora_parse($Query_ID,"SELECT $seq_name.NEXTVAL FROM DUAL")) 
			{
				// There is no such sequence yet, then create it
				if(!@ora_parse($Query_ID,"CREATE SEQUENCE $seq_name") ||
					!@ora_exec($Query_ID))
				{
					$this->halt('<br /> nextid() function - unable to create sequence');
					return 0;
				}
				@ora_parse($Query_ID,"SELECT $seq_name.NEXTVAL FROM DUAL");
			} 
			if (!@ora_exec($Query_ID))
			{
				$this->halt("<br />ora_exec() failed:<br />nextID function");
			}
			if (@ora_fetch($Query_ID) )
			{
				$next_id = ora_getcolumn($Query_ID, 0);
			}
			else
			{
				$next_id = 0;
			}
			if ( Query_ID > 0 )
			{
				ora_close(Query_ID);
			}
			return $next_id;
		}

		/**
		 * Disconnect database connection
		 *
		 * This only affects systems not using persistant connections 
		 * @return integer 1: ok; 0: not possible/already closed
		 */
		function disconnect()
		{
			if($this->Debug)
			{
				echo "Debug: Disconnecting $this->Query_ID...<br />\n";
			}
			if ( $this->Query_ID < 1 )
			{
				echo "<B>Warning</B>: disconnect(): Cannot free ID $this->Query_ID\n";
				# return();
			}
			ora_close($this->Query_ID);
			$this->Query_ID=0;
		}

        /**
        * Error handler
        *
        * @param string $msg error message
        * @param integer $line line of calling method/function (optional)
        * @param string $file file of calling method/function (optional)
		* @access private
        */
		function halt($msg)
		{
			if ($this->Halt_On_Error == 'no')
			{
				return;
			}

			$this->haltmsg($msg);

			if ($this->Halt_On_Error != 'report')
			{
				die('Session halted.');
			}
		}

        /** 
         * Display database error
         *
         * @param string $msg Error message
         */
		function haltmsg($msg)
		{
			printf("<b>Database error:</b> %s<br />\n", $msg);
			printf("<b>Oracle Error</b>: %s (%s)<br />\n",
			$this->Errno,
			$this->Error);
		}

        /**
         * Get a list of table names in the current database
         *
         * @return array List of the tables
         */
		function table_names()
		{
			$this->connect();
			$this->query('SELECT table_name,tablespace_name FROM user_tables');
			$i=0;
			while ($this->next_record())
			{
				$info[$i]['table_name']      = strtolower($this->Record['table_name']);
				$info[$i]['tablespace_name'] = $this->Record['tablespace_name'];
				$i++;
			} 
			return $info;
		}

	
		function f($Name, $strip_slashes = False)
		{
			$Name = strtoupper($Name);
			if ($strip_slashes || ($this->auto_stripslashes && ! $strip_slashes))
			{
				return stripslashes($this->Record[$Name]);
			}
			else
			{
				return $this->Record[$Name];
			}
		}
	
		function field_name($field_index)
		{
			//echo 'Field Index : '.$field_index.' - '.oci_field_name($this->Query_ID , $field_index).'<br>';
			return @oci_field_name($this->Query_ID , $field_index);
			//return @mysql_field_name($this->Query_ID , $field_index);
			//return $this->mysql_field_name($field_index);
		}
	
	}
