<?php
/**
*Модель для Сообщений обратной связи в БД
*========================================
*/
class Message {
	private $db; //соединение с бд
	
    public function Message($db){
		$this->db=$db;
    }
	
	//функция добавить в БД сообщение
	public function save ($title,$author,$text)
	{
		$sql = "INSERT INTO Message(MsgTitle, MsgAuthor, MsgText) VALUES ('$title','$author','$text')";
		$qry = $this->db->query($sql); 
		if(!$qry)
		{
			return false;
		}	
		return true;
	}
	
}