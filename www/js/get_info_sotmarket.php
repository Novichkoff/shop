<?php
$use_curl = true; // Использовать CURL
// Ключевое слово для поиска
$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

// Адрес страницы с результатами поиска
$url = "http://www.sotmarket.ru/search/?q=".$keyword;

$result->url = $url;

// Выбираем результаты поиска
$page = get_page($url);
$result->page = $page;

// Находим ссылку на описание товара
if(preg_match_all('/<div class="b-catalog_goods-link">  <a class="b-catalog_placeholder" href="(.*?)" data-img=/ui', $page, $matches))
	$product_url = 'http://www.sotmarket.ru'.reset($matches[1]);  

$page = get_page($product_url);

if(preg_match_all('/<div class="b-card-info-cell">(.*?)<\/div>  <div class="b-card-info-cell/ui', $page, $matches))
{
	// Описание товара
	$description = reset($matches[1]);  
	$result->description = strip_tags($description);
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($result));


function get_page($url,$use_curl = true)
{
	if($use_curl && function_exists('curl_init'))
  {
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

    // Для использования прокси используйте строки:
    //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
    //curl_setopt($ch, CURLOPT_PROXY, '88.85.108.16:8080'); 
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:password'); 
    
    $page = curl_exec($ch);
    curl_close($ch); 
  }
  else
  {
    $page = file_get_contents($url);
  }
	return $page;
}