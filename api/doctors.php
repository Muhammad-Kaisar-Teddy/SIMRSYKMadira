<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Include database connection
require_once '../db.php';

try {
    // Query untuk mengambil data dokter yang aktif
    $sql = "SELECT id, nama_dokter, spesialisasi, foto, email, telepon, jadwal_hari, jadwal_waktu 
            FROM doctors 
            WHERE status = 'aktif' 
            ORDER BY nama_dokter ASC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format response
    $response = [
        'success' => true,
        'data' => $doctors,
        'total' => count($doctors)
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch (PDOException $e) {
    // Error response
    $response = [
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
        'data' => []
    ];
    
    http_response_code(500);
    echo json_encode($response, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // General error response
    $response = [
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'data' => []
    ];
    
    http_response_code(500);
    echo json_encode($response, JSON_PRETTY_PRINT);
}
?>
