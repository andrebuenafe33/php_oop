<?php
include_once '../Database/Dbconnection.php';
include_once '../Controller/UserController.php';

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];  
    $profilePicture = $_FILES['profile_picture'];

    $userController->addUser($name, $password, $role, $email, $profilePicture);
    
    header("Location: admin_users.php"); 
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:rgba(10, 95, 223, 0.76);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .job-form {
            background: white;
            /* padding: 30px; */
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            /* width: 100%; */
            /* max-width: 600px; */
        }
        .job-form h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>


<div class="job-form col-md-8">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Add New User</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email"required></input>
            </div>

           <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Select Role --</option>
                    <option value="employer">Employer</option>
                    <option value="admin">Admin</option>
                    <option value="seeker">Seeker</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>

            <button type="submit" class="btn btn-primary mr-1">Save User</button>
            <a href="admin_users.php" class="btn btn-secondary "> Cancel</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>

