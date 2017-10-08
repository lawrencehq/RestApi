<?php
/**
 * Created by PhpStorm.
 * User: Enthalqy Huang
 * Date: 2017/9/3
 * Time: 21:06
 */

function formatOutput($status, $data, $info) {
    $output = array(
        "status" => $status,
        "data" => $data,
        "info" => $info
    );

    return json_encode($output);
}