-- Create and Populate Master Tables for Categories and Severities

-- ----------------------------
-- Table structure for mst_category
-- ----------------------------
DROP TABLE IF EXISTS `mst_category`;
CREATE TABLE `mst_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_cat_name` (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Populate mst_category with existing constant values
-- IDs are explicitly set to matching existing array indices (0-based) to preserve data integrity
INSERT INTO `mst_category` (`id`, `category_name`, `is_active`) VALUES 
(0, 'Bug', 1),
(1, 'Feature requests', 1),
(2, 'Software Troubleshooting', 1),
(3, 'How to', 1),
(4, 'Password Reset', 1),
(5, 'Network', 1),
(6, 'Hardware', 1),
(7, 'Access and Authorization', 1);


-- ----------------------------
-- Table structure for mst_severity
-- ----------------------------
DROP TABLE IF EXISTS `mst_severity`;
CREATE TABLE `mst_severity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `severity_val` int(11) NOT NULL,
  `severity_name` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_sev_name` (`severity_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Populate mst_severity with existing constant values
INSERT INTO `mst_severity` (`severity_val`, `severity_name`, `is_active`) VALUES 
(0, 'Low', 1),
(5, 'Medium', 1),
(10, 'High', 1);
