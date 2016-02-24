      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Новости</h1><br>
        <div id="edit_admin">
            Всего новостей: <?=$num_news?>
            <hr>
          <? if ($news) { ?>
            <table class="admin_products">            
              <? foreach ($news as $item) { ?>     
                <tr>
                  <td><?=$item->id?>.</td>                  
                  <td><a href="/admin/news_page/<?=$item->id?>" title="Перейти к новости"><span><?=$item->title?></span></a></td>
                  <td>
                    <a href="javascript:void();" onclick="delete_news_page(<?=$item->id?>)">
                      <img src="/images/delete.png" title="Удалить новость" alt="Удалить новость"/>
                    </a>
                  </td>
                </tr>
              <? } ?>
            </table>
          <? } else { ?>
            <br><span>Нет новостей</span><br><br>
          <? } ?>
            <div class="pagination"><?=$pagination;?></div>            
            <a href="javascript:void();" onclick="add_news_page()">
              <img src="/images/add.png" title="Добавить новость" alt="Добавить новость"/>Добавить новость
            </a>
        </div>        
      </div>    