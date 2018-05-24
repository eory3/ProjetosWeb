<?php
function __autoload($class)
{
	require_once"{$class}.class.php";
}
class CRUD extends ConDB
{
	private $query;
	
	private function prepExec($prep,$exec)
	{
		$this->query=$this->getConn()->prepare($prep);
		$this->query->execute($exec);
	}
	
	public function insert($tabela,$cond,$exec)
	{
		$this->prepExec('insert into '.$tabela.' set '.$cond.'',$exec);
		return $this->getConn()->lastInsertId();
	}
	
	public function select($fields,$table,$cond,$exec)
	{
		$this->prepExec('select '.$fields.' from '.$table.''.$cond.'',$exec);
		return $this->query;
	}
	
	public function update($table,$cond,$exec)
	{
		$this->prepExec('update '.$table.' set '.$cond.'',$exec);
	}
	
	public function delete($table,$cond,$exec)
	{
		$this->prepExec('delete from '.$table.''.$cond.'',$exec);
	}
}
?>