<?php
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query(
    "SELECT * FROM students ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<nav class="navbar">

    <h2>Student Management</h2>

    <div>
        Welcome,
        <strong>
            <?= htmlspecialchars($_SESSION["user_name"]) ?>
        </strong>

        <a class="logout" href="logout.php">
            Logout
        </a>
    </div>

</nav>

<div class="container">

    <div class="page-header">

        <h1>Students</h1>

        <a class="add-btn" href="add_student.php">
            + Add Student
        </a>

    </div>

    <div class="table-container">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($student = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= $student["id"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student["name"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student["email"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student["phone"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student["course"]) ?>
                        </td>

                        <td>
                            <?= $student["semester"] ?>
                        </td>

                        <td>

                            <a
                                class="edit"
                                href="edit_student.php?id=<?= $student["id"] ?>"
                            >
                                Edit
                            </a>

                            <a
                                class="delete"
                                href="delete_student.php?id=<?= $student["id"] ?>"
                                onclick="return confirm('Delete this student?')"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="7">
                        No students found.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
