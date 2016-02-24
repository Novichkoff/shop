<?php

// Ключевое слово для поиска
$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

$url = "https://api.partner.market.yandex.ru/v2/models.json?query=".$keyword;
$page = get_page($url);
$json = json_decode($page);
$id = $json->models[0]->id;

$url = "https://api.partner.market.yandex.ru/v2/models/".$id.".json?";
$page = get_page($url);
$json = json_decode($page);
$prices = $json->models[0]->prices;

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($prices));

function get_page($url) {
  
  // Дополняем URL необходимыми данными
  $url .="&regionId=54"; // Регион: Екатеринбург
  $url .="&oauth_token=e0a361bc54c1468e84138bb1ebcd1bd9&oauth_login=nikita-novichkoff&oauth_client_id=eb5e78bbaaa7484c8274483ab290b099"; // Ключ API
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
  curl_setopt($ch, CURLOPT_FAILONERROR, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
  curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
  curl_setopt($ch, CURLOPT_TIMEOUT, 33); // times out after 4s
  $result = curl_exec($ch); // run the whole process
  curl_close($ch);
  return $result;  
}

?>