-- ============================================================
-- UPGRADE: Database charset utf8 → utf8mb4
-- Diperlukan untuk support emoji dan karakter unicode modern
-- Jalankan di phpMyAdmin atau MySQL CLI
-- ============================================================

ALTER DATABASE `tiket_demo` CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

ALTER TABLE `users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `tickets` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `messages` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `attachments` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `mst_cabang` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `mst_divisi` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `mst_gender` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
