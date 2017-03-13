<?php
class CommonModule {

	public $KeyID;
	public $TableName;
	public $ViewCount;

	/**
	 * @desc  根据条件获取数据
	 * @param string $MysqlWhere
	 * @param bool|false $IsList 是否查询多条
	 * @return array
	 */
	public function GetInfoByWhere($MysqlWhere = '', $IsList = false){
		global $DB;
		$sql = 'select * from ' . $this->TableName . ' where 1 = 1 ' . $MysqlWhere;
		if($IsList == true){
			return $DB->select($sql);
		}
		return $DB->getone($sql);
	}

	/**
	 * @desc  查询数据总条数
	 * @param string $MysqlWhere 条件
	 * @return array
	 */
	public function GetListsNum($MysqlWhere = '') {
		global $DB;
		$sql = 'select count(`' . $this->KeyID . '`) as Num from ' . $this->TableName .' where 1 = 1  '. $MysqlWhere;
		return $DB->getone ( $sql );
	}

	/**
	 * @desc  查询列表数据
	 * @param string $MysqlWhere   条件
	 * @param int $Offset          limit 开始数
	 * @param int $Num             一页显示条数
	 * @param array $FieldArray    查询字段
	 * @return array
	 */
	public function GetLists($MysqlWhere = '', $Offset = 0, $Num = 10, $FieldArray = array()) {
		global $DB;
		if (count ( $FieldArray ) > 0) {
			$FieldString = '';
			foreach ( $FieldArray as $Value ) {
				$FieldString .= ',' . $Value;
			}
			$FieldString = substr ( $FieldString, 1 );
		} else {
			$FieldString = '*';
		}
		if (strstr ( $MysqlWhere, 'order' )){
			$OrderBy = '';
		}
		else {
			$OrderBy = ' order by ' . $this->KeyID . ' ASC';
		}
		$sql = 'select ' . $FieldString . ' from ' . $this->TableName . ' where 1 = 1 ' . $MysqlWhere . $OrderBy;
		return $DB->select ( $sql, $Offset, $Num );
	}

	/**
	 * @desc  新数据插入
	 * @param array $Array
	 * @return int
	 */
	public function InsertInfo($Array = array()) {
		global $DB;
		if (count ( $Array ) == 0) {
			return 0;
		}
		return $DB->insertArray ( $this->TableName, $Array ,true);
	}

	/**
	 * @desc  删除数据
	 * @param string $KeyID
	 * @return int
	 */
	public function DeleteByWhere( $Where = '') {
		global $DB;
		if ($Where == '')
			return 0;
		$sql = 'delete from `' . $this->TableName . '` where 1 = 1  ' . $Where;
		return $DB->Delete ( $sql );
	}

	/**
	 * @desc  根据条件更新单挑数据
	 * @param array $Array
	 * @param string $KeyID
	 * @return bool|int
	 */
	public function UpdateInfoByWhere($Array = array(), $Where = '') {
		global $DB;
		if ($Where == '' || count ( $Array ) == 0)
			return 0;
		return $DB->updateWhere ( $this->TableName, $Array , $Where);
	}

	/**
	 * @desc  删除数据
	 * @param string $KeyID
	 * @return int
	 */
	public function DeleteByKeyID($KeyID = '') {
		global $DB;
		if ($KeyID == '')
			return 0;
		$sql = 'delete from `' . $this->TableName . '` where ' . $this->KeyID . '=' . $KeyID;
		return $DB->Delete ( $sql );
	}

	/**
	 * @desc  根据keyID查询单条数据详情
	 * @param string $KeyID
	 * @return array|int
	 */
	public function GetInfoByKeyID($KeyID = '') {
		global $DB;
		if ($KeyID == '')
			return 0;
		$sql = 'select * from ' . $this->TableName . ' where ' . $this->KeyID . '=' . $KeyID;
		return $DB->getone ( $sql );
	}

	/**
	 * @desc  根据keyID更新单条数据
	 * @param array $Array
	 * @param string $KeyID
	 * @return bool|int
	 */
	public function UpdateInfoByKeyID($Array = array(), $KeyID = '') {
        global $DB;
        if ($KeyID == '' || count($Array) == 0)
            return 0;
        $DB->updateWhere($this->TableName, $Array, '`' . $this->KeyID . '`=' . intval($KeyID));
    }

    /**
	 * @desc  更新阅读量
	 * @param string $ArticleID
	 * @return string
	 */
	public function UpdateViewCount($ArticleID='') {
		if ($ArticleID=='')
			return '';
		global $DB;
		return $DB->Update ( 'Update ' . $this->TableName .' set '.$this->ViewCount.'='.$this->ViewCount.'+1 where `'. $this->KeyID . '`=' . $ArticleID );
	}

}