<?php
session_start();


function connectToDatabase(): ?PDO
{
    $databaseParams = [
        'dsn' => 'mysql:dbname=itc_blog;host=127.0.0.1;port=3306',
        'user' => 'root',
        'password' => '',
    ];

    try {
        $database = new PDO(
            $databaseParams['dsn'],
            $databaseParams['user'],
            $databaseParams['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );

        return $database;
    } catch (\Exception $e) {
        echo "Keine Verbindung zur Datenbank.";
        return null;
    }
}

function userIsLoggedIn(): bool
{
    return isset($_SESSION['userLoggedIn']);
}

