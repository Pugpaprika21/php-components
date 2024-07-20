<?php

$conn = mysqli_connect("localhost", "root", "", DB_NAME);
if (mysqli_connect_errno()) {
    exit("failed to connect to MySQL: " . mysqli_connect_error());
}