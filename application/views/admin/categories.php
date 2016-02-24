      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Категории товаров</h1><br>
        <div id="edit_admin">
          <label>Фильтр по категории: </label><select onchange="filter_category()" id="filter_category">
              <option value="0"></option>
              <? foreach($categories as $item) { ?>
                  <? if($item->id == $item_id) {?><option selected value="<?=$item->id?>"><?=$item->title?></option><? } else { ?><option value="<?=$item->id?>"><?=$item->title?></option><?}?>
                <? } ?>
            </select><hr>
          <? if (!$item_id) { ?>                    
            <ul id="sortable" class="admin_categories">
              <? foreach ($categories as $item) { ?>     
                <li id="<?=$item->id?>" <?=(empty($item->image) ? 'class="red_li"' : '');?>>
                  <input id="cat_<?=$item->id?>" onchange="update_category(<?=$item->id?>)" onkeyup="translit('cat_<?=$item->id?>','cat_alias_<?=$item->id?>')" name="cat_<?=$item->id?>" placeholder="Введите название..." value="<?=$item->title?>">
                  
                  <input id="cat_alias_<?=$item->id?>" type="hidden" hidden="true" disabled="true" name="cat_alias_<?=$item->id?>" value="<?=$item->alias?>">
                  <a href="javascript:void();" onclick="add_category(<?=$item->id?>)">
                    <img src="/images/add.png" title="Добавить подкатегорию" alt="Добавить подкатегорию"/>
                  </a>
                  <a href="javascript:void();" onclick="delete_category(<?=$item->id?>)">
                    <img src="/images/delete.png" title="Удалить категорию" alt="Удалить категорию"/>
                  </a>                
                  <div class="img_panel" id="img_panel_<?=$item->id?>">
                    <h3><?=$item->title?></h3>
                    <a href="javascript:void();" onclick="close_image_panel(<?=$item->id?>)">
                      <img class="close" src="/images/close.png" title="Закрыть" alt="Закрыть"/>
                    </a><br>
                    <a class="zoom" href="<?=$item->image?>" rel="lightbox">
                      <img src="<?=$item->image?>" class="img_edit" title="Нажмите для увеличения" alt="Нажмите для увеличения"/>
                    </a><br>                    
                    <p>Введите URL картинки</p>
                    <input name="url_<?=$item->id?>" type="text" placeholder="Введите URL" value="<?=$item->image?>"><br><br>
                    <a href="javascript:void();" onclick="category_image_change(<?=$item->id?>)">Отправить</a>
                  </div>
                  <a href="javascript:void();" onclick="show_image_panel(<?=$item->id?>)">
                    <img src="/images/picture.png" title="Изменить картинку" alt="Изменить картинку"/>
                  </a>
                  <img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"/>
                  <br>Префикс товара: <input class="prefix" onchange="update_prefix(<?=$item->id?>)" id="cat_prefix_<?=$item->id?>" name="cat_prefix_<?=$item->id?>" value="<?=$item->prefix?>">
                  <? if ($item->subcategories) { ?>
                    <ul class="admin_subcategories">
                      <? foreach($item->subcategories as $c_item) { ?>
                        <li>                          
                            <input onchange="update_category(<?=$c_item->id?>)" id="cat_<?=$c_item->id?>" onkeyup="translit('cat_<?=$c_item->id?>','cat_alias_<?=$c_item->id?>')" name="cat_<?=$c_item->id?>" placeholder="Введите название подкатегории..." value="<?=$c_item->title?>">
                            
                            <input id="cat_alias_<?=$c_item->id?>" type="hidden" hidden="true" disabled="true" name="cat_alias_<?=$c_item->id?>" value="<?=$c_item->alias?>">
                            <a href="javascript:void();" onclick="delete_category(<?=$c_item->id?>)">
                              <img src="/images/delete.png" title="Удалить подкатегорию" alt="Удалить подкатегорию"/>
                            </a>
                            <br>Префикс товара: <input class="prefix" onchange="update_prefix(<?=$c_item->id?>)" id="cat_prefix_<?=$c_item->id?>" name="cat_prefix_<?=$c_item->id?>" value="<?=$c_item->prefix?>">
                        </li>
                      <? } ?>
                    </ul>
                  <? } ?>
                </li>
              <? } ?>
            <ul>
            <a href="javascript:void();" onclick="add_category(0)">
              <img src="/images/add.png" title="Добавить категорию" alt="Добавить категорию"/> Добавить категорию
            </a>
          <? } else { ?>            
            <ul class="admin_categories">
              <? foreach ($categories as $item) { ?>     
                 <? if ($item->id == $item_id) { ?>
                  <li>
                    <input onchange="update_category(<?=$item->id?>)" id="cat_<?=$item->id?>" name="cat_<?=$item->id?>" placeholder="Введите название..." value="<?=$item->title?>" onkeyup="translit('cat_<?=$item->id?>','cat_alias_<?=$item->id?>')">
                    
                    <input id="cat_alias_<?=$item->id?>" type="hidden" hidden="true" disabled="true" name="cat_alias_<?=$item->id?>" value="<?=$item->alias?>">
                    <a href="javascript:void();" onclick="add_category(<?=$item->id?>)">
                      <img src="/images/add.png" title="Добавить подкатегорию" alt="Добавить подкатегорию"/>
                    </a>
                    <a href="javascript:void();" onclick="delete_category(<?=$item->id?>)">
                      <img src="/images/delete.png" title="Удалить категорию" alt="Удалить категорию"/>
                    </a>                
                    <div class="img_panel" id="img_panel_<?=$item->id?>">
                      <a href="javascript:void();" onclick="close_image_panel(<?=$item->id?>)">
                        <img class="close" src="/images/close.png" title="Закрыть" alt="Закрыть"/>
                      </a><br>
                      <a class="zoom" href="<?=$item->image?>" rel="lightbox">
                        <img src="<?=$item->image?>" class="img_edit" title="Нажмите для увеличения" alt="Нажмите для увеличения"/>
                      </a>
                      <p>Введите URL картинки</p>
                      <input name="url_<?=$item->id?>" type="text" placeholder="Введите URL">                  
                      <a href="javascript:void();" onclick="category_image_change(<?=$item->id?>)">Отправить</a>
                    </div>
                    <a href="javascript:void();" onclick="show_image_panel(<?=$item->id?>)">
                      <img src="/images/picture.png" title="Изменить картинку" alt="Изменить картинку"/>
                    </a>
                    <br>Префикс товара: <input class="prefix" onchange="update_prefix(<?=$item->id?>)" id="cat_prefix_<?=$item->id?>" name="cat_prefix_<?=$item->id?>" value="<?=$item->prefix?>">
                    <? if ($item->subcategories) { ?>
                      <ul id="sortable" class="admin_subcategories">
                        <? foreach($item->subcategories as $c_item) { ?>
                          <li id="<?=$c_item->id?>">                     
                              <input onchange="update_category(<?=$c_item->id?>)" id="cat_<?=$c_item->id?>" name="cat_<?=$c_item->id?>" placeholder="Введите название подкатегории..." value="<?=$c_item->title?>" onkeyup="translit('cat_<?=$c_item->id?>','cat_alias_<?=$c_item->id?>')">
                              <input id="cat_alias_<?=$c_item->id?>" type="hidden" hidden="true" disabled="true" name="cat_alias_<?=$c_item->id?>" value="<?=$c_item->alias?>">
                              <img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"/>
                              <a href="javascript:void();" onclick="delete_category(<?=$c_item->id?>)">
                                <img src="/images/delete.png" title="Удалить подкатегорию" alt="Удалить подкатегорию"/>
                              </a>
                              <br>Префикс товара: <input class="prefix" onchange="update_prefix(<?=$c_item->id?>)" id="cat_prefix_<?=$c_item->id?>" name="cat_prefix_<?=$c_item->id?>" value="<?=$c_item->prefix?>">
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
            jQuery.post("/admin/category_sort", {mass: mass},function() {location.reload()});
          }
        });        
      });
      
    var rusChars = new Array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ч','ц','ш','щ','э','ю','\я','ы','ъ','ь', ' ', '\'', '\"', '\#', '\$', '\%', '\&', '\*', '\,', '\:', '\;', '\<', '\>', '\?', '\[', '\]', '\^', '\{', '\}', '\|', '\!', '\@', '\(', '\)', '\-', '\=', '\+', '\/', '\\');
		var transChars = new Array('a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','ch','c','sh','csh','e','ju','ja','y','', '', '_', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
		var from = "";
		 
		function translit(cat, alias)
		  {
		  console.log(cat);
      from = document.getElementById(cat).value;
      console.log(from);
		  from = from.toLowerCase();
		  var to = "";
		  var len = from.length;
		  var character, isRus;
		  for(var i=0; i < len; i++)
			{
			character = from.charAt(i,1);
			isRus = false;
			for(var j=0; j < rusChars.length; j++)
			  {
			  if(character == rusChars[j])
				{
				isRus = true;
				break;
				}
			  }
			to += (isRus) ? transChars[j] : character;
			}
		   document.getElementById(alias).value = to;
		  }
    </script>      