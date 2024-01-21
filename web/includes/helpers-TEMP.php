<?php
// require __DIR__ . '/../../admin/common_helper.php';
include_once("includes/constant.php");

function parsePaginationLinkHeader($headerLink)
{
    $available_links = [];
    $links = explode(',', $headerLink);
    foreach ($links as $link) {
        if (preg_match('/<(.*)>;\srel=\\"(.*)\\"/', $link, $matches)) {
            $query_str = parse_url($matches[1], PHP_URL_QUERY);
            parse_str($query_str, $query_params);

            $available_links[$matches[2]] = $query_params['page_info'];
        }
    }
    return $available_links;
}

function stokesPOST($jwt_token, $api_param)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => getenv("ORDER_WEBHOOK_URL"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($api_param),
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $jwt_token",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
}


function registerWebhooks($shop, $accessToken)
{
    $whList = array(
        "orders/paid"  =>  getenv('ORDER_PAYMENT_WEBHOOK_URL'),
        "orders/create"  => getenv('ORDER_CREATE_WEBHOOK_URL'),
        "orders/fulfilled"  => getenv('ORDER_FULLFILL_WEBHOOK_URL'),
        "carts/update"  => getenv('CART_UPDATE_WEBHOOK_URL')
    );

    foreach ($whList as $listKey => $listValue) {
        $webhookParams = array(
            'webhook' =>
            array(
                'topic' => $listKey,
                'address' => $listValue,
                'format' => 'json'
            )
        );
        $data = performShopifyRequest($shop, $accessToken, "webhooks", $webhookParams, "POST");
    }
}


function stokesApiReq($url, $method = 'GET', $query = array(), $jwt_token, $request_headers = array())
{
    if (!is_null($query) && in_array($method, array(
        'GET',
        'DELETE'
    ))) {
        $url = $url . "?" . http_build_query($query);
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    $request_headers[] = "";
    $request_headers[] = "Content-Type: application/json";
    $request_headers[] = "cache-control: no-cache";

    if (!is_null($jwt_token)) {
        $request_headers[] = "authorization: Bearer " . $jwt_token;
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

    if ($method != 'GET' && in_array($method, array(
        'POST',
        'PUT'
    ))) {
        if (is_array($query)) {
            $query = json_encode($query);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
    }

    $response = curl_exec($curl);
    $error_number = curl_errno($curl);
    $error_message = curl_error($curl);
    curl_close($curl);

    if ($error_number) {
        return $error_message;
    } else {
        return $response;
    }
}

function getHandle($shop_url, $productIds)
{
    $accessToken = getAccessTokenfromDB($shop_url);
    $handle = array();
    foreach ($productIds as $productId) {
        $endpoint = '/admin/api/2021-10/products/' . $productId . '.json';
        $response = rest_api($accessToken, $shop_url, $endpoint, array('fields' => 'handle'), 'GET');
        $handle[] = json_decode($response['data'], true)['product']['handle'];
    }

    return $handle;
}

function getProductCustom($shop_url, $productIds, $fields)
{
    $accessToken = getAccessTokenfromDB($shop_url);
    $result = array();
    foreach ($productIds as $productId) {
        $endpoint = '/admin/api/2021-10/products/' . $productId . '.json';
        $response = rest_api($accessToken, $shop_url, $endpoint, array('fields' => $fields), 'GET');
        $result[] = json_decode($response['data'], true)['product'];
    }

    return $result;
}

function getCreatedMinDate()
{
    $today =  strtotime(date('y-m-d'));
    $before60DaysDate = strtotime("-60 day", $today);
    return date(DATE_ISO8601, $before60DaysDate);
}

function orderSync($shop, $accesstoken, $jwt_token, $pageInfo = null, $db)
{
    $params['created_at_min'] = getCreatedMinDate();
    if ($pageInfo == null) {

        $params = array(
            "limit" => getenv('ORDER_PROCESS_LIMIT')
        );
    } else {
        $params = array(
            "limit" => getenv('ORDER_PROCESS_LIMIT'),
            "page_info" => $pageInfo,
            "rel" => "next"
        );
    }

    $data = rest_api($accesstoken, $shop, "/admin/api/2022-04/orders.json", $params, 'GET');
    $ordersData = json_decode($data['data']);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => getenv('ORDER_SYNC_API_URL'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($ordersData),
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $jwt_token",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $info = curl_getinfo($curl);
    curl_close($curl);

    if (isset($response) && !empty($response)) {

        $db->select("stokes_stores", array("domain_name" => $shop), false, false, "AND", "orderSync");
        $storeData = $db->result_array();

        $currentProcessed = $storeData[0]['orderSync'] + count($ordersData->orders);
        $db->update("stokes_stores", array(
            "orderSync" => $currentProcessed
        ), array(
            "domain_name" => $shop
        ));
    }

    $allPageInfo = parsePaginationLinkHeader($data['headers']['Link']);
    $pageInfoNext = $allPageInfo['next'];

    if (!empty($pageInfoNext)) {
        orderSync($shop, $accesstoken, $jwt_token, $pageInfoNext, $db);
    }

    $db->update("stokes_stores", array(
        "orderSync" => "1"
    ), array(
        "domain_name" => $shop
    ));

    return true;
}

function rest_api($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array())
{
    $url = "https://" . $shop . $api_endpoint;
    if (!is_null($query) && in_array($method, array(
        'GET',
        'DELETE'
    ))) {
        $url = $url . "?" . http_build_query($query);
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    $request_headers[] = "";
    $headers[] = "Content-Type: application/json";
    if (!is_null($token)) {
        $request_headers[] = "X-Shopify-Access-Token: " . $token;
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

    if ($method != 'GET' && in_array($method, array(
        'POST',
        'PUT'
    ))) {
        if (is_array($query)) {
            $query = json_encode($query);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
    }

    $response = curl_exec($curl);
    $error_number = curl_errno($curl);
    $error_message = curl_error($curl);
    curl_close($curl);

    if ($error_number) {
        return $error_message;
    } else {
        $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
        $headers = array();
        $header_data = explode("\n", $response[0]);
        $headers['status'] = $header_data[0];
        array_shift($header_data);
        foreach ($header_data as $part) {
            $h = explode(":", $part, 2);
            $headers[trim($h[0])] = trim($h[1]);
        }

        return array(
            'headers' => $headers,
            'data' => $response[1]
        );
    }
}

function connectdb($dbDatabase, $dbUsername, $dbPassword, $dbServer)
{
    $db = new Database($dbDatabase, $dbUsername, $dbPassword, $dbServer);
    return $db;
}

function getAccessTokenfromDB($shop)
{
    $db = connectdb();
    $db->select("stokes_stores", array(
        "domain_name" => $shop
    ));
    $shop = $db->result_array();
    $accessToken = $shop[0]['access_token'];
    return $accessToken;
}

function registerShop($data)
{
    $url =  getenv("REGISTERSHOP_URL");
    $username =  getenv("REGISTERSHOP_USERNAME");
    $password =  getenv("REGISTERSHOP_PASSWORD");
    $payload = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Set HTTP Header for POST request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($data))
    ));

    // Submit the POST request
    $result = curl_exec($ch);

    // Close cURL session handle
    curl_close($ch);

    $resObj = json_decode($result);
    $resArr = (array)$resObj; //Obj to Arr
    return $resArr['accessToken'];
}

function addStore($validShop, $accessToken)
{
    $db = connectdb();
    $db->select("stokes_stores", array(
        "domain_name" => $validShop
    ));
    $shop = $db->result_array();
    $shopDetails = performShopifyRequest($validShop, $accessToken, "shop", array(), "GET");

    $storeName = $shopDetails['shop']['name'];
    $store_email = $shopDetails['shop']['email'];
    $records = array(
        "domain_name" => $validShop,
        "access_token" => $accessToken
    );

    $records['jwt_token'] = registerShop($shopDetails['shop']);
    $records['orderSync'] = "0";

    if (isset($shop) && !empty($shop)) {
        $db->update('stokes_stores', $records, array(
            "id" => $shop[0]['id']
        ));
    } else {
        $db->insert('stokes_stores', $records);
        $storeId = $db->id();
        $db->select("stokes_stores", array(
            "id" => $storeId
        ));
        $storeDetails = $db->result_array();
        $recipient = $storeDetails[0]['store_email'];
        $storeName = $storeDetails[0]['domain_name'];

        $options = array(
            "is_enabled" => "0",
            "recomLayout" => "layout_1"
        );

        foreach ($options as $key => $value) {
            addOption($storeId, $key, $value);
        }
        $options['products'] = "";

        $datas = array(
            'metafield' => array(
                'key' => 'Settings',
                'value' => json_encode($options),
                'type' => 'json_string',
                'namespace' => 'stokes_app'
            )
        );
        $metaData = performShopifyRequest($validShop, $accessToken, "metafields", $datas, "POST");
    }
    $result = array(
        "result" => 1
    );
    return $result;
}

function addOption($id, $name, $value)
{
    $db = connectdb();
    $records = array(
        'store_id' => $id,
        'option_name' => $name,
        'option_value' => $value,
    );
    $db->insert('stokes_options', $records);
    $result = array(
        "result" => 1,
        "data" => $db->id()
    );
    return $result;
}
function updateOption($id, $name, $value)
{
    $db = connectdb();
    $db->select('stokes_options', array(
        "store_id" => $id,
        "option_name" => $name
    ));
    $optionDetails = $db->result_array();
    if (empty($optionDetails)) {
        addOption($id, $name, $value);
    }
    $records = array(
        'option_value' => $value,
    );
    $result = $db->update('stokes_options', $records, array(
        "store_id" => $id,
        "option_name" => $name
    ));

    $result = array(
        "result" => 1
    );
    return $result;
}
//
function getOption($id, $name)
{
    $db = connectdb();
    $db->select("stokes_options", array(
        "store_id" => $id,
        "option_name" => $name
    ));
    $shop = $db->result_array();
    if (isset($shop) && !empty($shop)) {
        $opt = $shop[0]['option_value'];
    } else {
        $opt = "";
    }
    return $opt;
}

function getInfoFromAccessToken($token)
{
    $db = connectdb();
    $db->select("stokes_stores", array(
        "access_token" => $token
    ));
    $shopConfigs = $db->result_array();
    return $shopConfigs[0];
}

function UninstallCode($shop, $accessToken)
{
    $themeId = getThemeId($shop, $accessToken);
    $fileData = performShopifyRequest($shop, $accessToken, "/themes/{$themeId}/assets", array(
        "asset[key]" => "layout/theme.liquid"
    ), "GET");
    $fileContent = $fileData['asset']['value'];
    if (strpos($fileContent, "{% include 'stokes_app' %}") !== false) {
        $updatedFile_Content = str_replace("{% include 'stokes_app' %}", '', $fileContent);
        $asset_data = array(
            'asset' => array(
                'key' => 'layout/theme.liquid',
                'value' => $updatedFile_Content
            )
        );
        $themeLiquid_pushed = performShopifyRequest($shop, $accessToken, "/themes/{$themeId}/assets", $asset_data, "PUT");
    }
    return "y";
}
function updMetafields($storeId)
{
    $db = connectdb();
    $db->select("stokes_stores", array(
        "id" => $storeId
    ));
    $shopConfigs = $db->result_array();
    $shop = $shopConfigs[0]['domain_name'];
    $accessToken = $shopConfigs[0]['access_token'];
    $db->select("stokes_options", array(
        "store_id" => $storeId
    ));
    $meta_options = $db->result_array();
    addLiquidFiles($shop, $accessToken, "stokes_app.liquid");
    updateLayoutFileData($shop, $accessToken);
    $data = array();
    foreach ($meta_options as $key => $value) {
        $data[$value['option_name']] = $value['option_value'];
    }
    $payment_checker = checkPayment($shop, $accessToken);
    $params = array(
        'metafield' => array(
            'key' => 'Settings',
            'value' => json_encode($data),
            'type' => 'json_string',
            'namespace' => 'stokes_app'
        )
    );
    $updatefile = performShopifyRequest($shop, $accessToken, "metafields", $params, "POST");
}

function addLiquidFiles($shop, $accessToken, $filename)
{
    $themeID = getThemeId($shop, $accessToken);
    $baseUrl = getenv("LIQUID_PATH");
    $addLiquidprams = array(
        'asset' => array(
            'key' => 'snippets/' . $filename,
            'src' => $baseUrl . "/" . $filename
        )
    );
    $file_upload = performShopifyRequest($shop, $accessToken, "api/2021-10/themes/{$themeID}/assets", $addLiquidprams, "PUT");
}
function updateLayoutFileData($shop, $accessToken)
{
    $themeID = getThemeId($shop, $accessToken);
    $data = getLiquidFile($shop, $accessToken, "layout/theme.liquid");
    $res = $data;
    $newdata = $res['asset']['value'];
    if (strpos($newdata, "{% include 'stokes_app' %}") !== false) {
        $newdata1 = $newdata;
    } else {
        $newdata1 = $newdata . "{% include 'stokes_app' %}";
    }
    $changeddata = str_replace($newdata, $newdata1, $newdata);
    $datas = array(
        'asset' => array(
            'key' => 'layout/theme.liquid',
            'value' => $changeddata,
            'public_url' => null,
            "theme_id" => $themeID,
            "content_type" => "text/x-liquid",
        )
    );
    $updatefile = performShopifyRequest($shop, $accessToken, "themes/{$themeID}/assets", $datas, "PUT");
}

function getThemeId($shop, $accessToken)
{
    $params = array(
        "role" => "main"
    );
    $themedata = performShopifyRequest($shop, $accessToken, "themes", $params, "GET");
    $themeId = $themedata['themes'][0]['id'];
    return $themeId;
}
function getLiquidFile($shop, $accessToken, $key, $themeID = "current")
{
    if ($themeID == "current") {
        $themeID = getThemeId($shop, $accessToken);
    }
    $params = array(
        "asset" => array(
            "key" => $key,
            "theme_id" => $themeID
        )
    );
    $getfile = performShopifyRequest($shop, $accessToken, "themes/{$themeID}/assets", $params, "GET");
    return $getfile;
}

function graphql($token, $shop, $query = array())
{
    $url = "https://" . $shop . "/admin/api/2022-04/graphql.json";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $requestHeaders[] = "";
    $requestHeaders[] = "Content-Type: application/json";
    if (!is_null($token)) {
        $requestHeaders[] = "X-Shopify-Access-Token: " . $token;
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeaders);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($query));
    curl_setopt($curl, CURLOPT_POST, true);
    $response = curl_exec($curl);
    $errorNumber = curl_errno($curl);
    $errorMessage = curl_error($curl);
    curl_close($curl);
    if ($errorNumber) {
        return $errorMessage;
    } else {
        $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
        $headers = array();
        $headerData = explode("\n", $response[0]);
        $headers['status'] = $headerData[0];
        array_shift($headerData);
        foreach ($headerData as $part) {
            $h = explode(":", $part, 2);
            $headers[trim($h[0])] = trim($h[1]);
        }
        return json_decode($response[1], true);
    }
}
function validateShopDomain($shop)
{
    $substring = explode('.', $shop);

    if (count($substring) != 3) {
        return false;
    }

    $substring[0] = str_replace('-', '', $substring[0]);
    return (ctype_alnum($substring[0]) && $substring[1] . '.' . $substring[2] == 'myshopify.com');
}
function validateHmac($params, $secret)
{
    $hmac = $params['hmac'];
    unset($params['hmac']);
    ksort($params);
    $computedHmac = hash_hmac('sha256', http_build_query($params), $secret);

    return hash_equals($hmac, $computedHmac);
}
function getAccessToken($shop, $apiKey, $secret, $code)
{
    $query = array(
        'client_id' => $apiKey,
        'client_secret' => $secret,
        'code' => $code
    );
    $accessToken_url = "https://{$shop}/admin/oauth/access_token";
    $curl = curl_init();
    $curlOptions = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $accessToken_url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POSTFIELDS => http_build_query($query)
    );
    curl_setopt_array($curl, $curlOptions);
    $jsonResponse = json_decode(curl_exec($curl), true);
    curl_close($curl);
    return $jsonResponse['access_token'];
}
