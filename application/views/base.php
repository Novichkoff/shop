      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">        
        <h1 class="center">Добро пожаловать в <?=$site->name?>!</h1>
        <? if (!empty($site->slides)) { ?>
          <div id="slider">
            <? $count=0; ?>
            <? foreach ($site->slides as $item) { ?>
              <div id="slide_<?=$count++;?>" class="slide" name="slide"><?=$item->text?></div>
            <? } ?>
          </div>
        <? } ?>
        <div id="categories_list">
          <? foreach ($categories as $item) { ?>
            <? if ($item->id != 999 && $item->image) {?>              
              <div class="main_page_categories" id="main_page_categories_<?=$item->id?>">
                <a href="/catalog/categories/<?=$item->alias?>" title="<?=$item->title?>">
                  <div class="image_category">
                    <img src="<?=$item->image?>" title="<?=$item->title?>" alt="<?=$item->title?>" width="150" height="150"/>
                  </div>
                  <div class="name_category">
                    <h2><?=$item->title?></h2>
                  </div>
                </a>
                <div class="main_page_subcategory">
                  <? $sub_count=0; ?>
                  <? foreach ($subcategories as $sub_item) { ?>                    
                    <? if ($sub_item->parent_id == $item->id) { ?>
                      <a href="/catalog/categories/<?=$sub_item->alias?>" title="<?=$item->title?> <?=$sub_item->title?>">
                        <h3><?=mb_strtolower($sub_item->title)?></h3>
                      </a>
                      <? if ($sub_count==5) { break; } else { $sub_count++; } ?>
                    <? } ?>                    
                  <? } ?>                    
                </div>                  
              </div>              
            <? } ?>
          <? } ?>
        </div>        
        <div>
          <h2 class="back_grey">Рекомендуемые товары:</h2>
          <table class="products">
            <tr>
              <? $count = 0; foreach ($recommend_products as $item) { ?>
                <td class="td_base">
                  <a href="/catalog/detail/<?=$item['alias']?>" title="<?=$item['name']?>">
                    <div class="product_long" id="products_<?=$item['id']?>">
                      <div class="product_image_long">
                        <img src="<?=!empty($item['thumb']) ? $item['thumb'] : '/images/no-image.jpg'?>" width="150" height="150" alt="<?=$item['name']?>" title="<?=$item['name']?>"/>
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
        </div>
        <div>
          <h2 class="back_grey">Самые популярные товары:</h2>        
          <table class="products">
            <tr>
              <? $count = 0; foreach ($products as $item) { ?>
                <td class="td_base">
                  <a href="/catalog/detail/<?=$item['alias']?>" title="<?=$item['name']?>">
                    <div class="product_long" id="products_<?=$item['id']?>">
                      <div class="product_image_long">
                        <img src="<?=!empty($item['thumb']) ? $item['thumb'] : '/images/no-image.jpg'?>" width="150" height="150" alt="<?=$item['name']?>" title="<?=$item['name']?>"/>
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
        </div>
        <div>
          <h2 class="back_grey">У нас представлены:</h2>
          <div id="brand_slider">            
            <? $i=0; ?>
            <div id="brand_slide_<?=$i?>" class="brand_slide" name="brand_slide">
              <table class="brands">
                <tr>
                  <? $count = 0; foreach ($brands as $item) { ?>
                    <? if ($item->image) { ?>
                      <td class="brand_base">                  
                        <a href="/catalog/brand/<?=$item->alias;?>" title="<?=$item->title;?>">
                          <img class="brand_image" src="<?=$item->image;?>" width="100" alt="<?=$item->title;?>" title="<?=$item->title;?>"/>
                        </a>
                      </td>                
                    <? } ?>
                    <? if ($count==6) { $i++; ?></tr></table></div><div id="brand_slide_<?=$i?>" class="brand_slide" name="brand_slide"><table class="brands"><tr><? $count=0;} else { $count++;} ?> 
                  <? } ?>
                </tr>
              </table>
            </div>
          </div>          
        </div>
      </div>      
      <script>
        $( document ).ready(function () {
          var slides = document.getElementsByName("slide");
          var cnt_slides = slides.length;
          $('#slide_0').fadeIn(1000);
          var i = 1;
          setInterval(function() { $('.slide').fadeOut(1000);$('#slide_'+i).fadeIn(1000);if (i!=cnt_slides-1) {i++;} else {i=0;}}, 10000);          
          var brand_slides = document.getElementsByName("brand_slide");
          var cnt_brand_slides = brand_slides.length;
          console.log(cnt_brand_slides);
          $('#brand_slide_0').fadeIn(500);
          var t = 1;
          setInterval(function() { console.log(t); $('.brand_slide').hide(); $('#brand_slide_'+t).fadeIn(500);if (t<cnt_brand_slides-1) {t++;} else {t=0;}}, 3000);
        });
      </script>          