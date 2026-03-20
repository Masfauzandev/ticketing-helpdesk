-- ============================================================
-- UPGRADE: Password column VARCHAR(50) → VARCHAR(255)
-- Diperlukan agar bisa menyimpan bcrypt hash ($2y$...)
-- Jalankan di phpMyAdmin atau MySQL CLI
-- ============================================================

ALTER TABLE `users` MODIFY `password` VARCHAR(255) NOT NULL;
