<?php

include_once __DIR__ . "../../src/db.php";

try {
    $page = $_POST["page"] ?? 1;
    $limit = $_POST["limit"] ?? 100;

    $offset = ($page - 1) * $limit;

    $stmt = mysqli_prepare($conn, "SELECT id, first_name, last_name, email, gender, ip_address FROM users LIMIT ? OFFSET ?");
    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        header("Content-Type: application/json");
        echo json_encode(["data" => $rows]);
        exit;
    } else {
        echo json_encode(["error" => "Failed to fetch users"]);
        exit;
    }
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode(["error" => $th->getMessage()]);
    exit;
}
