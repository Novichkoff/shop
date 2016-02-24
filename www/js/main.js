function size_Change() {
  var pageurl = document.location.pathname.toString().split('/');
  var size = document.getElementById('product_size');    
  document.location.href = '/'+pageurl['1']+'/'+pageurl['2']+'/'+pageurl['3']+'/'+size.value;
}
function color_Change() {
  var pageurl = document.location.pathname.toString().split('/');
  var size = document.getElementById('product_size');    
  var color = document.getElementById('product_color');
  document.location.href = '/'+pageurl['1']+'/'+pageurl['2']+'/'+pageurl['3']+'/'+size.value+'/'+color.value;
}
function show_Description() {
  $('#description_small').hide();
  $('#description_full').show();     
}
function add_to_cart(color_id) {
  jQuery.post("/catalog/add_to_cart/"+color_id, on_success());  
  function on_success() {
    $('#image_to_cart').show();
    height = $('#image_to_cart').height();
    width = $('#image_to_cart').width();
    $('#image_to_cart').animate({width:'50px',height:'50px',left:'80%',top:'5%',opacity:'0'}, 500, function() {$('#image_to_cart').css({display:'none',width:width,height:height,left:'28%',top:'25%',opacity:'1'})}); 
  }
}
function update_cart_item(id) {
  var num = document.getElementsByName(id)[0].value;	
  jQuery.post("/catalog/update_cart_item/"+id+"/"+num, function() {location.reload()});  
}
function delete_cart_item(id) {
  jQuery.post("/catalog/delete_cart_item/"+id, function() {
    $('#row_'+id).hide(500, function() {location.reload()});    
  });  
}
function clear_cart() {   
  jQuery.post("/catalog/clear_cart", function(){location.reload()});  
}
function empty_cart() {   
  jQuery.post("/catalog/clear_cart", function(){document.location.href = '/';});  
}
function send_order() {  
  $('#order').show();
  $('#order').animate({opacity:'1'}, 500);
}
function accept_order() {
  var name = document.getElementById('client_name').value;
  if (!name) {document.getElementById('client_name').style.border='1px solid red';}
  var phone = document.getElementById('client_phone').value;
  if (!phone) {document.getElementById('client_phone').style.border='1px solid red';}
  var address = document.getElementById('client_address').value;
  if (!address) {document.getElementById('client_address').style.border='1px solid red';}
  var email = document.getElementById('client_email').value;
  if (document.getElementById('payment').checked) {
    var full_price = document.getElementById('full_price').value;
    if (name && phone && address) {jQuery.post('/catalog/accept_order_payment/', {name:name, phone:phone, address:address, email:email}, function() {document.location.href = 'https://w.qiwi.com/order/external/create.action?from=250044&to='+phone+'&summ='+full_price+'&currency=RUB&successUrl=http://ndural/catalog/success&com=NDURAL.RU';});} 
  } else {
    if (name && phone && address) {jQuery.post('/catalog/accept_order/', {name:name, phone:phone, address:address, email:email}, function() {document.location.href = '/catalog/success';});} 
  }
}
function login() { 
  $('#login_panel').show();
  jQuery.post("/auth/login", function(data) {jQuery('#login_panel').html(data);});
}
function update_menu(id) {
  var val = document.getElementsByName('cat_'+id)[0].value;  
  jQuery.post("/admin/edit_menu/"+id+"/"+val, function() {location.reload()});  
}
function update_menu_url(id) {
  var url = document.getElementsByName('url_'+id)[0].value;  
  jQuery.post("/admin/edit_menu_url/"+id, {url:url}, function() {location.reload()});  
}
function delete_menu(id) {
  jQuery.post("/admin/delete_menu/"+id, function() {location.reload()});  
}
function add_menu(id) {
  jQuery.post("/admin/add_menu/"+id, function() {location.reload()});  
}
function filter_menu() {
  var val = document.getElementById('filter_menu');
  document.location.href = '/admin/main_menu/'+val.value;
}
function link_menu(id) {
  var val = document.getElementById('link_menu_'+id).value;
  jQuery.post("/admin/link_menu/"+id, {val:val}, function() {location.reload()});
}
function update_category(id) {
  var val = document.getElementsByName('cat_'+id)[0].value; 
  var alias = document.getElementsByName('cat_alias_'+id)[0].value;
  jQuery.post("/admin/edit_category/"+id+"/"+val+"/"+alias, function() {location.reload()});  
}
function update_prefix(id) {
  var val = document.getElementById('cat_prefix_'+id).value;
  jQuery.post("/admin/update_prefix/"+id, {val:val}, function() {location.reload()});
}
function delete_category(id) {
  jQuery.post("/admin/delete_category/"+id, function() {location.reload()});  
}
function add_category(id) {
  jQuery.post("/admin/add_category/"+id, function() {location.reload()});  
}
function show_image_panel(id) { 
  $('#img_panel_'+id).show();
  $('#img_panel_'+id).animate({opacity:'1'}, 500);
}
function close_image_panel(id) {  
  $('#img_panel_'+id).animate({opacity:'0'}, 500, function(){$('#img_panel_'+id).hide();});  
}
function category_image_change(id) {
  var val = document.getElementsByName('url_'+id)[0].value;  
  jQuery.post("/admin/category_image_change/"+id, {val: val},function() {location.reload()});  
}
function update_brand(id) {
  var val = document.getElementsByName('brand_'+id)[0].value; 
  var alias = document.getElementsByName('brand_alias_'+id)[0].value;
  jQuery.post("/admin/edit_brand/"+id+"/"+val+"/"+alias, function() {location.reload()});  
}
function delete_brand(id) {
  jQuery.post("/admin/delete_brand/"+id, function() {location.reload()});  
}
function add_brand(id) {
  jQuery.post("/admin/add_brand/"+id, function() {location.reload()});  
}
function add_brand_name() {
  var val = document.getElementById('add_brand').value;
  jQuery.post("/admin/add_brand_name/",{val: val}, function() {location.reload()});  
}
function brand_image_change(id) {
  var val = document.getElementsByName('url_'+id)[0].value;  
  jQuery.post("/admin/brand_image_change/"+id, {val: val},function() {location.reload()});  
}
function add_category_name() {
  var val = document.getElementById('add_category').value;
  jQuery.post("/admin/add_category_name/",{val: val}, function() {location.reload()});  
}
function add_subcategory_name() {
  var cat = document.getElementById('category').value;
  var val = document.getElementById('add_subcategory').value;  
  jQuery.post("/admin/add_subcategory_name/",{cat: cat, val: val}, function() {location.reload()});  
}
function show_logo_panel() { 
  $('#logo_panel').show();
  $('#logo_panel').animate({opacity:'1'}, 500);
}
function close_logo_panel() { 
  $('#logo_panel').animate({opacity:'0'}, 500, function(){$('#logo_panel').hide();});
}
function logo_change() {
  var val = document.getElementsByName('url_logo')[0].value;  
  jQuery.post("/admin/logo_change/", {val: val},function() {location.reload()});  
}
function filter_category() {
  var val = document.getElementById('filter_category');
  document.location.href = '/admin/categories/'+val.value;
}
function filter_products() {
  var val = document.getElementById('filter_category');
  document.location.href = '/admin/products/'+val.value;
}
function delete_product(id) {
  jQuery.post("/admin/delete_product/"+id, function() {location.reload()});  
}
function add_product() {
  jQuery.post("/admin/add_product/", function() {document.location.href = '/admin/product/last';});
}
function update_product_name(id) {
  var val = document.getElementsByName('product_name')[0].value;
  var alias = document.getElementsByName('product_alias')[0].value;
  jQuery.post("/admin/update_product_name/"+id, {val: val, alias: alias}, function() {location.reload()});
}
function update_product_recommend(id) {
  var check = document.getElementsByName('product_recommend')[0];
  if(check.checked == true) { val = 1;} else { val=0; }
  console.log(val);
  jQuery.post("/admin/update_product_recommend/"+id, {val: val}, function() {location.reload()});
}
function update_product_image(id) {
  $('#img_src').attr('src', '/images/wait.jpg');
  var val = document.getElementsByName('product_image')[0].value;  
  jQuery.post("/admin/update_product_image/"+id, {val: val}, function() {location.reload()});  
}
function update_producto_image(id,i) {
  $('#img_src').attr('src', '/images/wait.jpg');
  var val = document.getElementById('immg_'+i).value;  
  jQuery.post("/admin/update_product_image/"+id, {val: val}, function() {location.reload()});  
}
function update_product_price(id) {
  var val = document.getElementsByName('product_price')[0].value;  
  jQuery.post("/admin/update_product_price/"+id, {val: val}, function() {location.reload()});  
}
function update_product_description(id) {
  var val = document.getElementById('product_description').value;  
  jQuery.post("/admin/update_product_description/"+id, {val: val}, function() {location.reload()});  
}
function update_product_description_small(id) {
  var val = document.getElementsByName('product_description_small')[0].value;  
  jQuery.post("/admin/update_product_description_small/"+id, {val: val}, function() {location.reload()});  
}
function small_description(id) {
  var val = document.getElementById('product_description').value;  
  jQuery.post("/admin/generate_description_small/"+id, {val: val}, function() {location.reload()});  
}
function product_brand_change(id) {
  var val = document.getElementById('brand').value;
  jQuery.post("/admin/product_brand_change/"+id, {val: val}, function() {location.reload()});  
}
function product_category_change(id) {
  var val = document.getElementById('category').value;
  jQuery.post("/admin/product_category_change/"+id, {val: val}, function() {location.reload()});  
}
function product_subcategory_change(id) {
  var val = document.getElementById('subcategory').value;
  jQuery.post("/admin/product_subcategory_change/"+id, {val: val}, function() {location.reload()});  
}
function product_additionally(id) {
  var mass = document.getElementById('additionally');
  jQuery.post("/admin/product_additionally/"+id, {mass: mass}, function() {location.reload()});  
}
function show_add_size() {
  $('#add_size').show(200);
  $('#add_size').animate({opacity:'1'}, 500);
}
function show_add_color() {
  $('#add_color').show(200); 
  $('#add_color').animate({opacity:'1'}, 500);
}
function add_size(id) {
  var val = document.getElementById('add_size').value;
  jQuery.post("/admin/add_size/"+id, {val: val}, function() {location.reload()});  
}
function delete_size(product_id,id) {
  jQuery.post("/admin/delete_size/"+id, function() {document.location.href = '/admin/product/'+product_id;});  
}
function add_color(id,size) {
  var val = document.getElementById('add_color').value;
  jQuery.post("/admin/add_color/"+id+"/"+size, {val: val}, function() {location.reload()});  
}
function delete_color(product_id,id) {
  jQuery.post("/admin/delete_color/"+id, function() {document.location.href = '/admin/product/'+product_id;});  
}
function edit_site_name() {
  var val = document.getElementById('site_name').value;
  jQuery.post("/admin/edit_site_name/", {val: val}, function() {location.reload()});
}
function edit_site_adress() {
  var val = document.getElementById('site_adress').value;
  jQuery.post("/admin/edit_site_adress/", {val: val}, function() {location.reload()});
}
function edit_site_phone() {
  var val = document.getElementById('site_phone').value;
  jQuery.post("/admin/edit_site_phone/", {val: val}, function() {location.reload()});
}
function edit_site_email() {
  var val = document.getElementById('site_email').value;
  jQuery.post("/admin/edit_site_email/", {val: val}, function() {location.reload()});
}
function edit_site_description() {
  var val = document.getElementById('site_description').value;
  jQuery.post("/admin/edit_site_description/", {val: val}, function() {location.reload()});
}
function edit_site_vk() {
  var val = document.getElementById('site_vk').value;
  jQuery.post("/admin/edit_site_vk/", {val: val}, function() {location.reload()});
}
function edit_site_facebook() {
  var val = document.getElementById('site_facebook').value;
  jQuery.post("/admin/edit_site_facebook/", {val: val}, function() {location.reload()});
}
function edit_site_twitter() {
  var val = document.getElementById('site_twitter').value;
  jQuery.post("/admin/edit_site_twitter/", {val: val}, function() {location.reload()});
}
function status_change(id) {
  var val = document.getElementById('status_'+id).value;
  jQuery.post("/admin/status_change/"+id, {val: val}, function() {location.reload()});
}
function delete_order(id) {
  jQuery.post("/admin/delete_order/"+id, function() {location.reload()});
}
function delete_order_detail(id) {
  jQuery.post("/admin/delete_order/"+id, function() {document.location.href = '/admin/orders';});
}
function show_submenu(id) {
  $('#sub_'+id).show();
  $('#sub_'+id).animate({opacity:'1'}, 500);
}
function hide_submenu(id) {
  $('#sub_'+id).hide();
}
function db_export() {
  jQuery.post("/admin/export/", function() {$('#export').hide(); $('#save_export').show();});
}
function delete_page(id) {
  jQuery.post("/admin/delete_page/"+id, function() {location.reload()});  
}
function add_page() {
  jQuery.post("/admin/add_page/", function() {document.location.href = '/admin/page/last';});
}
function update_page(id) {
  var title = document.getElementsByName('page_title')[0].value; 
  var alias = document.getElementsByName('page_alias')[0].value;    
  jQuery.post("/admin/update_page/"+id, {title: title, alias: alias}, function() {location.reload()});
}
function delete_news_page(id) {
  jQuery.post("/admin/delete_news_page/"+id, function() {location.reload()});  
}
function add_news_page() {
  jQuery.post("/admin/add_news_page/", function() {document.location.href = '/admin/news_page/last';});
}
function update_news_page(id) {
  var title = document.getElementsByName('page_title')[0].value; 
  var alias = document.getElementsByName('page_alias')[0].value;    
  jQuery.post("/admin/update_news_page/"+id, {title: title, alias: alias}, function() {location.reload()});
}