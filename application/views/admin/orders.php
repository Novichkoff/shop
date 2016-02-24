      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Заказы</h1><br>
        <div id="edit_admin">            
          <? if ($orders) { ?>
            <table class="admin_products">
              <thead>
                <tr>
                  <td>№</td>
                  <td>Имя</td>
                  <td>Телефон</td>
                  <td>Статус</td>
                  <td></td>
                </tr>
              </thead>
              <? foreach ($orders as $item) { ?>     
                <tr <?=($item->status=='Новый' || $item->status=='В обработке')? 'class="new_order"' : '';?>
                  <?=($item->status=='Отменен')? 'class="bad_order"' : '';?>
                  <?=($item->status=='Оплачивается')? 'class="new_order"' : '';?>
                  <?=($item->status=='Оплачен')? 'class="good_order"' : '';?>
                  <?=($item->status=='Подтвержден')? 'class="good_order"' : '';?>
                  <?=($item->status=='Выполнен')? 'class="ok_order"' : '';?>>
                  <td>&nbsp<a href="/admin/order/<?=$item->id?>" title="Перейти к заказу"><?=$item->id?></a></td>
                  <td><a href="/admin/order/<?=$item->id?>" title="Перейти к заказу"><span><?=$item->name?></span></a></td>
                  <td><a href="/admin/order/<?=$item->id?>" title="Перейти к заказу"><span><?=$item->phone?></span></a></td>
                  <td>
                    <select onchange="status_change(<?=$item->id?>)" id="status_<?=$item->id?>">
                      <option <?=($item->status=='Новый')? 'selected' : '';?> value="Новый">Новый</option>
                      <option <?=($item->status=='В обработке')? 'selected' : '';?> value="В обработке">В обработке</option>
                      <option <?=($item->status=='Оплачивается')? 'selected' : '';?> value="Оплачивается">Оплачивается</option>
                      <option <?=($item->status=='Подтвержден')? 'selected' : '';?> value="Подтвержден">Подтвержден</option>
                      <option <?=($item->status=='Оплачен')? 'selected' : '';?> value="Оплачен">Оплачен</option>
                      <option <?=($item->status=='Отменен')? 'selected' : '';?> value="Отменен">Отменен</option>
                      <option <?=($item->status=='Выполнен')? 'selected' : '';?> value="Выполнен">Выполнен</option>
                    </select>                    
                  <td>
                    <a href="javascript:void();" onclick="delete_order(<?=$item->id?>)">
                      <img src="/images/delete.png" title="Удалить заказ" alt="Удалить заказ"/>
                    </a>
                  </td>
                </tr>               
              <? } ?>
            </table>
          <? } else { ?>
            <br><span>Нет заказов</span><br><br>
          <? } ?>                      
        </div>        
      </div>    