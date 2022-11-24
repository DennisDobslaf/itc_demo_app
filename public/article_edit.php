<?php
require __DIR__ . '/../config/config.php';

if (!userIsLoggedIn()) {
    header('Location: login.php');
    exit();
}
$database = connectToDatabase();

$categories = $database->query('SELECT * FROM category', PDO::FETCH_ASSOC);

$articleStmt = $database->prepare('SELECT * FROM article WHERE id = :id');
$articleStmt->bindParam(':id', $_REQUEST['article_id']);
$articleStmt->execute();
$articles = $articleStmt->fetchAll(PDO::FETCH_ASSOC);
$article = $articles[0];

if ($article['user_id'] != $_SESSION['user_id']) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['sendMessageButton'])) {
    try {
        $updateStatement = $database->prepare('
            UPDATE
                article 
            SET
                title = :title,
                content = :content,
                category_id = :category_id
            WHERE
                id = :id
            ');

        $updateStatement->bindParam(':id', $_POST['article_id']);
        $updateStatement->bindParam(':title', $_POST['title']);
        $updateStatement->bindParam(':content', $_POST['content']);
        $updateStatement->bindParam(':category_id', $_POST['category']);
        $updateStatement->execute();

        $_SESSION['success_message'] = 'Artikel erfolgreich bearbeitet';
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        var_dump($e->getMessage());
    }
}


include __DIR__ . '/../templates/html_header.php';
?>
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
<h1>Artikel bearbeiten</h1>

<form class="form" action="article_edit.php" method="post">
    <input type="hidden" name="article_id" value="<?=$article['id']?>">
    <div class="control-group">
        <div class="form-group floating-label-form-group controls">
            <label>Titel</label>
            <input name="title" value="<?=$article['title']?>" type="text" class="form-control" placeholder="Titel" id="title" required data-validation-required-message="Bitte einen Titel eingeben.">
            <p class="help-block text-danger"></p>
        </div>

        <div class="form-group controls">
            <label>Kategorie</label>

            <select name="category" class="form-control">
                <?php foreach ($categories as $category) { ?>
                    <option
                        value="<?php echo $category['id'] ?>"
                        <?php if ($category['id'] == $article['category_id']) { ?>selected="selected"<?php } ?>
                    ><?php echo $category['title'] ?></option>
                <?php } ?>
            </select>

            <p class="help-block text-danger"></p>
        </div>

        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label>Nachrichteninhalt</label>
                <textarea name="content" rows="5" class="form-control" placeholder="Content" id="content" required data-validation-required-message="Bitte Inhalt eingeben."><?=$article['content']?></textarea>
                <p class="help-block text-danger"></p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="sendMessageButton" name="sendMessageButton">Send</button>

    </div>



</form>
    </div>
</div>
<?php
include __DIR__ . '/../templates/html_footer.php';
?>
