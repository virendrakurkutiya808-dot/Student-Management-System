<?php
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $course = trim($_POST["course"]);
    $semester = intval($_POST["semester"]);

    if (
        empty($name) ||
        empty($email) ||
        empty($course) ||
        $semester < 1
    ) {
        $message = "Please fill all required fields.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO students
            (name, email, phone, course, semester)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssi",
            $name,
            $email,
            $phone,
            $course,
            $semester
        );

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        }

        $message = "Unable to add student.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Student</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

    <h1>Add Student</h1>

    <?php if ($message): ?>
        <div class="error">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Name</label>

        <input
            type="text"
            name="name"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            required
        >

        <label>Phone</label>

        <input
            type="text"
            name="phone"
        >

        <label>Course</label>

        <input
            type="text"
            name="course"
            placeholder="BCA"
            required
        >

        <label>Semester</label>

        <input
            type="number"
            name="semester"
            min="1"
            max="12"
            required
        >

        <button type="submit">
            Add Student
        </button>

        <a class="back-btn" href="dashboard.php">
            Back
        </a>

    </form>

</div>

</body>

</html>
