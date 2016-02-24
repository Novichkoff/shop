      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Производители товаров</h1><br>
        <div id="edit_admin">
          <hr>                         
          <ul id="sortable" class="admin_categories">
            <? foreach ($brands as $item) { ?>     
              <li id="<?=$item->id?>" <?=(empty($item->image) ? 'class="red_li"' : '');?>>
                <input id="brand_<?=$item->id?>" onchange="update_brand(<?=$item->id?>)" onkeyup="translit('brand_<?=$item->id?>','brand_alias_<?=$item->id?>')" name="brand_<?=$item->id?>" placeholder="Введите название..." value="<?=$item->title?>">
                <input id="brand_alias_<?=$item->id?>" type="hidden" hidden="true" disabled="true" name="brand_alias_<?=$item->id?>" value="<?=$item->alias?>">                
                <a href="javascript:void();" onclick="delete_brand(<?=$item->id?>)">
                  <img src="/images/delete.png" title="Удалить производителя" alt="Удалить производителя"/>
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
                  <a href="javascript:void();" onclick="brand_image_change(<?=$item->id?>)">Отправить</a>
                </div>
                <a href="javascript:void();" onclick="show_image_panel(<?=$item->id?>)">
                  <img src="/images/picture.png" title="Изменить картинку" alt="Изменить картинку"/>
                </a>
                <img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"/>                  
              </li>
            <? } ?>
          <ul>
          <a href="javascript:void();" onclick="add_brand(0)">
            <img src="/images/add.png" title="Добавить производителя" alt="Добавить производителя"/> Добавить производителя
          </a>          
        </div>        
      </div>
    <script>
      $(document).ready(function(){
        $('#sortable').sortable({ 
          revert:true,           
          placeholder: 'ui-state-highlight', 
          update: function(event, ui) {
            var mass=$(this).sortable('toArray');
            jQuery.post("/admin/brand_sort", {mass: mass},function() {location.reload()});
          }
        });        
      });
      
    var rusChars = new Array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ч','ц','ш','щ','э','ю','\я','ы','ъ','ь', ' ', '\'', '\"', '\#', '\$', '\%', '\&', '\*', '\,', '\:', '\;', '\<', '\>', '\?', '\[', '\]', '\^', '\{', '\}', '\|', '\!', '\@', '\(', '\)', '\-', '\=', '\+', '\/', '\\');
		var transChars = new Array('a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','ch','c','sh','csh','e','ju','ja','y','', '', '_', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
		var from = "";
		 
		function translit(brand, alias)
		  {
		  console.log(brand);
      from = document.getElementById(brand).value;
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