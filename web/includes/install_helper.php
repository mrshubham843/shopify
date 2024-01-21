<?php
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

function addStore($validShop, $accessToken)
{
    //get shop details from api
    $endpoint = '/admin/api/2021-10/shop.json';
    $response = rest_api($accessToken, $validShop, $endpoint, array(), 'GET');
    $shopDetails = json_decode($response['data'], true);

    //prepare for db insert record
    $shopName = $shopDetails['shop']['name'];
    $shopEmail = $shopDetails['shop']['email'];
    $data = array(
        "shop_url" => $validShop,
        "shop_name" => $shopName,
        "shop_email" => $shopEmail,
        "access_token" => $accessToken,
        "install_date" => $accessToken
    );

    $db = connectdb();
    $db->select("shops", array(
        "shop_url" => $validShop
    ));
    $shop = $db->result_array();

    // update if shop availble othewise update it
    if (isset($shop) && !empty($shop)) {
        $db->update('shops', $data, array(
            "shop_url" => $shop[0]['shop_url']
        ));
    } else {
        $db->insert('shops', $data);
        // $storeId = $db->id();
    }
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

function connectdb()
{
    $db = new Database($GLOBALS['dbDatabase'], $GLOBALS['dbUsername'], $GLOBALS['dbPassword'], $GLOBALS['dbServer']);
    return $db;
}
