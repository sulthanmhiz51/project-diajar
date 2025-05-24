<div class="container mt-5">

    <div class="row">
        <div class="col">
            <?php Flasher::flash() ?>
        </div>
    </div>

    <div class="rt-2 bg-primary py-3 px-2 rounded-top-4">
        <div class="container">
            <h1 class="mb-0 text-light">Daftar Mahasiswa</h1>
        </div>
    </div>
    <div class="container p-3 bg-body-secondary rounded-bottom-4">
        <div class="col-auto mb-3">
            <button type="button" class="tombolTambah btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#formModal">
                Tambah data
            </button>
        </div>
        <div class="col-auto">
            <form action="<?= BASEURL ?>/mahasiswa/cari" method="post">
                <div class="input-group">
                    <input type="text" class="form-control border-primary" placeholder="Cari berdasarkan nama..."
                        name="keyword" id="keyword" autocomplete="off">
                    <!-- <button class="btn btn-primary" type="submit" id="button-addon2" id="tombolCari">Cari</button> -->
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col">

                <ul class="list-group mt-3" id="search-display">
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
            </div>

            <!-- Modal -->
            <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel">Tambah Data Mahasiswa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= BASEURL ?>/mahasiswa/tambah" method="POST">
                                <input type="hidden" name="id" id="id">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="npm" class="form-label">NPM</label>
                                    <input type="number" class="form-control" id="npm" name="npm">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <div class="input-group mb-3">
                                    <label class="form-label" for="jurusan">Jurusan</label>

                                    <select class="form-select" id="jurusan" name="jurusan">
                                        <option value="Teknik Informatika">Teknik Informatika</option>
                                        <option value="Matematika">Matematika</option>
                                        <option value="Statistika">Statistika</option>
                                        <option value="Ilmu Komputer">Ilmu Komputer</option>
                                        <option value="Pendidikan Bahasa Arab">Pendidikan Bahasa Arab</option>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation dialog -->
<script>

</script>