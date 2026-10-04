<?php
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET["id"] ?? 0);

$stmt = $conn->prepare(
    "DELETE FROM students WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
exit();
?>
