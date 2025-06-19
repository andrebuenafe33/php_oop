<?php

include_once '../Database/Dbconnection.php';
$conn = (new Dbconnection())->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO jobs (title, description, company, location) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['company'], $_POST['location']]);
    header('Location: admin_jobs.php');
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
            <h2 class="text-center">Add New Job</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter job title" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter job description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-control" placeholder="Enter company name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" placeholder="Enter location" required>
            </div>

            <button type="submit" class="btn btn-primary mr-1">Save Job</button>
            <a href="admin_jobs.php" class="btn btn-secondary "> Cancel</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>

