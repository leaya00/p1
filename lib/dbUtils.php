<?php
class Dbi{
	/************数据库配置参数*******/
	public static  $root='127.0.0.1';
	public static  $user='root';
	public static  $pass='root';
	public static  $db='lilang';
	/******************************/
	public $link;
	function __construct() {
		$this->link = mysqli_connect(self::$root,self::$user,self::$pass, self::$db);
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: (" . mysqli_connect_error . ") " ;
		}
	}
	
	/*
	 query
	 */

	function query($sql)
	{
		$result = mysqli_query($this->link,$sql);
		if(!($result)){
			echo "Error: ".mysqli_error($this->link);
			return false;
		}
		return $result;
	}
	/*
	 mysql_num_rows total
	 */
	function rows($result)
	{
		return mysqli_num_rows($result);
	}
	/*
	 get data store array
	 */
	function fetch_array($result){
		 
		return mysqli_fetch_array($result);		 
	}
	/*
	 取得刚插入的ID号
	 */

	function insert_id()
	{
		return mysqli_insert_id($this->link);
	}
	 
	//close current database link
	function close()
	{
		return mysqli_close($this->link);
	}
	//test mysql version
	function version()
	{
		$query = $this->query("SELECT VERSION()");
		return  mysqli_data_seek($query, 0);
	}
	
	function query_fetch($sql){
		
	//		查询
		$q=$this->query($sql);
		$result=array();
		while($row = $this->fetch_array($q)){
			$result[]=$row;
		}
		return $result;
	}
}

