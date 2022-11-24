<?php
$articleId = (int)$_GET['article_id'];

require __DIR__ . '/../config/config.php';

if (!userIsLoggedIn()) {
    header('Location: login.php');
    exit();
}
$database = connectToDatabase();

$deleteStmt = $database->prepare('DELETE FROM article WHERE id = :id');
$deleteStmt->bindParam(':id', $articleId, PDO::PARAM_INT);
$deleteStmt->execute();

header('Location: index.php');
exit();