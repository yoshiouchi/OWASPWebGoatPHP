<?php

header('Content-Type: application/json; charset=UTF-8');

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit(json_encode(array('error' => 'An id parameter is required.')));
}

$database = new PDO('sqlite::memory:');
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->exec('CREATE TABLE employees (id INTEGER PRIMARY KEY, name TEXT, salary INTEGER)');
$database->exec("INSERT INTO employees VALUES
    (1, 'Training Employee One', 50000),
    (2, 'Training Employee Two', 90000)");

$records = $database->query('SELECT id, name, salary FROM employees WHERE id = '.$_GET['id']);
echo json_encode($records->fetchAll(PDO::FETCH_ASSOC));
