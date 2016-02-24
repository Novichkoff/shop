<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
    parent::__construct();
    
    $this->load->model('Admin_model', '', TRUE);
    
    $this->load->model('Shop_model', '', TRUE);
    
    $this->load->library('pagination');
    
    $this->load->library('session');
    
    $this->load->library('ion_auth','russian');   
    
    $this->load->helper('url');   
    
  }
  
  function index()
	{
		
    if (!$this->ion_auth->logged_in()) {
    
      redirect('auth/login', 'refresh');
      
      } else {
    
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['site']->title = $data['site']->name;
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
          
      $this->load->view('admin/header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['orders'] = $this->Shop_model->get_new_orders();
      
      $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
      
      $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
      $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
      // var_dump($data['orders'], $data['category_no_image']);
      
      $this->load->view('admin/menu',$data); 
      
      // содержимое страницы
      
      $data['help'] = "Здесь размещена помощь";      
      
      // var_dump($data['orders']);

      $data['categories'] = $this->Shop_model->get_categories();

      $this->load->view('admin/base', $data);
     
      // подвал сайта
      
      $this->load->view('admin/footer', $data['site']);
    
    }
    
	}
  
  // -------------------------------- ОБЩИЕ НАСТРОЙКИ --------------------------------------
  
  function main() {
  
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = "Для изменения логотипа нажмите на него. В появившемся окне введите URL нового логотипа в формате .jpg, .gif или .png и нажмите кнопку Отправить.<br><br>Изменения производятся автоматически при потере фокуса элемента (нажатие Enter или щелчок мыши на любом другом элементы страницы).<br><br>Описание сайта должно содержать ключевые слова обазначенные тегами &lt;b&gt;...&lt;/b&gt;.<br><br>E-mail менеджера необходимо ввести тот, на котором будет приниматься информация о поступившем заказе.";

    $this->load->view('admin/main', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
  
  function edit_site_name() {
  
    $value = urldecode ($_POST['val']);
    
    $this->db->update('config', array('name' => $value, 'url' => 'http://'.$_SERVER['SERVER_NAME']));
    
    // Водяной знак с именем сайта
    $width = 100;
    $height = 15;
    $text = $_SERVER['SERVER_NAME'];
    $fontsize = 3;

    $img = imagecreate($width, $height);

    // Прозрачный фон
    $black = imagecolorallocate($img, 0, 0, 0);
    imagecolortransparent($img, $black);

    // Черный текст
    $red = imagecolorallocate($img, 200, 200, 200);
    imagestring($img, $fontsize, 2, 2, $text, $red);

    imagepng($img,'images/watermark.png');
    imagedestroy($img);
   
  }

  function edit_site_adress() {
  
    $value = $_POST['val'];
    
    $this->db->update('config', array('adress' => urldecode ($value))); 
   
  }
  
  function edit_site_phone() {
  
    $value = $_POST['val'];
    
    $this->db->update('config', array('phone' => urldecode ($value))); 
   
  }
  
  function edit_site_email() {
  
    $value = $_POST['val'];
    
    $this->db->update('config', array('email' => urldecode ($value))); 
   
  }
  
  function edit_site_vk() {
  
    $value = $_POST['val'];
    
    $this->db->update('config', array('vk' => urldecode ($value))); 
   
  }
  
  function edit_site_facebook() {
  
    $value = $_POST['val'];
    
    $this->db->update('config', array('facebook' => urldecode ($value))); 
   
  }
  
  function edit_site_twitter() {
  
    $value = $_POST['val'];
    
    $this->db->update('config', array('twitter' => urldecode ($value))); 
   
  }
  
  function edit_site_description() {
  
    $value = $_POST['val'];
    
    $this->db->update('config', array('description' => urldecode ($value))); 
   
  }
  
  function logo_change() {
  
    $file = $_POST['val'];   
    
    $url = 'images/logo.png';
    
    $image = $this->save_image($url, $file, 240);
    
    $image_url = '/'.$url;
    
    $this->db->update('config', array('logo' => $image_url)); 
   
  }
  
  // -------------------------------- ГЛАВНОЕ МЕНЮ --------------------------------------
  
  function main_menu($id='') {
  
    $data['item_id'] = $id;
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/add.png" title="Добавить подменю в категорию Главная" alt="Добавить подменю в категорию Главная"> - добавление подменю к текущему пункту меню (отображается в меню на сайте в всплывающем подменю). После нажатия автоматически появляется пустой пункт подменю, который необходимо отредактировать.<br><br><img src="/images/delete.png" title="Удалить меню" alt="Удалить меню"> - удаление пункта меню или подменю.<br><br><img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"> - свободное перемещение пунта меню в порядке отображения. Для перемещения нажмите на значок и не отпуская кнопки перенесите пункт меню в необходимое место. Для удобства новое местоположение будет подсвечено.<br><br>Для пересортировки пуктов подменю используйте Фильтр по меню.<br><br>Для изменения названия меню или ссылки используйте поля ввода. Сохранение происходит автоматически при потере фокуса.<br><br>Пукты можно связать с категориями и подкатегориями, при этом автоматически изменится название и ссылка пункта меню или подменю.<br><br>Для добавления нового пункта меню нажмите Добавить пункт меню, после чего отредактируйте появившейся новый элемент меню.';

    $data['menu'] = $this->Admin_model->get_menu();
    
    $data['categories'] = $this->Shop_model->get_categories();
    
    $data['subcategories'] = $this->Admin_model->get_subcategories($id);
    
    foreach ( $data['menu'] as $menu ) {      
            
      $menu->submenu = $this->Shop_model->get_submenu($menu->id);     
      
    }
    
    // var_dump($data['menu']);
    
    $this->load->view('admin/main_menu', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
  
  function edit_menu($id, $value) {
  
    $this->db->where('id', $id);
    
    $this->db->update('menu', array('title' => urldecode ($value))); 
   
  }
  
  function edit_menu_url($id) {
  
    $value = $_POST['url'];
  
    $this->db->where('id', $id);
    
    $this->db->update('menu', array('url' => urldecode ($value))); 
   
  }
  
  function link_menu($id) {
  
    $value = $_POST['val'];
    
    $category_name = $this->Admin_model->get_category_name($value);

    $category_alias = $this->Admin_model->get_category_alias($value);
    
    $category_id = $this->Admin_model->get_category_id($category_name);
  
    $this->db->where('id', $id);
    
    $this->db->update('menu', array('title' => $category_name, 'category_id' => $category_id, 'url' => urldecode ('/catalog/categories/'.$category_alias))); 
   
  }
  
  function delete_menu($id) {
  
    $this->db->delete('menu', array('id' => $id));     
   
  }
  
  function add_menu($id) {
  
    $this->db->insert('menu', array( 'parent_id' => $id, 'title' => '', 'url' => '', 'sort' => '999'));     
   
  }
  
  function menu_sort() {
  
    $cnt = 0;
    
    $mass = $_POST['mass'];
    
    foreach ($mass as $id) {
    
    $cnt++;
    
    $this->db->where('id', $id);
    
    $this->db->update('menu', array('sort' => $cnt)); 
    
    // var_dump($cnt,$id);
    
    }    
   
  }
  
  // -------------------------------- КАТЕГОРИИ ТОВАРОВ --------------------------------------
  
  function categories($id='') {
  
    $data['item_id'] = $id;
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/add.png" title="Добавить подкатегорию в категорию" alt="Добавить подкатегорию в категорию"> - добавление подкатегории к текущей категории. После нажатия автоматически появляется пустая подкатегория, которую необходимо отредактировать.<br><br><img src="/images/delete.png" title="Удалить категорию" alt="Удалить категорию"> - удаление категории или подкатегории.<br><br><img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"> - свободное перемещение категории в порядке отображения. Для перемещения нажмите на значок и, не отпуская кнопки, перенесите категорию в необходимое место. Для удобства новое местоположение будет подсвечено.<br><br>Для пересортировки подкатегорий используйте Фильтр по категории.<br><br>Для изменения названия категории или ссылки используйте поля ввода. Сохранение происходит автоматически при потере фокуса.<br><br>Для добавления новой категории нажмите Добавить категорию, после чего отредактируйте появившуюся новую категорию.<br><br><img src="/images/picture.png" title="Изменить картинку" alt="Изменить картинку"> - для изменения изображения категории.<br><br>При отсутствии картинки какой-либо категории в главном меню горит уведомление, а сама категория выделена цветом.';

    $data['categories'] = $this->Shop_model->get_categories();
    
    foreach ( $data['categories'] as $category ) {      
            
      $category->subcategories = $this->Shop_model->get_categories($category->id);     
      
    }
    
    // var_dump($data['categories']);
    
    $this->load->view('admin/categories', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
  
  function edit_category($id, $value, $alias) {
  
    $this->db->where('id', $id);
    
    $this->db->update('categories', array('title' => urldecode ($value), 'alias' => urldecode ($alias))); 
   
  }
  
  function update_prefix($id) {
  
    $prefix = $_POST['val'];
    
    $this->db->where('id', $id);
    
    $this->db->update('categories', array('prefix' => urldecode ($prefix))); 
   
  }  
  
  function delete_category($id) {
  
    $this->db->delete('categories', array('id' => $id));     
   
  }
  
  function add_category($id) {
  
    $this->db->insert('categories', array( 'parent_id' => $id, 'title' => '', 'alias' =>'', 'image' => '', 'sort' => '999'));     
   
  }
  
  function add_category_name() {
  
    $title = $_POST['val'];
    
    $alias = strtolower($_POST['val']);
    
    if (preg_match('/[^A-Za-z0-9_\-]/', $alias)) {
    
      $alias = translitIt($alias);
      
      $alias = preg_replace('/[^A-Za-z0-9_\-]/', '', $alias);

    }
    
    $this->db->insert('categories', array( 'parent_id' => 0, 'title' => $title, 'alias' => $alias, 'image' => '', 'sort' => '999'));     
   
  }
     
  function add_subcategory_name() {
  
    $category = $_POST['cat'];    
    
    $title = $_POST['val'];
    
    $alias = strtolower($_POST['val']);
    
    if (preg_match('/[^A-Za-z0-9_\-]/', $alias)) {
    
      $alias = translitIt($alias);
      
      $alias = preg_replace('/[^A-Za-z0-9_\-]/', '', $alias);

    }
    
    $this->db->insert('categories', array( 'parent_id' => $category, 'title' => $title, 'alias' => $alias, 'image' => '', 'sort' => '999'));      
   
  }
  
  function category_image_change($id) {
  
    $file = $_POST['val'];    
    
    $url = 'images/categories/0' . $id . '.jpg';
    
    $image = $this->save_image($url, $file, 150);
    
    $image_url = '/'.$url;
    
    $this->db->where('id', $id);
    
    $this->db->update('categories', array('image' => $image_url)); 
   
  }
    
  function category_sort() {
  
    $cnt = 0;
    
    $mass = $_POST['mass'];
    
    foreach ($mass as $id) {
    
    $cnt++;
    
    $this->db->where('id', $id);
    
    $this->db->update('categories', array('sort' => $cnt)); 
    
    // var_dump($cnt,$id);
    
    }    
   
  }
  
  // -------------------------------- ПРОИЗВОДИТЕЛИ --------------------------------------
  
  function brands($id='') {
  
    $data['item_id'] = $id;
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/add.png" title="Добавить производителя" alt="Добавить производителя"> - добавление производителя. После нажатия автоматически появляется пустой производителя, которого необходимо отредактировать.<br><br><img src="/images/delete.png" title="Удалить производителя" alt="Удалить производителя"> - удаление производителя.<br><br><img src="/images/move.png" class="move_icon" title="Переместить" alt="Переместить"> - свободное перемещение производителя в порядке отображения. Для перемещения нажмите на значок и, не отпуская кнопки, перенесите производителя в необходимое место. Для удобства новое местоположение будет подсвечено.<br><br>Для изменения названия производителя используйте поля ввода. Сохранение происходит автоматически при потере фокуса.<br><br>Для добавления нового производителя нажмите Добавить производителя, после чего отредактируйте появившегося нового производителя.<br><br><img src="/images/picture.png" title="Изменить картинку" alt="Изменить картинку"> - для изменения изображения производителя.<br><br>При отсутствии картинки какого-либо производителя в главном меню горит уведомление, а сам производитель выделен цветом.';

    $data['brands'] = $this->Shop_model->get_brands();
        
    // var_dump($data['categories']);
    
    $this->load->view('admin/brands', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
  
  function edit_brand($id, $value, $alias) {
  
    $this->db->where('id', $id);
    
    $this->db->update('brands', array('title' => urldecode ($value), 'alias' => urldecode ($alias))); 
   
  }
  
  function delete_brand($id) {
  
    $this->db->delete('brands', array('id' => $id));     
   
  }
  
  function add_brand($id) {
  
    $this->db->insert('brands', array( 'title' => '', 'alias' =>'', 'image' => '', 'sort' => '999'));     
   
  }
  
  function add_brand_name() {
  
    $title = $_POST['val'];
    
    $alias = strtolower($_POST['val']);
    
    if (preg_match('/[^A-Za-z0-9_\-]/', $alias)) {
    
      $alias = translitIt($alias);
      
      $alias = preg_replace('/[^A-Za-z0-9_\-]/', '', $alias);

    }
    
    $this->db->insert('brands', array( 'title' => $title, 'alias' => $alias, 'image' => '', 'sort' => '999'));     
   
  }
  
  function brand_image_change($id) {
  
    $file = $_POST['val'];    
    
    $url = 'images/brands/0' . $id . '.jpg';
    
    $image = $this->save_image($url, $file, 100);
    
    $image_url = '/'.$url;
    
    $this->db->where('id', $id);
    
    $this->db->update('brands', array('image' => $image_url)); 
   
  }
    
  function brand_sort() {
  
    $cnt = 0;
    
    $mass = $_POST['mass'];
    
    foreach ($mass as $id) {
    
    $cnt++;
    
    $this->db->where('id', $id);
    
    $this->db->update('brands', array('sort' => $cnt)); 
    
    // var_dump($cnt,$id);
    
    }    
   
  }
  
  // -------------------------------- ПРОДУКТЫ --------------------------------------
  
  function products($category=0, $page=1) {
  
    $limit=50;
    
    $data['item_id'] = $category;
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
    
    $data['products_no_image'] = $this->Admin_model->get_products_no_image();
    
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/delete.png" title="Удалить товар" alt="Удалить товар"> - удаление товара.<br><br>Для добавления нового товара нажмите Добавить товар, после чего отредактируйте товар в появившемся новом окне.<br><br>Можно использовать Фильтр по подкатегории.<br><br>Для редактирования товара выберите его.<br><br>При отсутствии картинки какого-либо товара в главном меню горит уведомление, а сам товар выделен цветом.';
    
    $data['categories'] = $this->Admin_model->get_subcategories($category);     

    $data['products'] = $this->Admin_model->get_products($category, $limit, ($page-1)*$limit);
    
    foreach ($data['products'] as &$product) {
    
      $product->price = $this->Admin_model->get_product_price($product->id);
      
    }
    
    //var_dump($data['products']);

    // разбивка на страницы
    
    $data['num_products'] = $this->Admin_model->get_num_products($category);
    
    $config['base_url'] = "/admin/products/".$category."/";
    
    $config['total_rows'] = $data['num_products'];
    
    $config['per_page'] = $limit;
    
    $config['uri_segment'] = 4;    

    $config['use_page_numbers'] = TRUE;    
    
    $config['next_link'] = 'Следующая';
    
    $config['prev_link'] = 'Предыдущая';
    
    $config['first_link'] = '<<';
    
    $config['last_link'] = '>>';    
    
    $this->pagination->initialize($config);

    $data['pagination'] = $this->pagination->create_links();
    
    $this->load->view('admin/products', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
    
  function delete_product($id) {
  
    $this->db->delete('products', array('id' => $id)); 

    $this->db->delete('products_sizes', array('parent_id' => $id));
    
    $this->db->delete('products_colors', array('parent_id' => $id));
   
  }
  
  // -------------------------------- ТОВАР --------------------------------------
  
  function product($id, $size=0, $color=0) {
  
    if ($id == 'last') $id = $this->Admin_model->get_last_product();
  
    // var_dump($id, $size, $color);
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';    
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы    

    $data['all_products'] = $this->Admin_model->get_all_products();
    
    $data['product'] = $this->Shop_model->get_product($id);
    
    $parent = $this->Shop_model->get_parent($data['product']->categories_id);
    
    $data['product']->parent_id = empty($parent) ? $data['product']->categories_id : $parent;
    
    $data['categories'] = $this->Admin_model->get_categories(0);
    
    $data['brands'] = $this->Shop_model->get_brands();
    
    $data['subcategories'] = $this->Admin_model->get_categories($data['product']->parent_id);
    
   // var_dump($data['product']->categories_id, $data['product']->parent_id, $parent, $data['categories'], $data['subcategories']);
    
    $data['product']->product_sizes = $this->Shop_model->get_product_sizes($id);
    
    if ($size) {
    
      foreach ($data['product']->product_sizes as $product_size) {
      
        if ($size == $product_size->id) { 
        
          $data['product']->size_id = $product_size->id;
          
          $data['product']->size = $product_size->size;                   
                  
        }
      
      } 
    
    }  else {
    
      if ($data['product']->product_sizes) {
    
        $data['product']->size_id = $data['product']->product_sizes[0]->id;
        
        $data['product']->size = $data['product']->product_sizes[0]->size;
      
      } else {
      
        $data['product']->size_id = '';
        
        $data['product']->size = '';
      
      }
    
    }
    
    $data['product']->product_colors = $this->Shop_model->get_product_colors($id, $data['product']->size_id);
    
    if ($color) {
    
      foreach ($data['product']->product_colors as $product_color) {
      
        if ($color == $product_color->id) { 
        
          $data['product']->color_id = $product_color->id; 
          
          $data['product']->color = $product_color->color;  
    
          $data['product']->image = $product_color->image;

          $data['product']->price = $product_color->price;
                  
        }
      
      }       
    
    } else {
    
      if ($data['product']->product_colors) {
      
        $data['product']->color_id = $data['product']->product_colors[0]->id;
        
        $data['product']->color = $data['product']->product_colors[0]->color;  
      
        $data['product']->image = $data['product']->product_colors[0]->image;
        
        $data['product']->price = $data['product']->product_colors[0]->price;
        
      } else {
      
        $data['product']->color_id = '';
        
        $data['product']->color = '';  
      
        $data['product']->image = '';
        
        $data['product']->price = '';
        
      }
    
    }

    $data['product']->description_small = !empty($data['product']->description_small) ? $data['product']->description_small : ''; 
    
    $category = $data['product']->categories_id;
    
    //-- дополнительные товары 
    
    $additionally = $this->Shop_model->get_additionally($id);    
    
    if ($additionally) foreach ($additionally as $item) {
    
      $data['product']->additionally_items[$item] = new stdClass;
            
      $data['product']->additionally_items[$item]->id = $item;
      
      $data['product']->additionally_items[$item]->image = $this->Shop_model->get_image($item);
      
    } 
    
    // var_dump($data);
    
    $this->load->view('admin/product', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
  
  function update_product_name($id) {
  
    $name = $_POST['val'];
	
    $alias = $_POST['alias'];
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('name' => urldecode ($name), 'alias' => urldecode ($alias))); 
   
  }
  
  function update_product_recommend($id) {
  
    $recommend = $_POST['val'];    
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('recommend' => $recommend)); 
   
  }
  
  function add_product() {
  
    $this->db->insert('products', array( 'name' => '', 'additionally' => '', 'categories_id' => '', 'description_small' => '', 'description' => ''));    
   
  }
  
  function update_product_price($id) {
  
    $price = $_POST['val'];
    
    $this->db->where('id', $id);
    
    $this->db->update('products_colors', array('price' => urldecode ($price))); 
   
  }
  
  function update_product_rating($id) {
  
    $total_reiting = $_POST['total_reiting'];
    
    $votes = $_POST['votes'];
    
    $user_votes = $_POST['user_votes'];
    
    $new_votes = $votes + 1;
    
    $arating = (($total_reiting * $votes) + $user_votes) / $new_votes;
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('rating' => $arating, 'votes' => $new_votes ));    
   
  }
  
  function update_product_image($id) {
  
    $file = $_POST['val'];

    $url = 'images/products/000' . $id . '.jpg';
    
    $thumb = 'images/products/000' . $id . '_thumb.jpg';
    
    $small = 'images/products/000' . $id . '_small.jpg';
        
    $image = $this->save_image($url, $file, 450);
    
    $image = $this->addWatermark($url);
    
    $image_thumb = $this->save_image($thumb, $file, 150);
    
    $image_small = $this->save_image($small, $file, 250);
    
    $image_url = '/'.$url; 

    $image_thumb = '/'.$thumb;
    
    $image_small = '/'.$small;
        
    $this->db->where('id', $id);
    
    $this->db->update('products_colors', array('image' => $image_url, 'thumb' => $image_thumb, 'small' => $image_small));
   
  }  
  
  function update_product_description($id) {
  
    $description = $_POST['val'];
    
    $description_small = strip_tags($_POST['val']);
    
    $description_small = $this->cutString($description_small,150);
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('description' => $description, 'description_small' => urldecode ($description_small))); 
   
  }
  
  function update_product_description_small($id) {
  
    $description = $_POST['val'];
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('description_small' => urldecode ($description))); 
   
  }
  
  function generate_description_small($id) {
  
    $description = strip_tags($_POST['val']);
    
    $description_small = $this->cutString($description,150);
    
    $this->db->where('id', $id);   
    
    $this->db->update('products', array('description_small' => urldecode ($description_small)));    
   
  }
  
  function product_category_change($id) {
  
    $category = $_POST['val'];
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('categories_id' => urldecode ($category))); 
   
  }
  
  function product_brand_change($id) {
  
    $brand = $_POST['val'];
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('brand_id' => urldecode ($brand))); 
   
  }
  
  function product_subcategory_change($id) {
  
    $category = $_POST['val'];
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('categories_id' => urldecode ($category))); 
   
  }
  
  function product_additionally($id) {
  
    $values = $_POST['all_values'];
    
    $this->db->where('id', $id);
    
    $this->db->update('products', array('additionally' => $values)); 
   
  }
  
  function add_size($id) {
  
    $size = $_POST['val'];   
    
    $this->db->insert('products_sizes', array( 'parent_id' => $id, 'size' => urldecode ($size)));
   
  }
  
  function delete_size($id) {
  
    $this->db->delete('products_sizes', array( 'id' => $id));
    
    $this->db->delete('products_colors', array( 'size_id' => $id)); 

  }
    
  function add_color($id, $size) {
  
    $color = $_POST['val'];    
    
    $this->db->insert('products_colors', array( 'parent_id' => $id, 'size_id' => $size, 'color' => urldecode ($color), 'price' => '', 'image' => ''));
   
  }
  
  function delete_color($id) {
  
    $this->db->delete('products_colors', array( 'id' => $id)); 

  }  

  // -------------------------------- ЗАКАЗЫ --------------------------------------
  
  function orders() {	
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/delete.png" title="Удалить заказ" alt="Удалить заказ"> - удаление заказа.<br><br>Для перехода к странице с подробным описанием заказа выберите его.<br><br>Для смены статуса заказа используйте выпадающий список.<br><br>Цветовое оформление указывает на статус заказа.';
    
    $data['orders'] = $this->Shop_model->get_orders();
    
   // var_dump($data['orders'] );
    
    if ($data['orders']) foreach ($data['orders'] as $item) {
    
      $item->order_items = unserialize($item->order);
      
    }

    $this->load->view('admin/orders', $data);
    
    // var_dump($data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']); 
        
	}
  
  // Изменение статуса заказа
  
  function status_change($id) {
  
    $data['site'] = $this->Shop_model->get_site_info();
    
    $this->load->library('email');
    
    $config['mailtype'] = html;
    
    $this->email->initialize($config);
    
    $value = $_POST['val'];
    
    $data['order'] = $this->Shop_model->get_order($id);
    
    $this->email->clear();
    
    $this->email->from('noreply@ndural.ru', $data['site']->name);
    
    $this->email->to($data['order']->email);

    $this->email->subject('Ваш заказ на NDUral.ru');    
      
    //<img src="http://ndural.ru/images/logo.png"><br>
    
    $message_client = '<html><body><img src="http://ndural.ru/images/logo.png"><br><h2>'.$data['site']->name.'</h2>';
    
    $message_client .= '<p>Добрый день, '.$data['order']->name.'!<br><br>';
    
    $message_client .= 'Cтатус Вашего заказа изменен на "'.urldecode ($value).'"</p>';
    
    $message_client .= $data['site']->name.' '.$data['site']->url.' '.$data['site']->phone;
    
    $message_client .= '</body></html>';
    
    $this->email->message($message_client); 
      
    $this->email->send();
    
    $this->db->where('id', $id);    
    
    $this->db->update('orders', array('status' => urldecode ($value))); 
   
  }  
  
  function delete_order($id) {   
    
    $this->db->delete('orders', array('id' => $id));
   
  }  
  
  // -------------------------------- ЗАКАЗ --------------------------------------
  
  function order($id) {	    
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/delete.png" title="Удалить заказ" alt="Удалить заказ"> - удаление заказа.<br><br>Для просмотра товара на сайте выберите его.<br><br>Для смены статуса заказа используйте выпадающий список.<br><br>Цветовое оформление указывает на статус заказа.';
    
    $data['order'] = $this->Shop_model->get_order($id);    
      
    $data['order']->order_items = unserialize($data['order']->order);
    
    $this->load->view('admin/order', $data);
      
    // var_dump($data['order']->order_items);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']); 
        
	}
  
  // -------------------------------- АВТОМАТИЗАЦИЯ --------------------------------------
  
  function import() {
    
    $config['upload_path'] = 'uploads/';
    
    $config['allowed_types'] = '*';
        
    $config['overwrite'] = 'true';
    
    $config['max_size']	= '0';    

    $this->load->library('upload', $config);

    if (!$this->ion_auth->logged_in()) {
    
      redirect('auth/login', 'refresh');
      
      } else {      
      
      require_once 'js/excel_reader.php';
    
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['site']->title = $data['site']->name;
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
          
      $this->load->view('admin/header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['orders'] = $this->Shop_model->get_new_orders();
      
      $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
      
      $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
      $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
      // var_dump($data['orders'], $data['category_no_image']);
      
      $this->load->view('admin/menu',$data); 
      
      // содержимое страницы
      
      $data['help'] = "Здесь размещена помощь";      
      
      // var_dump($data['orders']);

      $data['categories'] = $this->Shop_model->get_categories();
      
      $data['error'] = '';
      
      if ( ! $this->upload->do_upload()) {
      
        $data['error'] = $this->upload->display_errors();        
        
      }	else {
      
        $data['upload_data'] = array($this->upload->data());      
      
        $data['excel'] = new Spreadsheet_Excel_Reader($data['upload_data']['0']['full_path']);        

        for($j=2; $j<=$data['excel']->sheets[0]['numRows']; $j++) {
        
          for($i=1; $i<=$data['excel']->sheets[0]['numCols']; $i++) {
          
            if(empty($data['excel']->sheets[0]['cells'][$j][$i])) {
          
              $row[$j][$i] = ""; // Ликвидируем ошибку undefined offset 

            } else {
            
              $row[$j][$i] = $data['excel']->sheets[0]['cells'][$j][$i]; // Создаём массив из значений столбцов для каждой строки

            }
            
          }
                  
          // Ищем товар в базе
          
          $ins = $this->Admin_model->find_product($row[$j]);        
          
          // Если товар уже существует, то проверяем цену и обновляем при необходимости
          
          if ($ins) {
          
            if ($ins->price != $row[$j][5]) {
          
              $this->db->where('id', $ins->product_id);
            
              $this->db->update('products_colors', array('price' => $row[$j][5]));
              
            }
            
          } else {
          
            $last_product_id = $this->Admin_model->find_this_product($row[$j]);
            
            if ($last_product_id) {
            
              $lsize_id = $this->Admin_model->find_this_sizes($row[$j]);
            
              if ($this->Admin_model->find_this_size($row[$j])) {
              
                $this->db->insert('products_colors', array( 'color' => $row[$j][4], 'parent_id' => $last_product_id, 'size_id' => $lsize_id, 'price' => $row[$j][5], 'image' => ''));
              
              } else {
              
                $lsize_id = $this->Admin_model->get_product_sizes($last_product_id, $row[$j][3]);
              
                $this->db->insert('products_colors', array( 'color' => $row[$j][4], 'parent_id' => $last_product_id, 'size_id' => $lsize_id, 'price' => $row[$j][5], 'image' => ''));
              
              }
            
            } else {                          
    
              $alias = $this->translitIt(trim($row[$j][1]));              
              
              $this->db->insert('products', array( 'name' => ucfirst(strtolower(trim($row[$j][1]))), 'alias' => strtolower($alias), 'available' => '1', 'categories_id' => $row[$j][2]));
            
              $last_product_id = $this->Admin_model->get_last_product();
              
              $this->db->insert('products_sizes', array( 'size' => $row[$j][3], 'parent_id' => $last_product_id));
              
              $lsize_id = $this->Admin_model->get_product_sizes($last_product_id, $row[$j][3]);
              
              $this->db->insert('products_colors', array( 'color' => $row[$j][4], 'parent_id' => $last_product_id, 'size_id' => $lsize_id, 'price' => $row[$j][5], 'image' => ''));
            
            }
            
          } 
          
          $ins = 0;
          
        }
        
      }     

      $this->load->view('admin/import', $data);
     
      // подвал сайта
      
      $this->load->view('admin/footer', $data['site']);
    
    }
    
	}
  
  function import_csv() {
    
    $config['upload_path'] = 'uploads/';
    
    $config['allowed_types'] = '*';
        
    $config['overwrite'] = 'true';
    
    $config['max_size']	= '0';    

    $this->load->library('upload', $config);

    if (!$this->ion_auth->logged_in()) {
    
      redirect('auth/login', 'refresh');
      
      } else {      
      
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['site']->title = $data['site']->name;
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
          
      $this->load->view('admin/header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['orders'] = $this->Shop_model->get_new_orders();
      
      $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
      
      $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
      $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
      // var_dump($data['orders'], $data['category_no_image']);
      
      $this->load->view('admin/menu',$data); 
      
      // содержимое страницы
      
      $data['help'] = "Здесь размещена помощь";      
      
      // var_dump($data['orders']);

      $data['categories'] = $this->Shop_model->get_categories();
      
      $data['error'] = '';
      
      if ( ! $this->upload->do_upload()) {
      
        $data['error'] = $this->upload->display_errors();        
        
      }	else {
      
        $data['upload_data'] = array($this->upload->data());      
      
        $data['excel'] = new Spreadsheet_Excel_Reader($data['upload_data']['0']['full_path']);    
         
        //var_dump($data['excel']);

        /*for($j=2; $j<=$data['excel']->sheets[0]['numRows']; $j++) {
        
          for($i=1; $i<=$data['excel']->sheets[0]['numCols']; $i++) {
          
            if(empty($data['excel']->sheets[0]['cells'][$j][$i])) {
          
              $row[$j][$i] = ""; // Ликвидируем ошибку undefined offset 

            } else {
            
              $row[$j][$i] = $data['excel']->sheets[0]['cells'][$j][$i]; // Создаём массив из значений столбцов для каждой строки

            }
            
          }
                  
          // Ищем товар в базе
          
          $ins = $this->Admin_model->find_product($row[$j]);        
          
          // Если товар уже существует, то проверяем цену и обновляем при необходимости
          
          if ($ins) {
          
            if ($ins->price != $row[$j][5]) {
          
              $this->db->where('id', $ins->product_id);
            
              $this->db->update('products_colors', array('price' => $row[$j][5]));
              
            }
            
          } else {
          
            $last_product_id = $this->Admin_model->find_this_product($row[$j]);
            
            if ($last_product_id) {
            
              $lsize_id = $this->Admin_model->find_this_sizes($row[$j]);
            
              if ($this->Admin_model->find_this_size($row[$j])) {
              
                $this->db->insert('products_colors', array( 'color' => $row[$j][4], 'parent_id' => $last_product_id, 'size_id' => $lsize_id, 'price' => $row[$j][5], 'image' => ''));
              
              } else {
              
                $lsize_id = $this->Admin_model->get_product_sizes($last_product_id, $row[$j][3]);
              
                $this->db->insert('products_colors', array( 'color' => $row[$j][4], 'parent_id' => $last_product_id, 'size_id' => $lsize_id, 'price' => $row[$j][5], 'image' => ''));
              
              }
            
            } else {                          
    
              $alias = $this->translitIt(trim($row[$j][1]));              
              
              $this->db->insert('products', array( 'name' => ucfirst(strtolower(trim($row[$j][1]))), 'alias' => strtolower($alias), 'available' => '1', 'categories_id' => $row[$j][2]));
            
              $last_product_id = $this->Admin_model->get_last_product();
              
              $this->db->insert('products_sizes', array( 'size' => $row[$j][3], 'parent_id' => $last_product_id));
              
              $lsize_id = $this->Admin_model->get_product_sizes($last_product_id, $row[$j][3]);
              
              $this->db->insert('products_colors', array( 'color' => $row[$j][4], 'parent_id' => $last_product_id, 'size_id' => $lsize_id, 'price' => $row[$j][5], 'image' => ''));
            
            }
            
          } 
          
          $ins = 0;
          
        }*/
        
      }     

      $this->load->view('admin/import', $data);
     
      // подвал сайта
      
      $this->load->view('admin/footer', $data['site']);
    
    }
    
	}
  
  function import_signum() {
    
    $config['upload_path'] = 'uploads/signum/';
    
    $config['allowed_types'] = '*';
        
    $config['overwrite'] = 'true';
    
    $config['max_size']	= '0';    

    $this->load->library('upload', $config);

    if (!$this->ion_auth->logged_in()) {
    
      redirect('auth/login', 'refresh');
      
      } else {      
      
      require_once 'js/excel_reader.php';
    
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['site']->title = $data['site']->name;
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
          
      $this->load->view('admin/header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['orders'] = $this->Shop_model->get_new_orders();
      
      $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
      
      $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
      $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
      // var_dump($data['orders'], $data['category_no_image']);
      
      $this->load->view('admin/menu',$data); 
      
      // содержимое страницы
      
      $data['help'] = "Здесь размещена помощь";      
      
      // var_dump($data['orders']);

      $data['categories'] = $this->Shop_model->get_categories();
      
      $data['error'] = '';
      
      if ( ! $this->upload->do_upload()) {
      
        $data['error'] = $this->upload->display_errors();        
        
      }	else {
      
        $data['upload_data'] = array($this->upload->data());      
      
        $data['excel'] = new Spreadsheet_Excel_Reader($data['upload_data']['0']['full_path']);        

        $this->db->update('products', array('available' => '0'));
        
        for($j=2; $j<=$data['excel']->sheets[0]['numRows']; $j++) {
        
          for($i=1; $i<=$data['excel']->sheets[0]['numCols']; $i++) {
          
            if(empty($data['excel']->sheets[0]['cells'][$j][$i])) {
          
              $row[$j][$i] = ""; // Ликвидируем ошибку undefined offset 

            } else {
            
              $row[$j][$i] = $data['excel']->sheets[0]['cells'][$j][$i]; // Создаём массив из значений столбцов для каждой строки

            }
            
          }
          
          $ins = $this->Admin_model->find_product($row[$j]);        
          
          if ($ins) {
          
            if (empty($ins->description)) {
          
              $this->db->where('id', $ins->product_id);
            
              $this->db->update('products', array('available' => '1', 'description' => $row[$j][2], 'description_small' => $this->cutString($row[$j][2],150), 'price_for_us' => $row[$j][3]));
              
            } else {
            
              $this->db->where('id', $ins->product_id);
              
              $this->db->update('products', array('available' => '1', 'price_for_us' => $row[$j][3]));
              
            } 
            
          }  else {
          
            $alias = $this->translitIt(trim($row[$j][1]));

            $brand = explode(' ', trim($row[$j][1]));           
            
            if ($brand_id = $this->Shop_model->get_brand_id_alias($brand[0])) { 
      
              $this->db->where('id', $item->id);
            
              $this->db->update('products', array( 'brand_id' => $brand_id));
            
            }
              
            $this->db->insert('products', array( 'name' => ucfirst(strtolower(trim($row[$j][1]))), 'alias' => strtolower($alias), 'available' => '1', 'categories_id' => '999', 'description' => $row[$j][2], 'price_for_us' => $row[$j][3]));
          
            $last_product_id = $this->Admin_model->get_last_product();
            
            $this->db->insert('products_sizes', array( 'size' => 'Комплект', 'parent_id' => $last_product_id));
            
            $lsize_id = $this->Admin_model->get_product_sizes($last_product_id, 'Комплект');
            
            $price = intval($row[$j][3])*1.35;
            
            $this->db->insert('products_colors', array( 'color' => 'Стандарт', 'parent_id' => $last_product_id, 'size_id' => $lsize_id, 'price' => $price, 'image' => ''));
          
          }
          
          $ins = 0;
        
        }

      }

      $this->load->view('admin/import', $data);
     
      // подвал сайта
      
      $this->load->view('admin/footer', $data['site']);
    
    }
    
	}
  
  function export() {
  
    $this->load->dbutil();
    
    $this->load->helper('file');

    $query = $this->db->query("SELECT t1.name,t1.categories_id, t2.size, t3.color, t3.price
        FROM products t1
        JOIN products_sizes t2 ON t2.parent_id = t1.id
        JOIN products_colors t3 ON t3.size_id = t2.id      
        ORDER by t1.id");
        
    $export_data = $this->dbutil->csv_from_result($query);      
    
    if ( ! write_file('downloads/backup_'.date("dmY").'.csv', $export_data)) {
      
      echo 'Не удалось записать данные в файл!';
      
    } else {
    
      echo 'Файл записан!';
    
    }
  
  }
  
  // ---------------- ПОИСК ИЗОБРАЖЕНИЙ ТОВАРОВ НА ЯНДЕКС.МАРКЕТЕ ---------------------
  
  function images_find() {
  
    $products_without_images = $this->Admin_model->get_all_products_without_images();
        
    foreach ($products_without_images as $item) {
            
      $use_curl = true; // Использовать CURL

      $keyword = $item->name;      
      
      $keyword = str_replace(' ', '+', $keyword);
      
      // Адрес страницы с результатами поиска
      
      $url = "http://market.yandex.ru/search.xml?text=".$keyword."&nopreciser=1";
      
      // Выбираем результаты поиска
      
      $page = $this->get_page($url);

      // Находим ссылку на изображение товара
      
      if (preg_match_all('/<img class="b-offers__img" src="(.*?)"/ui', $page, $matches)) {
      
        $this->db->where('id', $item->id);
        
        $this->db->update('products_colors', array( 'image' => $matches[1][0], 'thumb' => $matches[1][0], 'small' => $matches[1][0]));
      
      }
        
    }
    
    echo "Ok";
    
  }
  
  // ---------------- ПОИСК ОПИСАНИЙ ТОВАРОВ НА ЯНДЕКС.МАРКЕТЕ ---------------------
  
  function description_find() {
  
    $products_without_description = $this->Admin_model->get_all_products_without_description();
    
    $count =0;
        
    foreach ($products_without_description as $item) {
      
      $use_curl = true; // Использовать CURL

      $keyword = $item->name;
      
      $keyword = str_replace(' ', '+', $keyword);
      
      // Адрес страницы с результатами поиска
      
      $url = "http://market.yandex.ru/search.xml?text=".$keyword."&nopreciser=1";
      
      // Выбираем результаты поиска
      
      $page = $this->get_page($url);      
      
      if (preg_match_all('/<h3 class="b-offers__title"><a href="(.*?)" class="b-offers__name">/ui', $page, $matches)) {
      
        $product_url = 'http://market.yandex.ru'.reset($matches[1]);
        
        $page = $this->get_page($product_url);

        if (preg_match_all('/<ul class="b-vlist b-vlist_type_mdash b-vlist_type_friendly">(.*?)<\/ul>/ui', $page, $matches)) {
          
          // Описание товара
          
          $description = '<ul>'.reset($matches[1]).'</ul>';
          
          // Страница характеристик
          
          if (preg_match_all('/<p class="b-model-friendly__title"><a href="(.*?)">все характеристики<\/a><\/p>/ui', $page, $matches)) {
            
            $options_url = "http://market.yandex.ru".reset($matches[1]);
            
            $options_page = $this->get_page($options_url);
            
            preg_match_all('/<th class="b-properties__label b-properties__label-title"><span>(.*?)<\/span><\/th><td class="b-properties__value">(.*?)<\/td>/ui', $options_page, $matches, PREG_SET_ORDER);
            
            $yandex_option = "<ul class='products_param_desc'>";
            
            foreach ( $matches as $m ) {
              
              $yandex_option .= "<li><span class='param'>".$m[1].":<\/span> <span class='value'>".$m[2]."<\/span><\/li>\n";              
              
            }     
            
            $yandex_option .= "<\/ul>";           
            
            $this->db->where('id', $item->id);
          
            $this->db->update('products', array( 'description' => $yandex_option, 'description_small' => $description));
            
            // echo $item->id." ==> ".$yandex_option." ==> ".$description;
            
          } else {
          
            $this->db->where('id', $item->id);
            
            $this->db->update('products', array( 'description' => $description, 'description_small' => $description));
            
            // echo $item->id." ==> ".$description." ==> ".$description;
            
          }
              
        } else {
        
          $this->db->where('id', $item->id);
              
          $this->db->update('products', array( 'description' => 'характеристики'));
          
          // echo $item->id." ==> 'характеристики'";
          
        }
        
        // echo $product_url;
              
      }

      $count++;
    
    }
    
    echo $count." Ok";
    
  }
    
  function get_page($url, $use_curl=true) {
  
    if($use_curl && function_exists('curl_init')) {
    
      $ch = curl_init(); 
      
      curl_setopt($ch, CURLOPT_URL, $url); 
      
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
      
      curl_setopt($ch, CURLOPT_HEADER, 1);
      
        curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
        
        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
        
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      // Для использования прокси используйте строки:
      
      // curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
      
      // curl_setopt($ch, CURLOPT_PROXY, '88.85.108.16:8080'); 
      
      // curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:password'); 

      // Яндекс может нас отправить в редирект, так что нужно следовать за редиректом
      
      do {
      
        curl_setopt($ch, CURLOPT_URL, $url);
        
        $header = curl_exec($ch);
        
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if($code == 301 || $code == 302) {
        
          preg_match('/Location:(.*?)\n/', $header, $matches);
          
          $url = trim(array_pop($matches));
          
        } else
          $code = 0;	
          
      } while($code);
                
      $page = curl_exec($ch);
      
      curl_close($ch); 
      
    } else {
    
      $page = file_get_contents($url);
      
    }
    
    return $page;
    
  } 
  
  // -------------------------------- СТРАНИЦЫ --------------------------------------
  
  function pages($page=1) {
  
    $limit=20;
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/delete.png" title="Удалить страницу" alt="Удалить страницу"> - удаление страницы.<br><br>Для добавления новой страницы нажмите Добавить страницу, после чего отредактируйте страницу в появившемся новом окне.<br><br>Для редактирования страницы выберите её.';
    
    $data['pages'] = $this->Admin_model->get_pages($limit, ($page-1)*$limit);
    
    // var_dump($data['pages']);

    // разбивка на страницы
    
    $data['num_pages'] = $this->Admin_model->get_num_pages();
    
    $config['base_url'] = "/admin/pages/";
    
    $config['total_rows'] = $data['num_pages'];
    
    $config['per_page'] = $limit;
    
    $config['uri_segment'] = 3;    

    $config['use_page_numbers'] = TRUE;    
    
    $config['next_link'] = 'Следующая';
    
    $config['prev_link'] = 'Предыдущая';
    
    $config['first_link'] = '<<';
    
    $config['last_link'] = '>>';    
    
    $this->pagination->initialize($config);

    $data['pagination'] = $this->pagination->create_links();
    
    $this->load->view('admin/pages', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
  
  function page( $id , $save = '') {

    if ($id == 'last') $id = $this->Admin_model->get_last_page();
    
    if ($save) {
    
      $title = $_POST['page_title'];
    
      $alias = $_POST['page_alias'];
      
      $text = $_POST['page_text'];
      
      $this->db->where('id', $id);
      
      $this->db->update('pages', array('title' => urldecode ($title), 'alias' => urldecode ($alias), 'text' => urldecode ($text)));
      
    }
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['page'] = $this->Admin_model->get_page($id);
    
    // var_dump($data['page']);    
    
    $this->load->view('admin/page', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
    
  function delete_page($id) {
  
    $this->db->delete('pages', array('id' => $id));     
   
  }
  
  function add_page() {
  
    $this->db->insert('pages', array( 'title' => '', 'text' => '', 'alias' => ''));
   
  }
  
  function update_page($id) {
  
    $title = $_POST['title'];
    
    $alias = $_POST['alias'];    
    
    $this->db->where('id', $id);
    
    $this->db->update('pages', array('title' => urldecode ($title), 'alias' => urldecode ($alias))); 
   
  }
  
  // -------------------------------- НОВОСТИ --------------------------------------
  
  function news($page=1) {
  
    $limit=20;
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['help'] = '<img src="/images/delete.png" title="Удалить новость" alt="Удалить новость"> - удаление новости.<br><br>Для добавления новой новости нажмите Добавить новость, после чего отредактируйте новость в появившемся новом окне.<br><br>Для редактирования новости выберите её.';
    
    $data['news'] = $this->Admin_model->get_news($limit, ($page-1)*$limit);
    
    // var_dump($data['pages']);

    // разбивка на страницы
    
    $data['num_news'] = $this->Admin_model->get_num_news();
    
    $config['base_url'] = "/admin/news/";
    
    $config['total_rows'] = $data['num_news'];
    
    $config['per_page'] = $limit;
    
    $config['uri_segment'] = 3;    

    $config['use_page_numbers'] = TRUE;    
    
    $config['next_link'] = 'Следующая';
    
    $config['prev_link'] = 'Предыдущая';
    
    $config['first_link'] = '<<';
    
    $config['last_link'] = '>>';    
    
    $this->pagination->initialize($config);

    $data['pagination'] = $this->pagination->create_links();
    
    $this->load->view('admin/news', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
  
  function news_page( $id , $save = '') {

    if ($id == 'last') $id = $this->Admin_model->get_last_news_page();
    
    if ( $save ) {
    
      $title = $_POST['page_title'];
    
      $alias = $_POST['page_alias'];
      
      $text = $_POST['page_text'];
      
      $keywords = $_POST['page_keywords'];
      
      $description = $_POST['page_description'];
      
      $image_file = $_POST['page_image'];
      
        $url = 'images/news/0' . $id . '.jpg';
        
        $thumb = 'images/news/0' . $id . '_thumb.jpg';
            
        $image = $this->save_image($url, $image_file, 400);
        
        //$image = $this->addWatermark($url);
        
        $image_thumb = $this->save_image($thumb, $image_file, 150); 
      
      $video = $_POST['page_video'];
      
      $this->db->where('id', $id);
      
      $this->db->update('news', array('title' => urldecode ($title), 'alias' => urldecode ($alias), 'text' => urldecode ($text), 'image' => urldecode ($url), 'thumb' => urldecode ($thumb), 'video' => urldecode ($video), 'keywords' => urldecode ($keywords), 'description' => urldecode ($description),));
      
      // Публикация в Твиттер - ключи twitter-приложения
      
      $options=array();
      
      $options['CONSUMER_KEY'] = 'yJ2P5G3bCDdOL11MA6lg';
      
      $options['CONSUMER_SECRET'] = '3SggXFetsE3zhLP2hhXElyBvuRApoxjdyoKtcJyX1I';
      
      $options['OAUTH_TOKEN'] = '2169600571-wtMcimM1UPrhoo0kBVrmLcZLxrjfohy76VLrGqw';
      
      $options['OAUTH_SECRET'] = 'qK8w8CtnbDhQFTy7JyuCoEgAmxydkWX5hYO6zM20Nb7YM';

      // -----
      
      require_once 'tools/twitteroauth/twitteroauth.php';
     
      $connection = new TwitterOAuth($options['CONSUMER_KEY'], $options['CONSUMER_SECRET'], $options['OAUTH_TOKEN'], $options['OAUTH_SECRET']);
     
      $connection->host = "https://api.twitter.com/1.1/";
      
      $tw_post = $title." http://ndural.ru/shop/news/".$alias;      
      
      $connection->post('statuses/update', array('status'=>$tw_post)); 
      
    }
    
    // шапка сайта
    
    $data['site'] = $this->Shop_model->get_site_info();
    
    $data['site']->title = $data['site']->name;
    
    $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
				
		$this->load->view('admin/header', $data['site']); 

    // верхнее меню сайта
    
    $data['menu'] = $this->Shop_model->get_menu();
    
    $data['orders'] = $this->Shop_model->get_new_orders();
    
    $data['category_no_image'] = $this->Admin_model->get_num_category_no_image();
    
    $data['brand_no_image'] = $this->Admin_model->get_num_brand_no_image();
      
    $data['product_no_image'] = $this->Admin_model->get_num_product_no_image();
      
    $this->load->view('admin/menu',$data); 
    
    // содержимое страницы
    
    $data['page'] = $this->Admin_model->get_news_page($id);
    
    // var_dump($data['page']);    
    
    $this->load->view('admin/news_page', $data);
   
    // подвал сайта
    
    $this->load->view('admin/footer', $data['site']);    
    
  }
    
  function delete_news_page($id) {
  
    $this->db->delete('news', array('id' => $id));     
   
  }
  
  function add_news_page() {
  
    $this->db->insert('news', array( 'title' => '', 'text' => '', 'alias' => ''));
   
  }
  
  function update_news_page($id) {
  
    $title = $_POST['title'];
    
    $alias = $_POST['alias'];    
    
    $this->db->where('id', $id);
    
    $this->db->update('news', array('title' => urldecode ($title), 'alias' => urldecode ($alias))); 
   
  }
  
  //--------------- ДОПОЛНИТЕЛЬНЫЕ ФУНКЦИИ ---------------
  
  function save_image($url, $file, $size) {
  
    $image_info = getimagesize($file);    
    
    $this->image_type = $image_info[2];    
    
    if( $this->image_type == IMAGETYPE_JPEG ) {
    
      $this->image = imagecreatefromjpeg($file);
       
    } elseif( $this->image_type == IMAGETYPE_GIF ) {
    
      $this->image = imagecreatefromgif($file);
       
    } elseif( $this->image_type == IMAGETYPE_PNG ) {
    
      $this->image = imagecreatefrompng($file);
       
    }
    
    $image = $this->resizeToSize($this->image, $size);   
    
    if( $this->image_type == IMAGETYPE_JPEG ) {
    
      imagejpeg($image, $url, 100);
       
    } elseif( $this->image_type == IMAGETYPE_GIF ) {
    
      imagegif($image, $url);
       
    } elseif( $this->image_type == IMAGETYPE_PNG ) {
    
      imagepng($image, $url);
       
    }    
    
    return $image;
       
  }    
  
  function resizeToSize($image, $size) {
   
    if (imagesy($image)>imagesx($image)) { $height = $size; $ratio = $size / imagesy($image); $width = imagesx($image) * $ratio; }
    
    else { $width = $size; $ratio = $size / imagesx($image); $height = imagesy($image) * $ratio; }
    
    $new_image = imagecreatetruecolor($width,$height);
    
    imageAlphaBlending($new_image, true);
    
    imageSaveAlpha($new_image, true);    
    
    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
        
    return $new_image;
      
  }
   
  function addWatermark($file) {
    
    $stamp = imagecreatefrompng('images/watermark.png');
		
    $im = imagecreatefromjpeg($file);

		$marge_right = 10;
		
    $marge_bottom = 10;
		
    $sx = imagesx($stamp);
		
    $sy = imagesy($stamp);

		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		imagejpeg($im, $file);
		
    return $im;
  
  }
  
  function translitIt($str) {
    $tr = array(
        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
        "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
        "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
        " "=> "_", "."=> "", "/"=> "_"
    );
    return strtr($str,$tr);
  }
  
  function brand_name_find() {
  
    $products_without_brand = $this->Admin_model->get_all_products_without_brand();    
        
    foreach ($products_without_brand as $item) {
      
      $brand = explode(' ', $item->name);      
      
      if ($brand_id = $this->Shop_model->get_brand_id_alias($brand[0])) { 
      
        $this->db->where('id', $item->id);
      
        $this->db->update('products', array( 'brand_id' => $brand_id));
      
      echo $item->name." - ".$brand[0]." - ".$brand_id."<br>";
      
      }
      
    } 
    
    echo "Ok";
    
  }
  
  function cutString($string, $maxlen) {
		
    $len = (mb_strlen($string) > $maxlen) ? mb_strripos(mb_substr($string, 0, $maxlen), ' ') : $maxlen ;
		
    $cutStr = mb_substr($string, 0, $len);
		
    return (mb_strlen($string) > $maxlen) ? '' . $cutStr . '.' : '' . $cutStr . '' ; 
	
  }
     
}

?>