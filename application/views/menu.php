

      <!--- Меню сайта --->
      <nav role="navigation">
	  <div id="main_menu" role="menubar">
        <? foreach ($menu as $menu_item) { ?>
          <? if ($menu_item->parent_id ==0) { ?>
            <a href="<?=$menu_item->url?>" title="<?=$menu_item->title?>" onmouseover="show_submenu(<?=$menu_item->id?>)" onmouseout="hide_submenu(<?=$menu_item->id?>)">
              <div class="main_menu_item" id="main_menu_item_<?=$menu_item->id?>" role="menuitem">
                <span><?=$menu_item->title?></span>
              </div>
            </a>
            <? foreach ($menu as $submenu_item) { ?>
              <? if ($submenu_item->parent_id == $menu_item->id) { ?>
                <div class="submenu" id="sub_<?=$menu_item->id?>" onmouseover="show_submenu(<?=$menu_item->id?>)" onmouseout="hide_submenu(<?=$menu_item->id?>)">
                  <article>
                    <? foreach ($menu as $submenu_item) { ?>
                      <? if ($submenu_item->parent_id == $menu_item->id) { ?>
                        <br><a href="<?=$submenu_item->url?>" title="<?=$submenu_item->title?>">
                          <span class="submenu_item"><?=$submenu_item->title?></span>
                        </a><br>
                        <? foreach ($subcategories as $subsubmenu_item) { ?>
                          <? if ($subsubmenu_item->parent_id == $submenu_item->category_id) { ?>
                            <a href="/catalog/categories/<?=$subsubmenu_item->alias?>" title="<?=$subsubmenu_item->title?>">
                              <span class="subsubmenu_item"><?=$subsubmenu_item->title?></span><br>
                            </a>
                          <? } ?>
                        <? } ?>
                        <br>
                      <? } ?>
                    <? } ?>
                  </article>
                </div>
              <? break; } ?>
            <? } ?>
          <? } ?>
        <? } ?>
        <form method="POST" action="/shop/search">
          <input class="search" name="search" type="search" placeholder="Поиск..." results="5" onchange="this.form.submit()">
          <input class="search" hidden="true" type="submit">
        </form>
      </div>
	  </nav>
      <!--- Меню сайта (The End)--->
      
      