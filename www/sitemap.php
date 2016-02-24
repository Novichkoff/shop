<?php
include_once"tools/db_connect.php";

header('Content-Type: application/xml; charset="utf-8"');
$sitemap = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";
$sitemap .= "<url><loc>http://ndural.ru/</loc><changefreq>daily</changefreq><priority>1</priority></url>";
$sitemap .= "<url><loc>http://ndural.ru/shop/page/payment</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>";
$sitemap .= "<url><loc>http://ndural.ru/shop/page/delivery</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>";
$sitemap .= "<url><loc>http://ndural.ru/shop/page/guarantie</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>";
$sitemap .= "<url><loc>http://ndural.ru/shop/page/actions</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>";
$sitemap .= "<url><loc>http://ndural.ru/shop/page/sales</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>";
$sitemap .= "<url><loc>http://ndural.ru/shop/page/presents</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>";
$sitemap .= "<url><loc>http://ndural.ru/catalog/cart</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>";

	//----------------- НОВОСТИ --------------------
  $query = "SELECT * FROM news ORDER by id";
  $result = mysql_query($query) or die("Не могу выполнить запрос");
  while ($row= mysql_fetch_array($result)) {		
		$sitemap .= "<url><loc>http://ndural.ru/shop/news/".$row["alias"]."</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>";	
	}  
  
  //----------------- КАТЕГОРИИ ТОВАРОВ --------------------
  $query = "SELECT * FROM categories ORDER by id";
  $result = mysql_query($query) or die("Не могу выполнить запрос");
  while ($row= mysql_fetch_array($result)) {		
		$sitemap .= "<url><loc>http://ndural.ru/catalog/categories/".$row["alias"]."</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>";	
	}
  
  //----------------- БРЭНДЫ ТОВАРОВ --------------------
  $query = "SELECT * FROM brands ORDER by id";
  $result = mysql_query($query) or die("Не могу выполнить запрос");
  while ($row= mysql_fetch_array($result)) {		
		$sitemap .= "<url><loc>http://ndural.ru/catalog/brand/".$row["alias"]."</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>";	
	}
  
  //----------------- ДЕТАЛИ ТОВАРОВ --------------------
	$query = "SELECT * FROM products WHERE available = 1 AND categories_id!=999 ORDER by id";
  $result = mysql_query($query) or die("Не могу выполнить запрос");
  while ($row= mysql_fetch_array($result)) {
		$sitemap .= "<url><loc>http://ndural.ru/catalog/detail/".$row["alias"]."</loc><changefreq>daily</changefreq><priority>0.9</priority></url>";    
	}

$sitemap .= "</urlset>";

echo $sitemap;

$sitemap_file = fopen ( "sitemap.xml", "w" ); 
fwrite ( $sitemap_file, $sitemap ); 
fclose ( $sitemap_file );
?>