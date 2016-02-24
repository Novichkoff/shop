      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Детали заказа</h1><br>
        <div id="edit_admin" <?=($order->status=='Новый')? 'class="new_order order_detail"' : '';?><?=($order->status=='Оплачивается')? 'class="new_order order_detail"' : '';?><?=($order->status=='Подтвержден')? 'class="good_order order_detail"' : '';?><?=($order->status=='Оплачен')? 'class="good_order order_detail"' : '';?><?=($order->status=='Отменен')? 'class="bad_order order_detail"' : '';?>>
          <? $sum = 0;?>
          <? if ($order) { ?>
            <label>Имя:</label><br>
            <h2><?=$order->name?></h2>
            <label>Телефон:</label><br>
            <h2><?=$order->phone?></h2>
            <label>Адрес доставки:</label><br>
            <h3><?=$order->address?></h3>
            <label>E-mail:</label><br>
            <h3><?=$order->email?></h3>
            <label>Статус заказа: </label>
            <select onchange="status_change(<?=$order->id?>)" id="status_<?=$order->id?>">
              <option <?=($order->status=='Новый')? 'selected' : '';?> value="Новый">Новый</option>
              <option <?=($order->status=='В обработке')? 'selected' : '';?> value="В обработке">В обработке</option>
              <option <?=($order->status=='Оплачивается')? 'selected' : '';?> value="Оплачивается">Оплачивается</option>
              <option <?=($order->status=='Оплачен')? 'selected' : '';?> value="Оплачен">Оплачен</option>
              <option <?=($order->status=='Подтвержден')? 'selected' : '';?> value="Подтвержден">Подтвержден</option>
              <option <?=($order->status=='Отменен')? 'selected' : '';?> value="Отменен">Отменен</option>
              <option <?=($order->status=='Выполнен')? 'selected' : '';?> value="Выполнен">Выполнен</option>
            </select><a class="delete_order" href="javascript:void();" onclick="delete_order_detail(<?=$order->id?>)"><img src="/images/delete.png" title="Удалить заказ" alt="Удалить заказ"/></a><a class="delete_order" href="javascript:void();" onclick="delete_order_detail(<?=$order->id?>)">Удалить заказ</a><br><hr>
            <? foreach ($order->order_items as $item) { ?>     
              <span><?=$item->name?>, <?=$item->color?>, <?=$item->size?></span>
              <div style="text-align:right;">
                <h4><?=$item->product_count?> x <?=$item->price?>.00 = <?=($item->product_count * $item->price)?>.00</h4> 
              </div>
              <? $sum += ($item->product_count * $item->price);?>
            <? } ?>
            <hr>
            <div style="text-align:right;">
              <h3>ИТОГ: <?=$sum?>.00</h3>
            </div>
          <? } ?>                      
        </div>        
      </div>    