    <script src="/js/ckeditor/ckeditor.js"></script>
	    <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">        
        <h1>Редактирование страницы</h1><br>
        <div id="edit_page">
          <form method="post" action="<?=$page->id?>/save">
            <table width="100%">
              <tr>
                <td>Название:</td>
                <td>Alias:</td>
              </tr>
              <tr>
                <td><input class="edit_product_input" name="page_title" placeholder="Введите заголовок..." value="<?=$page->title?>"></td>
                <td><input class="edit_product_input" name="page_alias" placeholder="Введите alias..." value="<?=$page->alias?>"></td>
              </tr>
              <tr>
                <td>Текст:</td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2"><textarea class="ckeditor" name="page_text"><?=$page->text?></textarea></td>
              </tr>
              <tr>
                <td><?  $text = iconv("UTF-8", "windows-1251", $page->text);
                        for ( $i = 192, $list = "Ёё"; $i < 256; $list .= chr($i), $i++ ); ?>
                        Кол-во слов: <?=str_word_count($text, 0, $list);?> - не менее 250</td>
                <td><input class="button" type="submit" value="Сохранить"></td>
              </tr>
            </table>          
          </form>
        </div>
      </div>    