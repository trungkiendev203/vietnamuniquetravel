<?php
/**
 * Database Migration Script with SQLite/MySQL dual support
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

use App\Config\Database;

try {
    $db = Database::getConnection();
    $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
    echo "Connected to Database driver [{$driver}] via PDO successfully.\n";

    if ($driver === 'sqlite') {
        // SQLite setup
        $sqliteSchema = "
        CREATE TABLE IF NOT EXISTS admins (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          username TEXT UNIQUE,
          email TEXT UNIQUE,
          password TEXT,
          name TEXT,
          role TEXT DEFAULT 'admin',
          status INTEGER DEFAULT 1,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS destinations (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          slug TEXT UNIQUE,
          image TEXT,
          is_featured INTEGER DEFAULT 0,
          sort_order INTEGER DEFAULT 0,
          status INTEGER DEFAULT 1,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS destination_translations (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          destination_id INTEGER,
          lang TEXT,
          name TEXT,
          short_description TEXT,
          description TEXT,
          seo_title TEXT,
          seo_description TEXT
        );

        CREATE TABLE IF NOT EXISTS categories (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          slug TEXT UNIQUE,
          icon TEXT,
          image TEXT,
          sort_order INTEGER DEFAULT 0,
          status INTEGER DEFAULT 1,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS category_translations (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          category_id INTEGER,
          lang TEXT,
          name TEXT,
          description TEXT
        );

        CREATE TABLE IF NOT EXISTS tours (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          code TEXT UNIQUE,
          slug TEXT UNIQUE,
          destination_id INTEGER,
          duration_type TEXT DEFAULT 'fullday',
          duration_days INTEGER DEFAULT 1,
          difficulty TEXT DEFAULT 'easy',
          transportation TEXT,
          group_size TEXT,
          price_from_usd REAL DEFAULT 0,
          price_from_vnd INTEGER DEFAULT 0,
          featured_image TEXT,
          is_featured INTEGER DEFAULT 0,
          is_signature INTEGER DEFAULT 0,
          signature_number INTEGER DEFAULT 0,
          sort_order INTEGER DEFAULT 0,
          status INTEGER DEFAULT 1,
          views INTEGER DEFAULT 0,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS tour_translations (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          tour_id INTEGER,
          lang TEXT,
          title TEXT,
          sub_title TEXT,
          short_description TEXT,
          highlights TEXT,
          overview TEXT,
          inclusions TEXT,
          exclusions TEXT,
          what_to_bring TEXT,
          child_policy TEXT,
          cancellation_policy TEXT,
          seo_title TEXT,
          seo_description TEXT
        );

        CREATE TABLE IF NOT EXISTS tour_categories (
          tour_id INTEGER,
          category_id INTEGER,
          PRIMARY KEY (tour_id, category_id)
        );

        CREATE TABLE IF NOT EXISTS tour_images (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          tour_id INTEGER,
          image_path TEXT,
          caption TEXT,
          sort_order INTEGER DEFAULT 0
        );

        CREATE TABLE IF NOT EXISTS tour_itinerary_steps (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          tour_id INTEGER,
          step_time TEXT,
          sort_order INTEGER DEFAULT 0,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS tour_itinerary_translations (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          step_id INTEGER,
          lang TEXT,
          title TEXT,
          description TEXT
        );

        CREATE TABLE IF NOT EXISTS tour_prices (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          tour_id INTEGER,
          transport_type TEXT DEFAULT 'motorbike',
          pax_tier TEXT,
          price_vnd INTEGER,
          price_usd REAL,
          note TEXT
        );

        CREATE TABLE IF NOT EXISTS bookings (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          booking_code TEXT UNIQUE,
          tour_id INTEGER,
          tour_name TEXT,
          travel_date DATE,
          adults INTEGER DEFAULT 1,
          children INTEGER DEFAULT 0,
          fullname TEXT,
          nationality TEXT,
          email TEXT,
          phone_whatsapp TEXT,
          pickup_location TEXT,
          dietary_requirements TEXT,
          health_notes TEXT,
          special_requests TEXT,
          status TEXT DEFAULT 'new',
          internal_notes TEXT,
          email_sent_admin INTEGER DEFAULT 0,
          email_sent_customer INTEGER DEFAULT 0,
          email_error_log TEXT,
          ip_address TEXT,
          user_agent TEXT,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS posts (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          slug TEXT UNIQUE,
          featured_image TEXT,
          is_featured INTEGER DEFAULT 0,
          status INTEGER DEFAULT 1,
          views INTEGER DEFAULT 0,
          published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS post_translations (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          post_id INTEGER,
          lang TEXT,
          title TEXT,
          summary TEXT,
          content TEXT,
          seo_title TEXT,
          seo_description TEXT
        );

        CREATE TABLE IF NOT EXISTS testimonials (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          client_name TEXT,
          client_country TEXT,
          client_avatar TEXT,
          rating INTEGER DEFAULT 5,
          content_en TEXT,
          content_vi TEXT,
          tour_name TEXT,
          is_featured INTEGER DEFAULT 1,
          sort_order INTEGER DEFAULT 0,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS faqs (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          category TEXT DEFAULT 'general',
          question_en TEXT,
          answer_en TEXT,
          question_vi TEXT,
          answer_vi TEXT,
          sort_order INTEGER DEFAULT 0,
          status INTEGER DEFAULT 1,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS settings (
          setting_key TEXT PRIMARY KEY,
          setting_value TEXT
        );

        CREATE TABLE IF NOT EXISTS tour_reviews (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          tour_id INTEGER NOT NULL,
          booking_id INTEGER,
          client_name TEXT NOT NULL,
          email TEXT NOT NULL,
          rating INTEGER DEFAULT 5,
          content TEXT NOT NULL,
          status TEXT DEFAULT 'pending',
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS admin_notifications (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          type TEXT DEFAULT 'booking',
          booking_id INTEGER,
          title TEXT NOT NULL,
          message TEXT NOT NULL,
          link TEXT,
          is_read INTEGER DEFAULT 0,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        ";
        $db->exec($sqliteSchema);
        echo "SQLite Schema applied.\n";

        // Read seed and adapt ON DUPLICATE KEY UPDATE / SET commands
        $seedSql = file_get_contents(__DIR__ . '/seed.sql');
        $seedSql = preg_replace('#SET NAMES.*?;#i', '', $seedSql);
        $seedSql = preg_replace('#SET FOREIGN_KEY_CHECKS.*?;#i', '', $seedSql);
        $seedSql = preg_replace('#ON DUPLICATE KEY UPDATE.*?;#i', ';', $seedSql);
        
        $queries = array_filter(explode(';', $seedSql));
        foreach ($queries as $q) {
            $q = trim($q);
            if ($q) {
                try {
                    $db->exec($q);
                } catch (\Throwable $e) {
                    // Ignore duplicate key errors on seed re-runs
                }
            }
        }
        echo "SQLite Seed applied.\n";

    } else {
        // MySQL Execution
        $schemaSql = file_get_contents(__DIR__ . '/schema.sql');
        $seedSql = file_get_contents(__DIR__ . '/seed.sql');
        $db->exec($schemaSql);
        $db->exec($seedSql);
        echo "MySQL Schema and Seed applied successfully.\n";
    }

} catch (\Throwable $e) {
    echo "Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
