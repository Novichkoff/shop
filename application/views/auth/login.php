<?php echo form_open("/auth/login");?>

  <p>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

  <p>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', TRUE, 'id="remember"');?>    
    <?php echo form_submit('submit', lang('login_submit_btn'));?>
  </p>

<?php echo form_close();?>