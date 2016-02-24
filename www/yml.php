<?

include_once"tools/db_connect.php";

$cdate = date("Y-m-d H:i",time());
$csite = "http://ndural.ru";
$cname = "Интернет автомагазин в Екатеринбурге";
$cdesc = "Продажа автосигнализаций, автомагнитол, усилителей, шумоизоляции и видеорегистраторов в Екатеринбурге";
$delivery = 200;

header('Content-Type: application/xml; charset="utf-8"');

$yandex ='<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="'.$cdate.'">
	<shop>
		<name>'.$cname.'</name>
		<company>'.$cdesc.'</company>
		<url>'.$csite.'</url>
		
		<currencies>
			<currency id="RUR" rate="1"/>
		</currencies>';
		
$yandex .= "\n\n		<categories>";

$query = "select * from categories where parent_id = 0 and id != 999 order by id"; 
$result = mysql_query($query);
	while ($row= mysql_fetch_array($result)) 
	{
		$id = $row["id"];
		$category = $row["title"];
		$yandex .= "\n			<category id=\"$id\">".$category."</category>\n";
			$qquery = "select * from categories where parent_id = ".$id." order by id"; 
			$qresult = mysql_query($qquery);
			while ($qrow= mysql_fetch_array($qresult))
			{
				$qid = $qrow["id"];
				$qcategory = $qrow["title"];
				if ($qcategory!=$category) {$yandex .= "				<category id=\"$qid\" parentId=\"$id\">".$qcategory."</category>\n";}		
			}
	}
$yandex .= "		</categories>\n";

$yandex .= "		<local_delivery_cost>".$delivery."</local_delivery_cost>\n";

$yandex .= "		<offers>\n";

$query = "SELECT t1.*, t2.size, t3.color, t3.price, t3.image, t4.id as category_id, t4.prefix as prefix, t5.title as brand
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
    $desc_cat = $row_product["prefix"];	
		$manufacturer = $row_product["brand"];
		$rating = $row_product["rating"];
		
		$yandex .= "\n			<offer id=\"$id\" type=\"vendor.model\" available=\"true\">\n";
		$yandex .= "				<url>http://ndural.ru/catalog/detail/".$alias."</url>\n";
		$yandex .= "				<price>".$price."</price>\n";	
		$yandex .= "				<currencyId>RUR</currencyId>\n";			
		$yandex .= "				<categoryId>".$wcategory."</categoryId>\n";
		$yandex .= "				<picture>http://ndural.ru".$picture."</picture>\n";		
		$yandex .= "				<typePrefix>".$desc_cat."</typePrefix>\n";				
		$yandex .= "				<vendor>".$manufacturer."</vendor>\n";
		$yandex .= "				<model>".$name."</model>\n";
		$yandex .= "				<description>".$promo."</description>\n";
		if ($ed_izm!="") {$yandex .= "				<param name=\"ед.изм.\" >".$ed_izm."</param>\n";}
		$yandex .= "			</offer>";
	}
$yandex .= "\n		</offers>\n";

$yandex .= "	</shop>
</yml_catalog>";
echo $yandex;

$yml_file = fopen ( "yml.xml", "w" ); 
fwrite ( $yml_file, $yandex ); 
fclose ( $yml_file );

?>