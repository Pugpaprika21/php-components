<?php

function get_provinces()
{
    global $conn;
    try {
        $stmt = mysqli_prepare($conn, "SELECT * FROM provinces ORDER BY name_in_thai ASC");

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $provinces = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        return $provinces;
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit;
    }
}

function get_districts($provinceId = 0)
{
    global $conn;
    try {
        $stmt = $provinceId
            ? mysqli_prepare($conn, "SELECT * FROM districts WHERE province_id = ? ORDER BY name_in_thai ASC")
            : mysqli_prepare($conn, "SELECT * FROM districts ORDER BY name_in_thai ASC");

        if ($provinceId) {
            mysqli_stmt_bind_param($stmt, "i", $provinceId);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $districts = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        return $districts;
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit;
    }
}

function get_subdistricts($districtId = 0)
{
    global $conn;
    try {
        $stmt = $districtId
            ? mysqli_prepare($conn, "SELECT * FROM subdistricts WHERE district_id = ? ORDER BY name_in_thai ASC")
            : mysqli_prepare($conn, "SELECT * FROM subdistricts ORDER BY name_in_thai ASC");

        if ($districtId) {
            mysqli_stmt_bind_param($stmt, "i", $districtId);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $subdistricts = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
        return $subdistricts;
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit;
    }
}
