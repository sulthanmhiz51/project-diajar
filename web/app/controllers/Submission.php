<?php
class Submission extends Controller
{
    public function index($modul_id = null)
    {
        $data['judul'] = 'Submission Modul';

        // Dummy modul
        $data['modul'] = [
            'id' => (int)$modul_id,
            'open_date' => '2025-06-01 08:00:00',
            'due_date' => '2025-06-15 23:59:59'
        ];

        // Format tanggal
        $data['open_date_formatted'] = date('j F Y, g:i A', strtotime($data['modul']['open_date']));
        $data['due_date_formatted'] = date('j F Y, g:i A', strtotime($data['modul']['due_date']));

        // Dummy submission
        $data['submission'] = [
            'status' => 'dinilai',
            'nilai' => 85,
            'created_at' => '2025-06-10 14:30:00',
            'files' => [
                ['name' => 'tugas1.pdf', 'created_at' => '2025-06-10 14:00:00'],
                ['name' => 'kode_saya.zip', 'created_at' => '2025-06-10 14:15:00']
            ],
            'last_modified' => '2025-06-10 15:00:00',
            'submitted_at' => '2025-06-10 14:30:00'
        ];

        // Status pengumpulan
        $submitted_time = strtotime($data['submission']['submitted_at']);
        $due_time = strtotime($data['modul']['due_date']);
        $data['submitted_early'] = $submitted_time <= $due_time;

        $diff = abs($due_time - $submitted_time);
        $data['time_early_text'] = $this->formatTimeDiff($diff) . ' before due date';
        $data['time_late_text'] = $this->formatTimeDiff($diff) . ' after due date';

        // Komentar dummy
        $data['comments'] = [
            [
                'author_name' => 'Dosen A',
                'content' => 'Bagus, tapi perlu perbaikan di bagian 2.',
                'created_at' => '2025-06-11 09:00:00'
            ],
            [
                'author_name' => 'Mahasiswa B',
                'content' => 'Terima kasih atas masukannya.',
                'created_at' => '2025-06-11 10:00:00'
            ]
        ];

        // Render pakai layout yang sama dengan modul
        $this->view('templates/header', $data);
        $this->view('submission/index', $data);
        $this->view('templates/footer');
    }

    private function formatTimeDiff($seconds)
    {
        $units = [
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
        ];

        foreach ($units as $name => $divisor) {
            if ($seconds >= $divisor) {
                $value = floor($seconds / $divisor);
                return $value . ' ' . $name . ($value > 1 ? 's' : '');
            }
        }
        return $seconds . ' seconds';
    }
}
