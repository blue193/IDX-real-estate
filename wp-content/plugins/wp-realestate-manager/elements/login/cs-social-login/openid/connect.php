<?php
require_once plugin_dir_url( __FILE__ ) . 'openid.php';



try {
  if(!isset($_GET['openid_mode']) || $_GET['openid_mode'] == 'cancel') {
    $openid = new LightOpenID;
    $openid->identity = urldecode($_GET['openid_url']);
    $openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
    header('Location: ' . $openid->authUrl());
  } else {
    $openid = new LightOpenID;
    if($openid->validate()) {
      $open_id = $openid->identity;
      $attributes = $openid->getAttributes();
      $email = $attributes['contact/email'];
      $first_name = $attributes['namePerson/first'];
      $last_name = $attributes['namePerson/last'];
      $signature = wp_rem_social_generate_signature($open_id);
      do_action( 'social_login_before_register_openid', $open_id, $signature );
      ?>
<html>
<head>
<script>
function init() {
  window.opener.wp_social_login({'action' : 'social_login', 'social_login_provider' : 'openid', 
    'social_login_openid_identity' : '<?php echo esc_js($open_id) ?>',
    'social_login_signature' : '<?php echo esc_js($signature) ?>',
    'social_login_email' : '<?php echo sanitize_email($email) ?>',
    'social_login_first_name' : '<?php echo esc_js($first_name) ?>',
    'social_login_last_name' : '<?php echo esc_js($last_name) ?>'});
    
  window.close();
}
</script>
</head>
<body onLoad="init();">
</body>
</html>      
      <?php
    }
  }
} catch(ErrorException $e) {
  echo balanceTags($e->getMessage(), true);
}