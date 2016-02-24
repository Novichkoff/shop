<?
// считываем текущее время
$start_time = microtime();
// разделяем секунды и миллисекунды
//(становятся значениями начальных ключей массива-списка)
$start_array = explode(" ",$start_time);
// это и есть стартовое время
$start_time = $start_array[1] + $start_array[0];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" lang="ru" xml:lang="ru">

  <head>
    
    <!--  Метатеги -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="last-modified" content="Wed Dec 18 03:28:43 2013"/>
    <meta http-equiv="expires" content="-1"/>
    <meta name="robots" content="index, follow"/>
    <meta name="description" content="<?=strip_tags($meta_description)?> NDUral.ru"/>
    <meta name="keywords" content="<?=!empty($keywords) ? $keywords : $title;?>"/>
    <meta name="viewport" content="width=device-width, target-densityDpi=device-dpi">    
    <meta name='yandex-verification' content='511bf83957e08883'/>
    <meta name="google-site-verification" content="anbR6klx3Yky5z2eBzGR-c_UQTXzFKq4zbQFlb7Nt0k"/>
    <meta name="msvalidate.01" content="23EF0BEC3CE39F9B3F7BCD2AEA51543D"/>
    <meta http-equiv="x-dns-prefetch-control" content="on"/>    
    <link rel="dns-prefetch" href="http://content.adriver.ru"/>
    <link rel="dns-prefetch" href="http://ad.adriver.ru"/>
    <link rel="dns-prefetch" href="http://mc.yandex.ru"/>
    <link rel="dns-prefetch" href="http://www.google-analytics.com"/>
    <link rel="dns-prefetch" href="http://counter.yadro.ru"/>
    <meta property="og:title" content="<?=$title?>"/>
    <? if (!empty($product)) { ?><meta property="og:type" content="product"/><? } ?>
    <meta property="og:site_name" content="NDURAL.RU"/>
    <meta property="og:description" content="<?=strip_tags($meta_description);?>"/>
    
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="/rssfeed.php">
    
    <!--  Стили -->
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/mobile.css" media="only screen and (max-device-width: 480px)" type="text/css" />
    <link rel="stylesheet" href="/css/rating.css" />
    <link rel="stylesheet" href="/css/lightbox.css" />
        
    <!--  JavaScripts -->
    <script src="/js/jquery-1.7.2.min.js"></script>
    <script src="/js/lightbox.js"></script>    
    <script src="/js/main.js"></script>
    <script src="/js/jquery.cookies.js"></script>
    
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>
    <script type="text/javascript">VK.init({apiId: 4065947, onlyWidgets: true});</script>  
    
    <!--  Заголовок страницы -->
    <title><?=$title?> | NDURAL.RU</title>
    
  </head>
  
  <body itemscope itemtype="http://schema.org/WebPage">
  
    <div id="fb-root"></div>    
  
    <div id="wrapper">  
    
      <!-- Шапка сайта -->
      <div id="header">
        
        <!-- Логотип сайта -->
        <div class="site_logo">
          <a href="/" title="<?=$name?>">
            <img src="/images/logo_small.png" title="<?=$title?> | NDURAL.RU" alt="<?=$name?>" width="120" height="50"/>
          </a>                   
        </div>
        <!-- Логотип сайта (The End)-->
        
        <!-- Название сайта -->
        <div class="site_name">          
          <span class="site_name_h2"><?=$name?></span>          
        </div>
        <!-- Название сайта (The End)-->
        
        <div class="user_panel">
        
          <!-- Вход пользователя -->
          <div id="login_panel"></div>
          <div class="welcome_panel">
            <? if ($user) { ?>
              <span>Привет, <strong><?=$user?></strong>. </span>
              <a href="/auth/logout"><img src="/images/exit.png" title="Выйти из аккаунта" alt="Выйти" /></a>
              <a href="/admin"><img src="/images/admin.png" title="Зайти в Администрирование" alt="Администрирование" /></a>
            <? } else { ?>
              <a class="pointer" onclick="login()" title="Войти на сайт"><span>Войти</span></a>
            <? } ?>
          </div>
          <!-- Вход пользователя (The End)-->
          
          <!-- Корзина -->
          <a href="/catalog/cart" title="Корзина товаров">
            <div id="cart">Корзина товаров</div>
          </a>
          <!-- Корзина (The End)-->
          
        </div>
        
        <!-- Телефон сайта -->
        <div class="site_phone">
          <span class="site_phone_h2"><?=$phone?></span>         
        </div>
        <!-- Телефон сайта (The End)-->
        
      </div>
      <!-- Шапка сайта (The End)-->