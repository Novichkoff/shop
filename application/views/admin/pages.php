      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Страницы</h1><br>
        <div id="edit_admin">
            Всего страниц: <?=$num_pages?>
            <hr>
          <? if ($pages) { ?>
            <table class="admin_products">            
              <? foreach ($pages as $item) { ?>     
                <tr>
                  <td><?=$item->id?>.</td>                  
                  <td><a href="/admin/page/<?=$item->id?>" title="Перейти к странице"><span><?=$item->title?></span></a></td>
                  <td>
                    <?/*<a href="javascript:void();" onclick="delete_page(<?=$item->id?>)">
                      <img src="/images/delete.png" title="Удалить страницу" alt="Удалить страницу"/>
                    </a>*/?>
                  </td>
                </tr>
              <? } ?>
            </table>
          <? } else { ?>
            <br><span>Нет страниц</span><br><br>
          <? } ?>
            <div class="pagination"><?=$pagination;?></div>            
            <a href="javascript:void();" onclick="add_page()">
              <img src="/images/add.png" title="Добавить страницу" alt="Добавить страницу"/>Добавить страницу
            </a>
        </div>        
      </div>    