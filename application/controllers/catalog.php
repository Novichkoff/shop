<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends CI_Controller {

	function __construct() {
    parent::__construct();
    
    $this->load->model('Shop_model', '', TRUE);
    
    $this->load->library('pagination');
    
    $this->load->library('session');
    
    $this->load->library('ion_auth','russian');
    
    $this->load->helper('url');
    
  }
  
  
  // *************** Категории товаров ****************
  
  
  function categories($alias, $sort='id', $page=1, $brand_id=0 ) {
		
    // $limit - количество товаров на странице, кратное 3
    
    $limit = 30;
    
    // Разбираемся с сортировкой
    
    if ($sort == 'id') $sort_param = 't2.id'; 
    
    if ($sort == 'price') $sort_param = 't2.price'; 
    
    if ($sort == 'name') $sort_param = 't1.name'; 
    
    if ($sort == 'brand') $sort_param = 't1.brand_id'; 
    
    $data['page'] = $page;
    
    $data['alias'] = $alias;

    $id = $this->Shop_model->get_category_id_alias($alias);
    
    // шапка сайта - получение данных о сайте
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';    
		
    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['subcategories'] = $this->Shop_model->get_subcategories();
    
    // хлебные крошки

    $parent = $this->Shop_model->get_parent($id);

    $parent_alias = $this->Shop_model->get_category_alias($parent);
    
    $data['breadcrumbs'] = '<div class="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/" title="Главная" itemprop="url"><span itemprop="title">Главная</span></a></div>';
      
    $data['breadcrumbs'] .= $parent ? ' > <div class="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/catalog/categories/'.$parent_alias.'" title="'.$this->Shop_model->get_category($parent).'" itemprop="url"><span itemprop="title">'.$this->Shop_model->get_category($parent).'</span></a></div>' : '';
      
    $data['breadcrumbs'] .= $parent!=$id ? ' > <a href="/catalog/categories/'.$alias.'" title="'.$this->Shop_model->get_category($id).'"><span>'.$this->Shop_model->get_category($id).'</span></a>' : '';

    // содержимое страницы
    
    $data['brands'] = $this->Shop_model->get_brands();

    $data['category'] = $this->Shop_model->get_category($id);
    
    $data['site']->title = $parent==0 ? $data['category'] : $this->Shop_model->get_category($parent)." ".mb_strtolower($data['category']);
    
    $data['site']->title .= " купить в Екатеринбурге";
    
    $data['site']->h1 = $parent==0 ? $data['category'] : $this->Shop_model->get_category($parent)." ".mb_strtolower($data['category']);
    
    if ($page > 1) $data['site']->title .=" : страница ".$page;
    
    $data['categories'] = $this->Shop_model->get_categories($id);
    
    foreach ($data['categories'] as &$item) {
            
      $item->num_products = $this->Shop_model->get_num_products($item->id);      
      
    }    
    
    if ($brand_id) $data['products'] = $this->Shop_model->get_products($id, $limit, ($page-1)*$limit, $sort_param, $brand_id);
      
      else $data['products'] = $this->Shop_model->get_products($id, $limit, ($page-1)*$limit, $sort_param);
    
    $data['num_products'] = $this->Shop_model->get_num_products($id);
    
    if ($data['num_products'] == 0) if ($brand_id) $data['products'] = $this->Shop_model->get_categories_best($id, $brand_id, $sort_param); else $data['products'] = $this->Shop_model->get_categories_best($id, 0, $sort_param);
    
    // var_dump($data['num_products']);
    
    foreach ($data['products'] as &$products) {
    
      $products['brand_img'] = $this->Shop_model->get_brand_image($products['brand_id']);
      
      $products['brand'] = $this->Shop_model->get_brand($products['brand_id']);
      
      $products['product_sizes'] = $this->Shop_model->get_product_sizes($products['id']);
            
      foreach ($products['product_sizes'] as &$sizes) {
      
        $sizes->product_colors = $this->Shop_model->get_product_colors($products['id'], $sizes->id);       
      
      }    
    
    }
    
    if (empty($data['products'])) $data['num_products'] = -1;
    
    $data['category_products_all'] = $this->Shop_model->get_categories_all($id);     
    
    // разбивка на страницы
    
    $data['base_url'] = "/catalog/categories/".$alias."/";
    
    $config['base_url'] = "/catalog/categories/".$alias."/".$sort."/";
    
    $config['total_rows'] = $data['num_products'];
    
    $config['per_page'] = $limit;
    
    $config['uri_segment'] = 5;

    $config['use_page_numbers'] = TRUE;

    $config['full_tag_open'] = '<b>Страницы: </b>';
    
    $config['next_link'] = 'Следующая';
    
    $config['prev_link'] = 'Предыдущая';
    
    $config['first_link'] = '<<';
    
    $config['last_link'] = '>>';   
    
    $this->pagination->initialize($config);

    $data['pagination'] = $this->pagination->create_links();
       
    // подвал сайта  

    $data['site']->news = $this->Shop_model->get_news();
    
    $data['site']->meta_description = "Подобрать и купить ".mb_strtolower($data['site']->h1)." в ".$data['site']->adress."е по лучшей цене. С доставкой и гарантией. 891-2229-2221";
    
    $data['site']->keywords = $data['site']->title.",".$data['site']->adress;
    
    // var_dump($data['products'][0]);
    
    // вывод
    
    $this->load->view('header', $data['site']);
    
    $this->load->view('menu', $data); 
    
    $this->load->view('breadcrumbs', $data);
    
    $this->load->view('catalog', $data);   
    
    $this->load->view('footer', $data['site']);    
    
	}
  
  // *************** Брэнды товаров ****************
  
  
  function brand($alias, $sort='id', $page=1 ) {
		
    // $limit - количество товаров на странице, кратное 3
    
    $limit = 30;
    
    // Разбираемся с сортировкой
    
    if ($sort == 'id') $sort_param = 't2.id'; 
    
    if ($sort == 'price') $sort_param = 't2.price'; 
    
    if ($sort == 'name') $sort_param = 't1.name'; 
    
    if ($sort == 'brand') $sort_param = 't1.brand_id'; 
    
    $data['page'] = $page;

    $id = $this->Shop_model->get_brand_id_alias($alias);
    
    // шапка сайта - получение данных о сайте
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';    
		
    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['subcategories'] = $this->Shop_model->get_subcategories();
    
    // хлебные крошки

    $data['breadcrumbs'] = '<a href="/" title="Главная" itemprop="url"><span itemprop="name">Главная</span></a>';
      
    $data['breadcrumbs'] .= ' > <a href="/catalog/brand/'.$alias.'" title="'.$this->Shop_model->get_brand($id).'" itemprop="url"><span itemprop="name">'.$this->Shop_model->get_brand($id).'</span></a>';

    // содержимое страницы

    $data['brand'] = $this->Shop_model->get_brand($id);	
    
    $data['brands'] = $this->Shop_model->get_brands();
    
    $data['site']->title = $data['brand'];
    
    $data['site']->title .=" - все товары бренда";
    
    if ($page > 1) $data['site']->title .=" : страница ".$page;    
    
    $data['products'] = $this->Shop_model->get_brand_products($id, $limit, ($page-1)*$limit, $sort_param);
    
    $data['num_products'] = $this->Shop_model->get_num_brand_products($id);
    
    if ($data['num_products'] == 0) $data['products'] = $this->Shop_model->get_brand_best($id);
    
    // var_dump($data['num_products']);
    
    foreach ($data['products'] as &$products) {
    
      $products['brand_img'] = $this->Shop_model->get_brand_image($products['brand_id']);
      
      $products['product_sizes'] = $this->Shop_model->get_product_sizes($products['id']);
            
      foreach ($products['product_sizes'] as &$sizes) {
      
        $sizes->product_colors = $this->Shop_model->get_product_colors($products['id'], $sizes->id);       
      
      }    
    
    }
    
    if (empty($data['products'])) $data['num_products'] = -1;
    
    // разбивка на страницы
    
    $data['base_url'] = "/catalog/brand/".$alias."/";
    
    $config['base_url'] = "/catalog/brand/".$alias."/".$sort."/";
    
    $config['total_rows'] = $data['num_products'];
    
    $config['per_page'] = $limit;
    
    $config['uri_segment'] = 5;

    $config['use_page_numbers'] = TRUE;    
    
    $config['next_link'] = 'Следующая';
    
    $config['prev_link'] = 'Предыдущая';
    
    $config['first_link'] = '<<';
    
    $config['last_link'] = '>>';   
    
    $this->pagination->initialize($config);

    $data['pagination'] = $this->pagination->create_links();
       
    // подвал сайта  

    $data['site']->news = $this->Shop_model->get_news();
    
    $data['site']->meta_description = "Купить продукцию ".$data['brand']." в ".$data['site']->adress."е по низким ценам.";
    
    $data['site']->keywords = $data['brand'].",".$data['site']->adress;
    
    // var_dump($data['products'][0]);
    
    // вывод    
    
    $this->load->view('header', $data['site']);
    
    $this->load->view('menu', $data); 
    
    $this->load->view('breadcrumbs', $data);
    
    $this->load->view('brand', $data);   
    
    $this->load->view('footer', $data['site']);    
    
	}
  
  
  // *************** Детали товаров ***************
  
  
  function detail($alias, $size=0, $color=0) {
  
    $id = $this->Shop_model->get_product_id_alias($alias);
  
		// шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();

    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';

    $data['site']->product = true;

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['subcategories'] = $this->Shop_model->get_subcategories();   
    
    // содержимое страницы
    
    $data['brands'] = $this->Shop_model->get_brands();

    $data['product'] = $this->Shop_model->get_product($id);
    
    $data['brand'] = $this->Shop_model->get_brand($data['product']->brand_id);
    
    $data['brand'] = !empty($data['brand']) ? $data['brand'] : ''; 
    
    $data['brand_image'] = $this->Shop_model->get_brand_image($data['product']->brand_id);

    $data['brand_alias'] = $this->Shop_model->get_brand_alias($data['product']->brand_id);
    
    $data['product']->product_sizes = $this->Shop_model->get_product_sizes($id);
    
    if ($size) {
    
      foreach ($data['product']->product_sizes as $product_size) {
      
        if ($size == $product_size->id) { 
        
          $data['product']->size_id = $product_size->id;
          
          $data['product']->size = $product_size->size;                   
                  
        }
      
      } 
    
    }  else {
    
      $data['product']->size_id = $data['product']->product_sizes[0]->id;
      
      $data['product']->size = $data['product']->product_sizes[0]->size;     
    
    }
    
    $data['product']->product_colors = $this->Shop_model->get_product_colors($id, $data['product']->size_id);
    
    if ($color) {
    
      foreach ($data['product']->product_colors as $product_color) {
      
        if ($color == $product_color->id) { 
        
          $data['product']->color_id = $product_color->id; 
          
          $data['product']->color = $product_color->color;  
    
          $data['product']->image = $product_color->image;
          
          $data['product']->thumb = $product_color->thumb;
          
          $data['product']->small = $product_color->small;

          $data['product']->price = $product_color->price;
                  
        }
      
      }       
    
    } else {
    
      $data['product']->color_id = $data['product']->product_colors[0]->id;
      
      $data['product']->color = $data['product']->product_colors[0]->color;  
    
      $data['product']->image = $data['product']->product_colors[0]->image;
      
      $data['product']->thumb = $data['product']->product_colors[0]->thumb;
      
      $data['product']->small = $data['product']->product_colors[0]->small;
      
      $data['product']->price = $data['product']->product_colors[0]->price;
    
    }

    $data['product']->description_small = (!empty($data['product']->description_small) ? $data['product']->description_small : $this->cutString($data['product']->description, 150)); 
    
    $category = $data['product']->categories_id;
    
    $prefix = $this->Shop_model->get_prefix($data['product']->categories_id);    
    
    $data['product']->prefix = $prefix->prefix; // Префикс товара
    
    $like = explode(" ", $data['product']->name);
    
    $price_between = $data['product']->price;
    
    $data['product']->similar = $this->Shop_model->get_similar($data['product']->id, $data['product']->categories_id, $like[0], $price_between); // Похожие товары
    
    // $data['product']->recommend_products = $this->Shop_model->get_recommend_products(2); // Рекомендуемые товары
    
    // var_dump($data['product']->similar);
    
    //-- хлебные крошки
    
    $parent = $this->Shop_model->get_parent($category);
    
    $parent_alias = $this->Shop_model->get_category_alias($parent);
    
    $data['breadcrumbs'] = '<div class="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/" title="Главная" itemprop="url"><span itemprop="title">Главная</span></a></div>';
      
    $data['breadcrumbs'] .= $parent ? ' > <div class="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/catalog/categories/'.$parent_alias.'" title="'.$this->Shop_model->get_category($parent).'" itemprop="url"><span itemprop="title">'.$this->Shop_model->get_category($parent).'</span></a></div>' : '';
    
    $data['breadcrumbs'] .= $parent!=$category ? ' > <div class="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/catalog/categories/'.$this->Shop_model->get_category_alias($category).'" title="'.$this->Shop_model->get_category($category).'" itemprop="url"><span itemprop="title">'.$this->Shop_model->get_category($category).'</span></a></div>' : '';     
        
    //-- дополнительные товары 
    
    $additionally = $this->Shop_model->get_additionally($id);    
    
    if ($additionally) foreach ($additionally as $item) {
    
      $data['product']->additionally_items[$item] = new stdClass;
            
      $data['product']->additionally_items[$item]->id = $item;
      
      $data['product']->additionally_items[$item]->image = $this->Shop_model->get_image($item);
      
      $data['product']->additionally_items[$item]->thumb = $this->Shop_model->get_thumb($item);
      
      $data['product']->additionally_items[$item]->name = $this->Shop_model->get_name($item);
      
    }      
    
    $data['site']->title = $data['product']->prefix." ".mb_strtoupper($data['product']->name)." купить за ".$data['product']->price." руб. в Екатеринбурге";
        
    // подвал сайта
    
    $data['site']->news = $this->Shop_model->get_news();
    
    // --- Описание товара в подвале ---
    
    $data['site']->description = '<strong>'.$data['site']->name.'</strong> предлагает Вам купить <strong>'.$data['product']->name.'</strong> по привлекательной цене: <strong>'.$data['product']->price.' руб</strong>.<br>';
    
    if ($data['product']->product_sizes[0]->size != "Комплект") {
    
      $data['site']->description .= 'В наличии есть '.$data['product']->name.' следующих размеров: ';
      
      foreach ($data['product']->product_sizes as $product_size) {    
               
        $data['site']->description .= $product_size->size.'; ';                  
                    
      }
      
    }
    
    if ($data['product']->product_colors[0]->color != "Стандарт") {
    
      $data['site']->description .= '<br>'.$data['product']->name.' доступен в следующих вариантах: ';
      
      foreach ($data['product']->product_colors as $product_color) {    
               
        $data['site']->description .= $product_color->color.'; ';                  
                    
      }
    
    }
    
    $data['site']->description .= 'Если Вы хотите купить <strong>'.mb_strtoupper($data['product']->name).'</strong> у нас, Вам необходимо оформить предварительный заказ.<br>Мы сами перезвоним Вам для оформления покупки и договоримся о доставке.';
    
    $data['site']->meta_description = "Купить ".mb_strtoupper($data['product']->name)." в Екатеринбурге по самой выгодной цене. Доставка, гарантия.";
    
    $data['site']->category = $this->Shop_model->get_category($category);
    
    $data['site']->description_hide = $data['product']->description;
    
    $data['site']->keywords = mb_strtoupper($data['product']->name).",".$data['product']->prefix.",".$data['site']->adress.",".$data['brand'];

    // var_dump($data);
         
    // Вывод
    
    $this->load->view('header', $data['site']);
    
    $this->load->view('menu', $data); 
    
    $this->load->view('breadcrumbs', $data);
    
    $this->load->view('detail', $data['product']);         
    
    $this->load->view('footer', $data['site']);  
        
	}
  
  function cutString($string, $maxlen) {
		
    $len = (mb_strlen($string) > $maxlen) ? mb_strripos(mb_substr($string, 0, $maxlen), ' ') : $maxlen ;
		
    $cutStr = mb_substr($string, 0, $len);
		
    return (mb_strlen($string) > $maxlen) ? '' . $cutStr . '.' : '' . $cutStr . '' ; 
	
  }
  
  function add_to_cart($color_id) {
    
    $product[$color_id] = isset($this->session->userdata[$color_id]) ? $this->session->userdata[$color_id] : '';
        
    if ($product[$color_id]) {
    
      //увеличиваем количество на единицу, если товар уже добавлен:
           
      $product[$color_id]->product_count++;
       
      $this->session->set_userdata($product); 
    
    } else {
    
      $product[$color_id] = $this->Shop_model->get_product_min( $color_id );
      
      $product[$color_id]->product_count = 1;
      
      $this->session->set_userdata($product);    
    
    }      
      
    // var_dump($this->session->userdata);  
      
    return true;  
    
	}
  
  function delete_cart_item($id) {
    
    $this->session->unset_userdata($id);    
      
    return true;  
    
	}
  
  function update_cart_item($id, $num) {
    
      $this->session->userdata[$id]->product_count = (int) $num;
       
      $this->session->set_userdata();     
    
      //var_dump($this->session->userdata);
    
    return true;  
    
	}
  
  function clear_cart() {
    
    $this->session->sess_destroy();
     
    return true;
     
  }   
  
  // *************** Корзина товаров ***************
  
  function cart() {
  
		// шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();	
    
    $data['site']->title = 'Корзина ваших товаров';   
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';		
    
    $data['site']->meta_description = "Корзина выбранных вами товаров ".$data['site']->title." ".$data['site']->adress;

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();  

    $data['subcategories'] = $this->Shop_model->get_subcategories();
    
    // содержимое страницы   
    
    $cart = $this->session->userdata;
    
    $cnt=1;
    
    $data['cart'] = new stdClass();
    
    foreach ($cart as $item) {
    
      $cnt++;    
      
      if (is_object($item)) {
      
        $data['cart']->$cnt = $item;
        
        $product_count = $data['cart']->$cnt->product_count;
      
        $data['cart']->$cnt = $this->Shop_model->get_product_full( $item->id );
        
        $data['cart']->$cnt->product_count = $product_count;
        
        $data['cart']->$cnt->name = $this->Shop_model->get_product_name( $data['cart']->$cnt->parent_id );
        
        $data['cart']->$cnt->size = $this->Shop_model->get_product_size( $data['cart']->$cnt->size_id );
        
      }
    
    }    

    // подвал сайта
    
    $data['site']->news = $this->Shop_model->get_news();
         
    // вывод
    
    $this->load->view('header', $data['site']);
    
    $this->load->view('menu', $data); 
    
    $this->load->view('cart', $data);    
    
    $this->load->view('footer', $data['site']);  
        
	}
  
  function accept_order() {
  
    $name = trim($_POST['name']);  
    
    $phone = trim($_POST['phone']);
    
    $address = trim($_POST['address']);
    
    $email = trim($_POST['email']);

    $cart = $this->session->userdata;
    
    $cnt=1;
    
    $data['cart'] = new stdClass();
    
    foreach ($cart as $item) {
    
      $cnt++;    
      
      if (is_object($item)) {
      
        $data['cart']->$cnt = $item;
        
        $product_count = $data['cart']->$cnt->product_count;
      
        $data['cart']->$cnt = $this->Shop_model->get_product_full( $item->id );
        
        $data['cart']->$cnt->product_count = $product_count;
        
        $data['cart']->$cnt->name = $this->Shop_model->get_product_name( $data['cart']->$cnt->parent_id );
        
        $data['cart']->$cnt->size = $this->Shop_model->get_product_size( $data['cart']->$cnt->size_id );
        
      }
    
    }
    
    $this->db->insert('orders', array( 'name' => $name, 'phone' => $phone, 'address' => $address, 'email' => $email, 'order' => serialize ($data['cart']), 'status' => 'Новый' ));
   
  }
  
  function accept_order_payment() {
  
    $name = trim($_POST['name']);  
    
    $phone = trim($_POST['phone']);
    
    $address = trim($_POST['address']);
    
    $email = trim($_POST['email']);

    $cart = $this->session->userdata;
    
    $cnt=1;
    
    $data['cart'] = new stdClass();
    
    foreach ($cart as $item) {
    
      $cnt++;    
      
      if (is_object($item)) {
      
        $data['cart']->$cnt = $item;
        
        $product_count = $data['cart']->$cnt->product_count;
      
        $data['cart']->$cnt = $this->Shop_model->get_product_full( $item->id );
        
        $data['cart']->$cnt->product_count = $product_count;
        
        $data['cart']->$cnt->name = $this->Shop_model->get_product_name( $data['cart']->$cnt->parent_id );
        
        $data['cart']->$cnt->size = $this->Shop_model->get_product_size( $data['cart']->$cnt->size_id );
        
      }
    
    }
    
    $this->db->insert('orders', array( 'name' => $name, 'phone' => $phone, 'address' => $address, 'email' => $email, 'order' => serialize ($data['cart']), 'status' => 'Оплачивается' ));
               
  }

  function success() {	

    // содержимое страницы
    
    $data['site'] = $this->Shop_model->get_site_info();	
    
    $data['site']->title = $data['site']->name;
    
    $data['order'] = $this->Shop_model->get_order('last');
    
    $data['cart'] = unserialize($data['order']->order);
    
    // Отправка писем    
      
    $this->load->library('email');
    
    $config['mailtype'] = 'html';
    
    $this->email->initialize($config);
    
    $this->email->from('noreply@ndural.ru', $data['site']->name);
    
    // Письмо администратору
    
    $this->email->to($data['site']->email);

    $this->email->subject('Новый заказ на сайте NDUral.ru');    
    
    $message_admin = '<html><body><img src="http://ndural.ru/images/logo.png"><br><h2>'.$data['site']->name.'</h2>';
    
    $message_admin .= '<p>Пришел новый заказ.<br>Нажмите на ссылку: '.$data['site']->url.'/admin/orders чтобы перейти к странице заказов.</p>';
    
    $message_admin .= "</body></html>";
    
    $this->email->message($message_admin);
    
    $this->email->send();

    // Письмо клиенту    
    
    $this->email->to($data['order']->email);

    $this->email->subject('Ваш заказ на NDUral.ru'); 

    $message_client = '<html><body><img src="http://ndural.ru/images/logo.png"><br><h2>'.$data['site']->name.'</h2>';
    
    $message_client .= '<p>Добрый день, '.$data['order']->name.'!<br>';
    
    $message_client .= 'Мы получили Ваш заказ и теперь спешим его выполнить.<br>В самое ближайшее время мы свяжемся с Вами по указанному Вами телефону.<br>';
    
    $message_client .= 'Также Вы будете получать уведомления на электронную почту о статусе Вашего заказа.<br></p>';
    
    $message_client .= $data['site']->name.' '.$data['site']->url.' '.$data['site']->phone;
    
    $message_client .= '</body></html>';
    
    $this->email->message($message_client);
    
    $this->email->send();
    
    // вывод
    
    $this->load->view('order', $data); 
        
	}
  
  // Ссылка для письма
  
  function make_link($text, $link) {
  
    return '<a href="'. (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $link .'">'. $text .'</a>';
    
  }
  
}
?>
