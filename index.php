<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Serve a static home page if the root URL is accessed
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '') {
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujju Quotes App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
            color: #333;
        }
        header {
            background: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header img {
            height: 50px;
        }
       
        .circle-image {
            width: 78px; /* Adjust the size as needed */
            height: 78px; /* Ensure width and height are equal for a perfect circle */
            border-radius: 50%; /* Makes the image circular */
            object-fit: cover; /* Ensures the image covers the circular area without stretching */
        }
  
        header nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }
        header nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #0056b3;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
        }
        .categories {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        .category {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: white;
            width: 200px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .category:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        footer {
            background: #007bff;
            color: white;
            text-align: center;
            padding: 10px 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="/images/app_logo.png" alt="Gujju Quotes App Logo" class="circle-image">
        </div>
        <nav>
            <a href="/">Home</a>
            <a href="/api">Explore API</a>
            <a href="#categories">Categories</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>
    <div class="container">
        <h1>Welcome to Gujju Quotes App</h1>
        <p>Discover a world of inspiring, humorous, and thought-provoking quotes across various categories!</p>
        <div class="categories" id="categories">
            <div class="category">Motivational Quotes</div>
            <div class="category">Funny Quotes</div>
            <div class="category">Love Quotes</div>
            <div class="category">Life Quotes</div>
            <div class="category">Friendship Quotes</div>
        </div>
        <a href="/api" class="btn">Explore All Quotes</a>
    </div>
    <footer>
        © 2025 Gujju Quotes App. All Rights Reserved.
    </footer>
</body>
</html>
HTML;
    exit;
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/bootstrap/app.php')
    ->handleRequest(Request::capture());
