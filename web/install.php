 
 <?php
  include_once("includes/constant.php");
  $shop = $_GET['shop'];
  $redirect_uri = $GLOBALS['ngRokUrl'] . $GLOBALS['projectDir'] . '/web/token.php';
  $nonce = bin2hex(random_bytes(12));
  $access_mode = 'per-user';
  $oauth_url = 'https://' . $shop . '/admin/oauth/authorize?client_id=' . $GLOBALS['appApiKey'] . '&scope=' . $GLOBALS['appScopes'] . '&redirect_uri=' . urlencode($redirect_uri) . '&state=' . $nonce . '&grant_options[]=' . $access_mode;
  header("Location: " . $oauth_url);
  exit();
