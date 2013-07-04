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
		return mysqli_stmt_num_rows($result);
	}
	//预处理查询 
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
	
	function query_fetch_all($sql){		
	//		查询
		$q=$this->query($sql);		
		return mysqli_fetch_all($q,MYSQLI_BOTH);
	}
	
	//	
//		$stmt =mysqli_prepare($this->link,$sql);
//		mysqli_stmt_bind_param($stmt,'ss',$_POST['username'],$_POST['password']);
//		mysqli_stmt_execute($stmt);
//		$result= mysqli_stmt_get_result($stmt);
//      mysqli_fetch_all($result,MYSQLI_BOTH);
//	
}

