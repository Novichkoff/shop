      <div id="main_menu">
        <a href="/admin" title="Главная">
          <div class="main_menu_item">
            <span>Главная</span>
          </div>
        </a>
        <a href="/admin/main" title="Основные">
          <div class="main_menu_item">
            <span>Основные</span>
          </div>
        </a>
        <a href="/admin/main_menu" title="Меню">
          <div class="main_menu_item">
            <span>Меню</span>
          </div>
        </a>
        <a href="/admin/categories" title="Категории">
          <div class="main_menu_item">
            <span>Категории</span>
            <? if ($category_no_image) { ?><div class="new_ord blue" title="Количество категорий без изображения"><?=$category_no_image?></div><? } ?>
          </div>
        </a>
        <a href="/admin/brands" title="Производители">
          <div class="main_menu_item">
            <span>Производители</span>
            <? if ($brand_no_image) { ?><div class="new_ord blue" title="Количество производителей без изображения"><?=$brand_no_image?></div><? } ?>
          </div>
        </a>
        <a href="/admin/products" title="Товары">
          <div class="main_menu_item">
            <span>Товары</span>
            <? if ($product_no_image) { ?><div class="new_ord blue" title="Количество товаров без изображения"><?=$product_no_image?></div><? } ?>
          </div>
        </a>
        <a href="/admin/pages" title="Страницы">
          <div class="main_menu_item">
            <span>Страницы</span>
          </div>
        </a>
        <a href="/admin/news" title="Страницы">
          <div class="main_menu_item">
            <span>Новости</span>
          </div>
        </a>
        <a href="/admin/orders" title="Заказы">
          <div class="main_menu_item">
            <span>Заказы</span>
            <? if ($orders) { ?><div class="new_ord red" title="Количество новых заказов"><?=$orders?></div><? } ?>
          </div>
        </a>
        <a href="/admin/import" title="Автомат">
          <div class="main_menu_item">
            <span>Автомат</span>
          </div>
        </a>
      </div>