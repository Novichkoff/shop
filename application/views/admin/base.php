      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white;">
        <a href="/admin/main" title="Основные">
          <div class="admin_page_categories">
            <span>Основные</span></br>
            <img src="/images/info.jpg" alt="Основные" title="Основные"/>
          </div>
        </a>
        <a href="/admin/main_menu" title="Меню">
          <div class="admin_page_categories">
            <span>Меню</span></br>
            <img src="/images/menu.gif" alt="Меню" title="Меню"/>
          </div>
        </a>
        <a href="/admin/categories" title="Категории">
          <div class="admin_page_categories">
            <? if ($category_no_image) { ?><div class="new_ordr blue" title="Количество категорий без изображения"><?=$category_no_image?></div><? } ?>
            <span>Категории</span><br>
            <img src="/images/categories.jpg" alt="Категории" title="Категории"/>            
          </div>
        </a>
        <a href="/admin/products" title="Товары">
          <div class="admin_page_categories">
            <? if ($product_no_image) { ?><div class="new_ordr blue" title="Количество товаров без изображения"><?=$product_no_image?></div><? } ?>
            <span>Товары</span></br>
            <img src="/images/items.png" alt="Товары" title="Товары"/>             
          </div>
        </a>
        <a href="/admin/pages" title="Страницы">
          <div class="admin_page_categories">
            <span>Страницы</span></br>
            <img src="/images/pages.png" alt="Страницы" title="Страницы"/>
          </div>
        </a>
        <a href="/admin/orders" title="Заказы">
          <div class="admin_page_categories">
            <? if ($orders) { ?><div class="new_ordr red" title="Количество новых заказов"><?=$orders?></div><? } ?>
            <span>Заказы</span><br>
            <img src="/images/orders.png" alt="Заказы" title="Заказы"/>            
          </div>          
        </a>
         
      </div>    