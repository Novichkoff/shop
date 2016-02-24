      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Меню сайта</h1><br>
        <div id="edit_admin">
          <label>Фильтр по меню: </label><select onchange="filter_menu()" id="filter_menu">
              <option value="0"></option>
              <? foreach($menu as $item) { ?>
                  <? if($item->id == $item_id) {?><option selected value="<?=$item->id?>"><?=$item->title?></option><? } else { ?><option value="<?=$item->id?>"><?=$item->title?></option><?}?>
                <? } ?>
            </select><hr>
          <? if (!$item_id) { ?>                    
            <ul id="sortable" class="admin_menu">
              <? foreach ($menu as $item) { ?>     
                <li id="<?=$item->id?>">
                  <input onchange="update_menu(<?=$item->id?>)" name="cat_<?=$item->id?>" placeholder="Введите название..." value="<?=$item->title?>">
                  <a href="javascript:void();" onclick="add_menu(<?=$item->id?>)" title="Добавить подменю в категорию <?=$item->title?>">
                    <img src="/images/add.png" title="Добавить подменю в категорию <?=$item->title?>" alt="Добавить подменю в категорию <?=$item->title?>"/>
                  </a>
                  <a href="javascript:void();" onclick="delete_menu(<?=$item->id?>)">
                    <img src="/images/delete.png" title="Удалить меню" alt="Удалить меню"/>
                  </a>
                  <img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"/><br>
                  <input class="edit_url_menu" onchange="update_menu_url(<?=$item->id?>)" name="url_<?=$item->id?>" placeholder="Введите URL..." value="<?=$item->url?>">                  
                  <? if ($item->submenu) { ?>
                    <ul class="admin_submenu">
                      <? foreach($item->submenu as $c_item) { ?>
                        <li>                          
                          <input onchange="update_menu(<?=$c_item->id?>)" name="cat_<?=$c_item->id?>" placeholder="Введите название подкатегории..." value="<?=$c_item->title?>">                            
                          <a href="javascript:void();" onclick="delete_menu(<?=$c_item->id?>)">
                            <img src="/images/delete.png" title="Удалить подменю" alt="Удалить подменю"/>
                          </a><br>
                          <input class="edit_url_menu" onchange="update_menu_url(<?=$c_item->id?>)" name="url_<?=$c_item->id?>" placeholder="Введите URL..." value="<?=$c_item->url?>">
                          <img src="/images/link.png" title="Связать с подкатегорией" alt="Связать с подкатегорией"/>
                          <select onchange="link_menu(<?=$c_item->id?>)" class="link_menu" id="link_menu_<?=$c_item->id?>">
                            <option value="0"></option>
                            <? foreach($categories as $itemms) { ?>
                              <option value="<?=$itemms->id?>"><?=$itemms->title?></option>
                            <? } ?>
                          </select>                         
                        </li>
                      <? } ?>
                    </ul>
                  <? } ?>
                </li>
              <? } ?>
            <ul>
            <a href="javascript:void();" onclick="add_menu(0)" title="Добавить пункт меню">
              <img src="/images/add.png" title="Добавить пункт меню" alt="Добавить пункт меню"/> Добавить пункт меню</a>
          <? } else { ?>            
            <ul class="admin_menu">
              <? foreach ($menu as $item) { ?>     
                 <? if ($item->id == $item_id) { ?>
                  <li>
                    <input onchange="update_menu(<?=$item->id?>)" name="cat_<?=$item->id?>" placeholder="Введите название..." value="<?=$item->title?>">
                    <a href="javascript:void();" onclick="add_menu(<?=$item->id?>)">
                      <img src="/images/add.png" title="Добавить подменю" alt="Добавить подменю"/>
                    </a>
                    <a href="javascript:void();" onclick="delete_menu(<?=$item->id?>)">
                      <img src="/images/delete.png" title="Удалить меню" alt="Удалить меню"/>
                    </a><br>
                    <input class="edit_url_menu" onchange="update_menu_url(<?=$item->id?>)" name="url_<?=$item->id?>" placeholder="Введите URL..." value="<?=$item->url?>">
                    <? if ($item->submenu) { ?>
                      <ul id="sortable" class="admin_submenu">
                        <? foreach($item->submenu as $c_item) { ?>
                          <li id="<?=$c_item->id?>">                     
                            <input onchange="update_menu(<?=$c_item->id?>)" name="cat_<?=$c_item->id?>" placeholder="Введите название подкатегории..." value="<?=$c_item->title?>">
                            <img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"/>
                            <a href="javascript:void();" onclick="delete_menu(<?=$c_item->id?>)">
                              <img src="/images/delete.png" title="Удалить подменю" alt="Удалить подменю"/>
                            </a><br>
                            <input class="edit_url_menu" onchange="update_menu_url(<?=$c_item->id?>)" name="url_<?=$c_item->id?>" placeholder="Введите URL..." value="<?=$c_item->url?>">
                            <img src="/images/link.png" title="Связать с подкатегорией" alt="Связать с подкатегорией"/>
                            <select onchange="link_menu(<?=$c_item->id?>)" class="link_menu" id="link_menu_<?=$c_item->id?>">
                              <option value="0"></option>
                              <? foreach($categories as $itemms) { ?>
                                <option value="<?=$itemms->id?>"><?=$itemms->title?></option>
                              <? } ?>
                            </select>
                          </li>
                        <? } ?>
                      </ul>
                    <? } ?>
                  </li>
                <? } ?>  
              <? } ?>
            <ul>
          <? } ?>
        </div>        
      </div>
    <script>
      $(document).ready(function(){
        $('#sortable').sortable({ 
          revert:true,           
          placeholder: 'ui-state-highlight', 
          update: function(event, ui) {
            var mass=$(this).sortable('toArray');
            jQuery.post("/admin/menu_sort", {mass: mass},function() {location.reload()});
          }
        });        
      });
    </script>      