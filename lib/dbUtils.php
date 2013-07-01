<?php


class Db{
	/************数据库配置参数*******/
	public static  $root='127.0.0.1';
	public static  $user='root';
	public static  $pass='root';
	public static  $db='lilang';
	/******************************/
	
	public $conn;
	// c 普通连接 p持久连接
	public $links='p';

	function __construct() {
		$this->connect();	
	}

	function connect()
	{
		try{
			if( 'p' == $this->links )
			{
				$this->conn = mysql_pconnect(self::$root,self::$user,self::$pass) or die(mysql_error());
			}
			else
			{
				$this->conn = mysql_connect(self::$root,self::$user,self::$pass) or die( mysql_error());
			}
			mysql_select_db(self::$db,$this->conn);
		}catch (Exception $e){
			echo '数据库连接失败，请联系相关人员!';
			exit;
		}
	}

	/*
	 query
	 */

	function query($sql)
	{
		$this->row = mysql_query( $sql,$this->conn ) or die( mysql_error());
		return $this->row;
	}
	/*
	 mysql_num_rows total
	 */
	function rows($row)
	{
		return mysql_num_rows( $row );
	}
	/*
	 get data store array
	 */
	function fetch($row)
	{
		 
		return mysql_fetch_array( $row );
		 
	}

	/*
	 取得刚插入的ID号
	 */

	function insert_id()
	{
		return @mysql_insert_id($this->row);
	}
	 
	//close current database link
	function close()
	{
		return @mysql_close($this->conn);
	}
	 

	//test mysql version
	function version()
	{
		$query = @mysql_query("SELECT VERSION()",$this->conn);
		return  @mysql_result($query, 0);
	}
	
	function query_fetch($sql){
		
	//		查询
		$this->query($sql);
		$result=array();
		while($row = $this->fetch($this->row)){
			$result[]=$row;
		}
		return $result;
	}
}
?>