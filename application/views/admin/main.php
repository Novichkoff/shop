      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Конфигурация сайта</h1><br>
        <div id="edit_admin" class="configuration">
          <div class="logo_panel" id="logo_panel">
            <a href="javascript:void();" onclick="close_logo_panel()">
              <img class="close" src="/images/close.png" title="Закрыть" alt="Закрыть"/>
            </a><br>
            <a class="zoom" href="<?=$site->logo?>" rel="lightbox">
              <img src="<?=$site->logo?>" class="logo_edit" title="Нажмите для увеличения" alt="Нажмите для увеличения"/>
            </a>
            <p>Введите URL картинки</p>
            <input name="url_logo" type="text" placeholder="Введите URL" value="<?=$site->logo?>">
            <a href="javascript:void();" onclick="logo_change()">Отправить</a>
          </div>
          <a href="javascript:void();" onclick="show_logo_panel()">
            <img width="100px" src="<?=$site->logo?>" title="Изменить логотип" alt="Изменить логотип"/>
          </a><br>
          <label>Название сайта:</label><br>
          <input id="site_name" onchange="edit_site_name()" value="<?=$site->name?>"><br><br>
          <label>Описание сайта:</label><br>
          <textarea id="site_description" onchange="edit_site_description()"><?=$site->description?></textarea><br><br>
          <label>Адрес:</label><br>
          <input id="site_adress" onchange="edit_site_adress()" value="<?=$site->adress?>"><br><br>
          <label>Телефон:</label><br>
          <input id="site_phone" onchange="edit_site_phone()" value="<?=$site->phone?>"><br><br>
          <label>E-mail менеджера:</label><br>
          <input id="site_email" onchange="edit_site_email()" value="<?=$site->email?>"><br><br>
          <img width="16px" height="16px" src="/images/vk.png" alt="Вконтакте" title="Вконтакте"/><label> vk:</label><br>
          <input id="site_vk" onchange="edit_site_vk()" value="<?=$site->vk?>"><br><br>
          <img width="16px" height="16px" src="/images/fb.png" alt="Facebook" title="Facebook"/><label> facebook:</label><br>
          <input id="site_facebook" onchange="edit_site_facebook()" value="<?=$site->facebook?>"><br><br>
          <img width="16px" height="16px" src="/images/twitter.png" alt="Twitter" title="Twitter"/><label> twitter:</label><br>
          <input id="site_twitter" onchange="edit_site_twitter()" value="<?=$site->twitter?>"><br><br>          
        </div>        
      </div>    