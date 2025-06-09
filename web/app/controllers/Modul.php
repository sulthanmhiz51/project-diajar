<?php
class Modul extends Controller
{
    public function index($id = null)
    {
        $data['judul'] = 'Detail Modul';

        // Cek apakah $id dikasih atau tidak (bisa kamu sesuaikan kalau nanti dari database)
        if ($id === null) {
            // Contoh data default kalau belum ada database
            $data['module'] = [
                'title' => 'Tree',
                'session' => 14,
                'date' => '2025-06-03',
                'description' => "- PPT Tree\n- Tugas Tree\n- Lihat file PPT\n- Kerjakan tugasnya. Jawaban manual di pdf\n- Kumpulkan cpp dan pdf",
                'materials' => [],
                'breadcrumbs' => []
            ];
        } else {
            // Kalau sudah ada data dari database, kamu bisa ambil dari model
            // Contoh: $data['module'] = $this->model('ModulModel')->getById($id);
            $data['module'] = null; // untuk sementara anggap nggak ketemu
        }

        $this->view('templates/header', $data);
        $this->view('modul/index', $data);
        $this->view('templates/footer');
    }
}
