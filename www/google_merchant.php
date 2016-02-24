<?
include_once"tools/db_connect.php";

$csite = "http://ndural.ru";
$cname = "Интернет автомагазин в Екатеринбурге";
$cdesc = "Продажа автосигнализаций, автомагнитол, усилителей, шумоизоляции и видеорегистраторов в Екатеринбурге";

header('Content-Type: application/xml; charset="utf-8"');

$google ='<?xml version="1.0"?>
<rss version="2.0" 
xmlns:g="http://base.google.com/ns/1.0">
<channel>
<title>'.$cname.'</title>
		<link>'.$csite.'</link>
		<description>'.$cdesc.'</description>';		

$query = "SELECT t1.*, t2.size, t3.color, t3.price, t3.image, t4.id as category_id, t4.prefix as category, t5.title as brand
          FROM products t1           
          JOIN products_sizes t2 ON t2.parent_id = t1.id
          JOIN products_colors t3 ON t3.parent_id = t1.id
          JOIN categories t4 ON t4.id = t1.categories_id
          JOIN brands t5 ON t5.id = t1.brand_id
          WHERE t1.available = 1
            AND t1.categories_id!=999
          ORDER by id";
$result = mysql_query($query);
	while ($row_product= mysql_fetch_array($result)) 
	{
		$id = $row_product["id"];
		$name = $row_product["name"];
    $alias = $row_product["alias"];
		$price = $row_product["price"];
		$ed_izm = $row_product["size"];
		$promo = $row_product["description_small"];		
		$picture = $row_product["image"];		
		$wcategory = $row_product["category_id"];	
    $desc_cat = $row_product["category"];	
		$manufacturer = $row_product["brand"];
		$rating = $row_product["rating"];
		
		$google .= "\n			<item>\n";
		$google .= "				<title>".$name."</title>\n";
		$google .= "				<link>http://ndural.ru/catalog/detail/".$alias."</link>\n";
		$google .= "				<description>".$promo."</description>\n";
		$google .= "				<g:image_link>http://ndural.ru".$picture."</g:image_link>\n";
		$google .= "				<g:google_product_category>Автотовары</g:google_product_category>\n";
		$google .= "				<g:price>".$price." руб.</g:price>\n";
		$google .= "				<g:brand>".$manufacturer."</g:brand>\n";
    $google .= "				<g:product_type>".$desc_cat."</g:product_type>\n";
		$google .= "				<g:availability>in stock</g:availability>\n";
		$google .= "				<g:tax>
										<g:country>RU</g:country>
										<g:rate>".$rating."</g:rate>
									</g:tax>\n";
		$google .= "				<g:shipping>
										<g:country>RU</g:country>
										<g:service>Курьер</g:service>
										<g:price>200 руб.</g:price>
									</g:shipping>\n";
		$google .= "				<g:condition>new</g:condition>\n";
		$google .= "				<g:id>".$id."</g:id>\n";			
		$google .= "			</item>\n";
	}

$google .= "	</channel>
</rss>";
echo $google;

$google_file = fopen ( "google_merchant.xml", "w" ); 
fwrite ( $google_file, $google ); 
fclose ( $google_file );

?>