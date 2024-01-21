<?php
include_once("includes/constant.php");
include_once('includes/Database.php');
include_once("includes/install_helper.php");
$parameters = $_GET;
$shop_url = $parameters['shop'];

if (validateHmac($parameters, $GLOBALS['appApiSecretKey'])) {
    $access_token = getAccessToken($shop_url, $GLOBALS['appApiKey'], $GLOBALS['appApiSecretKey'], $parameters['code']);
    $result = addStore($parameters['shop'], $access_token);
    if ($result) {
        header("Location: https://" . $shop_url . "/admin/apps/" . $GLOBALS['appUrlId']);
        die;
    }
} else {
    echo 'This is not coming from Shopify and probably someone is hacking.';
}
