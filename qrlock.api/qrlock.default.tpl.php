<!-- Файл темплейта блока с QR-кодом. В нем описан внешний бид блока и функционал его работы
 В некоторых редких случая требует изменения, но лучше редактировать его копию и копию
 затем указать в качестве параметра функции ShowQRBlock (второй параметр). Если его не указать
 будет использован шаблон по умолчанию "qrlock.default.tpl.php", поэтому не удаляйте его.
 ============================================================================================
-->
<!-- Загрузка удаленной части скрипта, в общем-то может грузиться откуда угодно, но так как сейчас
 происходит период отладки и тестирования, желательно его грузить с нашего сервера, так как он
 будет часто меняться.
-->
<script src="<?php e(__API_POINT__); ?>api.js"></script>
<script>
// Локальная часть скрипта, определяющая ллогику работы и дизайн сайта, который испольузет
// сервис qrlock.me. Здесь расположены переменные и функции, которые может (но в большинстве
// случае это не обязательно и не требуется) мзменить ваш программист или дизайнер.
// Переменные
// ============================================================================================
// Параметры, передаваемые в скрипт conector.php, могут быть очень разными, в примере их два
// и описаны они в файле принимающего скрипта. Главный (но не обязательно единственный)
// результат ответа этого скрипта - это токен, полученный с сервиса qrlock.me
// Наличие этих переменных здесь - ОБЯЗАТЕЛЬНО. Имена этих переменных не должны быть измененны.
// Их значения импортируются из файла qrlock.cfg.php
var json_params = <?php e(json_encode($params)); ?>;
// Адрес, откуда получается информация о состоянии QR-кода и действия пользователя (открыл ли
// он страницу с пин-кодом и нажал ли на кнопку пинкода. Так же именно из данного источника "прилетит"
// защищеннй контент и будет показан в браузере.
var callback_point = '<?php e(__CB_POINT__); ?>';
// Адрес conection point. Адрес скрипта connector.php, расположенного на ВАШЕМ сервере.
// В этом файле определеляется логика получения вашего контента, которая скрыта от пользователя
// (а так же и от сервиса qrlock.me) и выполняется на вашем сервере.
var connector_point = '<?php e(__CON_POINT__); ?>';
// Сюда будет сохранен токен.
var token = '';

// Функции
// ============================================================================================
function CallAfterInit(j)
{
 // Любые действия, выполняемые после инициализации скрипта. Здесь могут быть скрыты или
 // показаны какие-то элементы, выполнениы какие-то подготовительные действия и пр.
 // ВАЖНО!!!: Здесь еще пользователь не сканировал код и не нажимал пин-код.
 // ===========================================================================================
 // Сохраняем токен
 token = j.token;
 // Задаем цвет кнопки с пинкодом (передается с сервера)
 $("div#pinbtn").attr('class', PinBtnCls(j.cls));
 // Задаем собственно пинкод (передается с сервера)
 $("div#pinbtn").text(j.pin);
 // Отрисовываем QR-код (но ПОКА не показываем его, так как возможно его и не надо будет
 // показывать так как контент уже открыт
 $("img#imgcode").attr("src",j.img);
}
// Функция вызывается между таймаутами запроса к серверу сервиса. Используется редко,
// в данном примере используется для того чтобы показть скрытый QR-код. Это не обязательное
// действие, в других примерах возможно будет иначе. В данном примере это сделано только
// с дизайнерской целью (зачем показывать код, который уже был отсканирован и контент уже открыт).
function CallAfterWait(j)
{
  // Ping - поддержка соединения. Подтверждение еще не пришло, показываем QR-код
  $("div#qrlock").removeClass("d-none").addClass("d-block");
}

// Данная функция будет вызвана после того как пользователь отсканирует код и нажмет
// правильный пин-код. Функция вызывается АВТОМАТИЧСКИ, на сайте ничего нажимать не надо.
// Период опроса (сейчас) 5 секунд. В течении 5ти секунд понтент будет показан и блок
// с QR-кодом скрыт.
// Для показа контента в данном примере используется textarea и выззов метода val
// В случае использования других объектов (например сокрытие флеш-плеера или каких-то кнопок)
// требуется переписать логику работы. В данном примере здесь "прилетает" текст (на сегодняшний
// день - единственный вариант работы сервиса, но будут и продолжения)
function CallAfterSuccess(j)
{
   $("#txtcnt").val(j.content);
   $("div#qrlock").removeClass("d-block").addClass("d-none");
}

// Инициализируем библиотеку qrlock. В данном примере делается это после окончания
// загрузки документа в браузер (чтобы прогруились все необходимые элементы).
// Но это не обязательно, может быть вызывана и позже, по мере требования.
$(document).ready(initqrlock);

</script>

<!-- Собственно сам дизайн блока с QR-кодом. Для работы с дизайном и функционалом данного
 блока используются две библиотеки: twitter bootstrap и jQuery. Скрипты и css-файлы данных
 библиотек поддключаются во внешнем файле (см. примеры demo). Если вы уже используете эти
 библиотеки, то вторично их подключать не требуется
-->
<div class="d-flex justify-content-center">
 <div class="d-none" id="qrlock" aria-hidden="true" style="max-width: 200px;">
  <img id="imgcode" style="position:relative; top:0px" src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width=200px height=230px class="mx-auto d-block" alt="qrlock.me">
  <div id="pinbtn" style="width: 200px; position:relative; top:0px;">----</div>
 </div>
</div>
<!-- Сюда будет помещен текст ошибки, если таковая произойдет и будет обработана нашим сервисом. -->
<div id="errstr" class="w-100 text-danger"></div>
<hr>