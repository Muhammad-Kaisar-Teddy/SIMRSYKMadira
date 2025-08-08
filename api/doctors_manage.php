<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Include database connection
require_once '../db.php';

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';
    
    switch ($action) {
        case 'add':
            addDoctor($pdo, $input);
            break;
            
        case 'update':
            updateDoctor($pdo, $input);
            break;
            
        case 'delete':
            deleteDoctor($pdo, $input);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    
    http_response_code(400);
    echo json_encode($response);
}

function addDoctor($pdo, $data) {
    $sql = "INSERT INTO doctors (nama_dokter, spesialisasi, foto, email, telepon, jadwal_hari, jadwal_waktu) 
            VALUES (:nama_dokter, :spesialisasi, :foto, :email, :telepon, :jadwal_hari, :jadwal_waktu)";
    
    $stmt = $pdo->prepare($sql);
    
    // Generate foto dummy jika tidak diisi
    $foto = !empty($data['foto']) ? $data['foto'] : generateDummyPhoto($data['nama_dokter']);
    
    $stmt->execute([
        ':nama_dokter' => $data['nama_dokter'],
        ':spesialisasi' => $data['spesialisasi'],
        ':foto' => $foto,
        ':email' => $data['email'] ?? null,
        ':telepon' => $data['telepon'] ?? null,
        ':jadwal_hari' => $data['jadwal_hari'],
        ':jadwal_waktu' => $data['jadwal_waktu']
    ]);
    
    $response = [
        'success' => true,
        'message' => 'Dokter berhasil ditambahkan',
        'doctor_id' => $pdo->lastInsertId()
    ];
    
    echo json_encode($response);
}

function updateDoctor($pdo, $data) {
    $sql = "UPDATE doctors 
            SET nama_dokter = :nama_dokter, 
                spesialisasi = :spesialisasi, 
                foto = :foto, 
                email = :email, 
                telepon = :telepon, 
                jadwal_hari = :jadwal_hari, 
                jadwal_waktu = :jadwal_waktu 
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    
    // Generate foto dummy jika tidak diisi
    $foto = !empty($data['foto']) ? $data['foto'] : generateDummyPhoto($data['nama_dokter']);
    
    $stmt->execute([
        ':id' => $data['id'],
        ':nama_dokter' => $data['nama_dokter'],
        ':spesialisasi' => $data['spesialisasi'],
        ':foto' => $foto,
        ':email' => $data['email'] ?? null,
        ':telepon' => $data['telepon'] ?? null,
        ':jadwal_hari' => $data['jadwal_hari'],
        ':jadwal_waktu' => $data['jadwal_waktu']
    ]);
    
    $response = [
        'success' => true,
        'message' => 'Data dokter berhasil diperbarui'
    ];
    
    echo json_encode($response);
}

// Function untuk generate foto dummy
function generateDummyPhoto($nama_dokter) {
    // Menggunakan UI Avatars untuk generate avatar berdasarkan nama
    $nama_encoded = urlencode($nama_dokter);
    return "https://ui-avatars.com/api/?name={$nama_encoded}&size=200&background=4C7990&color=fff&bold=true";
}

function deleteDoctor($pdo, $data) {
    $sql = "UPDATE doctors SET status = 'non-aktif' WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $data['id']]);
    
    $response = [
        'success' => true,
        'message' => 'Dokter berhasil dihapus'
    ];
    
    echo json_encode($response);
}
?>
