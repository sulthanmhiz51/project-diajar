<?php
if (!isset($module)) {
    // data dummy utk testing
    $module = [
        'title' => 'Pengantar Teknologi dan Informatika',
        'session' => 'Pertemuan 1',
        'date' => '2025-06-08',
        'description' => "Pengenalan komputer\nJenis-jenis perangkat keras\nCara kerja dasar komputer",
    ];
}

// daftar materi (pdf, video, tugas)
$materials = [
    [
        'id' => 1,
        'title' => 'Slide PDF - Pengenalan Komputer',
        'type' => 'pdf',
        'file' => 'slide_pengenalan_komputer.pdf',
        'description' => 'Slide PDF berisi penjelasan dasar tentang sejarah dan komponen komputer.'
    ],
    [
        'id' => 2,
        'title' => 'Video: Cara Kerja Komputer',
        'type' => 'video',
        'link' => 'https://www.youtube.com/watch?v=abcd1234',
        'description' => 'Video pendek menjelaskan bagaimana komputer memproses data.'
    ],
    [
        'id' => 3,
        'title' => 'Tugas 1 - Rangkuman Materi',
        'type' => 'task',
        'description' => 'Kerjakan rangkuman dari materi PDF dan video lalu unggah melalui halaman tugas.'
    ],
    [
        'id' => 4,
        'title' => 'Artikel: Sejarah Komputer Modern',
        'type' => 'pdf',
        'file' => 'artikel_sejarah_komputer.pdf',
        'description' => 'Artikel mendalam membahas perkembangan komputer dari generasi ke generasi.'
    ],
    [
        'id' => 5,
        'title' => 'Video: Hardware vs Software',
        'type' => 'video',
        'link' => 'https://youtu.be/xyz5678',
        'description' => 'Penjelasan singkat tentang perbedaan hardware dan software.'
    ],
    [
        'id' => 6,
        'title' => 'Tugas 2 - Identifikasi Komponen',
        'type' => 'task',
        'description' => 'Identifikasi 5 komponen hardware yang kamu punya dan buat ringkasannya.'
    ]
];

?>

<div class="profile d-flex justify-content-center align-content-center h-100">
    <div class="bg-body w-75 p-5">
        <!-- Header Modul -->
        <div class="module-header">
            <h1><?= htmlspecialchars($module['title']) ?></h1>
            <p class="m-0">Sesi: <?= htmlspecialchars($module['session']) ?></p>
            <p class="m-0">Tanggal: <?= date('d M Y', strtotime($module['date'])) ?></p>
        </div>

        <hr>

        <!-- Deskripsi Modul -->
        <h2>Deskripsi</h2>
        <ul>
            <?php 
            $lines = explode("\n", $module['description']);
            foreach ($lines as $line) {
                if (!empty(trim($line))) {
                    echo '<li>' . htmlspecialchars(trim($line)) . '</li>';
                }
            }
            ?>
        </ul>
        <!-- Materi Modul -->
            <div>
                <h4>Materi</h4>
                <div class="d-flex flex-column gap-4">
                    <?php foreach ($materials as $item): ?>
                        <div class="bg-white p-4 shadow-sm rounded border">
                            <h5 class="mb-2">
                                <?php if ($item['type'] === 'pdf'): ?>
                                    📄 <?= htmlspecialchars($item['title']) ?>
                                <?php elseif ($item['type'] === 'video'): ?>
                                    ▶️ <?= htmlspecialchars($item['title']) ?>
                                <?php elseif ($item['type'] === 'task'): ?>
                                    📝 <?= htmlspecialchars($item['title']) ?>
                                <?php endif; ?>
                            </h5>
                            <p class="mb-3"><?= htmlspecialchars($item['description']) ?></p>

                            <?php if ($item['type'] === 'pdf'): ?>
                                <a href="<?= BASEURL ?>/files/modul/<?= $item['file'] ?>" class="btn btn-sm btn-success" download>
                                    📥 Unduh PDF
                                </a>
                            <?php elseif ($item['type'] === 'video'): ?>
                                <a href="<?= $item['link'] ?>" class="btn btn-sm btn-primary" target="_blank">
                                    ▶️ Tonton Video
                                </a>
                            <?php elseif ($item['type'] === 'task'): ?>
                                <a href="<?= BASEURL ?>/modul/submit/<?= $item['id'] ?>" class="btn btn-sm btn-warning">
                                    📝 Buka Halaman Tugas
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <div class="mt-5 text-center">
            <a href="<?= BASEURL ?>/courses" class="btn btn-outline-primary">← Kembali ke Daftar Kursus</a>
        </div>
    </div>
</div>

<script>
    document.title = "<?= htmlspecialchars($module['title']) ?>";
</script>
