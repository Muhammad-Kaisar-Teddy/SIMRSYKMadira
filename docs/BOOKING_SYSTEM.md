# Sistem Booking Layanan RSU YK Madira

## Deskripsi
Sistem booking layanan online untuk RSU YK Madira yang memungkinkan pasien untuk melakukan pendaftaran layanan kesehatan secara online.

## Fitur Utama

### 1. Form Booking Pasien (`booking.html`)
- **Identitas Pasien**: Nama lengkap, NIK, tanggal lahir, email, alamat, telepon
- **Layanan & Jadwal**: Jenis layanan, poliklinik, tanggal kunjungan, dokter, metode pembayaran
- **Upload Dokumen**: Mendukung PDF, JPG, PNG (maksimal 5MB)
- **Validasi**: Real-time validation dan error handling
- **Responsive Design**: Optimal untuk desktop dan mobile

### 2. Admin Panel (`admin/bookings.html`)
- **Dashboard Statistik**: Total, pending, confirmed, cancelled bookings
- **Filter & Search**: Berdasarkan status, tanggal, poliklinik
- **Manajemen Status**: Approve/reject booking
- **Detail View**: Modal untuk melihat detail lengkap booking
- **Export Data**: Fitur export ke Excel (dalam pengembangan)

### 3. API Backend (`api/bookings.php`)
- **CREATE**: Membuat booking baru dengan validasi
- **READ**: List semua booking dengan filter
- **UPDATE**: Update status booking
- **DELETE**: Cancel booking
- **File Upload**: Handling upload dokumen pendukung
- **Notification**: Simulasi notifikasi WhatsApp

## Database Schema

### Tabel `bookings`
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- booking_id (VARCHAR(20), UNIQUE) - Format: BKyyyymmddnnnn
- nama_lengkap (VARCHAR(255))
- nik (VARCHAR(20))
- tanggal_lahir (DATE)
- email (VARCHAR(255), NULL)
- alamat (TEXT)
- telepon (VARCHAR(20))
- jenis_layanan (VARCHAR(100))
- poliklinik (VARCHAR(100))
- tanggal_kunjungan (DATE)
- dokter (VARCHAR(255))
- metode_pembayaran (VARCHAR(50))
- dokumen_pendukung (VARCHAR(500), NULL)
- catatan_tambahan (TEXT, NULL)
- status (ENUM: pending, confirmed, cancelled, completed)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Tabel `booking_files`
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- booking_id (VARCHAR(20), FOREIGN KEY)
- file_name (VARCHAR(255))
- file_path (VARCHAR(500))
- file_type (VARCHAR(50))
- file_size (INT)
- uploaded_at (TIMESTAMP)
```

## Instalasi & Setup

### 1. Database Setup
```bash
# Import schema dan sample data
mysql -u root -p simrs_ykmaira < database/bookings_table.sql
```

### 2. File Permissions
```bash
# Set permissions untuk upload directory
chmod 755 uploads/
chmod 755 uploads/bookings/
```

### 3. Configuration
- Update `db.php` dengan konfigurasi database yang sesuai
- Pastikan PHP extensions yang diperlukan aktif:
  - PDO MySQL
  - GD (untuk image processing)
  - FileInfo (untuk file type detection)

## Penggunaan

### Untuk Pasien (User)
1. Akses `booking.html` dari dashboard atau langsung
2. Isi formulir booking dengan lengkap
3. Upload dokumen pendukung jika diperlukan
4. Submit form dan tunggu konfirmasi
5. Catat Booking ID untuk referensi

### Untuk Admin
1. Login ke admin panel
2. Akses `admin/bookings.html`
3. Monitor booking baru yang masuk
4. Review detail booking
5. Approve atau reject booking
6. Update status sesuai progress

## API Endpoints

### GET /api/bookings.php
- Mengambil list booking
- Query parameters:
  - `status`: Filter berdasarkan status
  - `tanggal`: Filter berdasarkan tanggal kunjungan
  - `poliklinik`: Filter berdasarkan poliklinik
  - `id`: Ambil detail booking tertentu

### POST /api/bookings.php
- Membuat booking baru
- Content-Type: multipart/form-data
- Required fields: nama_lengkap, nik, tanggal_lahir, alamat, telepon, jenis_layanan, poliklinik, tanggal_kunjungan, dokter, metode_pembayaran

### PUT /api/bookings.php
- Update status booking
- Content-Type: application/json
- Body: `{"booking_id": "BK...", "status": "confirmed"}`

### DELETE /api/bookings.php
- Cancel booking
- Content-Type: application/json
- Body: `{"booking_id": "BK..."}`

## Status Flow
```
pending → confirmed → completed
    ↘     ↙
    cancelled
```

## Security Features
- File upload validation (type, size)
- SQL injection protection (PDO prepared statements)
- XSS protection (input sanitization)
- Direct file access prevention (.htaccess)
- CSRF protection (dapat ditambahkan)

## Browser Support
- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+

## Mobile Responsiveness
- Breakpoints: 640px, 768px, 1024px, 1280px
- Touch-friendly UI elements
- Optimized form inputs untuk mobile

## Future Enhancements
1. **Email Notification**: Otomatis kirim email konfirmasi
2. **SMS Gateway**: Integrasi dengan provider SMS
3. **Payment Gateway**: Integrasi pembayaran online
4. **Calendar Integration**: Sinkronisasi dengan kalender dokter
5. **QR Code**: Generate QR code untuk booking
6. **Rating System**: Rating kepuasan pasien
7. **Reminder System**: Reminder otomatis sebelum jadwal

## Troubleshooting

### File Upload Issues
- Pastikan `upload_max_filesize` dan `post_max_size` cukup besar
- Check `file_uploads = On` di php.ini
- Verify folder permissions

### Database Connection
- Check database credentials di `db.php`
- Pastikan MySQL service running
- Verify database exists dan tables sudah diimport

### CORS Issues
- Headers sudah diset di API untuk cross-origin requests
- Jika masih ada issue, check server configuration

## Support
Untuk bantuan teknis, hubungi:
- Email: admin@rsuykmaira.com
- Phone: 08571100888
- WhatsApp: 08571100888
