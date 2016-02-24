<?php

$use_curl = true; // Использовать CURL

$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

$start='';
if(isset($_GET['start']))
	$start = intval($_GET['start']);

//$url = "http://images.rambler.ru/search?image_size=medium&image_color=white&query=".$keyword;
$url = "http://go.mail.ru/search_images?q=".$keyword."&start=".$start;
//$url = "http://images.google.com/search?tbm=isch&tbs=isz:lt,islt:qsvga,itp:photo&start=".$start."&q=".$keyword;
//$url = "http://www.google.ru/search?start=$start&q=$keyword&newwindow=1&source=lnms&tbm=isch&sa=X&ei=oyMoUrSZLY3UsgagoIDoBA&ved=0CAkQ_AUoAQ&biw=1280&bih=899#newwindow=1&q=$keyword&tbas=0&tbm=isch&tbs=isz:lt,islt:xga,isc:white";
//var_dump($url);

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
//var_dump($page);

//preg_match_all('/img class="b-serp__list_item-img" src="(.*?)"/', $page, $matches, PREG_SET_ORDER);
preg_match_all('/rel="http:\/\/(.*?)"/', $page, $matches, PREG_SET_ORDER);

//var_dump($matches);

$images = array();
foreach($matches as $m)
{
	$image = str_replace('%2520', '%20', $m[1]);
		$images[] = 'http://'.urldecode($image);
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($images));