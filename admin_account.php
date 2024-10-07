<?php
require_once '_guards.php';
require_once '_config.php';
Guard::adminOnly();

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Could not connect to the database " . DB_DATABASE . ": " . $e->getMessage());
}

$user = null; 

if (get('action') === 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Account</title>
    <link rel="icon" type="image/x-icon" href="icon.ico">
    <link rel="stylesheet" type="text/css" href="css/main-style.css">
    <link rel="stylesheet" type="text/css" href="css/admin-panel.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
</head>

<body>

    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>
            <div class="flex">
                <div class="category-form">
                    <span class="subtitle">
                        <?php if (get('action') === 'edit') : ?>
                            Edit User
                        <?php else : ?>
                            Add New User
                        <?php endif; ?>
                    </span>
                    <hr />

                    <div class="card">
                        <div class="card-content">
                            <form method="POST" action="api/user_controller.php">
                                <input type="hidden" name="action" value="<?= get('action') === 'edit' ? 'edit' : 'add' ?>" />
                                <input type="hidden" name="id" value="<?= isset($user) ? $user->id : '' ?>" />

                                <div class="form-control">
                                    <label>Name</label>
                                    <input value="<?= isset($user) ? $user->name : '' ?>" type="text" name="name" placeholder="Enter name" required="true" />
                                </div>

                                <div class="form-control">
                                    <label>Email</label>
                                    <input value="<?= isset($user) ? $user->email : '' ?>" type="email" name="email" placeholder="Enter email" required="true" />
                                </div>

                                <div class="form-control">
                                    <label>Role</label>
                                    <input value="<?= isset($user) ? $user->role : '' ?>" type="text" name="role" placeholder="Enter role" required="true" />
                                </div>

                                <div class="form-control">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Enter password" <?= get('action') === 'edit' ? '' : 'required="true"' ?> />
                                </div>

                                <div class="mt-16">
                                    <button class="btn btn-primary w-full" type="submit">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="category-table">
                    <span class="subtitle">User List</span>
                    <hr />

                    <?php displayFlashMessage('add_user') ?>
                    <?php displayFlashMessage('delete_user') ?>
                    <?php displayFlashMessage('update_user') ?>

                    <table id="userTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users ?? [] as $user) : ?>
                                <tr>
                                    <td><?= $user->name ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->role ?></td>
                                    <td>
                                        <a class="text-primary" href="?action=edit&id=<?= $user->id ?>">Edit</a>
                                        <a class="text-red-500 ml-16" href="api/delete_user.php?id=<?= $user->id ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                    </td> 
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>