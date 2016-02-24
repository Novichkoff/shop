      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <br><h1>Новости</h1>
        <div>            
        <hr>
          <? if ($news) { ?>
            <table class="news">            
              <? foreach ($news as $item) { ?>
                <tr>
                  <td><a href="/shop/news/<?=$item->alias?>" title="<?=$item->title?>"><img class="news_images" width="150" src="/<?=$item->thumb?>" alt="<?=$item->title?>" title="<?=$item->description?>"/></a></td>                  
                  <td>
                    <a href="/shop/news/<?=$item->alias?>" title="<?=$item->title?>"><h2><?=$item->title?></h2></a>
                    <p>Опубликовано: <?=$item->created?></p>
                    <p><?=$item->description?></p>
                  </td>
                </tr>
              <? } ?>
            </table>
          <? } else { ?>
            <br><span>Нет новостей</span><br><br>
          <? } ?>            
        </div>        
      </div>    