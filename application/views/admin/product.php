    <script src="/js/ckeditor/ckeditor.js"></script>  
      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">        
        <h1>Редактирование товара</h1><br>
        <div class="edit_product">
          <div class="left_panel">
            <div class="image_product" style="opacity: 1;">
              Изображение:<br>
              <input id="prod_image" class="edit_product_input" onchange="update_product_image(<?=$product->color_id?>)" name="product_image" placeholder="Введите URL..." value="<?=$product->image?>"><br>
              <img id="img_src" src="<?=!empty($product->image) ? $product->image : '/images/no-image.jpg'?>" alt="<?=$product->name?>" title="<?=$product->name?>"/><br>
              Подобрать изображения: 
              <a href="#" id="images_wizard"><img src="/images/wand.png" alt="Подобрать автоматически" title="Подобрать автоматически"/></a>
              <div class="images">
                <ul class="gnut">                
                </ul>
              </div>
            </div>
          </div>
          ID товара: <strong><?=$product->id?></strong><br><br>
          Название товара:
          <input id="product_name" class="edit_product_input" onkeyup="translit()" onchange="update_product_name(<?=$product->id?>)" name="product_name" placeholder="Введите название..." value="<?=$product->name?>"><br>
          <input id="product_alias" disabled="true" name="product_alias" value="<?=$product->alias?>"><br><br>
          Производитель:
          <select onchange="product_brand_change(<?=$product->id?>)" id="brand">
            <option selected></option>
            <? foreach($brands as $item) { ?>
              <? if($item->id == $product->brand_id) {?><option selected value="<?=$item->id?>"><?=$item->title?></option><? } else { ?><option value="<?=$item->id?>"><?=$item->title?></option><?}?>
            <? } ?>
          </select>
          <a href="#" onclick="$('#add_brand').show(200)"><img src="/images/add.png" alt="Добавить производителя" title="Добавить производителя"/></a><input class="add_brand" onchange="add_brand_name()" id="add_brand" placeholder="Введите производителя...">
          <br><br>
          Категория товара:
          <select onchange="product_category_change(<?=$product->id?>)" id="category">
            <option selected></option>
            <? foreach($categories as $item) { ?>
              <? if($item->id == $product->parent_id) {?><option selected value="<?=$item->id?>"><?=$item->title?></option><? } else { ?><option value="<?=$item->id?>"><?=$item->title?></option><?}?>
            <? } ?>
          </select>
          <a href="#" onclick="$('#add_category').show(200)"><img src="/images/add.png" alt="Добавить категорию" title="Добавить категорию"/></a><input class="add_category" onchange="add_category_name()" id="add_category" placeholder="Введите категорию...">          
          <br><br>
          Подкатегория товара:
          <select onchange="product_subcategory_change(<?=$product->id?>)" id="subcategory">
            <option selected></option>
            <? foreach($subcategories as $item) { ?>
              <? if($item->id == $product->categories_id) {?><option selected value="<?=$item->id?>"><?=$item->title?></option><? } else { ?><option value="<?=$item->id?>"><?=$item->title?></option><?}?>
            <? } ?>
          </select>
          <a href="javascript:void();" onclick="$('#add_subcategory').show(200)"><img src="/images/add.png" alt="Добавить подкатегорию" title="Добавить подкатегорию"/></a><input class="add_subcategory" onchange="add_subcategory_name()" id="add_subcategory" placeholder="Введите подкатегорию...">
          <br><br>
          Рекомендуем:
          <input type="checkbox" onchange="update_product_recommend(<?=$product->id?>)" name="product_recommend" <?=($product->recommend ? 'checked' : '');?>><br>
          <div class="params_block">
          Размеры товара:<br>
          <? if ($product->product_sizes) foreach($product->product_sizes as $item) { ?>
            <div class="params <?=($item->id == $product->size_id) ? 'current' : '';?>"><a href="/admin/product/<?=$product->id?>/<?=$item->id?>" title="нажмите для редактирования цвета товара"><?=$item->size?></a><a href="javascript:void();" onclick="delete_size(<?=$product->id?>,<?=$item->id?>)" title="удалить размер"><img class="delete_params" src="/images/del.png" alt="удалить" title="удалить"/></a></div>
          <? } ?>
          <div class="add_params"><a href="javascript:void();"  onclick="show_add_size()"><img src="/images/add.png" alt="Добавить размер" title="Добавить размер"/></a><input class="add_size_color" onchange="add_size(<?=$product->id?>)" id="add_size" placeholder="Введите размер..."></div>
          </div>
          <div class="params_block">
          Цвета(материалы) товара выбранного размера:<br>
          <? if($product->product_colors) foreach($product->product_colors as $item) { ?>
            <div class="params <?=($item->id == $product->color_id) ? 'current' : '';?>"><a href="/admin/product/<?=$product->id?>/<?=$item->size_id?>/<?=$item->id?>" title="нажмите для редактирования цены товара"><?=$item->color?></a><a href="javascript:void();" onclick="delete_color(<?=$product->id?>,<?=$item->id?>)" title="удалить цвет"><img class="delete_params" src="/images/del.png" alt="удалить" title="удалить"/></a></div>
          <? } ?>
          <div class="add_params"><a href="javascript:void();" onclick="show_add_color()"><img src="/images/add.png" alt="Добавить цвет" title="Добавить цвет"/></a><input class="add_size_color" onchange="add_color(<?=$product->id?>, <?=$product->size_id?>)" id="add_color" placeholder="Введите цвет..."></div>
          </div>
          Цена товара для нас: <strong><?=$product->price_for_us?> руб.</strong> Прибыль: <strong><?=intval($product->price)-intval($product->price_for_us);?> руб.</strong><br>
          <div class="prices">
            <img src="/images/yandex_market.png"> Min=<input class="price_min" size="4" type="text"> Средняя=<input class="price_avg" size="4" type="text"> Max=<input class="price_max" size="4" type="text">
          </div>
          Цена товара:<br>
          <input class="edit_product_price" onchange="update_product_price(<?=$product->color_id?>)" name="product_price" placeholder="цена..." value="<?=$product->price?>"><br>   
          <br>          
          Короткое описание товара:<br>
          <textarea class="small_description_edit" onchange="update_product_description_small(<?=$product->id?>)" name="product_description_small"><?=$product->description_small?></textarea><br>
          <a href="javascript:void();" onclick="small_description(<?=$product->id?>)"><div class="params current">Сгенерировать короткое описание товара</div></a><br><br><br>
        </div>
        <div class="edit_product">
          Полное описание товара:   
          <a href="#" id="properties_wizard"><img src="/images/automator.png" alt="Подобрать автоматически" title="Подобрать автоматически"/></a>
           - подобрать автоматически <a href="https://www.google.ru/search?q=<?=$product->name?>" target="_blank"> : Сразу на Google >></a>      
          <form action="/admin/update_product_description/<?=$product->id?>" method="post">
            <textarea class="full_description_edit" onchange="update_product_description(<?=$product->id?>)" id="product_description" name="val"><?=$product->description?></textarea><br>            
          </form>
          <a href="javascript:void();" onclick="update_product_description(<?=$product->id?>)"><div class="params current">Сохранить</div></a>       
          <br><br><br>      
          Дополнительные товары:<br>
          <select data-placeholder="Выберите дополнительные товары..." id="additionally" name="additionally" multiple class="chosen-select" tabindex="5">
            <? if ($product->additionally_items)  { ?>
              <? foreach($all_products as $items) { ?>
                <? $selected = 0; ?> 
                <? foreach($product->additionally_items as $item) { ?>
                  <? $selected += ($item->id == $items->id) ? 1 : 0; ?>
                <? } ?>
                <option <?=($selected == 1) ? 'selected' : '';?> value="<?=$items->id?>"><?=$items->id?>. <?=$items->name?></option>
              <? } ?>
            <? } else { ?>
              <? foreach($all_products as $items) { ?>
                <option value="<?=$items->id?>"><?=$items->id?>. <?=$items->name?></option>
              <? } ?>
            <? } ?>
          </select><br><br>

          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
          <script src="/js/chosen.jquery.js" type="text/javascript"></script>          
          <script>
            var config = {
              '.chosen-select'           : {}             
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
          
          // --- Дополнительные товары ---
          
            $( "#additionally" ).change(function() {
              var mass = [];
              $('select[name="additionally"] option:selected').each(function() {
                mass.push($(this).val());
              });
              var all_values= mass.join(',');
              jQuery.post("/admin/product_additionally/<?=$product->id?>", {all_values: all_values}, function() {location.reload()}); 
            });
          
          // --- Волшебные картинки ---
          
          $(function() {
            name_changed = false;
            $("input[name=product_name]").change(function() {
              name_changed = true;
              images_loaded = 0;
            });	
            images_num = 20;
            images_loaded = 0;            
            old_wizar_dicon_src = $('#images_wizard img').attr('src');
            $('#images_wizard').click(function() {              
              $('#images_wizard img').attr('src', '/images/load.gif'); 
              if(name_changed)
                $('div.images ul li.wizard').remove();
              name_changed = false;
              key = $('input[name=product_name]').val();              
              $.ajax({
                 url: "/js/get_images.php",
                  data: {keyword: key, start: images_loaded},
                  dataType: 'json',
                    success: function(data){
                      console.log(data);
                      for(i=0; i<Math.min(data.length, images_num); i++)
                      {
                        image_url = data[i];
                        img_num = images_loaded+i;
                      $("<li class=wizard><a href='"+image_url+"' rel='lightbox'><img onerror='$(this).closest(\"li\").remove();' height='70px' src='"+image_url+"' /></a><a href='javascript:void();' class='add' onclick='update_producto_image(<?=$product->color_id?>,"+img_num+")' title='Использовать это изображение'><img src='/images/action.png' height='20px'><input id='immg_"+img_num+"' value='"+image_url+"' type='hidden'></a></li>").appendTo('div .images ul');
                      }
                    $('#images_wizard img').attr('src', old_wizar_dicon_src);
                    images_loaded += images_num;
                    }
              });
              return false;
            });
          }); 
          
          // --- Цены на Маркете ---
          
          $(function () {
              key = $('input[name=product_name]').val();              
              $.ajax({
                 url: "/js/get_in.php",
                  data: {keyword: key},
                  dataType: 'json',
                    success: function(data){
                      console.log(data);                      
                      if(data) {                        
                        if (data.min) { $('.price_min').attr('value', data.min); }
                        if (data.max) { $('.price_max').attr('value', data.max); }
                        if (data.avg) { $('.price_avg').attr('value', data.avg); }                                                
                      }                      
                    }
              });
              return false;
            });
		  
		      
    // Волшебное описание 
		  
		$(function() {
			name_changed = false;
			$("input[name=product_name]").change(function() {
              name_changed = true;              
            });				
			$('#properties_wizard').click(function() {  
				
				if(name_changed)
					$('div.images ul li.wizard').remove();
				name_changed = false;
				key = $('input[name=product_name]').val();
        $('#properties_wizard img').attr('src', '/images/load.gif');
				                       
        // --------- Яндекс.Маркет потом Wikimart------------

                $.ajax({   
                   url: "/js/get_info_wiki.php",
                    data: {keyword: key},
                    dataType: 'json',
                    success: function(data){              
                      if(data) {                         
                        wiki_data = "<ul class='products_param_desc'>";
                        for(i=0; i<data.options.length; i++) {                  
                          wiki_data += "<li><span class='param'>"+data.options[i].name+":<\/span> <span class='value'>"+data.options[i].value+"<\/span><\/li>\n";                  
                        }
                        wiki_data += "<\/ul>";                        
                        $('.full_description_edit').attr('value', wiki_data);
                        $('#properties_wizard img').attr('src', '/images/automator.png');  
                      } else {
                        $.ajax({   
                           url: "/js/get_info_ek.php",
                            data: {keyword: key},
                            dataType: 'json',
                            success: function(data){              
                              if(data) {                         
                                ek_data = "<h3>Описание</h3>";
                                if (data.description != 'undefined') { ek_data += data.description; }
                                if (data.table != 'undefined') { ek_data += data.table; }                                
                                $('.full_description_edit').attr('value', ek_data);                         
                              } 
                              $('#properties_wizard img').attr('src', '/images/automator.png');                      
                            },
                            error: function(xhr, textStatus, errorThrown){
                              alert("Error: " +textStatus);              
                            }                  
                        });
                      }   
                      $('#properties_wizard img').attr('src', '/images/automator.png');
                    },
                    error: function(xhr, textStatus, errorThrown){
                      alert("Error: " +textStatus);              
                    }                  
                });                      
				return false;
			});
    });
      
      
          
		var rusChars = new Array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ч','ц','ш','щ','э','ю','\я','ы','ъ','ь', ' ', '\'', '\"', '\#', '\$', '\%', '\&', '\*', '\,', '\:', '\;', '\<', '\>', '\?', '\[', '\]', '\^', '\{', '\}', '\|', '\!', '\@', '\(', '\)', '\-', '\=', '\+', '\/', '\\', '\.');
		var transChars = new Array('a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','ch','c','sh','csh','e','ju','ja','y','', '', '_', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
		var from = "";
		 
		function translit()
		  {
		  from = document.getElementById("product_name").value;
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
		   document.getElementById("product_alias").value = to;
		  }      
	</script>
        </div>
      </div>    