<?php 
require_once '../Database/Dbconnection.php';

class UserController {
    private $conn;

    public function __construct() {
        $this->conn = (new Dbconnection())->getConnection();
    }

    public function addUser($name, $password, $role, $email, $profilePicture) {
        $uploadFolder = "../uploads/";
        $fileName = uniqid() . '_' . basename($profilePicture["name"]); // Avoid duplicate names
        $targetFile = $uploadFolder . $fileName;
        $relativePath = 'uploads/' . $fileName; // Store this in DB

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate image
        $check = getimagesize($profilePicture["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($profilePicture["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            return;
        }

        if (move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars($fileName) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            return;
        }

        // Save 
        $stmt = $this->conn->prepare("INSERT INTO users (name, password, role, email, profile_picture) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, password_hash($password, PASSWORD_DEFAULT), $role, $email, $relativePath]);
    }


    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name, $role, $email, $profilePicture = null, $password = null) {
        $profilePath = null;
        $fields = "name = ?, role = ?, email = ?";  
        $params = [$name, $role, $email];

        // If new password is provided
        if (!empty($password)) {
            $fields .= ", password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        // If new profile picture is uploaded
        if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
            $uploadFolder = __DIR__ . '/../uploads/';
            $fileName = uniqid() . '_' . basename($profilePicture["name"]);
            $targetFile = $uploadFolder . $fileName;
            $relativePath = 'uploads/' . $fileName;

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            $check = getimagesize($profilePicture["tmp_name"]);
            if ($check === false) {
                echo "File is not an image."; $uploadOk = 0;
            }
            if ($profilePicture["size"] > 500000) {
                echo "Sorry, your file is too large."; $uploadOk = 0;
            }
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                echo "Only JPG, JPEG, PNG, and GIF allowed."; $uploadOk = 0;
            }

            if ($uploadOk) {
                if (move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
                    $fields .= ", profile_picture = ?";
                    $params[] = $relativePath;
                } else {
                    echo "Failed to upload profile image.";
                    return;
                }
            } else {
                return; 
            }
        }

        $fields .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->conn->prepare("UPDATE users SET $fields");
        $stmt->execute($params);
    }



    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>
