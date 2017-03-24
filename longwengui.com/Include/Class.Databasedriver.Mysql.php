<?php
/*
 范例:
 $db = new DatabaseDriver_MySql(
 array(
 'host' => 'localhost',
 'username' => 'root',
 'password' => 'wushuang',
 'charset' => 'utf-8',
 'pconnect' => true,
 'dbname' => 'db_uc_test'
 )
 );

 echo $db->insertArray('test', array('username'=>'necylus', 'email'=>'necylus@126.com'), true);
 echo $db->delete('delete from test where userid=1');
 echo $db->updateArray('test', array('username'=>'无双'), array('email'=>'kylelees@126.com'));
 print_r($db->getone('select * from test'));
 print_r($db->select('select * from test',0, 100));

 */
!defined('NL_SUCCEED') && define('NL_SUCCEED', '99999');
!defined('NL_FAILED') && define('NL_FAILED', '-99999');
!defined('NL_NULL') && define('NL_NULL', '-88888');
!defined('NL_NOCACHE') && define('NL_NOCACHE', '-77777');

class DatabaseDriver_MySql {
	public $connect=null;
	public $option = array();
	public $status = null;
	public $server_version = '';
	public $table_pre='';
	public $version = '';
	public $querycounts = 0;
	public $autocommit = true;
	public $sql =null;
	public $new_link=false;
	const SUCCESS = 999999;
	const FAILED = -999999;
	/**
	 * @desc  初始化目标数据库参数
	 *  array(
	 * 		'host' => '主机',
	 * 		'port' => 'mysql端口',
	 * 		'username' => 'mysql用户',
	 * 		'password' => 'mysql用户密码',
	 * 		'charset' =>'目标数据库字符集',
	 * 		'pconnect' =>'是否开启持久性连接数据库',
	 * 		'dbname' => '数据库名称'
	 * 	)
	 * @param array $option
	 */
	public function __construct($option = array()) {
		$this->option ['host'] = $option ['host'].':'.($option['port']?$option['port']:'3306');
		$this->option ['username'] = substr($option ['username'],0,16);
		$this->option ['password'] = $option ['password'];
		$this->option ['charset'] = $option ['charset'] ? str_replace ( '-', '', $option ['charset'] ) : 'utf8';
		$this->option ['pconnect'] = $option ['pconnect'] ? 1 : 0;
		$this->option ['dbname'] = substr($option ['dbname'],0,16);
		foreach ($option as $key => $value){
			$this->$key = $value;
		}
		return $this->init();
	}
	public function __destruct(){
		mysql_close($this->connect);
	}
	/**
	 * @desc  连接数据库函数
	 * 但无须编码开启数据库接连，在操作前会判断当前连接将自动运行该函数;
	 * @return int 返回类常量成功或失败, 如果连接数据失败,将直接终止进程;
	 */
	private function init() {
		if(!$this->option['pconnect'])
		$this->connect = mysql_connect($this->option['host'], $this->option['username'], $this->option['password'],$this->new_link);
		else
		$this->connect = mysql_pconnect($this->option['host'], $this->option['username'], $this->option['password'],$this->new_link);
		if(!$this->connect){
			$this->halt();
		}
		if(!$this->select_db($this->option['dbname'])){
			$this->halt();
		}
		$this->status = true;
		$this->server_version = $version = $this->server_version();
		$charset = $this->option['charset'];
		if($version > '4.1'){
			$sql = "SET character_set_connection={$charset}, character_set_results={$charset}, character_set_client=binary";
		}
		if($version > '5.0.1')
		$sql .=", sql_mode=''";
		$this->query($sql);
		return $this->connect;
	}
	public function select_db($dbname){
		return mysql_select_db($dbname, $this->connect);
	}
	public function error(){
		return ($this->connect ? mysql_error($this->connect) : mysql_error());
	}
	public function errno() {
		return (($this->connect) ? mysql_errno($this->connect) : mysql_errno());
	}
	public function server_version(){
		if(empty($this->server_version)) {
			$this->server_version = mysql_get_server_info($this->connect);
		}
		return $this->server_version;
	}
	public function test(){
		$this->connect = mysql_connect($this->option['host'], $this->option['username'], $this->option['password']);
		if($this->connect)
		return self::SUCCESS;
		else
		return self::FAILED;
	}

	private function status(){
		if(!$this->status)
		return $this->init();
		else
		return NL_FAILED;
	}
	public function query($sql){
		$this->sql = $sql;
		$query = mysql_query($sql, $this->connect) or $this->halt();
		$this->querycounts++;
		return $query;
	}
	public function free_result($result){
		return mysql_free_result($result);
	}
	/**
	 * @desc   获取指定的SQL查询第一条结果
	 * @param  string $sql
	 * @return array or int
	 */
	public function getone($sql){
		if (!strstr(strtolower($sql),"limit")) {
			$sql.=" limit 0,1";
		}
		$result = $this->query($sql);
		if($result){
			$r = mysql_fetch_assoc($result);
			$this->free_result($result);
			return $r;
		}
		else
		return false;
	}

	/**
	 * @desc   查询sql语句并获取结果,并以数组形式返回
	 * @param  string $sql	SQL语句
	 * @param  int $limit_row_offset  记录起始号
	 * @param  int  $limit_row_count	 记录数
	 * @return array or int
	 */
	public function select($sql, $limit_row_offset=null, $limit_row_count=null, $rowid=false){
		$limit_row_offset = intval($limit_row_offset);
		$limit_row_count = intval($limit_row_count);
		if(!strstr($sql, 'limit')&& $limit_row_count){
			$sql .= " limit ". $limit_row_offset.",". $limit_row_count;
		}
		$result=$this->query($sql);
		if ($result) {
			$i = 1;
			while ($rows = mysql_fetch_assoc($result)){
				if($rowid) $rows['__rowid__'] = $i;
				$rowdatas[] = $rows;
				$i++;
			}
			$this->free_result($result);
			return $rowdatas;
		}
		$this->free_result($result);
		return false;
	}
	/**
	 * @desc   插入语句函数
	 * @param  string $sql
	 * @param  Booleans $get_last_insertid
	 * @return int
	 */
	public function insert($sql, $get_last_insertid=false){
		$result = $this->query($sql);
		if($result){
			return ($get_last_insertid?$this->lastInsertId():$result);
		}
		else {
			return false;
		}
	}
	public function lastInsertId(){
		return ($id = mysql_insert_id($this->connect)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	public function result($sql, $row = 0) {
		$query = @mysql_result($sql, $row);
		$this->querycounts++;
		return $query;
	}
	/**
	 * @desc   插入数组数据到数据表
	 * @param  string $tablename
	 * @param  array $arrData
	 * @param  booleans $get_last_insertid
	 * @return int
	 */
	public function insertArray($tablename, $arrData, $get_last_insertid=false){
		if(!$tablename || !is_array($arrData) || !count($arrData)){
			return false;
		}
		$sql_field_names = $sql_field_values = null;
		foreach ($arrData as $fieldname => $fieldvalue){
			$sql_field_names  .= '`'.$fieldname.'`,';
			$sql_field_values .= "'{$fieldvalue}',";
		}
		$sql_field_names = substr($sql_field_names, 0, -1);
		$sql_field_values = substr($sql_field_values, 0, -1);
		$sql = "insert into `{$tablename}`({$sql_field_names}) values({$sql_field_values})";
		return $this->insert($sql, $get_last_insertid);
	}

	/**
	 * @desc   执行更新语句
	 * @param  string $sql
	 * @return int 成功将返回更新的记录数
	 */
	public function update($sql){
		return $this->execute($sql);
	}

	/**
	 * @desc   根据条件更新数据
	 * @param  $tablename  表名
	 * @param  $arrData    更新数据
	 * @param  string $where  更新条件
	 * @return bool|int
	 */
	public function updateWhere($tablename, $arrData, $where=''){
		if(!$tablename || !is_array($arrData) || !count($arrData)){
			return false;
		}
		if($where)
		$where = 'where '.$where;
		else
		$where = '';
		$sql_ext = null;
		foreach ($arrData as $fieldname => $fieldvalue){
			$sql_ext .= ($sql_ext ? "," : ""). "`{$fieldname}` = '{$fieldvalue}'";
		}
		$sql = "update `{$tablename}` set {$sql_ext} {$where}";
		$result = $this->update($sql);
		return $result;
	}

	/**
	 * @desc   执行数组形式的更新
	 * @param  string $tablename 表名
	 * @param  array $arrData	数据数组
	 * @param  array $filters 条件语句
	 * @return int 成功将返回更新的记录数
	 */
	public function updateArray($tablename, $arrData, $filters=array()){
		if(!$tablename || !is_array($arrData) || !count($arrData)|| !is_array($filters) || !count($filters)){
			return false;
		}
		if(count($filters))
		$where = $this->filters($filters);
		else
		$where = '';
		$sql_ext = null;
		foreach ($arrData as $fieldname => $fieldvalue){
			$sql_ext .= ($sql_ext ? "," : ""). "`{$fieldname}` = '{$fieldvalue}'";
		}
		$sql = "update `$tablename` set {$sql_ext} {$where}";
		$result = $this->update($sql);
		return $result;
	}

	/**
	 * @desc   开启事务
	 * @return int 失败返回常量FAILED 成功 返回 SUCCESS
	 */
	public function beginTransaction(){
		if(mysql_query("SET AUTOCOMMIT=0", $this->connect)){
			$this->autocommit = false;
			return true;
		}
		else
		return false;
	}

	public function endTransaction(){
		if(mysql_query("SET AUTOCOMMIT=1", $this->connect)){
			$this->autocommit = true;
			return true;
		}
		else
		return false;
	}

	/**
	 * @desc   实施事务
	 * @return int 失败返回常量FAILED 成功 返回 SUCCESS
	 */
	public function commit(){
		if(!$this->autocommit)
		return mysql_query("COMMIT", $this->connect);
		else
		return true;
	}
	/**
	 * @desc   事务回滚, 取消实施
	 * @return int 失败返回常量FAILED 成功 返回 SUCCESS
	 */
	public function rollBack(){
		if(!$this->autocommit)
		return mysql_query("ROLLBACK", $this->connect);
		else {
			return false;
		}
	}
	/**
	 * @desc   自动生成条件语句
	 * @param  array $filters
	 * @return string
	 */
	public function filters($filters){
		$sql_where = '';
		if(is_array($filters)){
			foreach ($filters as $f => $v){
				$f_type = gettype($v);
				if($f_type == 'array'){
					$sql_where .= ($sql_where ? " and ":"")."(`{$f}` ".$v['operator']." '".$v['value']."')";
				}
				elseif ($f_type == 'string')
				$sql_where .= ($sql_where ? " or ":"")."(`{$f}` like '%{$v}%')";
				else{
					$sql_where .= ($sql_where ? " and ":""). "(`{$f}` = '{$v}')";
				}
			}
		}
		elseif(strlen($filters)){
			$sql_where = $filters;
		}
		else
		return '';
		$sql_where = $sql_where ? " where ".$sql_where : '';
		return $sql_where;
	}

	public function multi($recordcount, $page, $pagecount, $pagesize){
		$data['recordcount'] = $recordcount;
		$data['firstpage'] = 1;
		$data['lastpage'] = $pagecount;
		$data['backpage'] = ($page>1) ? $page-1 : 1;
		$data['nextpage'] = ($page<$pagecount) ? $page+1 : $pagecount;
		$data['limit_start'] = ($page-1)*$pagesize+1;
		$data['limit_end'] = $page*$pagesize;
		return $data;
	}
	/**
	 * @desc   执行删除语句专用函数
	 * @param  string $sql
	 * @return int
	 */
	public function delete($sql){
		return $this->execute($sql);
	}

	/**
	 * @desc   执行sql语句
	 * @param  string $sql
	 * @return int
	 */
	public function execute($sql){
		$result = $this->query($sql);
		$syntax = strtolower(substr($sql, 0, strpos($sql, ' ')));
		$syntax_affected_rows = array(
				"delete" => 'mysql_affected_rows',
				"insert" => 'mysql_affected_rows',
				'replace' => 'mysql_affected_rows',
				'update' => 'mysql_affected_rows');
		$syntax_num_rows = array(
				'select' => 'mysql_num_rows'
				);
				if ($syntax_affected_rows[$syntax]){
					return $result ? $syntax_affected_rows[$syntax]($this->connect) : $result;
				}
				elseif ($syntax_num_rows[$syntax])
				return $result ? $syntax_num_rows[$syntax]($result) : $result;
				else
				return $result;
	}

	public function runsqls($sql){
		$result = mysql_query($sql, $this->connect);
		$syntax = strtolower(substr($sql, 0, strpos($sql, ' ')));
		$syntax_affected_rows = array(
			"delete" => 'mysql_affected_rows',
			"insert" => 'mysql_affected_rows',
			'replace' => 'mysql_affected_rows',
			'update' => 'mysql_affected_rows');
		$syntax_num_rows = array(
			'select' => 'mysql_num_rows'
			);
			if ($syntax_affected_rows[$syntax]){
				return $result ? $syntax_affected_rows[$syntax]($this->connect) : $result;
			}
			elseif ($syntax_num_rows[$syntax])
			return $result ? $syntax_num_rows[$syntax]($result) : $result;
			else
			return $result;
	}

	public function exec($sql){
		return $this->query($sql);
	}

	public function halt($errno=null, $error=null){
		if(!$errno) $errno = $this->connect ? mysql_errno($this->connect) : mysql_errno();
		if(!$error) $error = $this->connect ? mysql_error($this->connect) : mysql_error();
		throw new Exception("[MYSQL-{$errno}]".$error."\r\n[SQL]".$this->sql, E_USER_ERROR);
	}

	public function ReplaceArray($tablename, $arrData, $get_last_insertid=false){
		if(!$tablename || !is_array($arrData) || !count($arrData)){
			return false;
		}
		$sql_field_names = $sql_field_values = null;
		foreach ($arrData as $fieldname => $fieldvalue){
			$sql_field_names  .= '`'.$fieldname.'`,';
			$sql_field_values .= "'{$fieldvalue}',";
		}
		$sql_field_names = substr($sql_field_names, 0, -1);
		$sql_field_values = substr($sql_field_values, 0, -1);
		$sql = "replace into `{$tablename}`({$sql_field_names}) values({$sql_field_values})";
		return $this->insert($sql, $get_last_insertid);
	}
}
?>