<?php

namespace App\Models;

use App\Core\Model;

class Setting extends Model {
    protected string $table = 'settings';

    public function getAllSettings(): array {
        $rows = $this->query("SELECT * FROM settings");
        $result = [];
        foreach ($rows as $row) {
            $result[$row['setting_key']] = $row['setting_value'];
        }
        return $result;
    }

    public function updateSetting(string $key, ?string $value): void {
        $this->execute("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :val)
                        ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)", [
            'key' => $key,
            'val' => $value
        ]);
    }
}
