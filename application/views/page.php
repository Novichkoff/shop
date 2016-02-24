      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">
        <h1><?=$page->title?></h1>
        <div id="view_page">
          <?=$page->text?>          
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
        $( document ).ready(function () {         
          
          var brand_slides = document.getElementsByName("brand_slide");
          var cnt_brand_slides = brand_slides.length;
          console.log(cnt_brand_slides);
          $('#brand_slide_0').fadeIn(500);
          var t = 1;
          setInterval(function() { console.log(t); $('.brand_slide').hide(); $('#brand_slide_'+t).fadeIn(500);if (t<cnt_brand_slides-1) {t++;} else {t=0;}}, 3000)       
                
        });
      </script>          