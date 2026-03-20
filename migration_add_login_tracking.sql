-- Migration: Add login tracking columns to users table
-- Required by: User list page (tabler/list_users)
-- These columns are referenced by the DataTable but don't exist in the database yet.

ALTER TABLE `users`
  ADD COLUMN `last_login` INT(11) NULL DEFAULT NULL COMMENT 'Timestamp of last login' AFTER `status`,
  ADD COLUMN `last_ip` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Last login IP address' AFTER `last_login`,
  ADD COLUMN `last_os` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Last login OS info' AFTER `last_ip`,
  ADD COLUMN `last_pc_name` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Last login PC name' AFTER `last_os`;
