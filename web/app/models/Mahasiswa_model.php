<?php

class Mahasiswa_model
{
    // private $mhs = [
    //     [
    //         "nama" => "Sulthan Muhammad",
    //         "npm" => "140810240053",
    //         'email' => 'sulthan24002@mail.unpad.ac.id',
    //         'jurusan' => 'Teknik Informatika'
    //     ],
    //     [
    //         "nama" => "Rama Aditya",
    //         "npm" => "120810240011",
    //         'email' => 'rambon24001@mail.unpad.ac.id',
    //         'jurusan' => 'Sistem Informasi'
    //     ],
    //     [
    //         "nama" => "Gagah Gattuso",
    //         "npm" => "210810240076",
    //         'email' => 'gattuso24001@mail.unpad.ac.id',
    //         'jurusan' => 'Pendidikan Bahasa Arab'
    //     ]
    // ];
    private $table = 'mahasiswa';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAllMahasiswa()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getMahasiswaById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataMahasiswa($data)
    {
        $query = "INSERT INTO mahasiswa
                    VALUES
                    (NULL, :nama, :npm, :email, :jurusan)";

        $this->db->query(($query));
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('npm', $data['npm']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);

        $this->db->execute();

        return $this->db->rowCount();
    }
    public function hapusDataMahasiswa($id)
    {
        $query = "DELETE FROM mahasiswa WHERE id = :id";

        $this->db->query(($query));
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }
    public function ubahDataMahasiswa($data)
    {
        var_dump($data);
        $query = "UPDATE mahasiswa SET
                    nama = :nama,
                    npm = :npm,
                    email = :email,
                    jurusan = :jurusan
                WHERE id = :id";

        $this->db->query(($query));
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('npm', $data['npm']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cariDataMahasiswa($keyword)
    {
        $query = "SELECT * FROM mahasiswa WHERE nama LIKE :keyword";
        $this->db->query(($query));
        $this->db->bind('keyword', "%$keyword%");
        return $this->db->resultSet();
    }
}
