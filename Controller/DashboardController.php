<?php
require_once '../Database/Dbconnection.php';

class DashboardController {
    private $conn;

    public function __construct() {
        $this->conn = (new Dbconnection())->getConnection();
    }

    public function getDashboardData() {

        // Total number of users
        $stmt = $this->conn->query("SELECT COUNT(*) as user_count FROM users");
        $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];

        // Total number of jobs
        $stmt = $this->conn->query("SELECT COUNT(*) as job_count FROM jobs");
        $jobCount = $stmt->fetch(PDO::FETCH_ASSOC)['job_count'];
        

        return [
            'user_count' => $userCount,
            'job_count' => $jobCount
        ];
    }
}

?>