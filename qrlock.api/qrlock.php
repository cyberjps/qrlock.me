<?php
// Данный файл содержит необходимые для работы библиотеки функции и определения.
// В большинстве случаев менять его не нужно, а скорее всего даже противопоказано
// В данном файле интересно только наличие функции PostCurl, которую можно заменить на свою,
// если в вашем проекте используется более "продвинутая" версия
// Все переменные, которые можно менять вынесены в файл qrlock.cfg.php (в этом же дирректории).

// API Packet
// Ver. 1 commands
define('_QRL_CMD_CNT_CRT_',			1); // Create contnet

// Content packet

// Parameter position
define('_QRL_CNT_INDX_VER_',		0); // Packet version
// Ver. 1
define('_QRL_CNT_INDX_TYPE_',		1); // Content type (position!)
define('_QRL_CNT_INDX_VAL_',		2); // Content value

// Content types
define('_QRL_CNT_TYPE_PLN_',		1); // Content type plain
define('_QRL_CNT_TYPE_URL_',		2); // Content type url
define('_QRL_CNT_TYPE_RLD_',		3); // Content type reload

require_once(__DIR__.'/qrlock.cfg.php');

function e($text) { echo($text); }
function ee($text) { echo($text.PHP_EOL); }

function PinBtnCls($num=1) {
 switch($num) {
  case 6:
   return 'btn pinbtn btn-md rounded-pill text-monospace btn-info text-gray';
  case 5:
   return 'btn pinbtn btn-md rounded-pill text-monospace btn-danger text-gray';
  case 4:
   return 'btn pinbtn btn-md rounded-pill text-monospace btn-success text-gray';
  case 3:
   return 'btn pinbtn btn-md rounded-pill text-monospace btn-dark text-white';
  case 2:
   return 'btn pinbtn btn-md rounded-pill text-monospace btn-warning text-dark';
  case 1:
  default:
   return 'btn pinbtn btn-md rounded-pill text-monospace btn-primary text-gray';
 }
}

function ShowQRBlock($params, $tmpl = __QRL_TMPL_DEF__) {
 if(file_exists($tmpl_path = __DIR__."/{$tmpl}.tpl.php")) require_once($tmpl_path);
}

function PostCurl($apipoint,$param) {
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,$apipoint);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $server_output = curl_exec($ch);
 curl_close ($ch);
 return $server_output;
}

function request_url()
{
  $result = ''; // Пока результат пуст
  $default_port = 80; // Порт по-умолчанию
 
  // А не в защищенном-ли мы соединении?
  if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
    // В защищенном! Добавим протокол...
    $result .= 'https://';
    // ...и переназначим значение порта по-умолчанию
    $default_port = 443;
  } else {
    // Обычное соединение, обычный протокол
    $result .= 'http://';
  }
  // Имя сервера, напр. site.com или www.site.com
  $result .= $_SERVER['SERVER_NAME'];
 
  // А порт у нас по-умолчанию?
  if ($_SERVER['SERVER_PORT'] != $default_port) {
    // Если нет, то добавим порт в URL
    $result .= ':'.$_SERVER['SERVER_PORT'];
  }
  // Последняя часть запроса (путь и GET-параметры).
  $result .= $_SERVER['REQUEST_URI'];
  // Уфф, вроде получилось!
  return $result;
}
