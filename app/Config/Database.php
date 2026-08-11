<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $connection = env('DB_CONNECTION', 'mysql');

            $isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL');

            if ($connection === 'sqlite' || $isVercel) {
                $dbFile = $isVercel ? '/tmp/database.sqlite' : __DIR__ . '/../../' . env('DB_FILE', 'storage/database.sqlite');
                $dir = dirname($dbFile);
                if (!is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }
                self::$instance = new PDO("sqlite:" . $dbFile, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                self::ensureSqliteSeeded(self::$instance);
            } else {
                $host = env('DB_HOST', '127.0.0.1');
                $port = env('DB_PORT', '3306');
                $dbname = env('DB_DATABASE', 'vnu_travel');
                $username = env('DB_USERNAME', 'root');
                $password = env('DB_PASSWORD', '');

                $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
                
                try {
                    self::$instance = new PDO($dsn, $username, $password, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => true,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                    ]);
                } catch (PDOException $e) {
                    // Fallback to SQLite if MySQL is unavailable
                    $dbFile = '/tmp/database.sqlite';
                    if (!is_dir(dirname($dbFile))) {
                        @mkdir(dirname($dbFile), 0755, true);
                    }
                    self::$instance = new PDO("sqlite:" . $dbFile, null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]);
                    self::ensureSqliteSeeded(self::$instance);
                }
            }
        }
        return self::$instance;
    }

    private static function ensureSqliteSeeded(PDO $pdo): void {
        try {
            $check = $pdo->query("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='tour_translations'")->fetchColumn();
            if ($check > 0) {
                $count = $pdo->query("SELECT count(*) FROM tour_translations")->fetchColumn();
                if ($count >= 14) {
                    return;
                }
            }
        } catch (\Throwable $e) {}

        $sqliteSchema = "
        CREATE TABLE IF NOT EXISTS admins (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT UNIQUE, email TEXT UNIQUE, password TEXT, name TEXT, role TEXT DEFAULT 'admin', status INTEGER DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS destinations (id INTEGER PRIMARY KEY AUTOINCREMENT, slug TEXT UNIQUE, image TEXT, is_featured INTEGER DEFAULT 0, sort_order INTEGER DEFAULT 0, status INTEGER DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS destination_translations (id INTEGER PRIMARY KEY AUTOINCREMENT, destination_id INTEGER, lang TEXT, name TEXT, short_description TEXT, description TEXT, seo_title TEXT, seo_description TEXT);
        CREATE TABLE IF NOT EXISTS categories (id INTEGER PRIMARY KEY AUTOINCREMENT, slug TEXT UNIQUE, icon TEXT, image TEXT, sort_order INTEGER DEFAULT 0, status INTEGER DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS category_translations (id INTEGER PRIMARY KEY AUTOINCREMENT, category_id INTEGER, lang TEXT, name TEXT, description TEXT);
        CREATE TABLE IF NOT EXISTS tours (id INTEGER PRIMARY KEY AUTOINCREMENT, code TEXT UNIQUE, slug TEXT UNIQUE, destination_id INTEGER, duration_type TEXT DEFAULT 'fullday', duration_days INTEGER DEFAULT 1, difficulty TEXT DEFAULT 'easy', transportation TEXT, group_size TEXT, price_from_usd REAL DEFAULT 0, price_from_vnd INTEGER DEFAULT 0, featured_image TEXT, is_featured INTEGER DEFAULT 0, is_signature INTEGER DEFAULT 0, signature_number INTEGER DEFAULT 0, sort_order INTEGER DEFAULT 0, status INTEGER DEFAULT 1, views INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS tour_translations (id INTEGER PRIMARY KEY AUTOINCREMENT, tour_id INTEGER, lang TEXT, title TEXT, sub_title TEXT, short_description TEXT, highlights TEXT, overview TEXT, inclusions TEXT, exclusions TEXT, what_to_bring TEXT, child_policy TEXT, cancellation_policy TEXT, seo_title TEXT, seo_description TEXT);
        CREATE TABLE IF NOT EXISTS tour_categories (tour_id INTEGER, category_id INTEGER, PRIMARY KEY (tour_id, category_id));
        CREATE TABLE IF NOT EXISTS tour_images (id INTEGER PRIMARY KEY AUTOINCREMENT, tour_id INTEGER, image_path TEXT, caption TEXT, sort_order INTEGER DEFAULT 0);
        CREATE TABLE IF NOT EXISTS tour_itinerary_steps (id INTEGER PRIMARY KEY AUTOINCREMENT, tour_id INTEGER, step_time TEXT, sort_order INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS tour_itinerary_translations (id INTEGER PRIMARY KEY AUTOINCREMENT, step_id INTEGER, lang TEXT, title TEXT, description TEXT);
        CREATE TABLE IF NOT EXISTS tour_prices (id INTEGER PRIMARY KEY AUTOINCREMENT, tour_id INTEGER, transport_type TEXT DEFAULT 'motorbike', pax_tier TEXT, price_vnd INTEGER, price_usd REAL, note TEXT);
        CREATE TABLE IF NOT EXISTS bookings (id INTEGER PRIMARY KEY AUTOINCREMENT, booking_code TEXT UNIQUE, tour_id INTEGER, tour_name TEXT, travel_date DATE, adults INTEGER DEFAULT 1, children INTEGER DEFAULT 0, fullname TEXT, nationality TEXT, email TEXT, phone_whatsapp TEXT, pickup_location TEXT, dietary_requirements TEXT, health_notes TEXT, special_requests TEXT, status TEXT DEFAULT 'new', internal_notes TEXT, email_sent_admin INTEGER DEFAULT 0, email_sent_customer INTEGER DEFAULT 0, email_error_log TEXT, ip_address TEXT, user_agent TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS posts (id INTEGER PRIMARY KEY AUTOINCREMENT, slug TEXT UNIQUE, featured_image TEXT, is_featured INTEGER DEFAULT 0, status INTEGER DEFAULT 1, views INTEGER DEFAULT 0, published_at DATETIME DEFAULT CURRENT_TIMESTAMP, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS post_translations (id INTEGER PRIMARY KEY AUTOINCREMENT, post_id INTEGER, lang TEXT, title TEXT, summary TEXT, content TEXT, seo_title TEXT, seo_description TEXT);
        CREATE TABLE IF NOT EXISTS testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT, client_name TEXT, client_country TEXT, client_avatar TEXT, rating INTEGER DEFAULT 5, content_en TEXT, content_vi TEXT, tour_name TEXT, is_featured INTEGER DEFAULT 1, sort_order INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS faqs (id INTEGER PRIMARY KEY AUTOINCREMENT, category TEXT DEFAULT 'general', question_en TEXT, answer_en TEXT, question_vi TEXT, answer_vi TEXT, sort_order INTEGER DEFAULT 0, status INTEGER DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS settings (setting_key TEXT PRIMARY KEY, setting_value TEXT);
        ";
        $pdo->exec($sqliteSchema);

        $seedFile = __DIR__ . '/../../database/seed.sql';
        if (file_exists($seedFile)) {
            $seedSql = file_get_contents($seedFile);
            $seedSql = preg_replace('#SET NAMES.*?;#i', '', $seedSql);
            $seedSql = preg_replace('#SET FOREIGN_KEY_CHECKS.*?;#i', '', $seedSql);
            $seedSql = preg_replace('#ON DUPLICATE KEY UPDATE.*?;#i', ';', $seedSql);
            $seedSql = preg_replace('#INSERT IGNORE INTO#i', 'INSERT OR IGNORE INTO', $seedSql);

            try {
                $pdo->exec($seedSql);
            } catch (\Throwable $e) {
                preg_match_all('#INSERT\s+(?:OR\s+IGNORE\s+)?INTO.*?\);#is', $seedSql, $matches);
                if (!empty($matches[0])) {
                    foreach ($matches[0] as $q) {
                        try { $pdo->exec($q); } catch (\Throwable $ex) {}
                    }
                }
            }
        }
    }
}

