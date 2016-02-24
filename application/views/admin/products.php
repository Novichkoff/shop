      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Товары</h1><br>
        <div id="edit_admin">
            <label>Фильтр по подкатегории: </label><select onchange="filter_products()" id="filter_category">
              <option value="0"></option>
              <? foreach($categories as $item) { ?>
                  <? if($item->id == $item_id) {?><option selected value="<?=$item->id?>"><?=$item->title?></option><? } else { ?><option value="<?=$item->id?>"><?=$item->title?></option><?}?>
                <? } ?>
            </select>
            товаров:<?=$num_products?>
            <hr>
          <? if ($products) { ?>
            <table class="admin_products">            
              <? foreach ($products as $item) { ?>
                <? $color_row = '';?>
                <?  foreach ($products_no_image as $item_no_img) {                     
                      if ($item->id == $item_no_img->parent_id) {
                        $color_row = 'style="background:#FFD5D5;"';
                        break;
                      }
                    } ?>
                <tr>
                  <td <?=$color_row?>><?=$item->id?>.</td>                  
                  <td <?=$color_row?>>
                    <? if ($item->available) { ?>
                      <a href="/admin/product/<?=$item->id?>" title="Перейти к товару">
                        <span><?=$item->name?></span>
                      </a>
                    <? } else { ?>
                      <span><?=$item->name?></span>
                    <? } ?>                    
                  </td>
                  <td <?=$color_row?>>
                    <span><?=$item->price?></span>
                  </td>
                  <td <?=$color_row?>>
                    <a href="javascript:void();" onclick="delete_product(<?=$item->id?>)">
                      <img src="/images/delete.png" title="Удалить товар" alt="Удалить товар"/>
                    </a>
                  </td>
                </tr>
              <? } ?>
            </table>
          <? } else { ?>
            <br><span>В категории нет товаров</span><br><br>
          <? } ?>
            <div class="pagination"><?=$pagination;?></div>            
            <a href="javascript:void();" onclick="add_product()">
              <img src="/images/add.png" title="Добавить товар" alt="Добавить товар"/>Добавить товар
            </a>
        </div>        
      </div>    