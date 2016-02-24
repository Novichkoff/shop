      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">
        <h1>Корзина товаров</h1>
        <table class="cart_table">
                <thead>
                  <th></th>                  
                  <th>Наименование, цвет</th>
                  <th>Ед.изм.</th>
                  <th>Цена</th>
                  <th>Кол-во</th>
                  <th>Общ.цена</th>                  
                </thead>
            <? $sum = 0;?>
            <? foreach($cart as $item) { ?>
              <? if (!empty($item)) {?>
                <tr id="row_<?=$item->id?>">
                  <td><a href="<?=!empty($item->image) ? $item->image : '/images/no-image.jpg'?>" rel="lightbox"><img src="<?=!empty($item->image) ? $item->image : '/images/no-image.jpg'?>" width="40px"/></a></td>
                  <td><?=$item->name?><?if($item->color!="Стандарт"){?>, <?=$item->color?><?}?></a></td>
                  <td class="center"><?=$item->size?></td>
                  <td class="center"><?=$item->price?> руб.</td>
                  <td class="center">
                    <input size="1" name="<?=$item->id?>" value="<?=$item->product_count?>"/><br>
                    <a class="cart_button" onclick="update_cart_item(<?=$item->id?>)" title="Обновить">обновить</a><br>
                    <a class="cart_button" onclick="delete_cart_item(<?=$item->id?>)" title="Удалить">удалить</a>
                  </td>
                  <td class="right"><?=$item->price * $item->product_count;?> руб.</td>
                </tr>
                <? $sum += $item->price * $item->product_count;?>
              <? } ?>              
            <? } ?>
            <? if ($sum<5000 && $sum>0) {?>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="2" class="center">Доставка:</td>                  
                  <td class="right"><strong>200 руб.</strong></td>
                </tr>
              <? $sum += 200;?>
            <? } ?>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="2" class="center">Общая цена:</td>                  
                  <td class="right"><strong><?=$sum?> руб.</strong></td>
                </tr>
        </table>
        <div class="accept_cart">         
          <a onclick="clear_cart()" title="Очистить список">
            <div class="button">Очистить список</div>
          </a>
        </div>
        <? if ($sum) { ?>
          <div id="order">
            <h2>Оформление заказа:</h2>
            <p>Для жителей Екатеринбурга!<br><br>Пожалуйста, заполните все поля отмеченные звездочками.<br>Укажите адрес электронной почты, чтобы получать уведомления о статусе заказа.</p>
            <label>Ваше имя:</label>
            <input id="client_name">*<br><br>
            <label>Контактный телефон:</label>
            <input id="client_phone">*<br>
            <span class="description_order">(формат: 79091234567)</span><br>
            <label>Адрес доставки:</label>
            <input id="client_address" value="г.Екатеринбург, ">*<br><br>
            <a onclick="accept_order()" title="Отправить заказ">
              <div class="button">Оформить заказ</div>
            </a>
            <label>E-mail:</label>
            <input id="client_email"><br><br><br>
          <? if ($sum<=15000) {?>
            <img src="/images/QIWI.png" class="qiwi" alt="Qiwi.Кошелек" title="Qiwi.Кошелек">
            <label>Оплатить через Qiwi.Кошелек:</label>
            <input type="checkbox" id="payment"><input type="hidden" hidden="true" id="full_price" value="<?=$sum?>"><br>
            <span class="description_order">(необходимо заполнить поле "Телефон" в указанном формате)</span><br>
          <? } ?>
          </div>
        <? } ?>
      </div>