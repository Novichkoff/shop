<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
    function __construct() {    
      parent::__construct();      
    }    
    
    function get_products( $category, $limit=20, $offset=0 ) {    
      if ($category) { 
        $this->db->where( array('categories_id' => $category, 'available' => '1')); 
      } else { 
        $this->db->where( array('available' => '1')); 
      }      
      $this->db->order_by("available DESC");      
      $query = $this->db->get('products', $limit, $offset);      
      return $query->result();      
    } 
    
    function get_product_price($id) {    
      $query = $this->db->get_where('products_colors', array('parent_id' => $id));
      return $query->row('price');      
    }
    
    function get_all_products() {    
      $this->db->order_by("id");            
      $query = $this->db->get('products');      
      return $query->result();      
    }
    
    function get_all_products_without_images() {    
      return $query = $this->db->query("SELECT t1.*
        FROM products t1
        JOIN products_sizes t2 ON t2.parent_id = t1.id
        JOIN products_colors t3 ON t3.size_id = t2.id
        WHERE t3.image = '' 
        ORDER by t1.available DESC")->result();
    }
    
    function get_all_products_without_description() {    
      return $query = $this->db->query("SELECT * FROM products WHERE description = '' ORDER by available DESC LIMIT 10")->result();
    }
    
    function get_all_products_without_brand() {    
      return $query = $this->db->query("SELECT name, id FROM products WHERE brand_id = 0 ORDER by available DESC")->result();
    }
    
    function get_num_products( $category='' ) { 
      if ($category) { 
        $this->db->where( array('categories_id' => $category, 'available' => '1')); 
      } else { 
        $this->db->where( array('available' => '1')); 
      }
      $query = $this->db->get('products');     
      return $query->num_rows();     
    }
    
    function get_categories($id) {
      $this->db->order_by("sort"); 
      $query = !isset($id) ? $this->db->get_where('categories', array('parent_id !=' => 0)) : $this->db->get_where('categories', array('parent_id' => $id));
      return $query->result();      
    }    
    
    function get_subcategories($id) {
      $this->db->order_by("sort"); 
      $query = isset($id) ? $this->db->get_where('categories', array('parent_id !=' => 0)) : $this->db->get_where('categories', array('parent_id' => $id));
      return $query->result();      
    }

    function get_menu() {
      $this->db->order_by("sort");
      $query = $this->db->get_where('menu', array('parent_id' => 0));
      return $query->result();      
    }
    
    function get_category_name($id) {
      $query = $this->db->get_where('categories', array('id' => $id));
      return $query->row('title');      
    }
    
    function get_category_id($name) {
      $query = $this->db->get_where('categories', array('title' => $name));
      return $query->row('id');      
    }

    function get_category_alias($id) {
      $query = $this->db->get_where('categories', array('id' => $id));
      return $query->row('alias');      
    }

    function get_num_category_no_image() {
      $query = $this->db->get_where('categories', array('parent_id' => 0, 'image' => ''));
      return $query->num_rows();      
    }
    
    function get_num_brand_no_image() {
      $query = $this->db->get_where('brands', array('image' => ''));
      return $query->num_rows();      
    }
    
    function get_num_product_no_image() {
      return $this->db->query("
      SELECT *
        FROM products t1        
        JOIN products_colors t2 ON t2.size_id = t1.id  
        WHERE t2.image = ''
          AND t1.available = 1")->num_rows();            
    }
    
    function get_products_no_image() {    
      $query = $this->db->get_where('products_colors', array('image' => ''));
      return $query->result();      
    }
        
    function get_product( $id ) {             
      $query = $this->db->get_where('products', array('id' => $id));      
      return $query->row();      
    }
    
    function get_last_product() {
      $this->db->order_by('id','DESC');
      $query = $this->db->get('products');      
      return $query->row('id');    
    }
    
    function get_product_sizes($id, $size) {
      $query = $this->db->get_where('products_sizes', array('parent_id' => $id, 'size' => $size));      
      return $query->row('id');    
    }
        
    function get_export() {    
      return $this->db->query("
      SELECT t1.name,t1.categories_id, t2.size, t3.color, t3.price
        FROM products t1
        JOIN products_sizes t2 ON t2.parent_id = t1.id
        JOIN products_colors t3 ON t3.size_id = t2.id      
        ORDER by t1.id")->result_array();
    }
    
    function find_product( $params ) {    
      return $this->db->query("
      SELECT t3.id as product_id, t1.name, t1.categories_id, t2.size, t3.color, t1.price_for_us, t1.available, t1.description, t3.price as price
        FROM products t1
        JOIN products_sizes t2 ON t2.parent_id = t1.id
        JOIN products_colors t3 ON t3.size_id = t2.id
        WHERE LOWER (t1.name) LIKE  '%".strtolower($params['1'])."%'
        ORDER by t1.id")->row();
    } 
    
    function find_this_product( $params ) {    
      return $this->db->query("
      SELECT *
        FROM products       
        WHERE LOWER(name) LIKE '%".strtolower($params['1'])."%'
        ORDER by id")->row('id');
    }
    
    function find_this_size( $params ) {    
      return $this->db->query("
      SELECT t1.name, t1.categories_id, t2.size, t2.id as id
        FROM products t1
        JOIN products_sizes t2 ON t2.parent_id = t1.id        
        WHERE LOWER(t1.name) LIKE '%".strtolower($params['1'])."%'
          AND t2.size = '".$params['3']."'           
        ORDER by t1.id")->row('id');
    }
    
    function get_pages( $limit=20, $offset=0 ) {    
      $this->db->order_by("id");            
      $query = $this->db->get('pages', $limit, $offset);      
      return $query->result();      
    }  
    
    function get_num_pages() { 
      $query = $this->db->get('pages');     
      return $query->num_rows();    
    }
    
    function get_page( $id ) {             
      $query = $this->db->get_where('pages', array('id' => $id));      
      return $query->row();      
    }
    
    function get_last_page() {
      $this->db->order_by('id','DESC');
      $query = $this->db->get('pages');      
      return $query->row('id');    
    }
    
    function get_news( $limit=20, $offset=0 ) {    
      $this->db->order_by("id");            
      $query = $this->db->get('news', $limit, $offset);      
      return $query->result();      
    }  
    
    function get_num_news() { 
      $query = $this->db->get('news');     
      return $query->num_rows();    
    }
    
    function get_news_page( $id ) {             
      $query = $this->db->get_where('news', array('id' => $id));      
      return $query->row();      
    }
    
    function get_last_news_page() {
      $this->db->order_by('id','DESC');
      $query = $this->db->get('news');      
      return $query->row('id');    
    }
    
}
?>