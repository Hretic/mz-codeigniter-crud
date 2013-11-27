<?php
	class TUBADBENGINE {
		private $db_type = "";// MYSQL / POSTGRESQL / MSSQL / MSACCESS
		private $db_ip = "";
		private $db_un = "";
		private $db_pw = "";
		private $db_name = "";
		private $db_connectionstring = "";
		private $connector = "";
		private $connected = false;
		private $result = "";
		private $totalrows = 0;
		private $totalfields = 0;
		private $position = 0;
		private $lasterror = "";
		private $selectsql = "";
		private $commandsql = "";
		private $insert_id = "";
		

		function TUBADBENGINE($v1 , $v2 , $v3 , $v4 , $v5 , $v6) {
			$this->db_type = $v1;
			$this->db_ip = $v2;
			$this->db_un = $v3;
			$this->db_pw = $v4;
			$this->db_name = $v5;
			$this->db_connectionstring = $v6;
			$this->Connect();
		}
		
		function Connect() {
			if ($this->db_type == "MYSQL") {
				$this->connector = mysql_connect($this->db_ip , $this->db_un , $this->db_pw);
				if ($this->connector) {
					$temp = mysql_select_db($this->db_name);
					if (!$temp) {
						$this->connected = false;
					} else {
						$this->connected = true;
					}
				} else {
					$this->connected = false;
				}
				$this->lasterror = mysql_error();
				
			} else if ($this->db_type == "POSTGRE") {
			} else if ($this->db_type == "MSSQL") {
			} else if ($this->db_type == "MSACCESS") {
			}

		}
		
		function IsConnected() {
			return $this->connected;
		}
		
		function Command($SQL) {
			if (!$this->connected) { 
				die("Not conencted to database !");
				exit();
			}
			$this->commandsql = $SQL;
			$command = mysql_query($SQL , $this->connector);
			$this->lasterror = mysql_error();
			if ($command) {
				if (strtolower(substr($SQL , 0 , 6)) == "insert") {
					$this->insert_id = mysql_insert_id();
				}
				return true;
			} else {
				return false;
			}
		}
		
		function GetLID() {
			return $this->insert_id;
		}
		
		function Select($SQL) {
			if (!$this->connected) { 
				die("Not conencted to database !");
				exit();
			}
			$this->selectsql = $SQL;
			$this->result = mysql_query($SQL , $this->connector);
			$this->lasterror = mysql_error();
			if ($this->result) {
				$this->totalrows = mysql_num_rows($this->result);
				$this->totalfields = count(mysql_fetch_row($this->result));
				$this->position = -1;
				return true;
			} else {
				$this->totalrows = 0;
				return false;
			}
		}
		
		function Refresh() {
			if (!$this->connected) { 
				die("Not conencted to database !");
				exit();
			}
			if ($this->selectsql == "") {
				die("NO Select command !");
				exit();
			}
			$SQL = $this->selectsql;
			$this->result = mysql_query($SQL , $this->connector);
			$this->lasterror = mysql_error();
			if ($this->result) {
				$this->totalrows = mysql_num_rows($this->result);
				$this->totalfields = count(mysql_fetch_row($this->result));
				$this->position = -1;
				return true;
			} else {
				$this->totalrows = 0;
				return false;
			}
		}
		
		function Count() {
			return $this->totalrows;
		}
		
		function First($field_id = -1) {
			if ($this->totalrows > 0) {
				$this->position = 0;
				if ($field_id == -1) {
					for ($i = 0 ; $i < $this->totalfields ; $i++) {
						$temp[$i] = mysql_result($this->result , $this->position , $i);
					}
					return $temp;
				} else {
					if ($field_id < $this->totalfields) {
						return mysql_result($this->result , $this->position , $field_id);
					} else {
						die("Field number is not in list !");
					}
				}
			} else {
				die("No record available !");
			}
		}
		

		function Next($field_id = -1) {
			if (($this->totalrows - 1) > $this->position) {
				$this->position++;
				if ($field_id == -1) {
					for ($i = 0 ; $i < $this->totalfields ; $i++) {
						$temp[$i] = mysql_result($this->result , $this->position , $i);
					}
					return $temp;
				} else {
					if ($field_id < $this->totalfields) {
						return mysql_result($this->result , $this->position , $field_id);
					} else {
						die("Field number is not in list !");
					}
				}
			} else {
				die("No record available !");
			}
		}

		function Prev($field_id = -1) {
			if ($this->position > 0) {
				$this->position--;
				if ($field_id == -1) {
					for ($i = 0 ; $i < $this->totalfields ; $i++) {
						$temp[$i] = mysql_result($this->result , $this->position , $i);
					}
					return $temp;
				} else {
					if ($field_id < $this->totalfields) {
						return mysql_result($this->result , $this->position , $field_id);
					} else {
						die("Field number is not in list !");
					}
				}
			} else {
				die("No record available !");
			}
		}
		
		function Last($field_id = -1) {
			if ($this->totalrows > 0) {
				$this->position = $this->totalrows - 1;
				if ($field_id == -1) {
					for ($i = 0 ; $i < $this->totalfields ; $i++) {
						$temp[$i] = mysql_result($this->result , $this->position , $i);
					}
					return $temp;
				} else {
					if ($field_id < $this->totalfields) {
						return mysql_result($this->result , $this->position , $field_id);
					} else {
						die("Field number is not in list !");
					}
				}
			} else {
				die("No record available !");
			}
		}
		
		function GoToRec($pos = 0 , $field_id = -1) {
			if (($pos >= 0) && ($pos < $this->totalrows)) {
				$this->position = $pos;
				if ($field_id == -1) {
					for ($i = 0 ; $i < $this->totalfields ; $i++) {
						$temp[$i] = mysql_result($this->result , $this->position , $i);
					}
					return $temp;
				} else {
					if ($field_id < $this->totalfields) {
						return mysql_result($this->result , $this->position , $field_id);
					} else {
						die("Field number is not in list !");
					}
				}
			} else {
				die("No record available !");
			}
		}
		
		function Current($field_id = -1) {
			if ($this->totalrows > 0) {
				if ($field_id == -1) {
					for ($i = 0 ; $i < $this->totalfields ; $i++) {
						$temp[$i] = mysql_result($this->result , $this->position , $i);
					}
					return $temp;
				} else {
					if ($field_id < $this->totalfields) {
						return mysql_result($this->result , $this->position , $field_id);
					} else {
						die("Field number is not in list !");
					}
				}
			} else {
				die("No record available !");
			}
		}
		
		function Lasterror() {
			return $this->lasterror;
		}
		
		
		
	}


?>
