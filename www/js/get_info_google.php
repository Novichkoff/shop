<?php
$use_curl = true; // Использовать CURL
// Ключевое слово для поиска
$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

// Адрес страницы с результатами поиска
$url = "https://www.google.ru/search?q=".$keyword;

// Выбираем результаты поиска
$page = get_page($url);
$result->page = $page;

// Находим ссылку на описание товара
if(preg_match_all('/<h3 class="r"><a href="(.*?)" onmousedown="return/ui', $page, $matches))
	
  $product_url = reset($matches[1]);
  $page = get_page($product_url);
  $result->url = $page; 

if(preg_match_all('/<p>(.*?)<\/p>/ui', $page, $matches))
{
	// Описание товара	
	$result->description = $matches[1];
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($result));


function get_page($url, $use_curl=true)
{
	if($use_curl && function_exists('curl_init'))
	{
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
	    curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Для использования прокси используйте строки:
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
		//curl_setopt($ch, CURLOPT_PROXY, '88.85.108.16:8080'); 
		//curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:password'); 

		// Яндекс может нас отправить в редирект, так что нужно следовать за редиректом
		do{
			curl_setopt($ch, CURLOPT_URL, $url);
			$header = curl_exec($ch);
			$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($code == 301 || $code == 302)
			{
				preg_match('/Location:(.*?)\n/', $header, $matches);
				$url = trim(array_pop($matches));
			}
			else
				$code = 0;			
		}while($code);
		    			
		$page = curl_exec($ch);
		curl_close($ch); 
	}
	else
	{
		$page = file_get_contents($url);
	}
	return $page;
}