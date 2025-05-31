<?php
// File: app/views/courses/detail.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengantar Teknologi Komputer dan Informatika (A)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        
        .profile {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        
        .course-container {
            background-color: #f8f9fa;
            width: 75%;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .course-header {
            margin-bottom: 25px;
        }
        
        .course-meta {
            display: flex;
            gap: 20px;
            margin: 15px 0;
            flex-wrap: wrap;
        }
        
        .announcement-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            border-left: 4px solid #6c757d;
        }
        
        .file-indicator {
            color: #6c757d;
            font-weight: bold;
        }
        
        hr {
            margin: 25px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="profile d-flex justify-content-center align-items-center h-100">
        <div class="course-container bg-body-secondary w-75">
            <!-- Navbar Minimal -->
            <nav class="navbar mb-4 p-0">
                <div class="container-fluid p-0">
                    <a class="navbar-brand fw-bold" href="<?= BASEURL ?>">Diajar</a>
                </div>
            </nav>

            <!-- Konten Kursus -->
            <div class="course-header">
                <h1>Pengantar Teknologi Komputer dan Informatika (A)</h1>
                <div class="course-meta">
                    <span>Kode Prodi: 140810</span>
                    <span>SKS: 2</span>
                    <span>Kelas: A</span>
                </div>
                <p>Course start date: Monday, 19 August 2024</p>
            </div>

            <hr>

            <h2>General</h2>
            <h3 class="mt-4">Announcements</h3>

            <div class="announcement-item">
                <strong>KULIAH-1:</strong> PENDAHULUAN: 20-08-2024 →<br>
                <span class="file-indicator">File: ↑</span>
            </div>

            <div class="announcement-item">
                <strong>KULIAH-2:</strong> HARDWARE BASIC: 27-08-2024 →<br>
                <span class="file-indicator">File: ↑</span>
            </div>

            <div class="announcement-item">
                <strong>KULIAH-3:</strong> SISTEM BILANGAN: 03-09-2024 →<br>
                <span class="file-indicator">File: ↑</span>
            </div>

            <div class="mt-5 text-center">
                <a href="<?= BASEURL ?>/courses" class="btn btn-outline-secondary">Kembali ke Daftar Kursus</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>