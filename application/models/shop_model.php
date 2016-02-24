<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_model extends CI_Model {

    function __construct() {
      parent::__construct();
    }
    
    function get_site_info() {
      $query = $this->db->get('config');
      return $query->row();      
    }
    
    function get_products( $id=0 , $limit=12, $offset=0, $sort_param='t2.id', $brand_id=0 ) {    
      if ($brand_id) return $this->db->query("
        SELECT t1.*, t2.image, t2.thumb, t2.small, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t1.categories_id = ".$id."
          AND t1.brand_id = ".$brand_id."
          AND t1.available = 1
        GROUP by t1.id
        ORDER by ".$sort_param."
        LIMIT ". $offset .", ". $limit." ")->result_array();
      else return $this->db->query("
        SELECT t1.*, t2.image, t2.thumb, t2.small, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t1.categories_id = ".$id."
          AND t1.available = 1
        GROUP by t1.id
        ORDER by ".$sort_param."
        LIMIT ". $offset .", ". $limit." ")->result_array();
    }
    
    function get_similar( $id, $categories_id, $like, $price, $limit=4 ) {    
      return $this->db->query("
        SELECT t1.*, t2.image, t2.thumb, t2.small, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t1.categories_id = ".$categories_id."
          AND t1.available = 1
          AND t1.id != ".$id."
          AND t2.price BETWEEN ".(intval($price)-5000)." AND ".(intval($price)+5000)."                    
        GROUP by t1.id
        ORDER by t1.rating DESC
        LIMIT ".$limit." ")->result_array();
    }
    
    function get_brand_products( $id=0 , $limit=12, $offset=0, $sort_param='t2.id' ) {    
      return $this->db->query("
        SELECT t1.*, t2.image, t2.thumb, t2.small, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t1.brand_id = ".$id."
          AND t1.available = 1
        GROUP by t1.id
        ORDER by ".$sort_param."
        LIMIT ". $offset .", ". $limit." ")->result_array();
    }
    
    function get_new_products( $limit=7 ) {    
      return $this->db->query("
        SELECT t1.*, t2.image, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t2.image != ''
          AND t1.available = 1
        GROUP by t1.id
        ORDER by t1.create_date DESC
        LIMIT ". $limit." ")->result_array();
    }
    
    function get_best_products( $limit=6 ) {    
      return $this->db->query("
        SELECT t1.*, t2.thumb, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t2.image != ''
          AND t1.available = 1
        GROUP by t1.id
        ORDER by t1.rating DESC
        LIMIT ". $limit." ")->result_array();
    }
        
    function get_recommend_products( $limit=6 ) {    
      return $this->db->query("
        SELECT t1.*, t2.thumb, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t2.image != ''
          AND t1.recommend = 1
            AND t1.available = 1
        GROUP by t1.id
        ORDER by t1.rating DESC
        LIMIT ". $limit." ")->result_array();
    }
    
    function get_categories_best( $id=0, $brand_id=0, $sort_param='t1.name' ) {    
      if ($brand_id) return $this->db->query("
        SELECT t1.*, t2.image, t2.color, t2.thumb, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        JOIN categories t4 ON t4.id = t1.categories_id
        WHERE t4.parent_id = ".$id."
          AND t1.available = '1'
          AND t1.brand_id = ".$brand_id."
        GROUP by t1.id
        ORDER by ".$sort_param." ")->result_array();
      else return $this->db->query("
        SELECT t1.*, t2.image, t2.color, t2.thumb, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        JOIN categories t4 ON t4.id = t1.categories_id
        WHERE t4.parent_id = ".$id."
          AND t1.available = '1'         
        GROUP by t1.id
        ORDER by ".$sort_param." ")->result_array();
    }
    
    function get_categories_all( $id=0 ) {    
      return $this->db->query("
        SELECT t3.*
        FROM products t1
        JOIN categories t2 ON t2.id = t1.categories_id
        JOIN brands t3 ON t3.id = t1.brand_id
        WHERE t2.parent_id = ".$id."
          OR t2.id = ".$id."
          AND t1.available = '1'
        ORDER by t3.title")->result_array();
    }
    
    function get_brand_best( $id=0 , $limit=120 ) {    
      return $this->db->query("
        SELECT t1.*, t2.image, t2.color, t2.thumb, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        JOIN brands t4 ON t4.id = t1.brand_id
        WHERE t4.id = ".$id."
          AND t1.available = '1'
        GROUP by t1.id
        ORDER by t1.rating DESC
        LIMIT ". $limit." ")->result_array();
    }
    
    function get_product_min( $color_id ) {    
      $this->db->select('id');
      $query = $this->db->get_where('products_colors', array('id' => $color_id));
      return $query->row();
    }
    
    function get_product_full( $color_id ) {    
      $this->db->select('id,parent_id,size_id,color,price,image');
      $query = $this->db->get_where('products_colors', array('id' => $color_id));
      return $query->row();
    }
    
    function get_product_name( $id ) {    
      $query = $this->db->get_where('products', array('id' => $id));
      return $query->row('name');
    }
    
    function get_product_size( $id ) {    
      $query = $this->db->get_where('products_sizes', array('id' => $id));
      return $query->row('size');
    }
    
    function get_parent( $id ) {
      $query = $this->db->get_where('categories', array('id' => $id));              
      return $query->row('parent_id');
    }

    function get_category_id_alias( $alias ) {
      $query = $this->db->get_where('categories', array('alias' => $alias));              
      return $query->row('id');
    }

    function get_brand_id_alias( $alias ) {
      $query = $this->db->get_where('brands', array('alias' => $alias));              
      return $query->row('id');
    }
    
    function get_category_alias( $id ) {
      $query = $this->db->get_where('categories', array('id' => $id));              
      return $query->row('alias');
    }
    
    function get_brand_alias( $id ) {
      $query = $this->db->get_where('brands', array('id' => $id));              
      return $query->row('alias');
    }
    
    function get_num_products( $id = 0 ) {
      return $this->db->query("
        SELECT t1.*, t2.image, t2.thumb, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t1.categories_id = ".$id."
          AND t1.available = 1")->num_rows();
    }
    
    function get_num_brand_products( $id = 0 ) {
      return $this->db->query("
        SELECT t1.*, t2.image, t2.thumb, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t1.brand_id = ".$id." 
          AND t1.available = 1")->num_rows();
    }
    
    function get_product($id) {
      $query = $this->db->get_where('products', array('id' => $id));
      return $query->row();
    }
    
    function get_prefix($id) {
      $query = $this->db->get_where('categories', array('id' => $id));
      return $query->row();
    }    
    
    function get_product_id_alias($alias) {
      $query = $this->db->get_where('products', array('alias' => $alias));
      return $query->row('id');
    }    
    
    function get_image($id) {
      $query = $this->db->get_where('products_colors', array('parent_id' => $id));
      return $query->row('image');
    }
    
    function get_thumb($id) {
      $query = $this->db->get_where('products_colors', array('parent_id' => $id));
      return $query->row('thumb');
    }
    
    function get_name($id) {
      $query = $this->db->get_where('products', array('id' => $id));
      return $query->row('name');
    }
    
    function get_additionally($id) {
      $query = $this->db->get_where('products', array('id' => $id));
      $expl = $query->row('additionally') ? explode(",", $query->row('additionally')) : 0;
      return $expl;
    }
    
    function get_product_sizes($id) {
      $query = $this->db->get_where('products_sizes', array('parent_id' => $id));
      return $query->result();
    }
    
    function get_product_colors($id, $size_id) {
      $query = $this->db->get_where('products_colors', array('parent_id' => $id, 'size_id' => $size_id));
      return $query->result();
    }
    
    function get_menu() {
      $this->db->order_by("sort");
      $query = $this->db->get('menu');
      return $query->result();      
    }
    
    function get_submenu($id) {
      $query = $this->db->get_where('menu', array('parent_id' => $id));
      return $query->result();      
    }
    
    function get_category($id) {
      $query = $this->db->get_where('categories', array('id' => $id));
      return $query->row('title');      
    }
    
    function get_categories( $id=0 ) {
      $this->db->order_by("sort");
      $query = $this->db->get_where('categories', array('parent_id' => $id));
      return $query->result();      
    }
    
    function get_subcategories() {
      $this->db->order_by("sort");
      $query = $this->db->get_where('categories', 'parent_id != 0');
      return $query->result();      
    }
    
    function get_brand($id) {
      $query = $this->db->get_where('brands', array('id' => $id));
      return $query->row('title');      
    }
    
    function get_brand_image($id) {
      $query = $this->db->get_where('brands', array('id' => $id));
      return $query->row('image');      
    }
    
    function get_brands( $id=0 ) {
      $this->db->order_by("sort");
      $query = $this->db->get('brands');
      return $query->result();      
    }
            
    function get_order( $id ) {
      if ($id == 'last') {
        $this->db->order_by("date", "DESC");
        $query = $this->db->get('orders');
      } else {
        $query = $this->db->get_where('orders', array('id' => $id));
      }
      return $query->row();      
    }
    
    function get_orders() {
      $query = $this->db->get('orders');      
      return $query->result();      
    }
    
    function get_new_orders() {
      $query = $this->db->get_where('orders', array('status' => 'Новый'));      
      return $query->num_rows();  
    }   
    
    function get_page( $alias ) {             
      $query = $this->db->get_where('pages', array('alias' => $alias));      
      return $query->row();      
    }
    
    function get_news() {             
      $this->db->order_by('created DESC');
      $this->db->limit(1);
      $query = $this->db->get('news');      
      return $query->row();      
    }
    
    function get_all_news( $limit = 0 ) {             
      $this->db->order_by('created DESC');
      if ($limit) $this->db->limit($limit);
      $query = $this->db->get('news');      
      return $query->result();      
    }
    
    function get_news_page( $alias ) {             
      $query = $this->db->get_where('news', array('alias' => $alias));      
      return $query->row();      
    }
    
    function get_slides() {             
      $this->db->like('alias', 'slide');
      $query = $this->db->get('pages');
      return $query->result();      
    }
    
    function search_products( $query ) {    
      return $this->db->query("
        SELECT t1.*, t2.image, t2.thumb, t2.small, t2.color, t2.price, t3.size
        FROM products t1 
        JOIN products_colors t2 ON t2.parent_id = t1.id
        JOIN products_sizes t3 ON t3.parent_id = t1.id
        WHERE t1.available = 1
          AND t1.name LIKE '%".$query."%'
          OR t1.description LIKE '%".$query."%'
        GROUP by t1.id
        ORDER by t1.rating DESC")->result_array();
    }
    
}
?>