      <div id="base" itemscope itemtype="http://schema.org/Article" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">
        <strong itemprop="articleSection">НОВОСТИ</strong>
        <h1 itemprop="name"><?=$news_page->title?></h1>
        <a href="https://plus.google.com/105477929575507273845" rel="publisher">NDURAL.RU</a>
         | <span itemprop="datePublished" content="<?=$news_page->created?>"><?=$news_page->created?></span>
        <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,gplus" data-yashareTheme="counter"></div> 
        <hr>
        <!-- Поделиться -->
        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
        <div id="view_page">
          <img itemprop="image" class="news_image" width="400" src="/<?=$news_page->image?>" alt="<?=$news_page->title?>" title="<?=$news_page->description?>" />
          <span itemprop="articleBody"><?=$news_page->text?></span>
          <? if (!empty($news_page->video)) { ?><iframe id="ytplayer" type="text/html" width="400" height="300" src="https://www.youtube.com/embed/<?=$news_page->video?>?rel=0&showinfo=0&color=white&theme=light" frameborder="0" allowfullscreen></iframe><? } ?>
          <div id="vk_comments"></div>
          <script type="text/javascript">VK.Widgets.Comments("vk_comments", {limit: 5, attach: "*"});</script>
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
        <meta itemprop="url" content="http://ndural.ru/shop/news/<?=$news_page->alias?>">
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