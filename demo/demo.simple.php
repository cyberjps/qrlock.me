<?php
require_once(__DIR__.'/../../jLIB.PHP/qrlock/qrlock.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>

<title>An example of using the service qrlock.me</title>
<meta name="description" content="An example of using the service qrlock.me." >            
<meta name="keywords" content="qrlock.me">
<meta name="Robots" content="All"> 
<meta name="Language" content="English">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<style type="text/css">
<!-- 
-->
</style>
<body>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="container text-center mx-auto">
 <div class="m-3">
  <textarea class="form-control" rows=10 id="txtcnt">
  </textarea>
  </div>
 <div class="p-3">
<?php ShowQRBlock(['content_id'=>'bla-bla-bla-2','urlmob'=>request_url()]); ?>
  <a href="resetdemo.php" class="<?php e(PinBtnCls(1)); ?>">Reset demo</a>
  <a href="./" class="<?php e(PinBtnCls(1)); ?>">Modern demo</a>
  <a href="/" class="<?php e(PinBtnCls(1)); ?>">Return home</a>
 </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
