<?php
session_start();
require_once '../Controller/UserController.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$userController = new UserController();

if (!isset($_GET['id'])) {
    echo "User ID is missing.";
    exit();
}

$id = $_GET['id'];
$user = $userController->getUserById($id);

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'] ?? null;
    $profile = $_FILES['profile_picture'] ?? null;

    $userController->updateUser($id, $username, $role, $email, $profile, $password);

    header("Location: admin_users.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:rgba(10, 95, 223, 0.76);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .edit-job-form {
            background: white;
            /* padding: 30px; */
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            /* width: 100%; */
            /* max-width: 600px; */
        }
        .edit-job-form h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="edit-job-form col-md-8">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Edit User</h2>
        </div>
         <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                 <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Select Role --</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="employer" <?= $user['role'] === 'employer' ? 'selected' : '' ?>>Employer</option>
                        <option value="seeker" <?= $user['role'] === 'seeker' ? 'selected' : '' ?>>Seeker</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required value="<?= htmlspecialchars($user['password']); ?>">
                </div>

                <button type="submit" class="btn btn-success mr-1">Update User</button>
                <a href="admin_users.php" class="btn btn-secondary"> Cancel</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>

