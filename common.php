<?php

/**
 * Description of Class Common.php
 * General functions class for Add, Update, Delete, Search records and Database connection
 * @author Hemant
 */
include_once 'DB.php';

class Common {
	private $config;
	private $db;

	public function __construct() {
		$this->config = array("hostname"=>"localhost", "username"=>"root","password"=>"","database"=>"CIM", "prefix"=>"", "connector"=>"mysql");
		$this->db = new db($this->config);
		$this->db->openConnection();
	}

	public function Add($data = '')
	{
		$query = "Insert into customer(name, address1, address2, suburb, state, postcode, date_added) values('".$data['name']."','".$data['address1']."','".$data['address2']."','".$data['suburb']."','".$data['state']."','".$data['postcode']."', '".date('Y-m-d H:i:s')."')";
		$id = $this->db->query($query);
	}

	public function Update($data = '')
	{
		$query = "Update customer set name = '".$data['name']."', address1 = '".$data['address1']."', address2 = '".$data['address2']."', suburb = '".$data['suburb']."', state = '".$data['state']."', postcode = '".$data['postcode']."' where id= ".$data['id'];
		return $this->db->query($query);
	}

	public function Delete($id)
	{
		$query = "Delete from customer where id= ".$id;
		return $this->db->query($query);
	}

	//Search in all columns except primary key :id
	public function Search($search)
	{
		if(trim($search) == '')
			$this->Get_data(1);

		$out = "";
		$table = 'customer';
		$sql_search = "select * from ".$table." where ";
		$sql_search_fields = Array();
		$sql2 = "SHOW COLUMNS FROM ".$table;
		$rs2 = $this->db->query($sql2);
		if(mysql_num_rows($rs2) > 0){
			while($r2 = mysql_fetch_array($rs2)){
				if($r2[0] != 'id')
				{
					$colum = $r2[0];
					$sql_search_fields[] = $colum." like('%".$search."%')";
				}
			}
		}
		$sql_search .= implode(" OR ", $sql_search_fields);
		$rs3 = $this->db->query($sql_search);
		$out = $rs3;

		return $out;
	}

	public function Get_data($page = 1)
	{
		$limit = ($page-1)*5;
		$query = "select * from customer order by date_added desc limit ".$limit." , 5";
		$data = $this->db->query($query);
		return $data;
	}

	public function Get_count_num_rows()
	{
		$query = "select count(*) as count from customer";
		$data = $this->db->query($query);
		$data = mysql_fetch_array($data);
		return $data['count'];
	}
}

?>
