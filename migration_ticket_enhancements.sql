-- Migration Script for Ticket System Enhancements
-- Date: 2026-01-26
-- Description: Add fields for resolve, reason, closed_at tracking, and user login tracking

-- Add new fields to tickets table
ALTER TABLE `tickets` 
ADD COLUMN `resolve` TEXT DEFAULT NULL COMMENT 'Resolution notes when closing ticket' AFTER `data`,
ADD COLUMN `reason` TEXT DEFAULT NULL COMMENT 'Reason for On Hold or Cancelled status' AFTER `resolve`,
ADD COLUMN `closed_at` INT(11) DEFAULT NULL COMMENT 'Timestamp when ticket was closed or cancelled' AFTER `reason`;

-- Add new fields to users table for login tracking
ALTER TABLE `users` 
ADD COLUMN `last_login` INT(11) DEFAULT NULL COMMENT 'Timestamp of last login' AFTER `updated`,
ADD COLUMN `last_ip` VARCHAR(45) DEFAULT NULL COMMENT 'IP address of last login' AFTER `last_login`,
ADD COLUMN `last_os` VARCHAR(100) DEFAULT NULL COMMENT 'Operating system information' AFTER `last_ip`,
ADD COLUMN `last_pc_name` VARCHAR(100) DEFAULT NULL COMMENT 'PC/Device name' AFTER `last_os`;

-- Verify the changes
SELECT 'Tickets table columns added successfully' AS Status;
SELECT 'Users table columns added successfully' AS Status;
