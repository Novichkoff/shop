
      <!--- Описание страницы --->
      <div id="description_site">
        <?=$description?>
      </div>
      <!--- Описание страницы (The End) ---> 
      
      <? if (!empty($description_hide)) { ?>
        <!--- Скрытое описание страницы --->
        <div id="description_hide">
          <?=$description_hide?>
        </div>
        <!--- Скрытое описание страницы (The End) --->
      <? } ?>
      
      <!--- Подвал --->
      <div id="footer">
        <table>
          <thead>
            <tr>
              <td>Наши услуги</td>
              <td>Акции и скидки</td>
              <td>Новости</td>
              <td>Мы в социальных сетях</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <a href="/shop/page/payment" title="Оплата"><img src="/images/payment.png" width="16" height="16" alt="Оплата" title="Оплата товаров"/>Оплата</a><br>
                <a href="/shop/page/delivery" title="Доставка"><img src="/images/delivery.png" width="16" height="16" alt="Доставка" title="Доставка товаров"/>Доставка</a><br>
                <a href="/shop/page/guarantie" title="Гарантия"><img src="/images/guarantie.png" width="16" height="16" alt="Гарантия" title="Гарантия на товары"/>Гарантия</a><br>
              </td>
              <td>
                <a href="/shop/page/actions" title="Акции"><img src="/images/action.png" width="16" height="16" alt="Акции" title="Наши акции"/>Акции</a><br>
                <a href="/shop/page/sales" title="Скидки"><img src="/images/sale.png" width="16" height="16" alt="Скидки" title="Наши скидки"/>Скидки</a><br>
                <a href="/shop/page/presents" title="Подарки"><img src="/images/present.png" width="16" height="16" alt="Подарки" title="Наши подарки"/>Подарки</a><br>
              </td>
              <td>
                <p>
                <strong><?=$news->title;?></strong><br><?=$news->description;?> <a href="/shop/news/<?=$news->alias;?>" title="<?=$news->title;?>">подробнее..</a>
                </p>
              </td>
              <td>
                <a href="http://<?=($vk ? $vk : '');?>" title="Мы в Вконтакте">
                  <img src="/images/vk.png" width="16" height="16" alt="Вконтакте" title="Мы в ВВконтакте"/>Вконтакте
                </a><br>
                <a href="http://<?=($facebook ? $facebook : '');?>" title="Мы в Facebook">
                  <img src="/images/fb.png" width="16" height="16" alt="Facebook" title="Мы в Facebook"/>Facebook
                </a><br>
                <a href="http://<?=($twitter ? $twitter : '');?>" title="Мы в Twitter">
                  <img src="/images/twitter.png" width="16" height="16" alt="Twitter" title="Мы в Twitter"/>Twitter
                </a><br>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--- Подвал (The End) --->
      
      <!--- Контактная информация сайта --->
      <div id="copyright" itemscope itemtype="http://schema.org/Organization">
        © <span itemprop="name"><?=($name ? $name : '');?></span> | <span itemprop="telephone"><?=($phone ? $phone :'');?></span> | <a class="email_a" href="mailto:<?=$email;?>" title="Написать письмо"><strong><?=$email;?></strong></a>
        
        <!--- Счетчики сайта --->
        <div class="counter">
          
          <a rel="nofollow" href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://market.yandex.ru/shop/190506/reviews/add"><img src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://img.yandex.ru/market/informer12.png" border="0" alt="Оцените качество магазина на Яндекс.Маркете." /></a>
                            
          <!-- begin of Top100 code -->

          <script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2973784"></script>
          <noscript>
          <a rel="nofollow" href="http://top100.rambler.ru/navi/2973784/">
          <img src="http://counter.rambler.ru/top100.cnt?2973784" alt="Rambler's Top100" title="Rambler's Top100" border="0" />
          </a>

          </noscript>
          <!-- end of Top100 code -->
          
          <!--LiveInternet counter-->
          <script type="text/javascript"><!--
          document.write("<a href='http://www.liveinternet.ru/click' "+
          "target=_blank><img src='//counter.yadro.ru/hit?t13.11;r"+
          escape(document.referrer)+((typeof(screen)=="undefined")?"":
          ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
          screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
          ";"+Math.random()+
          "' alt='LiveInternet' rel='nofollow' title='LiveInternet: показано число просмотров за 24"+
          " часа, посетителей за 24 часа и за сегодня' "+
          "border='0' width='88' height='31'><\/a>")
          //--></script><!--/LiveInternet-->          
          
          <!-- Yandex.Metrika counter -->
            <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter22848181 = new Ya.Metrika({id:22848181,
                                webvisor:true,
                                clickmap:true,
                                trackLinks:true,
                                accurateTrackBounce:true});
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
            </script>
            <script>
              (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
            </script>
            <noscript><div><img src="//mc.yandex.ru/watch/22848181" style="position:absolute; left:-9999px;" alt="Yandex.Metrika" /></div></noscript>
          <!-- /Yandex.Metrika counter -->
          
        </div>
        <!--- Счетчики сайта (The End) --->
        
      </div>
      <!--- Контактная информация сайта (The End) --->
    </div>
  <body>
</html>