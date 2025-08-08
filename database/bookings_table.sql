-- Tabel untuk menyimpan data booking layanan
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id VARCHAR(20) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    nik VARCHAR(20) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    email VARCHAR(255) NULL,
    alamat TEXT NOT NULL,
    telepon VARCHAR(20) NOT NULL,
    jenis_layanan VARCHAR(100) NOT NULL,
    poliklinik VARCHAR(100) NOT NULL,
    tanggal_kunjungan DATE NOT NULL,
    dokter VARCHAR(255) NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    dokumen_pendukung VARCHAR(500) NULL,
    catatan_tambahan TEXT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_booking_id (booking_id),
    INDEX idx_status (status),
    INDEX idx_tanggal_kunjungan (tanggal_kunjungan),
    INDEX idx_poliklinik (poliklinik),
    INDEX idx_telepon (telepon)
);

-- Insert sample booking data for testing
INSERT INTO bookings (
    booking_id, nama_lengkap, nik, tanggal_lahir, email, alamat, telepon,
    jenis_layanan, poliklinik, tanggal_kunjungan, dokter, metode_pembayaran,
    catatan_tambahan, status
) VALUES 
(
    'BK20250101001',
    'Budi Santoso',
    '3671012345678901',
    '1985-05-15',
    'budi.santoso@email.com',
    'Jl. Merdeka No. 123, Palembang',
    '081234567890',
    'konsultasi',
    'jantung',
    '2025-01-10',
    'dr_jantung_1',
    'bpjs',
    'Merasa sering sesak napas saat aktivitas berat',
    'confirmed'
),
(
    'BK20250101002',
    'Siti Aminah',
    '3671012345678902',
    '1990-08-22',
    'siti.aminah@email.com',
    'Jl. Sudirman No. 456, Palembang',
    '081234567891',
    'pemeriksaan',
    'anak',
    '2025-01-11',
    'dr_anak_1',
    'tunai',
    'Anak demam tinggi sejak 2 hari',
    'pending'
),
(
    'BK20250101003',
    'Ahmad Fauzi',
    '3671012345678903',
    '1978-12-10',
    'ahmad.fauzi@email.com',
    'Jl. Veteran No. 789, Palembang',
    '081234567892',
    'konsultasi',
    'mata',
    '2025-01-12',
    'dr_mata_1',
    'asuransi',
    'Mata sering berair dan pandangan kabur',
    'confirmed'
),
(
    'BK20250101004',
    'Dewi Sartika',
    '3671012345678904',
    '1992-03-18',
    'dewi.sartika@email.com',
    'Jl. Diponegoro No. 321, Palembang',
    '081234567893',
    'pemeriksaan',
    'kandungan',
    '2025-01-13',
    'dr_kandungan_1',
    'bpjs',
    'Kontrol kehamilan rutin',
    'pending'
),
(
    'BK20250101005',
    'Rizki Pratama',
    '3671012345678905',
    '1988-07-25',
    'rizki.pratama@email.com',
    'Jl. Ahmad Yani No. 654, Palembang',
    '081234567894',
    'konsultasi',
    'kulit',
    '2025-01-14',
    'dr_kulit_1',
    'tunai',
    'Gatal-gatal di seluruh tubuh',
    'confirmed'
);

-- Create uploads directory structure table for tracking files
CREATE TABLE IF NOT EXISTS booking_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id VARCHAR(20) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE,
    INDEX idx_booking_id (booking_id)
);
