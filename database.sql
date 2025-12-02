-- Donation/Charity Website Database Schema
-- Database: donation
-- User: root
-- Password: (empty)

CREATE DATABASE IF NOT EXISTS `donation` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `donation`;

-- Admins table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Campaigns table
CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `goal_amount` decimal(10,2) NOT NULL,
  `collected_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Donations table
CREATE TABLE IF NOT EXISTS `donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `donor_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `message` text DEFAULT NULL,
  `proof_file` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `donated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `donated_at` (`donated_at`),
  CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin (password: admin123)
-- Email: admin@donation.com
-- Password: admin123 (hashed with password_hash)
INSERT INTO `admins` (`name`, `email`, `password`) VALUES
('Administrator', 'admin@donation.com', '$2y$10$SecvUAgJbURiI9H/zz7psOa6UBXVN5pzU1Sn1DjKgCEUmBcl/vgt2');

-- Sample campaigns
INSERT INTO `campaigns` (`title`, `description`, `goal_amount`, `collected_amount`, `deadline`) VALUES
('Education for All', 'Help us provide quality education to underprivileged children in rural areas. Your donation will fund school supplies, books, and educational programs.', 50000.00, 12500.00, '2024-12-31'),
('Clean Water Initiative', 'Building wells and water purification systems in communities without access to clean drinking water. Every dollar helps save lives.', 75000.00, 32000.00, '2024-11-30'),
('Emergency Relief Fund', 'Support families affected by natural disasters. This fund provides immediate aid including food, shelter, and medical supplies.', 100000.00, 45000.00, '2024-12-31');

