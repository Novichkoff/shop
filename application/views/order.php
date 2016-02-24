<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="/rssfeed.php">
    
    <link rel="stylesheet" href="/css/style.css" />    
    
    <script src="/js/jquery-1.7.2.min.js"></script>
    <script src="/js/main.js"></script>
    
    <title><?=$site->title?></title>
    <script>
      var timerMulti;
      $( document ).ready(
        function() {          
          $('#order_check').animate({opacity:'1'}, 1000, function (){
            timerMulti = window.setTimeout("empty_cart();", 5000);           
          });    
        }
      );        
    </script>    
  </head>
  <body>
    <div id="order_check">
      <br><br>
      <h1><?=$site->name?></h1>
      <h2><?=$site->adress?></h2>
      <h2><?=$site->phone?></h2>
      <h2>***********************</h2>
      <div style="text-align:left;">
        <? $sum = 0;?>
        <h3>#<?=$order->id?>  Дата: <?=$order->date?></h3>        
        <? foreach($cart as $item) { ?>
          <? if (!empty($item)) {?>
            <h3><?=$item->name?></h3>
            <div style="text-align:right;">
              <h3><?=$item->product_count?>.000 x <?=$item->price?>.00 = <?=($item->product_count * $item->price)?>.00</h3> 
            </div>
            <? $sum += ($item->product_count * $item->price);?>
          <? } ?>
        <? } ?>
        <br>
        <div style="text-align:right;">
          <h1>ИТОГ: <?=$sum?>.00</h1>
        </div>
        <br>
        <div style="text-align:center;">          
          <br>
          <h2>СПАСИБО !</h2>
          <h3>Мы свяжемся с Вами в самое ближайшее время для подтверждения заказа.</h3>
          <h2><?=$site->name?></h2>
          <h3><?=$site->adress?><br><?=$site->phone?></h3>
          <br><br>
        </div>
      </div>
    </div>
  <body>
</html>