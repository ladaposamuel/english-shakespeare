<?php
require __DIR__ . "/vendor/autoload.php";
use Twilio\Rest\Client;
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


require 'functions.php';


$texts = "I want to drink Water";

echo convertToShakespeare($texts);