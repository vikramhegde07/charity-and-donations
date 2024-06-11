<?php

include '../includes/config.php';
include './includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        createUser($_POST['username'], $_POST['email'], $_POST['password']);
    } elseif (isset($_POST['delete'])) {
        deleteUser($_POST['delete_id']);
    } elseif (isset($_POST['create_admin'])) {
        createAdmin($_POST['admin_name'], $_POST['admin_email'], $_POST['admin_password']);
    } elseif (isset($_POST['delete_admin'])) {
        echo $_POST['delete_admin_id'];
        deleteAdmin($_POST['delete_admin_id']);
    }
}

$users = getUsers();
$admins = getAdmins();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <?php
            $sql = "SELECT count(id) as total from users;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                $total = $row['total'];
            ?>
            <div class="col-md-4">
                <div class="block-48">
                    <span class="block-48-text-1">Total Volunteers</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="#manage" class="btn btn-white px-3 py-2">Manage Volunteers</a></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="block-48">

                    <h2>Add new admin</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control py-2" id="name" name="admin_name" placeholder="Enter admin name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control py-2" id="email" name="admin_email" placeholder="Enter admin email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control py-2" id="password" name="admin_password" placeholder="Enter password for admin">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-white px-5 py-2" name="create_admin" value="Add admin">
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="block-48">

                    <h2>Add new Volunteer</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control py-2" id="name" name="username" placeholder="Enter volunteer name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control py-2" id="email" name="email" placeholder="Enter volunteer email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control py-2" id="password" name="password" placeholder="Enter password for volunteer">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-white px-5 py-2" name="create" value="Add Volunteer">
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="container mt-5" id="manage">
            <h2>Manage Volunteers</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Volunteer Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>

                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-primary btn-sm">Delete</button>
                                </form>
                                <!-- Add edit functionality here if needed -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="container mt-5" id="manage">
            <h2>Manage Admins</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($admin = $admins->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admin['id']); ?></td>
                            <td><?php echo htmlspecialchars($admin['adminName']); ?></td>
                            <td><?php echo htmlspecialchars($admin['email']); ?></td>

                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="delete_admin_id" value="<?php echo $admin['id']; ?>">
                                    <button type="submit" name="delete_admin" class="btn btn-primary btn-sm">Delete</button>
                                </form>
                                <!-- Add edit functionality here if needed -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

</body>

</html>