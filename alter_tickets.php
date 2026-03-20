<?php
$conn = new mysqli("localhost", "root", "", "tiket_demo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqls = [
    "ALTER TABLE `tickets` ADD COLUMN `resolve` TEXT NULL AFTER `status`;",
    "ALTER TABLE `tickets` ADD COLUMN `reason` TEXT NULL AFTER `resolve`;",
    "ALTER TABLE `tickets` ADD COLUMN `closed_at` INT(11) NULL AFTER `reason`;"
];

foreach ($sqls as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Successfully ran: $sql\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}
$conn->close();
?>
