    <script src="/js/ckeditor/ckeditor.js"></script>
	    <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">        
        <h1>Редактирование новости</h1><br>
        <div id="edit_page">
          <form method="post" action="<?=$page->id?>/save">
            <table width="100%">
              <tr>
                <td>Название:</td>
                <td>Alias:</td>
              </tr>
              <tr>
                <td><input class="edit_product_input" name="page_title" placeholder="Введите заголовок..." onkeyup="translit()" value="<?=$page->title?>"></td>
                <td><input class="edit_product_input" name="page_alias" placeholder="Введите alias..." value="<?=$page->alias?>"></td>
              </tr>
              <tr>
                <td>Изображение для новости:</td>
                <td>Видео для новости:</td>
              </tr>
              <tr>
                <td><input class="edit_product_input_img" name="page_image" value="<?=$page->image?>" /></td>
                <td><input class="edit_product_input_img" name="page_video" value="<?=$page->video?>" /></td>
              </tr>
              <tr>
                <td><? if (!empty($page->image)) { ?><img src="/<?=$page->image?>" /><? } ?></td>
                <td><? if (!empty($page->video)) { ?><iframe id="ytplayer" type="text/html" width="250" src="https://www.youtube.com/embed/<?=$page->video?>?rel=0&showinfo=0&color=white&theme=light" frameborder="0" allowfullscreen></iframe><? } ?></td>              
              </tr>
              <tr>
                <td>Текст:</td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2"><textarea class="ckeditor" name="page_text"><?=$page->text?></textarea></td>
              </tr>
              <tr>
                <td colspan="2"><?  $text = iconv("UTF-8", "windows-1251", $page->text);
                        for ( $i = 192, $list = "Ёё"; $i < 256; $list .= chr($i), $i++ ); ?>
                        <span class="<?=(str_word_count($text, 0, $list)<250) ? 'red' : '';?>">Кол-во слов: <?=str_word_count($text, 0, $list);?> - не менее 250</span></td>                
              </tr>              
              <tr>
                <td colspan="2"><h3>SEO</h3></td>
              </tr>
              <tr>
                <td colspan="2">Описание для поисковиков (100 знаков):</td>
              </tr>
              <tr>
                <td colspan="2"><input class="edit_product_input_full" name="page_description" value="<?=$page->description?>" /></td>
              </tr>
              <tr>
                <td colspan="2">Ключевые слова:</td>
              </tr>
              <tr>
                <td><input class="edit_product_input_full" name="page_keywords" value="<?=$page->keywords?>" /></td>
                <td><input class="button" type="submit" value="Сохранить"></td>
              </tr>              
            </table>          
          </form>
        </div>
      </div>
      <script>
        var rusChars = new Array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ч','ц','ш','щ','э','ю','\я','ы','ъ','ь', ' ', '\'', '\"', '\#', '\$', '\%', '\&', '\*', '\,', '\:', '\;', '\<', '\>', '\?', '\[', '\]', '\^', '\{', '\}', '\|', '\!', '\@', '\(', '\)', '\-', '\=', '\+', '\/', '\\', '\.');
        var transChars = new Array('a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','ch','c','sh','csh','e','ju','ja','y','', '', '_', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        var from = "";
         
        function translit() {
          from = document.getElementsByName("page_title")[0].value;
          from = from.toLowerCase();
          var to = "";
          var len = from.length;
          var character, isRus;
          for(var i=0; i < len; i++) {
            character = from.charAt(i,1);
            isRus = false;
            for(var j=0; j < rusChars.length; j++) {
              if(character == rusChars[j]) {
                isRus = true;
                break;
              }
            }
            to += (isRus) ? transChars[j] : character;
          }
          console.log(to);
          document.getElementsByName("page_alias")[0].value = to;
        }      
      </script>