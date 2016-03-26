<?php
/**
*МОДЕЛЬ ДЛЯ РАБОТЫ СО СТАТЬЯМИ
*===================================
*/
class Page {	
	private $db;//соединение с бд
	
    public function Page($db){
		$this->db=$db;
    }
	
	//подсчитать количество статей
	public function getnum() {
		$qry = $this->db->query("SELECT COUNT(1) FROM Page");
		$qry=$qry->fetch();
		return $qry[0]; 
	}
	
	//получить список статей из бд постранично (Только названия и ид для формирования ссылок)
	public function getlist ($limit, $offset)
	{
		$sql = "SELECT PageID, PageTitle FROM Page LIMIT $limit OFFSET $offset";
		$qry=$this->db->query($sql);
		if(!$qry)
		{
		return false;
		}
		else {
			$str=array();
			foreach ($qry as $row)
			{
				$str[]=array ($row['PageID'],$row['PageTitle']);
			}
		} 		
		return $str;
	}
	
	//получить заголовок и текст по ид (отдельную статью)
	public function getitem($id)
	{	
		$sql = "SELECT * FROM Page WHERE PageID='$id'";
		$qry = $this->db->query($sql); 
		if(!$qry)
		{
		return false;
		}
		else {
			$row = $qry->fetch();
			} 		
		return $row;
	}

}