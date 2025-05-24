            <ul class="list-group" id="search-display">
                <?php foreach ($data['mhs'] as $mhs) : ?>
                    <li class="list-group-item">
                        <?= $mhs['nama'] ?>
                        <a href="<?= BASEURL ?>/mahasiswa/hapus/<?= $mhs['id'] ?>"
                            class="badge float-end ms-1 text-bg-danger link-underline link-underline-opacity-0 hapus">hapus</a>
                        <a href="<?= BASEURL ?>/mahasiswa/ubah/<?= $mhs['id'] ?>"
                            class="badge float-end ms-1 text-bg-secondary link-underline link-underline-opacity-0 tampilModalUbah"
                            data-bs-toggle="modal" data-bs-target="#formModal" data-id="<?= $mhs['id'] ?>">ubah</a>
                        <a href="<?= BASEURL ?>/mahasiswa/detail/<?= $mhs['id'] ?>"
                            class="badge float-end ms-1 text-bg-primary link-underline link-underline-opacity-0">detail</a>
                    </li>
                <?php endforeach; ?>
            </ul>