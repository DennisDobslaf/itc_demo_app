<?php
require __DIR__ . '/../config/config.php';

if (!userIsLoggedIn()) {
    header('Location: login.php');
    exit();
}

$database = connectToDatabase();

$categories = $database->query('SELECT * FROM category', PDO::FETCH_ASSOC);

if (isset($_POST['sendMessageButton'])) {
    try {
        $insertStatement = $database->prepare('INSERT INTO article (title, content, created, user_id, category_id) VALUES (:title, :content, :created, :user_id, :category_id)');

        $now = new DateTime('now');
        $createdAt = $now->format('Y-m-d H:i:s');

        $userid = $_SESSION['user_id'];
        $categoryid = $_POST['category'];
        $insertStatement->bindParam(':title', $_POST['title']);
        $insertStatement->bindParam(':content', $_POST['content']);
        $insertStatement->bindParam(':created', $createdAt);
        $insertStatement->bindParam(':user_id', $userid);
        $insertStatement->bindParam(':category_id', $categoryid);
        $insertStatement->execute();

        $_SESSION['success_message'] = 'Artikel erfolgreich angelegt';
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
<h1>Neuen Artikel anlegen</h1>

<form class="form" action="article_create.php" method="post">
    <div class="control-group">
        <div class="form-group floating-label-form-group controls">
            <label>Titel</label>
            <input name="title" type="text" class="form-control" placeholder="Titel" id="title" required data-validation-required-message="Bitte einen Titel eingeben.">
            <p class="help-block text-danger"></p>
        </div>

        <div class="form-group controls">
            <label>Kategorie</label>

            <select name="category" class="form-control">
                <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['title'] ?></option>
                <?php } ?>
            </select>

            <p class="help-block text-danger"></p>
        </div>

        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label>Nachrichteninhalt</label>
                <textarea name="content" rows="5" class="form-control" placeholder="Content" id="content" required data-validation-required-message="Bitte Inhalt eingeben."></textarea>
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
