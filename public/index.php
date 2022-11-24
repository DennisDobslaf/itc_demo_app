<?php
require_once __DIR__ . '/../config/config.php';

$db = connectToDatabase();

$sql = '
SELECT  
    a.id, a.title, a.content, a.created, a.user_id, u.username, c.title AS category_title
FROM
    article a 
        JOIN user u ON a.user_id = u.id
        JOIN category c ON a.category_id = c.id
';

$articles = $db->query($sql, PDO::FETCH_ASSOC);
?>

<?php
include __DIR__ . '/../templates/html_header.php';
?>
<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            <?php foreach ($articles as $article) { ?>
                <!-- Post preview-->
                <div class="post-preview">
                    <a href="post.php">
                        <h2 class="post-title"><?php echo $article['title'] ?>
                            (Kategorie: <?php echo $article['category_title'] ?>)
                        </h2>
                        <h3 class="post-subtitle"><?php echo $article['content'] ?></h3>
                    </a>
                    <p class="post-meta">
                        Posted by <?php echo $article['username'] ?>
                        on <?php echo $article['created'] ?>

                        <?php if (userIsLoggedIn() && $article['user_id'] == $_SESSION['user_id']) { ?>
                            - <a href="article_edit.php?article_id=<?=$article['id']?>">Diesen Artikel bearbeiten</a>
                        <?php } ?>
                        <?php if (userIsLoggedIn() && $article['user_id'] == $_SESSION['user_id']) { ?>
                            - <a href="article_delete.php?article_id=<?=$article['id']?>">Diesen Artikel löschen</a>
                        <?php } ?>
                    </p>
                </div>
                <!-- Divider-->
                <hr class="my-4" />
            <?php } ?>

            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">Older Posts →</a></div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/../templates/html_footer.php';
?>