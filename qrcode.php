<?php

$text = $_REQUEST['text'];

include('3rd_party/qrcode/qrlib.php');

QRcode::png($text);
  
 ?>