-- Create rooms table
CREATE TABLE IF NOT EXISTS `#__hotelbooking_rooms` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `alias` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `capacity` int(11) NOT NULL DEFAULT 2,
    `base_price` decimal(10,2) NOT NULL,
    `status` enum('available','maintenance','blocked') NOT NULL DEFAULT 'available',
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_by` int(11) NOT NULL,
    `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `modified_by` int(11) NOT NULL,
    `state` tinyint(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

-- Create room images table
CREATE TABLE IF NOT EXISTS `#__hotelbooking_room_images` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `room_id` int(11) NOT NULL,
    `image_path` varchar(255) NOT NULL,
    `ordering` int(11) NOT NULL DEFAULT 0,
    `is_primary` tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `idx_room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;