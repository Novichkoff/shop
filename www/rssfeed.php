<?php
define('DATE_FORMAT_RFC822','r');
header('Content-Type: application/xml; charset="utf-8"');

$lastBuildDate=date(DATE_FORMAT_RFC822);

$rssfeed = '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
    <title>Лента новостей NDURAL.RU</title>
    <link>http://ndural.ru</link>
    <description>Интеренет-автомагазин NDURAL.RU</description>
    <pubDate>'.$lastBuildDate.'</pubDate>
    <lastBuildDate>'.$lastBuildDate.'</lastBuildDate>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>Weblog Editor 2.0</generator>
	<image>
		<url>http://ndural.ru/images/logo.png</url>
		<title>Интеренет-автомагазин NDURAL.RU</title>
		<link>http://ekb-oriflame.ru</link>
		<description>
		<![CDATA[ У нас можно купить: автосигнализацию, автомагнитолу, акустику, сабвуфер, видеорегистратор, навигатор, мультимедийные системы и кабельную продукцию по очень низким ценам в Екатеринбурге. Мы работаем напрямую с авторизованными дилерами автоэлектроники и предлагаем быструю и удобную доставку в Екатеринбурге и полную гарантию на предлагаемые товары. Оформите заказ на сайте и мы сделаем все остальное. Мы предлагаем товары следующих брендов: Pioneer, Alpine, Sony, ParkVision, Prology, MBQuart, Vibe, Jaguar, Pantera, JBL, Infinity, Alligator, KGB, Clifford, GroundZero, Lanzar и др. ]]>
		</description>
	</image>
    <copyright>Copyright 2013 ndural.ru</copyright>
    <managingEditor>info@ndural.ru</managingEditor>
    <webMaster>novichkoff@icloud.com</webMaster>
    <language>ru</language>';

include_once "tools/db_connect.php";    
$query = "SELECT title, description, text, alias, image, UNIX_TIMESTAMP(created) as pubdate 
          FROM news
          ORDER by created desc
          LIMIT 0,10";

$res   = mysql_query($query);
while ($row=mysql_fetch_array($res)) {

$title    = strip_tags(trim($row['title']));
$anons    = $row['description'];
$author   = "NDURAL.RU";
$url      = "http://ndural.ru/shop/news/".$row['alias'];
$image    = "http://ndural.ru/".$row['image'];
$pubDate  = date(DATE_FORMAT_RFC822, $row['pubdate']);
$rssfeed .= '
    <item>
        <title>'.$title.'</title>
        <description><![CDATA[<div><img title="'.$title.'" src="'.$image.'" alt="'.$title.'" style"float:left;">
									<pre>'.$anons.'</pre>
									<a href="'.$url.'">Подробнее...</a></div>]]></description>
        <link>'.$url.'</link>
		<author>'.$author.'</author>
		<enclosure url="http://ndural.ru/'.$picture.'" type="image/jpeg"/>
        <guid isPermaLink="true">'.$url.'</guid>
        <pubDate>'.$pubDate.'</pubDate>
    </item>';
}

$rssfeed .= '</channel>
</rss>';

echo $rssfeed;

$rssfeed_file = fopen ( "rssfeed.xml", "w" ); 
fwrite ( $rssfeed_file, $rssfeed ); 
fclose ( $rssfeed_file );
?>