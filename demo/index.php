<?php
// Подключаем "библиотеку" qrlock. Вообще называть ее библиотекой будет не верно, это просто вынесенные в отдельный php-файл
// функции и определения, которые нет необходимости менять для запуска данного примера. Есстественно, здесь подставить свой путь.
require_once(__DIR__.'/../../jLIB.PHP/qrlock/qrlock.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<!-- Стандартный заголовок HTML -->
<html>
<head>

<title>An example of using the service qrlock.us</title>
<meta name="description" content="An example of using the service qrlock.us." >            
<meta name="keywords" content="qrlock.us">
<meta name="Robots" content="All"> 
<meta name="Language" content="English">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Подключаем стили Twitter Bootstrap.
	Эти файлы нужны только для работы этого примера (дизайн) и НЕ ВЛИЯЮТ на работу протокола в целом.
-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<style type="text/css">
<!-- 
-->
</style>
<body>
<!-- Подключаем библиотеку jQuery.
	Эти файлы нужны только для работы этого примера (дизайн) и НЕ ВЛИЯЮТ на работу протокола в целом.
-->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="container text-center mx-auto">
 <div class="m-3">
<!-- ВАЖНО!!! Сюда будет помещен полученный контент. В данном примере испольузется textarea,
	однако это может быть любой другой HTML элемент. Ключевой момент - это идентификатор элемента,
	по которому будет найдено место, куда записать "спрятанный" контент. В данном случае это "txtcnt".
	Все это может быть изменено редактированием как этого файла, так и прочих файлов проекта.
	Главное - это понимать что делать. Не забудьте сохранить файлы перед редактированием.
-->
  <textarea class="form-control" rows=10 id="txtcnt">
  </textarea>
  </div>
 <div class="p-3">
<!-- ВАЖНО!!! Основной вызов, отрисовывающий блок с QR-кодом. Значения параметров (обращаем ваше внимание,
	первый параметр - это массив, содержащий переменное количество именованных параметров, их значение ниже):
	- content_id - уникальный идентификатор контента, по которому вы (!) определяетет какой контент вы
		собираетесь прятать/показывать. По данному идентификатору внутри файла connector.php (см. отдельное описание)
		вы получаете контент (из базы, генерируете, выгружаете из друого сервера или пр.) и отправляете к нам на сервер,
		формируя пакет с контентом. После обработки пользователя (сканирование кода и получение контента через JavaScript
		с нашего сервера, он будет записан поле, указанное выше (с идентификатором txtcnt).
	- urlmob - это url, который откроется на мобильном устройстве. Собственно в открытии этого url и состоит основной
		профит работы данного сервиса. В данном случае открывается обычная страница на нашем же сервисе, подтверждающая что
		все прошло успешно. Однако здесь может быть любой другой url (как на вашем сервисе, так и стороннем, включая даже "слив"
		трафика на парнерские программы, на которые по каким-то соображениям нельзя было это делать с вашего сайта (гугль банит,
		нетематическая линка, не желавние ассоциироваться с данным сервисом и пр.).
		ВАЖНО!!! Данная линка будет видна в коде сайта, однако это сделано только в нашем примере. Так делать не обязательно и вполне
		можно задать его внутри файла connector.php, содержимое которого пользователь не видит.
	- второй параметр (обращаем ваше внимание, что это ВТОРОЙ параметр вызова функции ShowQRBlock, первые два - это элементы массива)
		это собственно имя файла темплейта, который необходимо использовать при отрисовке QR-кода. В текущей версии их два
		qrlock.modern и qrlock.default (siimple). Используется БЕЗ указания расширения имени файла (.php).
-->
<?php ShowQRBlock(['content_id'=>'bla-bla-bla-1','urlmob'=>'http://qrlock.us/demo/10x.php'],'qrlock.modern'); ?>
<!-- "Функция" PinBtnCls находится в файле qrlock.php. Она просто рисует красивую кнопку. Ее использование - необязательно. -->
  <a href="resetdemo.php" class="<?php e(PinBtnCls(1)); ?>">Reset demo</a>
  <a href="demo.simple.php" class="<?php e(PinBtnCls(1)); ?>">Simple demo</a>
  <a href="/" class="<?php e(PinBtnCls(1)); ?>">Return home</a>
 </div>
</div>

<!-- Подключаем скрипты Twitter Bootstrap.
	Эти файлы нужны только для работы этого примера (дизайн) и НЕ ВЛИЯЮТ на работу протокола в целом.
-->
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
