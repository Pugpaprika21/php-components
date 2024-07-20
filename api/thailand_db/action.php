<?php

const DB_NAME = "thailand_db";

include_once __DIR__ . "../../../src/db.php";
include_once __DIR__ . "../../../query/thailand_db/query_func.php";

header("Content-type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

if (!empty($_POST["get_provinces"]) && $_POST["get_provinces"] == "get_provinces") {
    $provinces = get_provinces();
    echo json_encode(["data" => $provinces]);
    exit;
}

if (!empty($_POST["get_districts"]) && $_POST["get_districts"] == "get_districts") {
    $provinceId = $_POST["province_id"] ?? 0;
    $districts = get_districts($provinceId);
    echo json_encode(["data" => $districts]);
    exit;
}

if (!empty($_POST["get_subdistricts"]) && $_POST["get_subdistricts"] == "get_subdistricts") {
    $districtId = $_POST["district_id"] ?? 0;
    $subdistricts = get_subdistricts($districtId);
    echo json_encode(["data" => $subdistricts]);
    exit;
}
