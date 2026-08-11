<?php
// Vercel Serverless PHP Front Controller Entry Point
$_SERVER['SCRIPT_NAME'] = '/index.php';
require_once __DIR__ . '/../public/index.php';
