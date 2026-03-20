<?php
function test_ajax() {
    $url = 'http://localhost/tiket-master/API/Auth/login';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['username'=>'admin', 'password'=>'admin']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    $login_res = curl_exec($ch);
    
    $url2 = 'http://localhost/tiket-master/Tabler/list_my_tickets?type=all_tickets';
    curl_setopt($ch, CURLOPT_URL, $url2);
    curl_setopt($ch, CURLOPT_POST, 1);
    $dt_params = [
        'draw' => '1',
        'columns' => [
            ['data' => 'id'],
            ['data' => 'ticket_no'],
            ['data' => 'ticket_no'],
            ['data' => 'subject'],
            ['data' => 'title'],
            ['data' => 'severity'],
            ['data' => 'status'],
            ['data' => 'category'],
            ['data' => 'owner'],
            ['data' => 'assign_to'],
            ['data' => 'created'],
        ],
        'order' => [
            ['column' => '10', 'dir' => 'desc']
        ],
        'start' => '0',
        'length' => '10',
        'search' => ['value' => '', 'regex' => 'false']
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dt_params));
    $dt_res = curl_exec($ch);
    
    echo "HTTP CODE: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
    echo "RESPONSE:\n" . substr($dt_res, 0, 1000) . "...\n";
    
    // Check if JSON
    $json = json_decode($dt_res);
    if ($json) echo "\nVALID JSON!\n";
    else echo "\nINVALID JSON! Error: " . json_last_error_msg() . "\n";
    curl_close($ch);
}
test_ajax();
