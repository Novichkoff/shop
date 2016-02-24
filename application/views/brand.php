      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">
          <? if ($num_products==-1) { ?>
            <h1><?=$title;?></h1>
          <br>
            <h4>В данной категории пока нет товаров</h4>
          <? } else { ?>
        <div class="sort">
          Сортировать:<br>
          <a href="<?=$base_url;?>name" rel="nofollow" title="Сортировать по названию">по названию</a><br>
          <a href="<?=$base_url;?>price" rel="nofollow" title="Сортировать по цене">по цене</a><br>          
			  </div>
			  <h1><?=$title;?></h1>
			        <table class="products">
                <tr>
                  <? $count = 0; foreach ($products as $item) { ?>
                    <td>
                      <a href="/catalog/detail/<?=$item['alias']?>" title="<?=$item['name']?>">
                        <div itemtype="http://schema.org/Product" itemscope="itemscope" class="product" id="product_<?=$item['id']?>" onmouseover="$('#product_colors_<?=$item['id']?>').show()" onmouseout="$('#product_colors_<?=$item['id']?>').hide()">
                          <div class="product_image">
                            <img src="<?=!empty($item['thumb']) ? $item['thumb'] : '/images/no-image.jpg'?>" alt="<?=$item['name']?>" title="<?=$item['name']?>"/>
                            <? if ($item['create_date'] > date('Y-m-d H:i:s', time() - 60 * 60 * 24 * 1)) { ?>
                              <img class="new_product" src="/images/novinka.png" alt="Новинка" title="Новинка"/>
                            <? } ?>                     
                          </div>
                          <div class="product_name">
                            <meta itemprop="name" content="<?=$item['name']?>"/>
                            <span><?=$item['name']?></span>                           
                          </div>
                          <div class="raiting_stars">
                            <div id="raiting">
                              <div id="raiting_blank"></div>                        
                              <div id="raiting_votes" style="width:<?=intval($item['rating'])*17;?>px; display: block;"></div>
                            </div>
                          </div><br>
                          <div class="product_price">
                            <span itemtype="http://schema.org/Offer" itemprop="offers" itemscope="itemscope">
                              <meta itemprop="priceCurrency" content="RUB"></meta>
                              <span itemprop="price"><?=$item['price']?>.</span>
                            </span>
                          </div>                          
                        </div>
                      </a>
                    </td>              
                    <? if ($count==3) { ?></tr><tr><? $count=0;} else { $count++;}
                    } ?>
                </tr>
              </table>           
            <div class="pagination"><?=$pagination;?></div>
          <? } ?>
      </div>     