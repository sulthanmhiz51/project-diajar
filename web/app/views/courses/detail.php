<?php
$course = $data['course'];
$thumbnail = $course['thumbnail_url'] ?? 'default-thumbnail.webp';
$title = $course['title'];
$createDate = $course['created_at'];
$author = $course['first_name'] || $course['last_name'] ? $course['first_name'] . ' ' . $course['last_name'] : $course['instr_uname'];
$desc = $course['description'];
var_dump($course)
?>

<div class="profile d-flex justify-content-center align-content-center h-100">
    <div class="bg-body w-75 p-5">
        <!-- Konten Kursus -->
        <div class="course-header">
            <img src="<?= BASEURL ?>/img/thumbnail/<?= $thumbnail ?>" alt="Thumbnail" class="w-100 mb-4"
                style="height: 250px; object-fit: cover;">
            <h1><?= $title ?></h1>
            <p class="m-0">Author: <?= $author ?> </p>
            <p>Created at: <?= $createDate ?> </p>
        </div>

        <hr>

        <h2>Descriptions</h2>

        <?= $desc ?>

        <h3 class="mt-4">Announcements</h3>

        <!-- Kuliah 1 -->
        <div class="kuliah-card p-3 bg-white rounded shadow-sm mb-3">
            <div class="announcement-item">
                <strong>KULIAH-1:</strong> PENDAHULUAN: 20-08-2024 →<br>
                <span class="file-indicator" style="display: inline-block; width: 20px;">↑</span>
            </div>
        </div>

        <!-- Kuliah 2 -->
        <div class="kuliah-card p-3 bg-white rounded shadow-sm mb-3">
            <div class="announcement-item">
                <strong>KULIAH-2:</strong> HARDWARE BASIC: 27-08-2024 →<br>
                <span class="file-indicator" style="display: inline-block; width: 20px;">↑</span>
            </div>
        </div>

        <!-- Kuliah 3 -->
        <div class="kuliah-card p-3 bg-white rounded shadow-sm mb-3">
            <div class="announcement-item">
                <strong>KULIAH-3:</strong> SISTEM BILANGAN: 03-09-2024 →<br>
                <span class="file-indicator" style="display: inline-block; width: 20px;">↑</span>
            </div>
        </div>

        <div class="mt-5 text-center">
            <a href="<?= BASEURL ?>/courses" class="btn btn-outline-primary">Kembali ke Daftar Kursus</a>
        </div>
    </div>
</div>

<script>
    document.title = "<?= $title ?>"
</script>