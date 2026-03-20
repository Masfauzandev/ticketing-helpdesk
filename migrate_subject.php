<?php
$mysqli = new mysqli("localhost", "root", "", "tiket_demo");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$q1 = "CREATE TABLE IF NOT EXISTS `mst_subject` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `is_active` TINYINT(1) DEFAULT 1
)";

$q2 = "ALTER TABLE `tickets` ADD COLUMN `title` VARCHAR(255) NULL AFTER `subject`";

if ($mysqli->query($q1)) {
    echo "mst_subject created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error . "\n";
}

if ($mysqli->query($q2)) {
    echo "tickets altered successfully\n";
} else {
    echo "Error altering table: " . $mysqli->error . "\n";
}
?>
