<?php
class db
{
	private $connection;
	private $selectdb;
	private $lastQuery;
	private $config;

	function __construct($config)
	{
		$this->config = $config;
	}

	function __destruct()
	{

	}

	public function openConnection()
	{
		try
		{
			if($this->config['connector'] == "mysql")
			{
				$this->connection = mysql_connect($this->config['hostname'], $this->config['username'], $this->config['password']);
				$this->selectdb = mysql_select_db($this->config['database']);
			}
			elseif($this->config['connector'] == "mysqli")
			{
				$this->connection = mysqli_connect($this->config['hostname'], $this->config['username'], $this->config['password']);
				$this->selectdb = mysqli_select_db($this->connection, $this->config['database']);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}

	public function closeConnection()
	{
		try
		{
			if($this->config['connector'] == "mysql")
			{
				mysql_close($this->connection);
			}
			elseif($this->config['connector'] == "mysqli")
			{
				mysqli_close($this->connection);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}


	public function query($query)
	{
		$query = str_replace("}", "", $query);
		$query = str_replace("{", $this->config['prefix'], $query);

		try
		{
			if(empty($this->connection))
			{
				$this->openConnection();

				if($this->config['connector'] == "mysql")
				{
					$this->lastQuery = mysql_query($query);
				}
				elseif($this->config['connector'] == "mysqli")
				{
					$this->lastQuery = mysqli_query($this->connection,$query);
				}

				$this->closeConnection();

				return $this->lastQuery;
			}
			else
			{
				if($this->config['connector'] == "mysql")
				{
					$this->lastQuery = mysql_query($query);
				}
				elseif($this->config['connector'] == "mysqli")
				{
					$this->lastQuery = mysqli_query($this->connection, $query);
				}

				return $this->lastQuery;
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}

	public function lastQuery()
	{
		return $this->lastQuery;
	}
}

?>