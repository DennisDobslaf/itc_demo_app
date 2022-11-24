<?php
require __DIR__ . '/../config/config.php';

if (userIsLoggedIn()) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $database = connectToDatabase();
    $preparedStatement = $database->prepare('SELECT * FROM user WHERE username = :username');
    $preparedStatement->bindParam(':username', $username);

    $preparedStatement->execute();
    $foundUsers = $preparedStatement->rowCount();

    if ($foundUsers === 1) {
        $users = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
        $user = $users[0];

        if (password_verify($password, $user['password'])) {
            $_SESSION['userLoggedIn'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            $_SESSION['success_message'] = 'Erfolgreich angemeldet';

            header('Location: index.php');
            exit();
        }
    }
}


include __DIR__ . '/../templates/html_header.php';
?>
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <h1>Login</h1>

        <form class="form" action="login.php" method="post">
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Benutzername</label>
                    <input name="username" type="text" class="form-control" placeholder="Benutzername">
                </div>

                <div class="form-group floating-label-form-group controls">
                    <label>Kennwort</label>
                    <input name="password" type="password" class="form-control" placeholder="Kennwort">
                </div>

                <button type="submit" class="btn btn-primary" id="sendMessageButton" name="submit">Login</button>
            </div>
        </form>
    </div>
</div>
<?php
include __DIR__ . '/../templates/html_footer.php';
?>
