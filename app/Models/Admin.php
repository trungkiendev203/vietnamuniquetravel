<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model {
    protected string $table = 'admins';

    public function findByUsername(string $username): ?array {
        return $this->queryOne("SELECT * FROM admins WHERE username = :username AND status = 1", ['username' => $username]);
    }

    public function verifyCredentials(string $username, string $password): ?array {
        $admin = $this->findByUsername($username);
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return null;
    }
}
