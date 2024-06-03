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
// сервис qrlock.us. Здесь расположены переменные и функции, которые может (но в большинстве
// случае это не обязательно и не требуется) мзменить ваш программист или дизайнер.
// Переменные
// ============================================================================================
// Параметры, передаваемые в скрипт conector.php, могут быть очень разными, в примере их два
// и описаны они в файле принимающего скрипта. Главный (но не обязательно единственный)
// результат ответа этого скрипта - это токен, полученный с сервиса qrlock.us
// Наличие этих переменных здесь - ОБЯЗАТЕЛЬНО. Имена этих переменных не должны быть измененны.
// Их значения импортируются из файла qrlock.cfg.php
var json_params = <?php e(json_encode($params)); ?>;
// Адрес, откуда получается информация о состоянии QR-кода и действия пользователя (открыл ли
// он страницу с пин-кодом и нажал ли на кнопку пинкода. Так же именно из данного источника "прилетит"
// защищеннй контент и будет показан в браузере.
var callback_point = '<?php e(__CB_POINT__); ?>';
// Адрес conection point. Адрес скрипта connector.php, расположенного на ВАШЕМ сервере.
// В этом файле определеляется логика получения вашего контента, которая скрыта от пользователя
// (а так же и от сервиса qrlock.us) и выполняется на вашем сервере.
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
 $("span#pinbtntxt").text(j.pin);
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
 библиотеки, то вторично их подключать не требуется -->
<div class="d-flex justify-content-center">

<div style="display: none;" id="qrlock" aria-hidden="true">
<div class="jumbotron py-3" style="max-width: 740px; border-radius: 1rem;" id="qrlock1">
<h2 class="text-center">Content protected by qrlock.us service.</h2>
<hr class="my-2">
<div class="row">
 <div class="col" style="max-width: 230px">
  <p><img id="imgcode" style="position:relative; top:0px" src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width=200px height=230px class="mx-auto d-block" alt="qrlock.us"></p>
  <div id="pinbtn" style="width: 200px; position:relative; top:0px;">----</div>
  <!--<div class="pt-3 text-center">
  <div class="spinner-border text-info" role="status" id="spin">
   <span class="sr-only">Loading...</span>
  </div>
  </div>-->

 </div>
 <div class="col text-left">
 <b>How it works.</b><br>
 To see hidden content, please do the following:
 <ol>
  <li>Use your mobile phone (smartphone) to scan the QR code that you see here.</li>
  <li>In the opened window (on the smartphone), select the pin code that you see (<span id="pinbtntxt">----</span>).</li>
  <li>Press (on the smartphone) button with this pin code</li>
  <li>Wait a few seconds, everything else will happen <b>automatically.</b></li>
  <li>If this does not happen, refresh the page and try again. Otherwise - contact the technical support of the site.</li>
 </ol>
 <a href="#" data-toggle="modal" data-target="#QRMoreDetail"><b>More details ...</b></a>

 <br>
  <div class="text-center py-4">
   <div id="errstr" class="w-100 text-danger"></div>
  </div>
 </div>
</div>


</div>
<!-- Сюда будет помещен текст ошибки, если таковая произойдет и будет обработана нашим сервисом. -->
<div id="errstr" class="w-100 text-danger"></div>
<hr>


<!-- Modal -->
<div class="modal fade" id="QRMoreDetail" tabindex="-1" role="dialog" aria-labelledby="QRMoreDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-center" role="document" style="min-height: calc(100% - 3.5rem); display: inline-block;">
    <div class="modal-content" style="border-radius: 1rem; vertical-align: middle;">
      <div class="modal-header">
        <h5 class="modal-title" id="QRMoreDetailLongTitle">More details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
You need to scan the QR code shown on the site using your mobile phone (or tablet) and perform the required actions on your device.<br>
In order to be able to scan the code, use the camera of your phone. For Apple phones, no additional software is required (just point the camera at the QR code and follow the instructions). Most Android-based phones also do not require third-party programs.<br>
For those who have problems, we recommend a program for reading QR codes <b>Privacy Friendly QR Scanner</b> (we are not affiliated with this software, but tested this application and it performs the necessary functions).<br>
You can download it from google play.<br>
<div class="text-center pt-3">
 <a href="https://play.google.com/store/apps/details?id=com.secuso.privacyFriendlyCodeScanner" target="_blank"><img src="<?php e(_QR_IMG_HTML_URL_); ?>gpb1.png" widtg="128" height="40"></a>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>
</div>
