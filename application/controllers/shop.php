<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

	function __construct() {
    parent::__construct();
    
    $this->load->model('Shop_model', '', TRUE);
    
    $this->load->library('session');
    
    $this->load->library('ion_auth','russian');
    
    $this->load->helper('url');
    
  }
  
  function index() {
		        
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['site']->title = $data['site']->name." : ".$data['site']->adress;
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
            
      // var_dump($this->session->userdata);
      
      $data['site']->meta_description = $this->cutString(strip_tags($data['site']->description), 150);
          
      $this->load->view('header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['subcategories'] = $this->Shop_model->get_subcategories();
      
      $this->load->view('menu', $data); 
      
      // содержимое страницы

      $data['categories'] = $this->Shop_model->get_categories();

      $data['brands'] = $this->Shop_model->get_brands();
      
      $data['site']->slides = $this->Shop_model->get_slides();      
      
      $data['products'] = $this->Shop_model->get_best_products();
    
      foreach ($data['products'] as &$products) {
      
        $products['brand_img'] = $this->Shop_model->get_brand_image($products['brand_id']);
        
        $products['brand'] = $this->Shop_model->get_brand($products['brand_id']);
        
        $products['product_sizes'] = $this->Shop_model->get_product_sizes($products['id']);
              
        foreach ($products['product_sizes'] as &$sizes) {
        
          $sizes->product_colors = $this->Shop_model->get_product_colors($products['id'], $sizes->id);       
        
        }    
      
      }   

      $data['recommend_products'] = $this->Shop_model->get_recommend_products();
    
      foreach ($data['recommend_products'] as &$products) {
      
        $products['brand_img'] = $this->Shop_model->get_brand_image($products['brand_id']);
        
        $products['brand'] = $this->Shop_model->get_brand($products['brand_id']);
        
        $products['product_sizes'] = $this->Shop_model->get_product_sizes($products['id']);
              
        foreach ($products['product_sizes'] as &$sizes) {
        
          $sizes->product_colors = $this->Shop_model->get_product_colors($products['id'], $sizes->id);       
        
        }    
      
      }

      $this->load->view('base', $data);
     
      // подвал сайта
      
      $data['site']->news = $this->Shop_model->get_news();
      
      $data['site']->categories = $this->Shop_model->get_categories(); 
      
      foreach ($data['site']->categories as $items) {
      
        $data['site']->description_hide .= 'Купить '.mb_strtolower($items->title).' по самой низкой цене в Екатеринбурге.<br>';
        
      }
      
      $data['site']->subcategories = $this->Shop_model->get_subcategories(); 
      
      foreach ($data['site']->subcategories as $items) {
      
        $data['site']->description_hide .= 'Купить '.mb_strtolower($items->title).' по самой низкой цене в Екатеринбурге.<br>';
        
      }
      
      // var_dump($data['site']);
      
      $this->load->view('footer', $data['site']);
            
	}
    
  function cutString($string, $maxlen) {
		
    $len = (mb_strlen($string) > $maxlen) ? mb_strripos(mb_substr($string, 0, $maxlen), ' ') : $maxlen ;
		
    $cutStr = mb_substr($string, 0, $len);
		
    return (mb_strlen($string) > $maxlen) ? '' . $cutStr . '.' : '' . $cutStr . '' ; 
	
  }

  function page( $alias = 'contacts' ) {
		        
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['page'] = $this->Shop_model->get_page($alias); 
      
      $data['site']->title = $data['page']->title;
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
            
      // var_dump($this->session->userdata);
      
      $data['site']->meta_description = $this->cutString(strip_tags($data['page']->text), 150);
          
      $this->load->view('header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['subcategories'] = $this->Shop_model->get_subcategories();
      
      $this->load->view('menu', $data); 
      
      // содержимое страницы
      
      $data['brands'] = $this->Shop_model->get_brands();

      $this->load->view('page', $data);
     
      // подвал сайта
      
      $data['site']->news = $this->Shop_model->get_news();
      
      $this->load->view('footer', $data['site']);
            
	}
  
  function news( $alias = '' ) {
		        
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
      
      if ($alias) {
      
        $data['news_page'] = $this->Shop_model->get_news_page($alias); 
        
        $data['site']->title = $data['news_page']->title;
        
        $data['site']->meta_description = $data['news_page']->description;
        
        $data['site']->keywords = $data['news_page']->keywords;

      } else {
      
        $data['news'] = $this->Shop_model->get_all_news();

        $data['site']->title = "Новости от наших партнеров";
        
        $data['site']->meta_description = "Самые последние новости о товарах наших партнеров";
        
        $data['site']->keywords = "новости, новинки, обзоры, видео, автотовары, автоэлектроника";        
      
      }
                      
      $this->load->view('header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['subcategories'] = $this->Shop_model->get_subcategories();
      
      $this->load->view('menu', $data); 
      
      // содержимое страницы
      
      $data['brands'] = $this->Shop_model->get_brands();

      if ($alias) $this->load->view('page_news', $data); 
      
      else $this->load->view('news', $data);
     
      // подвал сайта
      
      $data['site']->news = $this->Shop_model->get_news();
      
      $this->load->view('footer', $data['site']);
            
	}
  
  function search() {
		        
      $data['query'] = urldecode ($_POST['search']);
      
      // шапка сайта
      
      $data['site'] = $this->Shop_model->get_site_info();
      
      $data['site']->title = 'Поиск '.$data['query'];
      
      $data['site']->user = $this->ion_auth->logged_in() ? $this->session->userdata( 'username' ) : '';
            
      // var_dump($this->session->userdata);
      
      $data['site']->meta_description = 'Поиск на сайте '.$data['query'];
          
      $this->load->view('header', $data['site']); 

      // верхнее меню сайта
      
      $data['menu'] = $this->Shop_model->get_menu();
      
      $data['subcategories'] = $this->Shop_model->get_subcategories();
      
      $this->load->view('menu', $data); 
      
      // содержимое страницы      
      
      $lenght_query = strlen($data['query']);
      
      if ( $lenght_query > 2) {
      
        $data['results'] = '<h3>Найдено среди товаров:</h3><br><article>';
        
        $data['results_product'] = $this->Shop_model->search_products($data['query']);
        
        if (!empty($data['results_product'])) {
        
          $data['results'] .= '<ul>';
        
          foreach ($data['results_product'] as $products_result) {
          
            $data['results'] .= '<li><a href="/catalog/detail/'.$products_result['alias'].'" title="'.$products_result['name'].'">'.$products_result['name'].'</a></li><br>';
            
          }
          
          $data['results'] .= '</ul>';
          
        }
        
        $data['results'] .= '</article>';
      
      } else {
      
        $data['results'] = '<h4>Слишком короткий запрос</h4>';
      
      }    
      
      //var_dump($data['results_product']);
      
      $data['brands'] = $this->Shop_model->get_brands();

      $this->load->view('search_result', $data);
     
      // подвал сайта
      
      $data['site']->news = $this->Shop_model->get_news();
      
      $this->load->view('footer', $data['site']);
            
	}
  
}
?>