<?php

$_act = $_GET['act'];

$default_res = [
    "code" => 0,
];


if($_act == "getList") {
    $res = $default_res;
    $res["offset"] = 10;
    $res["total"] = 104;
    $res["data"] = [
        [
            oid => 123,
            state => 123,
            timestamp => 122222222222,
            cost => 123,
            freight => 123,
            carriage => 123,
            address => "收款人地址1",
            name => "收款人姓名1",
        ],
        [
            oid => 124,
            state => 124,
            timestamp => 123242342432342,
            cost => 124,
            freight => 124,
            carriage => 124,
            address => "收款人地址2",
            name => "收款人姓名2",
        ]
    ];
}

echo json_encode($res);

?>