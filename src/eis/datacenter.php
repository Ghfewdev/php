<?php
session_start();

if (!isset($_SESSION['us_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- 🔹 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
            📊 DATA CENTER Dashboard
        </span>

        <div class="d-flex align-items-center text-white">
            <span class="me-3">
                หน่วยงาน: <?= $_SESSION['us_dv'] ?>
            </span>
            <a href="logout.php" class="btn btn-sm btn-light">
                Logout
            </a>
        </div>
    </div>
</nav>

<!-- 🔹 Content -->
<div class="container-fluid mt-4">

    <div class="row g-4">

        <!-- Power BI Report 1 -->
        <div class="col-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-white fw-bold">
                    รายงาน OPD
                </div>
                <div class="card-body p-0">
                    <iframe 
                        title="Power BI Report 1"
                        width="100%" 
                        height="600"
                        src="https://app.powerbi.com/view?r=eyJrIjoiN2YyYzlkOWYtM2QxNi00MTNiLTk4NTQtMmMyYzYwOWExZjJhIiwidCI6ImRjMWI3ODc0LTE1ZTItNGQzYy05YWRmLWVhNDkxZTM2NmRhZSIsImMiOjEwfQ%3D%3D"
                        frameborder="0"
                        allowFullScreen="true">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Power BI Report 2 -->
        <div class="col-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-white fw-bold">
                    รายงาน IPD
                </div>
                <div class="card-body p-0">
                    <iframe 
                        title="Power BI Report 2"
                        width="100%" 
                        height="600"
                        src="https://app.powerbi.com/view?r=eyJrIjoiNWQ1OWExOTQtNmZjNC00YmQ0LWI4OGItMjMwNGE1MzM0MTc3IiwidCI6ImRjMWI3ODc0LTE1ZTItNGQzYy05YWRmLWVhNDkxZTM2NmRhZSIsImMiOjEwfQ%3D%3D"
                        frameborder="0"
                        allowFullScreen="true">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
