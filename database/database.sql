-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.37 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for campushub
CREATE DATABASE IF NOT EXISTS `campushub` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `campushub`;

-- Dumping structure for table campushub.announcements
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `created_by` int DEFAULT NULL,
  `for_students` tinyint(1) DEFAULT '1',
  `for_admins` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.announcements: ~5 rows (approximately)
INSERT INTO `announcements` (`id`, `title`, `content`, `category`, `priority`, `created_by`, `for_students`, `for_admins`, `is_active`, `created_date`) VALUES
	(1, 'Welcome to CampusHub', 'Welcome to the new student portal! Explore events, join communities, and connect with peers.', 'general', 'high', 1, 1, 0, 1, '2026-06-20 05:20:42'),
	(2, 'New Event Registration Open', 'Registration for Tech Bootcamp is now open. Join us for an exciting learning experience!', 'events', 'high', 1, 1, 0, 1, '2026-06-20 05:20:42'),
	(3, 'Admin Panel Updates', 'New features available in admin panel for event management.', 'admin', 'medium', 1, 0, 1, 1, '2026-06-20 05:20:42'),
	(4, 'Important Symposium Update', 'Please note that the AI Symposium will start at 10 AM sharp.', 'events', 'high', 1, 1, 0, 1, '2026-06-20 07:21:59'),
	(5, 'Important Symposium Update', 'Please note that the AI Symposium will start at 10 AM sharp.', 'events', 'high', 1, 1, 0, 1, '2026-06-20 07:22:30');

-- Dumping structure for table campushub.communities
CREATE TABLE IF NOT EXISTS `communities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT NULL,
  `community_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.communities: ~12 rows (approximately)
INSERT INTO `communities` (`id`, `name`, `description`, `category`, `community_image`) VALUES
	(1, 'Tech Club', 'For technology and coding enthusiasts', 'tech', NULL),
	(2, 'Arts & Culture', 'Creative arts and cultural activities', 'arts', NULL),
	(3, 'Sports Club', 'Sports and fitness activities', 'sports', NULL),
	(4, 'Debate Society', 'Debate competitions and discussions', 'debate', NULL),
	(5, 'Volunteer Network', 'Community service and volunteering', 'volunteer', NULL),
	(6, 'Music Club', 'Musicians and music lovers', 'music', NULL),
	(7, 'Tech Club', 'For technology and coding enthusiasts', 'tech', NULL),
	(8, 'Arts & Culture', 'Creative arts and cultural activities', 'arts', NULL),
	(9, 'Sports Club', 'Sports and fitness activities', 'sports', NULL),
	(10, 'Debate Society', 'Debate competitions and discussions', 'debate', NULL),
	(11, 'Volunteer Network', 'Community service and volunteering', 'volunteer', NULL),
	(12, 'Music Club', 'Musicians and music lovers', 'music', NULL);

-- Dumping structure for table campushub.community_channels
CREATE TABLE IF NOT EXISTS `community_channels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `community_id` int DEFAULT NULL,
  `channel_name` varchar(100) NOT NULL,
  `channel_type` enum('text','media','announcements') DEFAULT 'text',
  `description` text,
  PRIMARY KEY (`id`),
  KEY `community_id` (`community_id`),
  CONSTRAINT `community_channels_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.community_channels: ~36 rows (approximately)
INSERT INTO `community_channels` (`id`, `community_id`, `channel_name`, `channel_type`, `description`) VALUES
	(1, 1, 'general', 'text', 'General discussion'),
	(2, 1, 'media', 'media', 'Photos and videos'),
	(3, 1, 'announcements', 'announcements', 'Important announcements'),
	(4, 2, 'general', 'text', 'General discussion'),
	(5, 2, 'media', 'media', 'Photos and videos'),
	(6, 2, 'announcements', 'announcements', 'Important announcements'),
	(7, 3, 'general', 'text', 'General discussion'),
	(8, 3, 'media', 'media', 'Photos and videos'),
	(9, 3, 'announcements', 'announcements', 'Important announcements'),
	(10, 4, 'general', 'text', 'General discussion'),
	(11, 4, 'media', 'media', 'Photos and videos'),
	(12, 4, 'announcements', 'announcements', 'Important announcements'),
	(13, 5, 'general', 'text', 'General discussion'),
	(14, 5, 'media', 'media', 'Photos and videos'),
	(15, 5, 'announcements', 'announcements', 'Important announcements'),
	(16, 6, 'general', 'text', 'General discussion'),
	(17, 6, 'media', 'media', 'Photos and videos'),
	(18, 6, 'announcements', 'announcements', 'Important announcements'),
	(19, 7, 'general', 'text', 'General discussion'),
	(20, 7, 'media', 'media', 'Photos and videos'),
	(21, 7, 'announcements', 'announcements', 'Important announcements'),
	(22, 8, 'general', 'text', 'General discussion'),
	(23, 8, 'media', 'media', 'Photos and videos'),
	(24, 8, 'announcements', 'announcements', 'Important announcements'),
	(25, 9, 'general', 'text', 'General discussion'),
	(26, 9, 'media', 'media', 'Photos and videos'),
	(27, 9, 'announcements', 'announcements', 'Important announcements'),
	(28, 10, 'general', 'text', 'General discussion'),
	(29, 10, 'media', 'media', 'Photos and videos'),
	(30, 10, 'announcements', 'announcements', 'Important announcements'),
	(31, 11, 'general', 'text', 'General discussion'),
	(32, 11, 'media', 'media', 'Photos and videos'),
	(33, 11, 'announcements', 'announcements', 'Important announcements'),
	(34, 12, 'general', 'text', 'General discussion'),
	(35, 12, 'media', 'media', 'Photos and videos'),
	(36, 12, 'announcements', 'announcements', 'Important announcements');

-- Dumping structure for table campushub.community_members
CREATE TABLE IF NOT EXISTS `community_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `community_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `role` enum('member','moderator','admin') DEFAULT 'member',
  `join_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_member` (`community_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `community_members_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `community_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.community_members: ~1 rows (approximately)
INSERT INTO `community_members` (`id`, `community_id`, `user_id`, `role`, `join_date`) VALUES
	(15, 1, 1, 'member', '2026-06-20 12:46:37'),
	(16, 1, 14, 'member', '2026-06-20 17:41:18');

-- Dumping structure for table campushub.community_messages
CREATE TABLE IF NOT EXISTS `community_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `channel_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `message_text` text NOT NULL,
  `media_attachment` varchar(255) DEFAULT NULL,
  `message_type` enum('text','media','announcement') DEFAULT 'text',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `channel_id` (`channel_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `community_messages_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `community_channels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `community_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.community_messages: ~4 rows (approximately)
INSERT INTO `community_messages` (`id`, `channel_id`, `user_id`, `message_text`, `media_attachment`, `message_type`, `created_date`) VALUES
	(1, 1, NULL, 'Hello team! Testing community messaging from script.', NULL, 'text', '2026-06-20 07:21:59'),
	(2, 1, NULL, 'Hello team! Testing community messaging from script.', NULL, 'text', '2026-06-20 07:22:29'),
	(3, 1, 14, 'watch', NULL, 'text', '2026-06-20 17:41:53'),
	(4, 1, 14, 'Background', NULL, 'text', '2026-06-20 17:42:25');

-- Dumping structure for table campushub.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `event_date` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `max_capacity` int DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `organizer_id` int DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  PRIMARY KEY (`id`),
  KEY `organizer_id` (`organizer_id`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.events: ~8 rows (approximately)
INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `location`, `category`, `max_capacity`, `image_url`, `organizer_id`, `status`) VALUES
	(1, 'Tech Bootcamp', 'Learn web development basics', '2024-02-15 10:00:00', 'Room 101', 'technology', 50, NULL, 1, 'upcoming'),
	(2, 'Art Exhibition', 'Showcase of student artwork', '2024-02-20 14:00:00', 'Gallery Hall', 'arts', 100, NULL, 1, 'upcoming'),
	(3, 'Sports Day', 'Annual sports competition', '2024-02-28 08:00:00', 'Sports Field', 'sports', 200, NULL, 1, 'upcoming'),
	(4, 'Tech Bootcamp', 'Learn web development basics', '2024-02-15 10:00:00', 'Room 101', 'technology', 50, NULL, 1, 'upcoming'),
	(5, 'Art Exhibition', 'Showcase of student artwork', '2024-02-20 14:00:00', 'Gallery Hall', 'arts', 100, NULL, 1, 'upcoming'),
	(6, 'Sports Day', 'Annual sports competition', '2024-02-28 08:00:00', 'Sports Field', 'sports', 200, NULL, 1, 'upcoming'),
	(7, 'Test AI Symposium', 'A symposium testing API event generation.', '2026-06-30 09:21:59', 'Lecture Hall 4A', 'academic', 100, NULL, 1, 'upcoming'),
	(8, 'Test AI Symposium', 'A symposium testing API event generation.', '2026-06-30 09:22:29', 'Lecture Hall 4A', 'academic', 100, NULL, 1, 'upcoming');

-- Dumping structure for table campushub.event_groups
CREATE TABLE IF NOT EXISTS `event_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `group_name` varchar(100) NOT NULL,
  `description` text,
  `group_category` varchar(50) DEFAULT NULL,
  `max_members` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_groups_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.event_groups: ~18 rows (approximately)
INSERT INTO `event_groups` (`id`, `event_id`, `group_name`, `description`, `group_category`, `max_members`) VALUES
	(1, 1, 'Beginners', 'For beginners', 'level', 15),
	(2, 1, 'Intermediate', 'For intermediate learners', 'level', 20),
	(3, 1, 'Advanced', 'For advanced learners', 'level', 15),
	(4, 2, 'Beginners', 'For beginners', 'level', 15),
	(5, 2, 'Intermediate', 'For intermediate learners', 'level', 20),
	(6, 2, 'Advanced', 'For advanced learners', 'level', 15),
	(7, 3, 'Beginners', 'For beginners', 'level', 15),
	(8, 3, 'Intermediate', 'For intermediate learners', 'level', 20),
	(9, 3, 'Advanced', 'For advanced learners', 'level', 15),
	(10, 4, 'Beginners', 'For beginners', 'level', 15),
	(11, 4, 'Intermediate', 'For intermediate learners', 'level', 20),
	(12, 4, 'Advanced', 'For advanced learners', 'level', 15),
	(13, 5, 'Beginners', 'For beginners', 'level', 15),
	(14, 5, 'Intermediate', 'For intermediate learners', 'level', 20),
	(15, 5, 'Advanced', 'For advanced learners', 'level', 15),
	(16, 6, 'Beginners', 'For beginners', 'level', 15),
	(17, 6, 'Intermediate', 'For intermediate learners', 'level', 20),
	(18, 6, 'Advanced', 'For advanced learners', 'level', 15),
	(19, 7, 'AI Researchers', 'For students interested in research.', 'academic', 10),
	(20, 8, 'AI Researchers', 'For students interested in research.', 'academic', 10);

-- Dumping structure for table campushub.event_registrations
CREATE TABLE IF NOT EXISTS `event_registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `registration_status` enum('registered','attended','cancelled','pending') DEFAULT 'registered',
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `check_in_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `event_id` (`event_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `event_registrations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_registrations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_registrations_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `event_groups` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.event_registrations: ~0 rows (approximately)

-- Dumping structure for table campushub.forms
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) NOT NULL,
  `form_description` text,
  `form_type` varchar(50) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `form_status` enum('active','inactive','closed') DEFAULT 'active',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.forms: ~0 rows (approximately)
INSERT INTO `forms` (`id`, `form_name`, `form_description`, `form_type`, `created_by`, `form_status`, `created_date`) VALUES
	(1, 'AI Feedback Survey', 'Survey for the AI Symposium.', 'feedback', 1, 'active', '2026-06-20 07:22:30');

-- Dumping structure for table campushub.form_fields
CREATE TABLE IF NOT EXISTS `form_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int DEFAULT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_label` varchar(255) NOT NULL,
  `is_required` tinyint(1) DEFAULT '0',
  `field_options` text,
  `field_order` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `form_fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.form_fields: ~0 rows (approximately)
INSERT INTO `form_fields` (`id`, `form_id`, `field_name`, `field_type`, `field_label`, `is_required`, `field_options`, `field_order`) VALUES
	(1, 1, 'rating', 'select', 'How would you rate this symposium?', 1, '["Poor","Average","Excellent"]', 1);

-- Dumping structure for table campushub.form_submissions
CREATE TABLE IF NOT EXISTS `form_submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `submission_data` json NOT NULL,
  `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `form_submissions_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `form_submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.form_submissions: ~0 rows (approximately)

-- Dumping structure for table campushub.media
CREATE TABLE IF NOT EXISTS `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int DEFAULT NULL,
  `media_category` varchar(50) DEFAULT NULL,
  `description` text,
  `community_id` int DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `upload_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `community_id` (`community_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `media_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `media_ibfk_2` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE SET NULL,
  CONSTRAINT `media_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.media: ~2 rows (approximately)
INSERT INTO `media` (`id`, `user_id`, `file_name`, `file_path`, `file_type`, `file_size`, `media_category`, `description`, `community_id`, `event_id`, `upload_date`) VALUES
	(1, NULL, 'test_photo.jpg', 'uploads/6a363f97c7739_test_photo.jpg', 'image', 19, 'photo', 'A photo of the symposium event', NULL, 7, '2026-06-20 07:21:59'),
	(2, NULL, 'test_photo.jpg', 'uploads/6a363fb5f2b0d_test_photo.jpg', 'image', 19, 'photo', 'A photo of the symposium event', NULL, 8, '2026-06-20 07:22:29');

-- Dumping structure for table campushub.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student',
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `bio` text,
  `department` varchar(100) DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `full_name`, `phone`, `profile_photo`, `bio`, `department`, `registration_date`, `is_active`) VALUES
	(1, 'admin', 'admin@campushub.com', '$2y$10$EWvHmXETyx3wGtrDjiO.U.nju/HQrlpy2QgM4A3.JO813W7HMky3a', 'admin', 'Campus Administrator', NULL, NULL, NULL, NULL, '2026-06-20 05:18:55', 1),
	(14, 'imesh', 'vishmikaimesh@gmail.com', '$2y$10$g85Zn2JaeT33glrLC3ogV.vr6VsixagSXsaNZ8W6bhSrkSZtmj6lO', 'student', 'Imesh vishmika', NULL, NULL, NULL, 'Computer Science', '2026-06-20 14:23:17', 1);

-- Dumping structure for table campushub.user_notifications
CREATE TABLE IF NOT EXISTS `user_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `notification_type` varchar(50) NOT NULL,
  `notification_title` varchar(255) NOT NULL,
  `notification_message` text,
  `related_id` int DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table campushub.user_notifications: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
