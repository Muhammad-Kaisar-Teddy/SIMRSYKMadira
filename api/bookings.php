<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Include database connection
require_once '../db.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            // Get booking list atau detail booking
            if (isset($_GET['id'])) {
                getBookingDetail($_GET['id']);
            } else {
                getBookingList();
            }
            break;
            
        case 'POST':
            // Create new booking
            createBooking();
            break;
            
        case 'PUT':
            // Update booking status
            updateBooking();
            break;
            
        case 'DELETE':
            // Cancel booking
            cancelBooking();
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            break;
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

function createBooking() {
    global $pdo;
    
    try {
        // Validate required fields
        $required_fields = ['nama_lengkap', 'nik', 'tanggal_lahir', 'alamat', 'telepon', 
                          'jenis_layanan', 'poliklinik', 'tanggal_kunjungan', 'dokter', 'metode_pembayaran'];
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Field $field is required");
            }
        }
        
        // Generate booking ID
        $booking_id = 'BK' . date('Ymd') . sprintf('%04d', rand(1000, 9999));
        
        // Prepare data
        $data = [
            'booking_id' => $booking_id,
            'nama_lengkap' => $_POST['nama_lengkap'],
            'nik' => $_POST['nik'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'email' => $_POST['email'] ?? null,
            'alamat' => $_POST['alamat'],
            'telepon' => $_POST['telepon'],
            'jenis_layanan' => $_POST['jenis_layanan'],
            'poliklinik' => $_POST['poliklinik'],
            'tanggal_kunjungan' => $_POST['tanggal_kunjungan'],
            'dokter' => $_POST['dokter'],
            'metode_pembayaran' => $_POST['metode_pembayaran'],
            'catatan_tambahan' => $_POST['catatan_tambahan'] ?? null,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Insert to database
        $sql = "INSERT INTO bookings (booking_id, nama_lengkap, nik, tanggal_lahir, email, alamat, telepon, 
                                    jenis_layanan, poliklinik, tanggal_kunjungan, dokter, metode_pembayaran, 
                                    catatan_tambahan, status, created_at) 
                VALUES (:booking_id, :nama_lengkap, :nik, :tanggal_lahir, :email, :alamat, :telepon,
                        :jenis_layanan, :poliklinik, :tanggal_kunjungan, :dokter, :metode_pembayaran,
                        :catatan_tambahan, :status, :created_at)";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($data);
        
        if ($result) {
            // Handle file upload if present
            $file_path = null;
            if (isset($_FILES['dokumen_pendukung']) && $_FILES['dokumen_pendukung']['error'] === UPLOAD_ERR_OK) {
                $file_path = handleFileUpload($_FILES['dokumen_pendukung'], $booking_id);
                
                // Update booking with file path
                if ($file_path) {
                    $stmt = $pdo->prepare("UPDATE bookings SET dokumen_pendukung = :file_path WHERE booking_id = :booking_id");
                    $stmt->execute(['file_path' => $file_path, 'booking_id' => $booking_id]);
                }
            }
            
            // Send notification (WhatsApp simulation)
            sendBookingNotification($data);
            
            echo json_encode([
                'success' => true,
                'message' => 'Booking berhasil dibuat',
                'data' => [
                    'booking_id' => $booking_id,
                    'status' => 'pending',
                    'file_uploaded' => $file_path ? true : false
                ]
            ]);
        } else {
            throw new Exception('Failed to create booking');
        }
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

function getBookingList() {
    global $pdo;
    
    try {
        // Optional filtering
        $where_conditions = [];
        $params = [];
        
        if (isset($_GET['status'])) {
            $where_conditions[] = "status = :status";
            $params['status'] = $_GET['status'];
        }
        
        if (isset($_GET['tanggal'])) {
            $where_conditions[] = "DATE(tanggal_kunjungan) = :tanggal";
            $params['tanggal'] = $_GET['tanggal'];
        }
        
        if (isset($_GET['poliklinik'])) {
            $where_conditions[] = "poliklinik = :poliklinik";
            $params['poliklinik'] = $_GET['poliklinik'];
        }
        
        $where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
        
        $sql = "SELECT * FROM bookings $where_clause ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'data' => $bookings,
            'total' => count($bookings)
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

function getBookingDetail($booking_id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE booking_id = :booking_id");
        $stmt->execute(['booking_id' => $booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($booking) {
            echo json_encode([
                'success' => true,
                'data' => $booking
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Booking not found'
            ]);
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

function updateBooking() {
    global $pdo;
    
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['booking_id']) || !isset($input['status'])) {
            throw new Exception('Booking ID and status are required');
        }
        
        $allowed_statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        if (!in_array($input['status'], $allowed_statuses)) {
            throw new Exception('Invalid status');
        }
        
        $stmt = $pdo->prepare("UPDATE bookings SET status = :status, updated_at = NOW() WHERE booking_id = :booking_id");
        $result = $stmt->execute([
            'status' => $input['status'],
            'booking_id' => $input['booking_id']
        ]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Booking status updated successfully'
            ]);
        } else {
            throw new Exception('Booking not found or no changes made');
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

function cancelBooking() {
    global $pdo;
    
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['booking_id'])) {
            throw new Exception('Booking ID is required');
        }
        
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'cancelled', updated_at = NOW() WHERE booking_id = :booking_id");
        $result = $stmt->execute(['booking_id' => $input['booking_id']]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Booking cancelled successfully'
            ]);
        } else {
            throw new Exception('Booking not found');
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

function handleFileUpload($file, $booking_id) {
    $upload_dir = '../uploads/bookings/';
    
    // Create directory if not exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Validate file
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowed_types)) {
        throw new Exception('Invalid file type. Only PDF, JPG, and PNG files are allowed.');
    }
    
    if ($file['size'] > $max_size) {
        throw new Exception('File size too large. Maximum size is 5MB.');
    }
    
    // Generate unique filename
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $booking_id . '_' . time() . '.' . $file_extension;
    $file_path = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        return 'uploads/bookings/' . $filename;
    } else {
        throw new Exception('Failed to upload file');
    }
}

function sendBookingNotification($booking_data) {
    // Simulasi pengiriman notifikasi WhatsApp
    // Dalam implementasi nyata, integrasikan dengan WhatsApp Business API
    
    $message = "🏥 *RSU YK Madira - Konfirmasi Booking*\n\n";
    $message .= "📋 ID Booking: {$booking_data['booking_id']}\n";
    $message .= "👤 Nama: {$booking_data['nama_lengkap']}\n";
    $message .= "🏥 Poliklinik: " . ucfirst($booking_data['poliklinik']) . "\n";
    $message .= "📅 Tanggal: {$booking_data['tanggal_kunjungan']}\n";
    $message .= "👨‍⚕️ Dokter: {$booking_data['dokter']}\n";
    $message .= "💳 Pembayaran: " . ucfirst($booking_data['metode_pembayaran']) . "\n\n";
    $message .= "✅ Booking Anda sedang diproses. Tim kami akan menghubungi Anda untuk konfirmasi lebih lanjut.\n\n";
    $message .= "📞 Hotline: 08571100888\n";
    $message .= "🌐 www.rsuykmaira.com";
    
    // Log notification (untuk development)
    error_log("WhatsApp Notification to {$booking_data['telepon']}: $message");
    
    return true;
}
?>
