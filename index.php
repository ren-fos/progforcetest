<?php
/**
*КОНТРОЛЛЕР
*=================
*/

require 'flight/Flight.php';

require 'tests/classes/Page.php'; //модель для работы со статьями
require 'tests/classes/Message.php'; //и с сообщениями

Flight::set('flight.views.path', './tests/views'); //путь до представлений

$lim=3; //число статей на странице

// Соединение с БД
Flight::register('db', 'PDO', array('mysql:host=localhost;port=3306;dbname=progforce', 'root', ''), function($db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});
$db = Flight::db();

//инициализация моделей
Flight::register('page', 'Page', array ($db));
$page = Flight::page();

Flight::register('msg', 'Message', array ($db));
$msg = Flight::msg();

//ОБРАБОТКА ОТПРАВЛЕННОГО СООБЩЕНИЯ
Flight::route('POST /send', function () {
	global $msg;
	//если проверка заполнения прошла успешно
	if ( !empty($_POST["title"])
		and !empty($_POST["author"])
		and !empty($_POST["text"])
		) 
		{
		//Если сообщение нормально сохранилось, печатаем его на странице после отправки
		if ($msg->save($_POST['title'],$_POST['author'],$_POST['text']))
		{	
			Flight::render('ok_save', array('title'=>$_POST['title'],'author'=>$_POST['author'], 'text'=>$_POST['text']), 'content');
		}
		//если сообщение не сохранилось, ошибка отправки
		else
		{
			Flight::render('content', array('title'=>'Ошибка отправки!', 'text'=>'Повторите позже'), 'content');
		}
	}
	//если что-то не заполнено, ошибка
	else
	{
		Flight::render('msgform', array('err_mes'=>'Какое-то из полей осталось пустым :('), 'content');	
	}
	Flight::render('navbar', array(), 'nav');
	Flight::render('footer', array(), 'footer');
	Flight::render('layout');
});

//ФОРМА ОБРАТНОЙ СВЯЗИ
Flight::route('/feedback', function () {

	Flight::render('navbar', array(), 'nav');
	Flight::render('msgform', array(), 'content');
	Flight::render('footer', array(), 'footer');
	Flight::render('layout');
});

//СПИСОК СТАТЕЙ
Flight::route('/@thispage:[1-9]{1,2}', function ($thispage) {
	global $page, $lim;
	$num=$page->getnum(); //число статей в базе
	$offset=$lim*($thispage-1); //расчет смещения на основании количества статей и номера текущей страницы
	$num_pages=ceil($num/$lim); //число страниц пейджера

	Flight::render('navbar', array(), 'nav');
	Flight::render('list', array('title'=>'Список статей','text'=>$page->getlist($lim,$offset), 'num_pages'=>$num_pages), 'content');
	Flight::render('footer', array(), 'footer');
	Flight::render('layout');
});

//ОТДЕЛЬНАЯ СТАТЬЯ
Flight::route('/pages/@id:[0-9]{1,3}', function ($id) {
	global $page;
	$str=$page->getitem($id);
	Flight::render('navbar', array(), 'nav');
	Flight::render('content', array('title'=>$str['PageTitle'],'text'=>$str['PageText']), 'content');
	Flight::render('footer', array(), 'footer');
	Flight::render('layout');
});


Flight::start();
?>
