<?php

class Users_model
{
    private $table = 'users';

    // required for JOIN to fetch user's profile
    private $usersTable;
    private $profileTable;
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->usersTable = $this->table;
        $this->profileTable = 'user_profile';
    }
    // public function getAllMahasiswa()
    // {
    //     $this->db->query('SELECT * FROM ' . $this->table);
    //     return $this->db->resultSet();
    // }

    // public function getMahasiswaById($id)
    // {
    //         $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
    //         $this->db->bind('id', $id);
    //         return $this->db->single();
    //     }

    //     public function hapusDataMahasiswa($id)
    //     {
    //         $query = "DELETE FROM mahasiswa WHERE id = :id";

    //         $this->db->query(($query));
    //         $this->db->bind('id', $id);

    //         $this->db->execute();

    //         return $this->db->rowCount();
    //     }
    //     public function ubahDataMahasiswa($data)
    //     {
    //         var_dump($data);
    //         $query = "UPDATE mahasiswa SET
    //                     nama = :nama,
    //                     npm = :npm,
    //                     email = :email,
    //                     jurusan = :jurusan
    //                 WHERE id = :id";

    //         $this->db->query(($query));
    //         $this->db->bind('nama', $data['nama']);
    //         $this->db->bind('npm', $data['npm']);
    //         $this->db->bind('email', $data['email']);
    //         $this->db->bind('jurusan', $data['jurusan']);
    //         $this->db->bind('id', $data['id']);

    //         $this->db->execute();

    //         return $this->db->rowCount();
    //     }

    //         public function cariDataMahasiswa($keyword)
    //         {
    //             $query = "SELECT * FROM mahasiswa WHERE nama LIKE :keyword";
    //             $this->db->query(($query));
    //             $this->db->bind('keyword', "%$keyword%");
    //             return $this->db->resultSet();
    //         }
    public function registerAccount($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_ARGON2I);

        $query = "INSERT INTO " . $this->table . " (username, email, password, role_id)
                VALUES (:username, :email, :password, :role)";

        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('role', $data['role']);

        try {
            $this->db->execute();
            return [
                'success' => true
            ];
        } catch (PDOException $e) {
            // Check for duplicate entry error (MySQL error code 1062)
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                // Custom message, you can also parse $e->getMessage() to decide which field is duplicate
                return [
                    'success' => false,
                    'error' => 1062,
                    'error_msg' => 'Username or email already registered.',
                    'role' => $data['role']
                ];
            }
            // For other errors, return a generic error (or log detailed info)
            return [
                'success' => false,
                'error' => $e->errorInfo[1],
                'error_msg' => 'An unexpected error occurred.',
                'role' => $data['role']
            ];
        }
    }
    public function signIn($data)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";

        $this->db->query($query);
        $this->db->bind('username', $data['username']);

        $user = $this->db->single();

        if ($user) {
            if (password_verify($data['password'], $user['password'])) {
                unset($user['password']);
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role_id'];
                return ['success' => true];
            } else {
                return [
                    'error' => 'password',
                    'error_msg' => 'You entered a wrog password',
                    'success' => false
                ];
            };
        } else {
            return [
                'error' => 'uname',
                'error_msg' => 'Username not found',
                'success' => false
            ];
        };
    }
}
