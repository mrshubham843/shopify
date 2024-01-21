<?php
// SMM FUNCTIONS
// SMM FUNCTIONS
// SMM FUNCTIONS
// SMM FUNCTIONS
function ssm_connect($post)
{

    $_post = [];
    if (is_array($post)) {
        foreach ($post as $name => $value) {
            $_post[] = $name . '=' . urlencode($value);
        }
    }

    $ch = curl_init($GLOBALS['SSM_API_URL']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    if (is_array($post)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
    }
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    $result = curl_exec($ch);
    if (curl_errno($ch) != 0 && empty($result)) {
        $result = false;
    }
    curl_close($ch);
    return $result;
}

function ssm_packages()
{ // get packages list
    return json_decode(ssm_connect([
        'key' => $GLOBALS['SSM_API_TOKEN'],
        'action' => 'services',
    ]));
}

function ssm_packages_getUpdate()
{

    //CALL THIS FUNCTION WHEN UPDATING PACKAGE PRICE OR ANY DETAIL

    $packages = ssm_packages();
    $allPackages = json_decode(json_encode($packages), true);

    if (isset($allPackages) && !empty($allPackages)) {
        foreach ($allPackages as $package) {
            $updated_rate = "0.00";
            $updated_desc = 'updated_desc';
            $updated_name = 'updated_name';
            $updated_service_name = 'updated_service_name';

            $dataInsert = array(
                'package_id' => '0',
                'service_id' => $package['service'],
                'name' => $package['name'],
                'rate' => $package['rate'],
                'min' => $package['min'],
                'max' => $package['max'],
                'service' => $package['category'],
                'type' => $package['type'],
                'description' => ' ',
                'updated_rate' => $updated_rate,
                'updated_name' => $updated_name,
                'updated_service_name' => $updated_service_name,
                'updated_desc' => $updated_desc,
                'refill' => ($package['refill'] == '1') ? '1' : '0',
                'cancel' => ($package['cancel'] == '1') ? '1' : '0',
                'created' => date('d-m-Y H:i:s')
            );

            $db = connectdb();
            $db->select("packages", array(
                "service_id" => $package['service']
            ));
            $isExists = $db->result_array();

            if (!$isExists) {
                if (stripos($package['name'], 'YouTube') !== false) {
                    $db->insert('packages', $dataInsert);
                } else {
                    echo $package['name'] . "<br>";
                }
            } else {
                // $dataUpdate = array(
                //     'package_id' => $package['id'],
                //     'service_id' => $package['service_id'],
                //     'name' => $package['name'],
                //     'rate' => $package['rate'],
                //     'min' => $package['min'],
                //     'max' => $package['max'],
                //     'service' => $package['service'],
                //     'type' => $package['type'],
                //     'description' => $package['desc'],
                //     'updated_rate' => $updated_rate,
                //     'updated_name' => $updated_name,
                //     'updated_service_name' => $updated_service_name,
                //     'updated_desc' => $updated_desc . '=updated',
                //     'created' => date('d-m-Y H:i:s')
                // );

                // if ($package['id'] == "5183") {
                //     $db->update('packages', $dataUpdate, array('package_id' => $package['id'], 'service_id' => $package['service_id']));
                // }
            }
        }
    }
    return true;
}

function ssm_packages_updatePrice()
{
    //CALL THIS FUNCTION WHEN UPDATING PACKAGE PRICE OR ANY DETAIL
    $packages = ssm_packages();
    $allPackages = json_decode(json_encode($packages), true);

    if (isset($allPackages) && !empty($allPackages)) {
        $db = connectdb();
        foreach ($allPackages as $package) {
            $availbleServices = array('1734', '2402', '1291', '1739', '1658', '1344', '2952', '2960', '230', '1283', '234');
            if (in_array($package['service'], $availbleServices)) {
                $db->select("services", array(
                    "service_id" => $package['service']
                ));

                $packages = $db->result_array();
                if (isset($packages) && !empty($packages)) {
                    $updated_rate = $package['rate'] * 0.4;
                    $total_updated_rate = $package['rate'] + $updated_rate;
                    $updateData = array('updated_rate' => $total_updated_rate);
                    $db->update('services', $updateData, array(
                        "service_id" => $package['service']
                    ));
                }
            }
        }
        die("inserted");
    }
}

function ssm_order($data)
{ // add order
    $post = array_merge([
        'key' => $GLOBALS['SSM_API_TOKEN'],
        'action' => 'add'
    ], $data);

    return json_decode(ssm_connect($post));
}

function ssm_status($order_id)
{ // get order status
    return json_decode(
        ssm_connect([
            'key' => $GLOBALS['SSM_API_TOKEN'],
            'action' => 'status',
            'orders' => $order_id
        ])
    );
}
