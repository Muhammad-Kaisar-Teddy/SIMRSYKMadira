-- Tabel untuk data dokter dan jadwal praktek
CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialisasi VARCHAR(100) NOT NULL,
    foto VARCHAR(255) DEFAULT 'img/doctor-default.jpg',
    email VARCHAR(100),
    telepon VARCHAR(20),
    jadwal_hari VARCHAR(100) NOT NULL,
    jadwal_waktu VARCHAR(50) NOT NULL,
    status ENUM('aktif', 'non-aktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data dokter contoh dengan foto dummy
INSERT INTO doctors (nama_dokter, spesialisasi, foto, email, telepon, jadwal_hari, jadwal_waktu) VALUES
('Dr. Desti Handayani', 'Spesialis Anak', 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=200&h=200&fit=crop&crop=face', 'desti@rsuykmaira.com', '081234567801', 'Senin, Selasa - Sabtu', '18:30 - 20:00'),
('Dr. Ahmad Subanto', 'Spesialis Jantung', 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=200&h=200&fit=crop&crop=face', 'ahmad@rsuykmaira.com', '081234567802', 'Senin - Jumat', '08:00 - 12:00'),
('Dr. Sari Indrawati', 'Spesialis Kandungan', 'https://images.unsplash.com/photo-1594824804732-ca58f6165e39?w=200&h=200&fit=crop&crop=face', 'sari@rsuykmaira.com', '081234567803', 'Selasa, Kamis, Sabtu', '14:00 - 17:00'),
('Dr. Budi Santoso', 'Spesialis Bedah', 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=200&h=200&fit=crop&crop=face', 'budi@rsuykmaira.com', '081234567804', 'Senin, Rabu, Jumat', '07:00 - 11:00'),
('Dr. Lisa Permata', 'Spesialis Mata', 'https://images.unsplash.com/photo-1527613426441-4da17471b66d?w=200&h=200&fit=crop&crop=face', 'lisa@rsuykmaira.com', '081234567805', 'Senin - Sabtu', '13:00 - 16:00'),
('Dr. Rizky Pratama', 'Spesialis Kulit', 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?w=200&h=200&fit=crop&crop=face', 'rizky@rsuykmaira.com', '081234567806', 'Selasa - Kamis', '09:00 - 12:00'),
('Dr. Maya Sari', 'Spesialis THT', 'https://images.unsplash.com/photo-1551884170-09fb70a3a2ed?w=200&h=200&fit=crop&crop=face', 'maya@rsuykmaira.com', '081234567807', 'Senin, Rabu, Jumat', '15:00 - 18:00'),
('Dr. Andi Wijaya', 'Spesialis Saraf', 'https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=200&h=200&fit=crop&crop=face', 'andi@rsuykmaira.com', '081234567808', 'Selasa, Kamis, Sabtu', '08:00 - 11:00'),
('Dr. Nina Kartika', 'Spesialis Paru', 'https://images.unsplash.com/photo-1594824804732-ca58f6165e39?w=200&h=200&fit=crop&crop=face', 'nina@rsuykmaira.com', '081234567809', 'Senin - Jumat', '16:00 - 19:00');
