<?php

include_once("includes/constant.php");
include_once('includes/Database.php');
include_once('includes/install_helper.php');
include_once('includes/SmmApi.php');
$parameters = $_GET;
$valid = checkToken($parameters);

// FORM SUBMIT 
$getPlateForms = getPlateforms();
$usdCurrencyRate = usdCurrencyRate();
$ytGallery = getYtGallery();

if (isset($_POST) && array_key_exists('action', $_POST) && $_POST['action'] == 'getServiceCategory') {
    getServiceDropDown($_POST['data']);
}
if (isset($_POST) && array_key_exists('action', $_POST) && $_POST['action'] == 'getServiceList') {
    getServiceList($_POST['data']);
}

if (isset($_POST) && array_key_exists('action', $_POST) && $_POST['action'] == 'submitOrder') {
    submitOrder($_POST);
}

if (isset($_POST) && array_key_exists('action', $_POST) && $_POST['action'] == 'getOrders') {
    getOrders($_POST);
}

if (isset($_GET) && array_key_exists('charge_id', $_GET) && $_GET['charge_id'] != '' &&  !empty($_GET['charge_id'])) {
    recurringChargeId($_GET['charge_id']);
}

if (isset($_POST) && array_key_exists('action', $_POST) && $_POST['action'] == 'submitYtGallery') {
    submitYtGallery($_POST);
}
if (isset($_POST) && array_key_exists('action', $_POST) && $_POST['action'] == 'getYtLinkPreview') {
    getYtLinkPreview($_POST);
}



// YOUTUBE API FUNCTION 
function getYoutubeVideoDetail($videoId)
{
    $data = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=" . $videoId . "&key=" . $GLOBALS['YOUTUBE_API_KEY'] . "&part=statistics,snippet");
    $data = json_decode($data, true);
    if (!empty($data['items']) && count($data['items']) > 0) {
        return $data['items'];
    } else {
        return false;
    }
}

function getYoutubeChannelDetail($channelId)
{
    $data = file_get_contents("https://www.googleapis.com/youtube/v3/channels?id=" . $channelId . "&key=" . $GLOBALS['YOUTUBE_API_KEY'] . "&part=statistics,snippet");
    $data = json_decode($data, true);
    if (!empty($data['items']) && count($data['items']) > 0) {
        return $data['items'];
    } else {
        return false;
    }
}


// APP CUSTOM FUNCTION
// APP CUSTOM FUNCTION
// APP CUSTOM FUNCTION

function getYtGallery()
{
    $db = connectdb();
    $db->select("youtubegallery", array('shop' => $_GET['shop']));
    $results = $db->result_array();
    if (isset($results) && !empty($results)) {
        return $results;
    } else {
        return false;
    }
}
function getYtLinkPreview($data)
{
    if ($data['linkType'] == '1') {
        $metaData = getYoutubeChannelDetail($data['ytLink']);
        $resultData = array(
            'channelId' => $metaData[0]['id'],
            'channelTitle' => $metaData[0]['snippet']['title'],
            'channelDescription' => $metaData[0]['snippet']['description'],
            'channelCustomUrl' => $metaData[0]['snippet']['customUrl'],
            'channelThumbnailDefault' => $metaData[0]['snippet']['thumbnails']['default']['url'],
            'channelThumbnailMedium' => $metaData[0]['snippet']['thumbnails']['medium']['url'],
            'channelThumbnailHigh' => $metaData[0]['snippet']['thumbnails']['high']['url'],
            'channelViews' => $metaData[0]['statistics']['viewCount'],
            'channelSubscriberCount' => $metaData[0]['statistics']['subscriberCount'],
            'channelVideoCount' => $metaData[0]['statistics']['videoCount']
        );
    } else if ($data['linkType'] == '2') {
        $ytLink = explode('v=', $data['ytLink']);
        $metaData = getYoutubeVideoDetail($ytLink[1]);

        $resultData = array(
            'videoId' => $metaData[0]['id'],
            'videoPublishedAt' => $metaData[0]['snippet']['publishedAt'],
            'videoTitle' => $metaData[0]['snippet']['title'],
            'videoDescription' => $metaData[0]['snippet']['description'],
            'videoUrl' => 'https://www.youtube.com/watch?v=' . $metaData[0]['id'],
            'videoThumbnailDefault' => $metaData[0]['snippet']['thumbnails']['default']['url'],
            'videoThumbnailMedium' => $metaData[0]['snippet']['thumbnails']['medium']['url'],
            'videoThumbnailHigh' => $metaData[0]['snippet']['thumbnails']['high']['url'],
            'videoViews' => $metaData[0]['statistics']['viewCount'],
            'videoLikeCount' => $metaData[0]['statistics']['likeCount'],
            'videoCommentCount' => $metaData[0]['statistics']['commentCount']
        );
    } else {
        return false;
    }

    if ($data['action'] == 'returnToFunction') {
        return $resultData;
    } else {
        echo json_encode($resultData);
        exit();
    }
}

function submitYtGallery($data)
{
    $db = connectdb();
    $db->select("youtubegallery", array('shop' => $_GET['shop']));
    $results = $db->result_array();
    $updateData = array(
        'shop' => $_GET['shop'],
        'linkType' => $data['linkType'],
        'youtubeLink' => $data['ytLink'],
        'page' => $data['selectPage'],
        'product' => $data['selectProduct']
    );

    if (isset($results) && !empty($results)) {
        $db->update('youtubegallery', $updateData, array('shop' => $_GET['shop']));
        $dbOrderId = $results[0]['id'];
    } else {
        $result = $db->insert('youtubegallery', $updateData);
        $dbOrderId = $result->id();
    }

    $data['action'] = 'returnToFunction';
    $ytData = getYtLinkPreview($data);
    $db->update('youtubegallery', $ytData, array('shop' => $_GET['shop']));


    $metafieldsData = array("metafield" =>
    array(
        "namespace" => "SocialX",
        "key" => "ytGallery",
        "value" => json_encode(array('youtube' => $ytData, 'linkType' => $data['linkType'], 'page' => $data['selectPage'], 'product' => $data['selectProduct'])),
        "type" => "json_string"
    ));
    $result = AddMeta($metafieldsData);

    // echo "<pre>";
    // print_r($resultData);
    // print_r($result);
    // die;
    return json_encode(true);
}

function getPlateforms()
{
    // select($table, $where = array(), $limit = false, $order = false, $where_mode = "AND", $select_fields = '*',$groupBy='')
    $db = connectdb();
    $db->select("plateforms", array());
    $data = $db->result_array();
    if (isset($data) && !empty($data)) {
        return $data;
    } else {
        return false;
    }
}

function getServiceType()
{
    // select($table, $where = array(), $limit = false, $order = false, $where_mode = "AND", $select_fields = '*',$groupBy='')
    $db = connectdb();
    $db->select("packages", array(), false, false, false, '*', 'service_id');
    $data = $db->result_array();
    if (isset($data) && !empty($data)) {
        return $data;
    } else {
        return false;
    }
}


function getPackageRecord($service_id = '')
{
    if ($service_id != '' &&  !empty($service_id)) {
        $db = connectdb();
        $db->select("services", array('service_id' => $service_id), '1');
        $data = $db->result_array();
        if (isset($data) && !empty($data)) {
            return $data;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function getServiceDropDown($id)
{
    $db = connectdb();
    $db->select("categories", array('plateform_id' => $id, 'status' => '1'));
    $results = $db->result_array();
    $optionTag = '';
    $firstArray = array();

    if (isset($results) && !empty($results)) {

        $i = '1';
        foreach ($results as $item) {
            if ($i == '1') {
                $firstArray = array('category_id' => $item['category_id'], 'category_name' => $item['category_name']);
                $i++;
            }
            $optionTag .= '<option value="' . $item['category_id'] .  '" >' . $item['category_name'] . '</option>';
        }
    }

    $response = array('options' => $optionTag, 'firstArray' => $firstArray);
    echo json_encode($response);
    exit();
}

function getServiceList($id)
{
    $db = connectdb();
    if ($id == '-1') {
        $db->select("services", array('active_status' => '1'));
    } else {
        $db->select("services", array('category_id' => $id, 'active_status' => '1'));
    }
    $results = $db->result_array();

    if (isset($results) && !empty($results)) {
        $optionTag = '';
        $firstArray = array();
        if (isset($results) && !empty($results)) {

            $i = '1';
            foreach ($results as $item) {
                if ($i == '1') {
                    $firstArray = array('service_id' => $item['service_id'], 'updated_service_name' => $item['service_id'] . ' - ' . $item['updated_service_name']);
                    $i++;
                }
                $optionTag .= '<option value="' . $item['service_id'] .  '" rate="' . $item['updated_rate'] .  '"  min="' . $item['min'] .  '"  max="' . $item['max'] .  '"  desc="' . $item['updated_desc'] .  '" >' . $item['service_id'] . ' - ' . $item['updated_service_name'] . '</option>';
            }
        }

        if ($id == '-1') {
            echo json_encode($results);
            exit();
        } else {
            $response = array('options' => $optionTag, 'firstArray' => $firstArray);
            echo json_encode($response);
            exit();
        }
    } else {
        return false;
    }
}

function updatedCharge($rate, $quantity)
{
    return $rate * $quantity;
}

function usdCurrencyRate()
{
    $url = 'https://api.exchangerate-api.com/v4/latest/USD';
    $json = file_get_contents($url);
    $exp = json_decode($json);

    return $exp->rates->INR;
}

function submitOrder($postData)
{
    $dbPackageRecord = getPackageRecord($postData['selectService_id']);

    if ($dbPackageRecord != false) {
        $profit = $dbPackageRecord[0]['rate'] / 1000;
        $profit = $profit * $postData['quantity'];
        $profit = $postData['usageChargeINR'] - $profit;

        $insertData = array(
            'shop' => $_GET['shop'],
            'plateform_id' => $postData['plateform_id'],
            'category_id' => $postData['selectServicesCategory_id'],
            'service_id' => $postData['selectService_id'],
            'link' => $postData['serviceLink'],
            'quantity' => $postData['quantity'],
            'rate' => $dbPackageRecord[0]['rate'],
            'charge' => $postData['usageCharge'],
            'chargeINR' => $postData['usageChargeINR'],
            'refill' => $dbPackageRecord[0]['refill'],
            'profit' => $profit,
            'order_status' => 1
        );

        $db = connectdb();
        $result = $db->insert('orders', $insertData);
        $dbOrderId = $result->id();

        if ($result) {
            usageCharges($dbPackageRecord[0]['service_id'] . '-' . $dbPackageRecord[0]['updated_service_name'], $postData['usageCharge'], $dbOrderId);

            $sendOrderdata = array(
                'key' => $GLOBALS['SSM_API_TOKEN'],
                'action' => 'add',
                'service' => $postData['selectService_id'],
                'link' => $postData['serviceLink'],
                'quantity' => $postData['quantity']
            );


            $orderSent = ssm_order($sendOrderdata);
            if (isset($orderSent->order) && !empty($orderSent->order)) {
                $ssmOrderId = $orderSent->order;
                $result = $db->update('orders', array('ssmOrderId' => $ssmOrderId, 'order_status' => '1'), array('id' => $dbOrderId));
            }
        }
    }
    return true;
}

function updateOrderStatus($shop, $orderId)
{
    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $shop
    ));
    $shop = $db->result_array();

    if (isset($shop) && !empty($shop)) {
        $status = ssm_status($orderId);
        $status = json_decode(json_encode($status, true), true);
        $order_status = $status[$orderId]['status'];

        $db->select("orders", array(
            "shop_url" => $shop,
            "ssmOrderId" => $orderId
        ));
        $orders = $db->result_array();

        if (isset($orders) && !empty($orders)) {
            $db->update('shops', array('order_status' => $order_status), array(
                "shop_url" => $shop,
                "ssmOrderId" => $orderId
            ));
        }

        return true;
    }
}

function updateAllOrderStatus()
{
    $shop = $_GET["shop"];
    $db = connectdb();
    $db->select("orders", array(
        "shop" => $shop
    ), false, false, false, 'ssmOrderId');

    $orders = $db->result_array();

    if (isset($orders) && !empty($orders)) {
        foreach ($orders as $order) {
            $status = ssm_status($order['ssmOrderId']);
            $status = json_decode(json_encode($status, true), true);
            $order_status = $status[$order['ssmOrderId']]['status'];

            $db->update('orders', array('order_status' => $order_status), array(
                "ssmOrderId" => $order['ssmOrderId']
            ));
        }
    }
    return true;
}

function getOrders($postData)
{
    $updated = updateAllOrderStatus();

    $mysql = mysqli_connect($GLOBALS['dbServer'], $GLOBALS['dbUsername'], $GLOBALS['dbPassword'], $GLOBALS['dbDatabase']);
    $query = 'SELECT s.*, o.* FROM orders o, services s WHERE s.service_id = o.service_id';
    if ($postData['filter'] != '0') {
        $query = $query . ' AND o.order_status =' . $postData['filter'];
    }

    $result = mysqli_query($mysql, $query);
    $results = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $results[] = $row;
        }
    }

    if (isset($results) && !empty($results)) {
        echo  json_encode($results);
        exit();
    } else {
        echo json_encode(false);
        exit();
    }
}

function checkToken($parameters)
{
    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $parameters['shop']
    ));
    $shop = $db->result_array();


    if (isset($shop) && !empty($shop)) {
        $endpoint = '/admin/api/2021-10/shop.json';

        $response = rest_api($shop[0]['access_token'], $parameters['shop'], $endpoint, array(), 'GET');

        $response = json_decode($response['data'], true);
        if (array_key_exists('errors', $response)) {
            echo "<script>window.top.location.href = '" . $GLOBALS['ngRokUrl'] . $GLOBALS['projectDir'] . "/web/install.php?shop=" . $_GET['shop'] . "'</script>";


            // echo 'install.php?shop=' . $_GET['shop'];
            // die("1");
            // header("Location: install.php?shop=" . $_GET['shop']);
            exit();
        }
    } else {
        header("Location: web/install.php?shop=" . $_GET['shop']);
        exit();
    }

    return true;
}

function usageCharges($description = "test", $price = "1", $dbOrderId = "-1")
{
    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $_GET['shop']
    ));

    $shop = $db->result_array();
    $recurring_charge_id = $shop[0]['recurring_charge_id'];

    $data = array('usage_charge' => array(
        "description" => $description,
        "price" => $price
    ));

    $url = 'https://' . $_GET['shop'] . '/admin/api/2023-07/recurring_application_charges/' . $recurring_charge_id . '/usage_charges.json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $headers = array();
    $headers[] = 'X-Shopify-Access-Token: ' . $shop[0]['access_token'];
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $results = json_decode($result, JSON_PRETTY_PRINT);
    $results = $results['usage_charge'];
    if (isset($shop) && !empty($shop)) {

        $dataUpdate = array(
            "shop_url" => $shop[0]['shop_url'],
            "recurring_charge_id" => $shop[0]['recurring_charge_id'],
            "usage_charge_id" => $results['id'],
            "description" => $results['description'],
            "price" => $results['price'],
            "created_at" => $results['created_at'],
            "billing_on" => $results['billing_on'],
            "balance_used" => $results['balance_used'],
            "balance_remaining" => $results['balance_remaining'],
            "risk_level" => $results['risk_level'],
            "db_order_id" => $dbOrderId
        );
        $db->insert('usage_charge', $dataUpdate);
    }

    return true;
}

function recurringApplicationCharge()
{
    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $_GET['shop']
    ));
    $shop = $db->result_array();
    $return_url = "https://" . $_GET['shop'] . "/admin/apps/" . $GLOBALS['appApiKey'];
    $url = 'https://' . $_GET["shop"] . '/admin/api/2023-07/recurring_application_charges.json';
    $data = array('recurring_application_charge' => array(
        "name" => "test",
        "price" => "10",
        "return_url" => $return_url,
        "capped_amount" => "100",
        "terms" => "$10 for 10k",
        "test" => true
    ));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $headers = array();
    $headers[] = 'X-Shopify-Access-Token:' . $shop[0]['access_token'];
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);


    $charge = json_decode($result, JSON_PRETTY_PRINT);

    $confirmation_url = $charge['recurring_application_charge']['confirmation_url'];
    echo "<script>window.top.location.href = \"$confirmation_url\";</script>";
    exit();
}

function recurringChargeId($chargeId)
{

    //future task : check if chargeId is valid or not.. apiCall + getList + check
    // "status": "pending",

    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $_GET['shop']
    ));
    $shop = $db->result_array();
    if (isset($shop) && !empty($shop)) {
        $data = array(
            'shop_url' => $_GET['shop'],
            'recurring_charge_id' => $chargeId
            // 'capped_amount' => $chargeId
            // 'balance_used' => $chargeId
            // 'balance_remaining' => $chargeId
        );
        $db->update('shops', $data, array(
            "shop_url" => $shop[0]['shop_url']
        ));
    }
}

function checkRecurringChargeIdUpdated()
{
    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $_GET['shop']
    ));
    $shop = $db->result_array();
    if (isset($shop) && !empty($shop)) {
        if (isset($shop[0]['recurring_charge_id']) && !empty($shop[0]['recurring_charge_id']) && $shop[0]['recurring_charge_id'] > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function graphql($query = array())
{
    $url = 'https://' . session('shop_url') . '/admin/api/2021-10/graphql.json';

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $headers[] = "";
    $headers[] = "Content-Type: application/json";
    if (session('access_token')) $headers[] = "X-Shopify-Access-Token: " . session('access_token');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($query));
    curl_setopt($curl, CURLOPT_POST, true);

    $response = curl_exec($curl);
    $error = curl_errno($curl);
    $error_msg = curl_error($curl);


    curl_close($curl);

    if ($error) {
        return $error_msg;
    } else {
        $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

        $headers = array();
        $headers_content = explode("\n", $response[0]);
        $headers['status'] = $headers_content[0];

        array_shift($headers_content);

        foreach ($headers_content as $content) {
            $data = explode(':', $content);
            $headers[trim($data[0])] = trim($data[1]);
        }

        return array('headers' => $headers, 'body' => $response[1]);
    }
}

function getCurrentThemeId()
{
    $themeData =  rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . '/themes.json', array("role" => "main", "asset[key]" => "templates/index.liquid"), 'GET', session('shop_url'), session('access_token'));

    $themeData = json_decode($themeData['body'], true);
    return $themeId =   $themeData['themes'][0]['id'];
}

function ShopifyThemeVersion()
{
    $themeId = getCurrentThemeId();
    $fileData =  rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . "/themes/{$themeId}/assets.json", array(), 'GET', session('shop_url'), session('access_token'));
    $fileData = json_decode($fileData['body'], true);
    $themeVersion = "1.0";

    foreach ($fileData['assets'] as $fileDatakey => $fileDatavalue) {
        if ($fileDatavalue['key'] == "templates/product.json") {
            $themeVersion = "2.0";
        }
    }
    return $themeVersion;
}

function Install_Code()
{
    $themeId = getCurrentThemeId();
    $fileData =  rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . "/themes/{$themeId}/assets.json", array("asset[key]" => "layout/theme.liquid"), 'GET', session('shop_url'), session('access_token'));

    $fileData = json_decode($fileData['body'], true);
    $fileContent = $fileData['asset']['value'];

    if (strpos($fileContent, '{% include "salesbooster_app_rtl" %}') !== false) {
        return true;
    } else {
        $asset_data = array('asset' => array(
            'key' => 'snippets/salesbooster_app_rtl.liquid',
            'value' => Storage::disk('local')->get('public/salesbooster_app_rtl.liquid')
        ));

        $assets = rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . "/themes/{$themeId}/assets.json", $asset_data, 'PUT', session('shop_url'), session('access_token'));   //file upload/update in theme


        $updatedFile_Content = str_replace('</body>', '{% include "salesbooster_app_rtl" %} </body>', $fileContent);

        $asset_data = array('asset' => array(
            'key' => 'layout/theme.liquid',
            'value' => $updatedFile_Content
        ));

        $themeLiquid_pushed = rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . "/themes/{$themeId}/assets.json", $asset_data, 'PUT', session('shop_url'), session('access_token'));
    }
}


function AddMeta($metafields_data)
{
    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $_GET['shop']
    ));
    $shop = $db->result_array();

    if (isset($shop) && !empty($shop)) {
        $url = 'https://' . $shop[0]['shop_url'] . '/admin/api/2023-07/metafields.json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($metafields_data));

        $headers = array();
        $headers[] = 'X-Shopify-Access-Token:' . $shop[0]['access_token'];
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        echo "<pre>";
        print_r($result);
        die;
    }
}

function AddProduct_Meta($productID, $metafields_data)
{
    $metafelds_create = rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . "/products/{$productID}/metafields.json", $metafields_data, 'POST', session('shop_url'), session('access_token'));
    $metafelds_create = json_decode($metafelds_create['body'], true);
    return "success";
}

function Uninstall_Code()
{
    $themeId = getCurrentThemeId();
    $fileData =  rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . "/themes/{$themeId}/assets.json", array("asset[key]" => "layout/theme.liquid"), 'GET', session('shop_url'), session('access_token'));

    $fileData = json_decode($fileData['body'], true);
    $fileContent = $fileData['asset']['value'];

    if (strpos($fileContent, '{% include "salesbooster_app_rtl" %}') !== false) {
        $updatedFile_Content = str_replace('{% include "salesbooster_app_rtl" %}', '', $fileContent);

        $asset_data = array('asset' => array(
            'key' => 'layout/theme.liquid',
            'value' => $updatedFile_Content
        ));

        $themeLiquid_pushed = rest_api('/admin/api/' . env('SHOPIFY_API_VERSION') . "/themes/{$themeId}/assets.json", $asset_data, 'PUT', session('shop_url'), session('access_token'));
    }
}

function clean_string($input)
{
    $input = preg_replace('/\s+/', '', $input); //remove all spaces
    $input = preg_replace('/[^A-Za-z0-9\-\. ]/', '', $input); //remove all special character except `spaces`,`.`
    return $input;
}

function get_currency($cname)
{
    $currency_symbols = array(
        'AED' => '&#1583;.&#1573;', // ?
        'AFN' => '&#65;&#102;',
        'ALL' => '&#76;&#101;&#107;',
        'AMD' => '',
        'ANG' => '&#402;',
        'AOA' => '&#75;&#122;', // ?
        'ARS' => '&#36;',
        'AUD' => '&#36;',
        'AWG' => '&#402;',
        'AZN' => '&#1084;&#1072;&#1085;',
        'BAM' => '&#75;&#77;',
        'BBD' => '&#36;',
        'BDT' => '&#2547;', // ?
        'BGN' => '&#1083;&#1074;',
        'BHD' => '.&#1583;.&#1576;', // ?
        'BIF' => '&#70;&#66;&#117;', // ?
        'BMD' => '&#36;',
        'BND' => '&#36;',
        'BOB' => '&#36;&#98;',
        'BRL' => '&#82;&#36;',
        'BSD' => '&#36;',
        'BTN' => '&#78;&#117;&#46;', // ?
        'BWP' => '&#80;',
        'BYR' => '&#112;&#46;',
        'BZD' => '&#66;&#90;&#36;',
        'CAD' => '&#36;',
        'CDF' => '&#70;&#67;',
        'CHF' => '&#67;&#72;&#70;',
        'CLF' => '', // ?
        'CLP' => '&#36;',
        'CNY' => '&#165;',
        'COP' => '&#36;',
        'CRC' => '&#8353;',
        'CUP' => '&#8396;',
        'CVE' => '&#36;', // ?
        'CZK' => '&#75;&#269;',
        'DJF' => '&#70;&#100;&#106;', // ?
        'DKK' => '&#107;&#114;',
        'DOP' => '&#82;&#68;&#36;',
        'DZD' => '&#1583;&#1580;', // ?
        'EGP' => '&#163;',
        'ETB' => '&#66;&#114;',
        'EUR' => '&#8364;',
        'FJD' => '&#36;',
        'FKP' => '&#163;',
        'GBP' => '&#163;',
        'GEL' => '&#4314;', // ?
        'GHS' => '&#162;',
        'GIP' => '&#163;',
        'GMD' => '&#68;', // ?
        'GNF' => '&#70;&#71;', // ?
        'GTQ' => '&#81;',
        'GYD' => '&#36;',
        'HKD' => '&#36;',
        'HNL' => '&#76;',
        'HRK' => '&#107;&#110;',
        'HTG' => '&#71;', // ?
        'HUF' => '&#70;&#116;',
        'IDR' => '&#82;&#112;',
        'ILS' => '&#8362;',
        'INR' => '&#8377;',
        'IQD' => '&#1593;.&#1583;', // ?
        'IRR' => '&#65020;',
        'ISK' => '&#107;&#114;',
        'JEP' => '&#163;',
        'JMD' => '&#74;&#36;',
        'JOD' => '&#74;&#68;', // ?
        'JPY' => '&#165;',
        'KES' => '&#75;&#83;&#104;', // ?
        'KGS' => '&#1083;&#1074;',
        'KHR' => '&#6107;',
        'KMF' => '&#67;&#70;', // ?
        'KPW' => '&#8361;',
        'KRW' => '&#8361;',
        'KWD' => '&#1583;.&#1603;', // ?
        'KYD' => '&#36;',
        'KZT' => '&#1083;&#1074;',
        'LAK' => '&#8365;',
        'LBP' => '&#163;',
        'LKR' => '&#8360;',
        'LRD' => '&#36;',
        'LSL' => '&#76;', // ?
        'LTL' => '&#76;&#116;',
        'LVL' => '&#76;&#115;',
        'LYD' => '&#1604;.&#1583;', // ?
        'MAD' => '&#1583;.&#1605;.', //?
        'MDL' => '&#76;',
        'MGA' => '&#65;&#114;', // ?
        'MKD' => '&#1076;&#1077;&#1085;',
        'MMK' => '&#75;',
        'MNT' => '&#8366;',
        'MOP' => '&#77;&#79;&#80;&#36;', // ?
        'MRO' => '&#85;&#77;', // ?
        'MUR' => '&#8360;', // ?
        'MVR' => '.&#1923;', // ?
        'MWK' => '&#77;&#75;',
        'MXN' => '&#36;',
        'MYR' => '&#82;&#77;',
        'MZN' => '&#77;&#84;',
        'NAD' => '&#36;',
        'NGN' => '&#8358;',
        'NIO' => '&#67;&#36;',
        'NOK' => '&#107;&#114;',
        'NPR' => '&#8360;',
        'NZD' => '&#36;',
        'OMR' => '&#65020;',
        'PAB' => '&#66;&#47;&#46;',
        'PEN' => '&#83;&#47;&#46;',
        'PGK' => '&#75;', // ?
        'PHP' => '&#8369;',
        'PKR' => '&#8360;',
        'PLN' => '&#122;&#322;',
        'PYG' => '&#71;&#115;',
        'QAR' => '&#65020;',
        'RON' => '&#108;&#101;&#105;',
        'RSD' => '&#1044;&#1080;&#1085;&#46;',
        'RUB' => '&#1088;&#1091;&#1073;',
        'RWF' => '&#1585;.&#1587;',
        'SAR' => '&#65020;',
        'SBD' => '&#36;',
        'SCR' => '&#8360;',
        'SDG' => '&#163;', // ?
        'SEK' => '&#107;&#114;',
        'SGD' => '&#36;',
        'SHP' => '&#163;',
        'SLL' => '&#76;&#101;', // ?
        'SOS' => '&#83;',
        'SRD' => '&#36;',
        'STD' => '&#68;&#98;', // ?
        'SVC' => '&#36;',
        'SYP' => '&#163;',
        'SZL' => '&#76;', // ?
        'THB' => '&#3647;',
        'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
        'TMT' => '&#109;',
        'TND' => '&#1583;.&#1578;',
        'TOP' => '&#84;&#36;',
        'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
        'TTD' => '&#36;',
        'TWD' => '&#78;&#84;&#36;',
        'TZS' => '',
        'UAH' => '&#8372;',
        'UGX' => '&#85;&#83;&#104;',
        'USD' => '&#36;',
        'UYU' => '&#36;&#85;',
        'UZS' => '&#1083;&#1074;',
        'VEF' => '&#66;&#115;',
        'VND' => '&#8363;',
        'VUV' => '&#86;&#84;',
        'WST' => '&#87;&#83;&#36;',
        'XAF' => '&#70;&#67;&#70;&#65;',
        'XCD' => '&#36;',
        'XDR' => '',
        'XOF' => '',
        'XPF' => '&#70;',
        'YER' => '&#65020;',
        'ZAR' => '&#82;',
        'ZMK' => '&#90;&#75;', // ?
        'ZWL' => '&#90;&#36;',
    );
    $currency = isset($currency_symbols[$cname]) ? $currency_symbols[$cname] : '';
    return $currency;
}
