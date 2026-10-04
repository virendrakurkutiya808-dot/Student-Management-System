<?php
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET["id"] ?? 0);

$stmt = $conn->prepare(
    "SELECT * FROM students WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("Student not found.");
}

$student = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $course = trim($_POST["course"]);
    $semester = intval($_POST["semester"]);

    $stmt = $conn->prepare(
        "UPDATE students
         SET name=?, email=?, phone=?, course=?, semester=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "ssssii",
        $name,
        $email,
        $phone,
        $course,
        $semester,
        $id
    );

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Student</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

    <h1>Edit Student</h1>

    <form method="POST">

        <label>Name</label>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($student["name"]) ?>"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($student["email"]) ?>"
            required
        >

        <label>Phone</label>

        <input
            type="text"
            name="phone"
            value="<?= htmlspecialchars($student["phone"]) ?>"
        >

        <label>Course</label>

        <input
            type="text"
            name="course"
            value="<?= htmlspecialchars($student["course"]) ?>"
            required
        >

        <label>Semester</label>

        <input
            type="number"
            name="semester"
            min="1"
            max="12"
            value="<?= $student["semester"] ?>"
            required
        >

        <button type="submit">
            Update Student
        </button>

        <a class="back-btn" href="dashboard.php">
            Cancel
        </a>

    </form>

</div>

</body>

</html>
