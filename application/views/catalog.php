      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">
        <? if ($num_products==-1) { ?>
          <h1><?=$h1;?></h1>
        <br>
          <h4>В данной категории пока нет товаров</h4>
        <? } else { ?>        
        <div class="sort">
          Сортировать:<br>
          <a href="<?=$base_url;?>name" rel="nofollow" title="Сортировать по названию">по названию</a><br>
          <a href="<?=$base_url;?>price" rel="nofollow" title="Сортировать по цене">по цене</a><br>
          <a href="<?=$base_url;?>brand" rel="nofollow" title="Сортировать по бренду">по бренду</a>
			  </div>
			  <h1><?=$h1;?></h1>
        <!-- Подкатегории -->
			  <? if ($categories) { ?>
          <div class="subcategories_list">
          <? foreach ($categories as $item) { ?>     
            <a href="/catalog/categories/<?=$item->alias?>" title="<?=$item->title?>">
            <div class="categories">
              <span><?=$item->title?> (<?=$item->num_products?>)</span>
            </div>
            </a>
          <? } ?>
          </div>
			  <? } ?>
        <!-- Бренды в категории -->
        <? if ($category_products_all) { 
          $prev_item = '';?>
          <br><div class="subcategories_list">
          <? foreach ($category_products_all as $item_cat) { ?>     
            <? if ($item_cat['title'] != $prev_item) { ?>
              <a href="/catalog/categories/<?=$alias;?>/id/1/<?=$item_cat['id']?>" title="<?=$title;?> <?=$item_cat['title']?>">
              <div class="categories_all">
                <span><?=$item_cat['title']?></span>
              </div>
              </a>
            <? $prev_item = $item_cat['title']; } ?>
          <? } ?>
          </div><br>
			  <? } ?>      
          <table class="products">
            <tr>
              <? $count = 0; foreach ($products as $item) { ?>
                <td class="td_base">
                  <a href="/catalog/detail/<?=$item['alias']?>" title="<?=$item['name']?>">
                    <div class="product_long" id="products_<?=$item['id']?>">
                      <div class="product_image_long">
                        <img src="<?=!empty($item['thumb']) ? $item['thumb'] : '/images/no-image.jpg'?>" alt="<?=$item['name']?>" title="<?=$item['name']?>"/>
                        <? if ($item['create_date'] > date('Y-m-d H:i:s', time() - 60 * 60 * 24 * 7)) { ?>
                          <img class="new_product" src="/images/novinka.png" alt="Новинка" title="Новинка"/>
                        <? } ?>
                        <? if ($item['recommend']) { ?>
                          <img class="recommended_product" src="/images/recommended.png" alt="Рекомендуем" title="Рекомендуем"/>
                        <? } ?>
                        <div id="raiting_stars">
                          <div id="raiting">
                            <div id="raiting_blank"></div>                        
                            <div id="raiting_votes" style="width:<?=intval($item['rating'])*17;?>px; display: block;"></div>
                          </div>
                        </div>
                      </div>
                      <div class="product_brand">
                        <? if ($item['brand_img']) { ?><img src="<?=$item['brand_img']?>" alt="<?=$item['brand']?>" title="<?=$item['brand']?>"><? } ?>
                      </div>
                      <div class="product_name_long">
                        <span><?=$item['name']?></span>
                      </div>                                            
                      <div class="product_description_long">
                        <span><?=$item['description_small']?></span>
                      </div>                      
                      <div class="product_price_long_red">
                        <span><?=$item['price']?>.-</span>
                      </div>
                    </div>
                  </a>
                </td>
                <? if ($count==2) { ?></tr><tr><? $count=0;} else { $count++;}
              } ?>
            </tr>
          </table>           
          <div class="pagination"><?=$pagination;?></div>
          <br>
        <? } ?>
        
        <div id="brand_slider">            
          <? $i=0; ?>
          <div id="brand_slide_<?=$i?>" class="brand_slide" name="brand_slide">
            <table class="brands">
              <tr>
                <? $count = 0; foreach ($brands as $item) { ?>
                  <? if ($item->image) { ?>
                    <td class="brand_base">                  
                      <a href="/catalog/brand/<?=$item->alias;?>" title="<?=$item->title;?>"><img class="brand_image" src="<?=$item->image;?>" alt="<?=$item->title;?>" title="<?=$item->title;?>"/></a>
                    </td>                
                  <? } ?>
                  <? if ($count==6) { $i++; ?></tr></table></div><div id="brand_slide_<?=$i?>" class="brand_slide" name="brand_slide"><table class="brands"><tr><? $count=0;} else { $count++;} ?> 
                <? } ?>
              </tr>
            </table>
          </div>
        </div>
        
      </div>
      
      <script>
        $( document ).ready(function () {         
          
          var brand_slides = document.getElementsByName("brand_slide");
          var cnt_brand_slides = brand_slides.length;
          console.log(cnt_brand_slides);
          $('#brand_slide_0').fadeIn(500);
          var t = 1;
          setInterval(function() { console.log(t); $('.brand_slide').hide(); $('#brand_slide_'+t).fadeIn(500);if (t<cnt_brand_slides-1) {t++;} else {t=0;}}, 3000)       
                
        });
      </script>