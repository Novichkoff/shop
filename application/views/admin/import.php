<? error_reporting(E_ALL ^ E_NOTICE);?>
      <div id="base" style="background: url('<?=$site->logo?>') 100% 100% no-repeat white; background-size: auto 100px;">
        <div id="help_admin">
          <span class="top_name">Помощь</span>
          <p><?=$help?></p>
        </div>
        <h1>Автоматизация</h1><br>
        <div>
          <h2>Экспорт (бэкап)</h2>
          <div id="export" class="params">
            <a href="#" onclick="db_export()">Нажмите для экспорта БД</a>
          </div>
          <div id="save_export" class="params">
            <a href="/downloads/backup_<?=date("dmY")?>.csv">Скачать файл</a>
          </div>
          <br><br>
          <h2>Импорт (CSV)</h2>
          <form method="post" action="import_csv" enctype="multipart/form-data" />
            <label>Выберите файл (.csv):</label><br>
            <input name="userfile" type="file"><input type="submit" value="Отправить">
          </form>
          <hr>
          <h2>Импорт (Excel)</h2>
          <form method="post" action="import" enctype="multipart/form-data" />
            <label>Выберите файл (.xls):</label><br>
            <input name="userfile" type="file"><input type="submit" value="Отправить">
          </form>
          <hr>
          <h2>Прайс Сигнум (Excel)</h2>
          <form method="post" action="import_signum" enctype="multipart/form-data" />
            <label>Выберите файл (.xls):</label><br>
            <input name="userfile" type="file"><input type="submit" value="Отправить">
          </form>
          <hr>
          <?php echo $error;?>
          <?php if ($excel) echo $excel->dump(false,false); ?>
        </div>        
      </div>    