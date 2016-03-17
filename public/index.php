<?php
require '../vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();
require '../config/config.php';
require '../config/database.php';
require '../app/Routes.php';