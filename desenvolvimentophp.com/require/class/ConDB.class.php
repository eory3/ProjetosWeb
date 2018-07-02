<?php
abstract class ConDB 
{
	private $cnx;
	private function setConn()
	{
		return 
		is_null($this->cnx)?
				$this->cnx = new PDO("mysql:host=localhost;dbname=desenvolvendophp","root","vertrigo"):
				$this->cnx;
	}
	
	public function getConn()
	{
		return $this->setConn();
	}
}
?>