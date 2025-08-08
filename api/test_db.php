<?php
// File untuk testing koneksi dan database
header('Content-Type: application/json');

require_once '../db.php';

try {
    // Test koneksi PDO
    $pdo->query("SELECT 1");
    $response['pdo_connection'] = 'OK';
    
    // Check if doctors table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'doctors'");
    $tableExists = $stmt->rowCount() > 0;
    $response['doctors_table_exists'] = $tableExists;
    
    if ($tableExists) {
        // Count doctors
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM doctors");
        $count = $stmt->fetch()['count'];
        $response['doctors_count'] = $count;
        
        // Get sample data
        $stmt = $pdo->query("SELECT * FROM doctors LIMIT 3");
        $response['sample_doctors'] = $stmt->fetchAll();
    }
    
    $response['success'] = true;
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
