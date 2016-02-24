      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">
        <div class="product_detail" itemscope itemtype="http://schema.org/Product">
          <div class="left_panel">
            <div class="image_product">            
              <a href="<?=!empty($image) ? $image : '/images/no-image.jpg'?>" rel="lightbox" title="<?=$name?>">
                <img itemprop="image" src="<?=!empty($small) ? $small : (!empty($thumb) ? $thumb : '/images/no-image.jpg')?>" width="250" height="250" alt="<?=$name?>" title="<?=$name?>"/>
              </a>
              <? if ($create_date > date('Y-m-d H:i:s', time() - 60 * 60 * 24 * 1)) { ?>
                <img class="new_product" src="/images/novinka.png" alt="Новинка" title="Новинка"/>
              <? } ?>              
            </div>
            <br>
            <div class="yandex_market_recommend">
              <? if (mb_strlen($description) < 1500) { ?>
                <a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://market.yandex.ru/shop/190506/reviews/add"><img src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://img.yandex.ru/market/informer2.png" border="0" alt="Оцените качество магазина на Яндекс.Маркете." /></a>
              <? } else { ?>
                <a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://market.yandex.ru/shop/190506/reviews/add"><img src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://img.yandex.ru/market/informer9.png" border="0" alt="Оцените качество магазина на Яндекс.Маркете." /></a>
              <? } ?>
            </div>
            <br>
            <? if (!empty($recommend_products)) { ?>
              <h4>Мы рекомендуем:</h4>
              <table class="products">
                <? foreach ($recommend_products as $item) { ?>
                  <tr>                 
                    <td>
                      <a href="/catalog/detail/<?=$item['alias']?>" title="<?=$item['name']?>">
                        <div class="product" id="product_<?=$item['id']?>" onmouseover="$('#product_colors_<?=$item['id']?>').show()" onmouseout="$('#product_colors_<?=$item['id']?>').hide()">
                          <div class="product_image">
                            <img src="<?=!empty($item['thumb']) ? $item['thumb'] : '/images/no-image.jpg'?>" alt="<?=$item['name']?>" title="<?=$item['name']?>"/>
                            <? if ($item['create_date'] > date('Y-m-d H:i:s', time() - 60 * 60 * 24 * 7)) { ?>
                              <img class="new_product" src="/images/novinka.png" alt="Новинка" title="Новинка"/>
                            <? } ?>
                            <? if ($item['recommend']) { ?>
                              <img class="recommended_product" src="/images/recommended.png" alt="Рекомендуем" title="Рекомендуем"/>
                            <? } ?>
                          </div>
                          <div class="product_name">                            
                            <span><?=$item['name']?></span>                           
                          </div>
                          <div class="raiting_stars">
                            <div id="raiting">
                              <div id="raiting_blank"></div>                        
                              <div id="raiting_votes" style="width:<?=intval($item['rating'])*17;?>px; display: block;"></div>
                            </div>
                          </div><br>
                          <div class="product_price">
                            <span>
                              <span><?=$item['price']?> руб.</span>
                            </span>    
                          </div>                          
                        </div>
                      </a>                    
                    </td>
                  </tr>
                <? } ?>
              </table>
            <? } ?>
          </div>
          <img id="image_to_cart" src="<?=!empty($small) ? $small : '/images/no-image.jpg'?>" title="<?=$name?>" alt="<?=$name?>"/>          
          <? if (!empty($brand_image)) { ?><a href="/catalog/brand/<?=$brand_alias;?>" title="<?=$brand;?>"><img class="brand_image" src="<?=$brand_image;?>" title="<?=$brand;?>" alt="<?=$brand;?>"/></a><? } ?>
          <strong><?=$prefix?></strong>
          <h1 itemprop="name"><?=$name?></h1>
          <div id="product_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <meta itemprop="priceCurrency" content="RUB"></meta>
            <span itemprop="price"><?=$price?></span>.-
            <? if ($price>5000) { ?><p class="delivery_free"><img src="/images/dostavka.png" title="Доставка бесплатно!" alt="Доставка бесплатно!">Доставка бесплатно!</p><? } ?>
            <div id="add_to_cart">
              <a onclick="add_to_cart(<?=$color_id?>)" title="Добавить в корзину">
                <? if ($available) { ?><div class="button buy">В корзину</div><? } else { ?><div class="button buy">Под заказ</div><? } ?>
              </a>
            </div>
          </div>          
          <? if (!empty($brand_alias)) { ?><span class="manuf">Производитель: </span><a href="/catalog/brand/<?=$brand_alias;?>" title="<?=$brand;?>"><span itemprop="brand" class="brand_name"><?=$brand;?></span></a><? } ?><br>
          <? if ($create_date > date('Y-m-d H:i:s', time() - 60 * 60 * 24 * 7)) { ?>
            <img src="/images/novinka.png" alt="Новинка" title="Новинка"/>
          <? } ?>
          <? if ($recommend) { ?>
            <img src="/images/recommended.png" alt="Рекомендуем" title="Рекомендуем"/>
          <? } ?>          
          <div id="raiting_star" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
            <div id="raiting">
              <div id="raiting_blank"></div>
              <div id="raiting_hover"></div>
              <div id="raiting_votes"></div>
            </div>
            <div id="raiting_info"><img src="/images/load.gif" alt="Рейтинг" title="Рейтинг"/><h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Рейтинг: <span itemprop="ratingValue"><?=number_format($rating,1)?></span> Голосов: <span itemprop="ratingCount"><?=$votes?></span></h5></div><meta itemprop="bestRating" content="5">
            <br>
            <div class="fb-like" data-width="150" data-layout="button_count" data-action="recommend" data-show-faces="false" data-send="false"></div>&nbsp;&nbsp;
            <a href="https://twitter.com/share" title="Твитнуть" class="twitter-share-button" data-via="twitterapi" data-lang="ru">Твитнуть</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            <? if ($user) { ?>
              <br><a href="/admin/product/<?=$id?>/<?=$size_id?>/<?=$color_id?>" target="_blank" title="Редактирование"><img src="/images/admin_small.png" title="Редактирование" alt="Редактирование" /> Редактировать товар</a>                        
            <? } ?>            
          </div>          
          <? if ($product->product_sizes[0]->size != "Комплект") { ?>
            <span class="label">Единица измерения:<br></span>
            <? if ($product->product_sizes) foreach($product->product_sizes as $item) { ?>            
              <a href="/catalog/detail/<?=$product->alias?>/<?=$item->id?>" title="<?=$item->size?>">
                <div class="params <?=($item->id == $product->size_id) ? 'current' : '';?>">
                  <?=($item->id == $product->size_id) ? '<span itemprop="height">' : '';?>
                    <?=$item->size?>
                  <?=($item->id == $product->size_id) ? '</span>' : '';?>
                </div>
              </a>
            <? } ?>
          <? } ?>
          <? if ($product->product_colors[0]->color != "Стандарт") { ?>
            <br><br><span class="label">Цвета(материалы):<br></span>
            <? if($product->product_colors) foreach($product->product_colors as $item) { ?>
              <a onmouseover="$('#image_color_<?=$item->id?>').show();" onmouseout="$('#image_color_<?=$item->id?>').hide();" href="/catalog/detail/<?=$product->alias?>/<?=$item->size_id?>/<?=$item->id?>" title="<?=$item->color?>">
                <div class="params <?=($item->id == $product->color_id) ? 'current' : '';?>">
                  <?=($item->id == $product->color_id) ? '<span itemprop="color">' : '';?>
                    <?=$item->color?>
                  <?=($item->id == $product->color_id) ? '</span>' : '';?>
                  <div id="image_color_<?=$item->id?>" class="image_color">
                    <img src="<?=$item->small?>" alt="<?=$item->color?>" title="<?=$item->color?>"/>
                    <span class="product_colors_price"><?=$item->price?> руб.</span>
                  </div>
                </div>
              </a>
            <? } ?><br>
          <? } ?>                 
          <br>
          <div id="description_small">
            <span class="detail_description">
              <span itemprop="description"><?=$description_small?></span>
              <a href="javascript:void(0);" onclick="show_Description()" title="Подробнее"> Подробнее...</a>
            </span>
          </div>
          <br>
          <div id="description_full">
            <h2>Характеристики товара:</h2><br>
            <span class="detail_description"><article class="one"><?=$description?></article></span>
          </div><br>
          <? if (isset($additionally_items)) {?>
            <div id="additionally">
              <h4>Дополнительные товары:</h4> 
                <? foreach($additionally_items as $item) { ?>
                  <div class="additionally_items">
                    <a href="/catalog/detail/<?=$item->id?>">
                      <img src="<?=$item->small?>" width="50px;" title="<?=$item->name?>" alt="Дополнительные товары"/>
                    </a>
                  </div>
                <? } ?>
            </div>
          <? } ?>          
        </div>
        <div class="recommended_products">
          <? if (!empty($similar)) { ?>
            <h4>Похожие товары:</h4>
            <table class="products">
              <tr>
                <? foreach ($similar as $item) { ?>                
                  <td>
                    <a href="/catalog/detail/<?=$item['alias']?>" title="<?=$item['name']?>">
                      <div class="product" id="product_<?=$item['id']?>" onmouseover="$('#product_colors_<?=$item['id']?>').show()" onmouseout="$('#product_colors_<?=$item['id']?>').hide()">
                        <div class="product_image">
                          <img src="<?=!empty($item['thumb']) ? $item['thumb'] : '/images/no-image.jpg'?>" alt="<?=$item['name']?>" title="<?=$item['name']?>"/>
                          <? if ($item['create_date'] > date('Y-m-d H:i:s', time() - 60 * 60 * 24 * 7)) { ?>
                            <img class="new_product" src="/images/novinka.png" alt="Новинка" title="Новинка"/>
                          <? } ?>
                          <? if ($item['recommend']) { ?>
                            <img class="recommended_product" src="/images/recommended.png" alt="Рекомендуем" title="Рекомендуем"/>
                          <? } ?>
                        </div>
                        <div class="product_name">                          
                          <span><?=$item['name']?></span>                           
                        </div>
                        <div class="raiting_stars">
                          <div id="raiting">
                            <div id="raiting_blank"></div>                        
                            <div id="raiting_votes" style="width:<?=intval($item['rating'])*17;?>px; display: block;"></div>
                          </div>
                        </div><br>
                        <div class="product_price">
                          <span>                            
                            <span ><?=$item['price']?> руб.</span>
                          </span>    
                        </div>                          
                      </div>
                    </a>
                  </td>
                <? } ?>
              </tr>
            </table>
          <? } ?>
        </div>
        <div class="product_guarantie">
          <p>
            <h3>Гарантия на <?=mb_strtoupper($name)?>:</h3>
          На каждый товар распространяется гарантия. Вы всегда сможете проконсультироваться с нами по вопросу подключения и настройки купленного оборудования.<br>
          Продажа <strong><?=mb_strtoupper($name)?></strong> в нашем магазине возможна только по предварительному заказу.
          </p>
        </div>
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
        $( document ).ready(function() {          
          $('.image_product').animate({opacity:'1'}, 1000);    
        
          total_reiting = <?=$rating?>;
          votes = <?=$votes?>;
          id_arc = <?=$id?>;
          var star_widht = total_reiting*17 ;
          $('#raiting_votes').width(star_widht);
          he_voted = $.cookies.get('article'+id_arc);
          if(he_voted == null){
            $('#raiting').hover(function() {
              $('#raiting_votes, #raiting_hover').toggle();
            }, function() {
              $('#raiting_votes, #raiting_hover').toggle();
            });
            var margin_doc = $("#raiting").offset();
            $("#raiting").mousemove(function(e){
              var widht_votes = e.pageX - margin_doc.left;
              if (widht_votes == 0) widht_votes =1 ;
              user_votes = Math.ceil(widht_votes/17);  
              $('#raiting_hover').width(user_votes*17);
            });
            $('#raiting').click(function(){
              $('#raiting_info h5, #raiting_info img').toggle();
              jQuery.post("/admin/update_product_rating/"+id_arc,{ total_reiting:total_reiting, votes: votes, user_votes: user_votes}, function(data){
                $("#raiting_info h5").html("&nbsp;Ваш голос принят!");
                $('#raiting_votes').width((total_reiting + user_votes)*17/2);
                $('#raiting_info h5, #raiting_info img').toggle();
                $.cookies.set('article'+id_arc, 123, {hoursToLive: 1}); 
                $("#raiting").unbind();
                $('#raiting_hover').hide();
              })
            });
          }
          
          var brand_slides = document.getElementsByName("brand_slide");
          var cnt_brand_slides = brand_slides.length;
          console.log(cnt_brand_slides);
          $('#brand_slide_0').fadeIn(500);
          var t = 1;
          setInterval(function() { console.log(t); $('.brand_slide').hide(); $('#brand_slide_'+t).fadeIn(500);if (t<cnt_brand_slides-1) {t++;} else {t=0;}}, 3000)
          
        });
      </script>
      