<?php

$data_source_name = 'mysql:host=localhost;dbname=store';
$username = 'storeuser';
$password = 'test';
$database = new PDO($data_source_name, $username, $password);