<?php
error_reporting(E_ERROR);
session_start();
ini_set('default_charset', 'UTF-8');

define("DB_PDO_DSN", "mysql:host=localhost;dbname=phpwafr");
define("DB_PDO_USER", "root");
define("DB_PDO_PASSWORD", "root");






// limpa filtro
if ($_GET["clear"] == 1) {
	$_SESSION["sWhere"] = "";
	$_SESSION["sMensagemWhere"] = "";
}


// Classes ////////////////////////////////////////////////////////////////////////////////////////////////

class Security {
	public static function verify($level = "") {
		$ok = true;
		if (!$_SESSION["sis_logado"]) {
			$ok = false;
		}
		if (intval($_SESSION["sis_usuario_nivel"]) < intval($level)) {
			$ok = false;
		}
		if (!$ok) {
			$result["redirect"] = 1;
			echo json_encode($result);
			exit;
		}
	}
}

class DBH extends PDO {

	private $error;
	private $sql;
	private $bind;
	private $errorCallbackFunction;
	private $errorMsgFormat;

	public function __construct($dsn = DB_PDO_DSN, $user = DB_PDO_USER , $passwd = DB_PDO_PASSWORD) {
		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		try {
			parent::__construct($dsn, $user, $passwd, $options);
			$this->query("SET NAMES utf8");
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}
	}

	private function debug() {
		if (!empty($this->errorCallbackFunction)) {
			$error = array("Error" => $this->error);
			if (!empty($this->sql))
				$error["SQL Statement"] = $this->sql;
			if (!empty($this->bind))
				$error["Bind Parameters"] = trim(print_r($this->bind, true));

			$backtrace = debug_backtrace();
			if (!empty($backtrace)) {
				foreach ($backtrace as $info) {
					if ($info["file"] != __FILE__)
						$error["Backtrace"] = $info["file"] . " at line " . $info["line"];
				}
			}

			$msg = "";
			if ($this->errorMsgFormat == "html") {
				if (!empty($error["Bind Parameters"]))
					$error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
				$css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
				$msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
				$msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
				foreach ($error as $key => $val)
					$msg .= "\n\t<label>" . $key . ":</label>" . $val;
				$msg .= "\n\t</div>\n</div>";
			}
			elseif ($this->errorMsgFormat == "text") {
				$msg .= "SQL Error\n" . str_repeat("-", 50);
				foreach ($error as $key => $val)
					$msg .= "\n\n$key:\n$val";
			}

			$func = $this->errorCallbackFunction;
			$func($msg);
		}
	}

	public function delete($table, $where, $bind = "") {
		$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
		$this->run($sql, $bind);
	}

	private function filter($table, $info) {
		$driver = $this->getAttribute(PDO::ATTR_DRIVER_NAME);
		if ($driver == 'sqlite') {
			$sql = "PRAGMA table_info('" . $table . "');";
			$key = "name";
		} elseif ($driver == 'mysql') {
			$sql = "DESCRIBE " . $table . ";";
			$key = "Field";
		} else {
			$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
			$key = "column_name";
		}

		if (false !== ($list = $this->run($sql))) {
			$fields = array();
			foreach ($list as $record)
				$fields[] = $record[$key];
			return array_values(array_intersect($fields, array_keys($info)));
		}
		return array();
	}

	private function cleanup($bind) {
		if (!is_array($bind)) {
			if (!empty($bind))
				$bind = array($bind);
			else
				$bind = array();
		}
		return $bind;
	}

	public function insert($table, $info) {
		$fields = $this->filter($table, $info);
		$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
		$bind = array();
		foreach ($fields as $field)
			$bind[":$field"] = $info[$field];
		return $this->run($sql, $bind);
	}

	public function run($sql, $bind = "") {
		$this->sql = trim($sql);
		$this->bind = $this->cleanup($bind);
		$this->error = "";

		try {
			$pdostmt = $this->prepare($this->sql);
			if ($pdostmt->execute($this->bind) !== false) {
				if (preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql))
					return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
				elseif (preg_match("/^(" . implode("|", array("delete", "insert", "update")) . ") /i", $this->sql))
					return $pdostmt->rowCount();
			}
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			$this->debug();
			return false;
		}
	}

	public function select($table, $where = "", $bind = "", $fields = "*") {
		$sql = "SELECT " . $fields . " FROM " . $table;
		if (!empty($where))
			$sql .= " WHERE " . $where;
		$sql .= ";";
		return $this->run($sql, $bind);
	}

	public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat = "html") {
		//Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
		if (in_array(strtolower($errorCallbackFunction), array("echo", "print")))
			$errorCallbackFunction = "print_r";

		if (function_exists($errorCallbackFunction)) {
			$this->errorCallbackFunction = $errorCallbackFunction;
			if (!in_array(strtolower($errorMsgFormat), array("html", "text")))
				$errorMsgFormat = "html";
			$this->errorMsgFormat = $errorMsgFormat;
		}
	}

	public function update($table, $info, $where, $bind = "") {
		$fields = $this->filter($table, $info);
		$fieldSize = sizeof($fields);

		$sql = "UPDATE " . $table . " SET ";
		for ($f = 0; $f < $fieldSize; ++$f) {
			if ($f > 0)
				$sql .= ", ";
			$sql .= $fields[$f] . " = :update_" . $fields[$f];
		}
		$sql .= " WHERE " . $where . ";";

		$bind = $this->cleanup($bind);
		foreach ($fields as $field)
			$bind[":update_$field"] = $info[$field];

		return $this->run($sql, $bind);
	}

	// chamadas estáticas


	public static function getRows($sql, $qtde=300) {
		$db = new DBH();
		$rows = $db->query($sql . " limit $qtde")->fetchAll(PDO::FETCH_OBJ);
		$db->debug();
		$db = null;
		return $rows;
	}

	public static function getRow($sql) {
		$db = new DBH();
		$row = $db->query($sql)->fetch();
		$db = null;
		return $row;
	}

	public static function getColumn($sql) {
		$db = new DBH();
		$value = $db->query($sql)->fetchColumn(0);
		$db = null;
		return $value;
	}

}

class Where {
	private $where;
	private $mensagens;
	
	public function Where() {
		$this->where = "";
		$this->mensagens = "";
	}
	
	public function add($msg, $expr, $valor, $criterio) {
		if ($criterio) {
			$this->mensagens .= "<li>".str_replace("'","´",str_replace("*",$valor,$msg))."</li>";
			$this->where .= " ".str_replace("*",$valor,$expr);
		}
	}

	public function handleWhere() {
		if ($_POST["executed"] == "s") {
			$_SESSION["sWhere"] = $this->where;
			if (strlen($this->mensagens)>0) {
				$_SESSION["sMensagemWhere"] = "<ul>".$this->mensagens."</ul>";	
			} else {
				$_SESSION["sMensagemWhere"] = "";
			}
			
		}
	}
	
	public static function getWhere() {
		return " " . $_SESSION["sWhere"] . " ";
	}
	
	public static function getMensagemFiltro() {
		return $_SESSION["sMensagemWhere"]."";
	}

}

class Error { 

	private $strError;
	private $count;

	public function add($error = '') {
		$this->strError .= "<li>" . $error . "</li>";
		$this->count++;
	}

	public function hasError() {
		return $this->count > 0;
	}

	public function toString() {
		if ($this->count > 0) {
			return "<ul>" . $this->strError . "</ul>";
		} else {
			return "";
		}
	}

}

class DBVal {

	public static function checkFK($table, $key, $val) {
		if (strlen($val)==0) return false;
		$sql = "SELECT count($key) FROM $table WHERE $key IN ($val)";
		$qt = DBH::getColumn($sql);
		return ($qt > 0);
	}

	public static function isDuplicated($tabela, $campo_valor, $key_field, $value, $chave = "") {
		$return = false;
		if (strlen($value)) {
			$iCount = 0;
			if ($chave == "") {
				$iCount = DBH::getColumn("SELECT count(*) AS qtde FROM $tabela WHERE $campo_valor='$value'");
			} else {
				$iCount = DBH::getColumn("SELECT count(*) AS qtde FROM $tabela WHERE $campo_valor='$value' AND NOT ($key_field=$chave)");
			}
			if ($iCount > 0)
				$return = true;
		}
		return $return;
	}

}

class Validation {

	public static function date($data) {
		$result = false;
		if (strlen($data)!=10) return false;
		$aData = explode("/", $data);
		$d = $aData[0];
		$m = $aData[1];
		$y = $aData[2];
		$result = checkdate($m, $d, $y);
		return $result;
	}
}

class Dates {

	public static function format($data) {
		return implode(preg_match("~\/~", $data) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data) == 0 ? "-" : "/", $data)));
	}
	
	public static function addDays($date, $nDays) {
		if (!isset($nDays)) {
			$nDays = 1;
		}
		$aVet = Explode("/", $date);
		return date("d/m/Y", mktime(0, 0, 0, $aVet[1], $aVet[0] + $nDays, $aVet[2]));
	}

}
