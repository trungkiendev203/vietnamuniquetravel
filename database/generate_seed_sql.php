<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

use App\Config\Database;

$db = Database::getConnection();

$sql = "-- Seed Data for Vietnam Unique Travel\n";
$sql .= "-- Compatible with MySQL 5.7+ / 8.0+ / SQLite\n\n";
$sql .= "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS = 0;\n\n";

$tables = ['admins', 'destinations', 'destination_translations', 'categories', 'category_translations', 'tours', 'tour_translations', 'tour_categories', 'tour_prices', 'tour_itinerary_steps', 'tour_itinerary_translations', 'faqs', 'testimonials', 'posts', 'post_translations', 'settings'];

foreach ($tables as $table) {
    $rows = $db->query("SELECT * FROM {$table}")->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) continue;

    $columns = array_keys($rows[0]);
    $colList = '`' . implode('`, `', $columns) . '`';

    $sql .= "-- Insert into {$table}\n";
    foreach ($rows as $row) {
        $values = [];
        foreach ($row as $val) {
            if ($val === null) {
                $values[] = 'NULL';
            } elseif (is_numeric($val) && !is_string($val)) {
                $values[] = $val;
            } else {
                $escaped = str_replace(["\\", "'"], ["\\\\", "''"], $val);
                $values[] = "'" . $escaped . "'";
            }
        }
        $valList = implode(', ', $values);
        $sql .= "INSERT IGNORE INTO `{$table}` ({$colList}) VALUES ({$valList});\n";
    }
    $sql .= "\n";
}

$sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";

file_put_contents(__DIR__ . '/seed.sql', $sql);
echo "Generated database/seed.sql successfully! File size: " . strlen($sql) . " bytes\n";
