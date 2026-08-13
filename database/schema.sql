-- Database Schema for Vietnam Unique Travel
-- Compatible with MySQL 5.7+ / 8.0+ / MariaDB / phpMyAdmin

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Admins Table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `role` VARCHAR(20) DEFAULT 'admin',
  `status` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Destinations Table
CREATE TABLE IF NOT EXISTS `destinations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `image` VARCHAR(255) NULL,
  `is_featured` TINYINT(1) DEFAULT 0,
  `sort_order` INT DEFAULT 0,
  `status` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_dest_slug` (`slug`),
  INDEX `idx_dest_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Destination Translations
CREATE TABLE IF NOT EXISTS `destination_translations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `destination_id` INT UNSIGNED NOT NULL,
  `lang` VARCHAR(5) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `short_description` TEXT NULL,
  `description` LONGTEXT NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  UNIQUE KEY `uk_dest_lang` (`destination_id`, `lang`),
  FOREIGN KEY (`destination_id`) REFERENCES `destinations`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Categories Table (Experiences)
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `icon` VARCHAR(50) NULL,
  `image` VARCHAR(255) NULL,
  `sort_order` INT DEFAULT 0,
  `status` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_cat_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Category Translations
CREATE TABLE IF NOT EXISTS `category_translations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NOT NULL,
  `lang` VARCHAR(5) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  UNIQUE KEY `uk_cat_lang` (`category_id`, `lang`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tours Table
CREATE TABLE IF NOT EXISTS `tours` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(20) NOT NULL UNIQUE,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `destination_id` INT UNSIGNED NULL,
  `duration_type` ENUM('halfday', 'fullday', 'multiday') DEFAULT 'fullday',
  `duration_days` INT DEFAULT 1,
  `difficulty` ENUM('easy', 'medium', 'hard') DEFAULT 'easy',
  `transportation` VARCHAR(100) NULL,
  `group_size` VARCHAR(50) NULL,
  `price_from_usd` DECIMAL(10,2) DEFAULT 0.00,
  `price_from_vnd` INT UNSIGNED DEFAULT 0,
  `featured_image` VARCHAR(255) NULL,
  `is_featured` TINYINT(1) DEFAULT 0,
  `is_signature` TINYINT(1) DEFAULT 0,
  `signature_number` INT DEFAULT 0,
  `sort_order` INT DEFAULT 0,
  `status` TINYINT(1) DEFAULT 1,
  `views` INT UNSIGNED DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_tours_code` (`code`),
  INDEX `idx_tours_slug` (`slug`),
  INDEX `idx_tours_status` (`status`),
  INDEX `idx_tours_featured` (`is_featured`),
  FOREIGN KEY (`destination_id`) REFERENCES `destinations`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tour Translations
CREATE TABLE IF NOT EXISTS `tour_translations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT UNSIGNED NOT NULL,
  `lang` VARCHAR(5) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `sub_title` VARCHAR(255) NULL,
  `short_description` TEXT NULL,
  `highlights` TEXT NULL,
  `overview` LONGTEXT NULL,
  `inclusions` TEXT NULL,
  `exclusions` TEXT NULL,
  `what_to_bring` TEXT NULL,
  `child_policy` TEXT NULL,
  `cancellation_policy` TEXT NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  UNIQUE KEY `uk_tour_lang` (`tour_id`, `lang`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tour Categories pivot
CREATE TABLE IF NOT EXISTS `tour_categories` (
  `tour_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`tour_id`, `category_id`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tour Images
CREATE TABLE IF NOT EXISTS `tour_images` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT UNSIGNED NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255) NULL,
  `sort_order` INT DEFAULT 0,
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Tour Itinerary Steps
CREATE TABLE IF NOT EXISTS `tour_itinerary_steps` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT UNSIGNED NOT NULL,
  `step_time` VARCHAR(50) NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Tour Itinerary Step Translations
CREATE TABLE IF NOT EXISTS `tour_itinerary_translations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `step_id` INT UNSIGNED NOT NULL,
  `lang` VARCHAR(5) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  UNIQUE KEY `uk_step_lang` (`step_id`, `lang`),
  FOREIGN KEY (`step_id`) REFERENCES `tour_itinerary_steps`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Tour Prices
CREATE TABLE IF NOT EXISTS `tour_prices` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT UNSIGNED NOT NULL,
  `transport_type` ENUM('motorbike', 'car', 'walking') DEFAULT 'motorbike',
  `pax_tier` VARCHAR(50) NOT NULL,
  `price_vnd` INT UNSIGNED NOT NULL,
  `price_usd` DECIMAL(10,2) NOT NULL,
  `note` VARCHAR(255) NULL,
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Bookings Table
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_code` VARCHAR(30) NOT NULL UNIQUE,
  `tour_id` INT UNSIGNED NULL,
  `tour_name` VARCHAR(255) NOT NULL,
  `travel_date` DATE NOT NULL,
  `adults` INT UNSIGNED NOT NULL DEFAULT 1,
  `children` INT UNSIGNED DEFAULT 0,
  `fullname` VARCHAR(100) NOT NULL,
  `nationality` VARCHAR(100) NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone_whatsapp` VARCHAR(50) NOT NULL,
  `pickup_location` TEXT NOT NULL,
  `dietary_requirements` TEXT NULL,
  `health_notes` TEXT NULL,
  `special_requests` TEXT NULL,
  `status` ENUM('new', 'contacted', 'confirmed', 'completed', 'cancelled') DEFAULT 'new',
  `internal_notes` TEXT NULL,
  `email_sent_admin` TINYINT(1) DEFAULT 0,
  `email_sent_customer` TINYINT(1) DEFAULT 0,
  `email_error_log` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_booking_code` (`booking_code`),
  INDEX `idx_booking_status` (`status`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Posts Table (Blog & Travel Guide)
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `featured_image` VARCHAR(255) NULL,
  `is_featured` TINYINT(1) DEFAULT 0,
  `status` TINYINT(1) DEFAULT 1,
  `views` INT UNSIGNED DEFAULT 0,
  `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_posts_slug` (`slug`),
  INDEX `idx_posts_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Post Translations
CREATE TABLE IF NOT EXISTS `post_translations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `post_id` INT UNSIGNED NOT NULL,
  `lang` VARCHAR(5) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `summary` TEXT NULL,
  `content` LONGTEXT NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  UNIQUE KEY `uk_post_lang` (`post_id`, `lang`),
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Testimonials Table
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(100) NOT NULL,
  `client_country` VARCHAR(100) NULL,
  `client_avatar` VARCHAR(255) NULL,
  `rating` TINYINT UNSIGNED DEFAULT 5,
  `content_en` TEXT NOT NULL,
  `content_vi` TEXT NULL,
  `tour_name` VARCHAR(150) NULL,
  `is_featured` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 17. FAQs Table
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category` VARCHAR(50) DEFAULT 'general',
  `question_en` TEXT NOT NULL,
  `answer_en` TEXT NOT NULL,
  `question_vi` TEXT NULL,
  `answer_vi` TEXT NULL,
  `sort_order` INT DEFAULT 0,
  `status` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 18. Media Table
CREATE TABLE IF NOT EXISTS `media` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_size` INT UNSIGNED DEFAULT 0,
  `mime_type` VARCHAR(50) NULL,
  `alt_text` VARCHAR(255) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 19. Settings Table
CREATE TABLE IF NOT EXISTS `settings` (
  `setting_key` VARCHAR(100) PRIMARY KEY,
  `setting_value` LONGTEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 20. Tour Reviews Table
CREATE TABLE IF NOT EXISTS `tour_reviews` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tour_id` INT UNSIGNED NOT NULL,
  `booking_id` INT UNSIGNED NULL,
  `client_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
  `content` TEXT NOT NULL,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_reviews_tour_status` (`tour_id`, `status`),
  INDEX `idx_reviews_booking` (`booking_id`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 21. Admin Notifications Table
CREATE TABLE IF NOT EXISTS `admin_notifications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) DEFAULT 'booking',
  `booking_id` INT UNSIGNED NULL,
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `link` VARCHAR(255) NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_notif_read` (`is_read`),
  INDEX `idx_notif_booking` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

