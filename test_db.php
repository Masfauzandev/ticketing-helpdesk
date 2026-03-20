<?php
$mysqli = new mysqli("localhost", "root", "", "tiket_demo");
$res = $mysqli->query("SHOW COLUMNS FROM tickets");
if ($res) {
    while($row = $res->fetch_assoc()) {
        print_r($row);
    }
}
?>
