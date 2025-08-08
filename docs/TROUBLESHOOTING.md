# 🚨 TROUBLESHOOTING: Gagal Memuat Data Dokter

## Kemungkinan Penyebab & Solusi:

### 1. **Database Belum Dibuat/Diimport**
**Masalah**: Tabel `doctors` belum ada di database `simrs_db`

**Solusi**:
```sql
-- 1. Buat database dulu (jika belum ada)
CREATE DATABASE simrs_db;

-- 2. Import file doctors_table.sql
-- Via phpMyAdmin: Import > Choose file > database/doctors_table.sql
-- Via command line: mysql -u root -p simrs_db < database/doctors_table.sql
```

### 2. **XAMPP/MySQL Belum Jalan**
**Masalah**: Apache dan MySQL di XAMPP tidak aktif

**Solusi**:
- Buka XAMPP Control Panel
- Start **Apache** dan **MySQL**
- Pastikan keduanya hijau

### 3. **Konfigurasi Database Salah**
**Masalah**: Username/password/host database tidak sesuai

**Solusi**: Edit file `db.php`
```php
$host = "localhost";      // ✅ Biasanya localhost
$user = "root";           // ✅ Default XAMPP
$pass = "";               // ✅ Default XAMPP kosong
$db   = "simrs_db";       // ✅ Nama database
```

### 4. **File API Tidak Ditemukan**
**Masalah**: File `api/doctors.php` tidak ada atau path salah

**Solusi**:
- Pastikan struktur folder benar:
```
SIMRSYKMadira/
├── api/
│   ├── doctors.php       ← Harus ada
│   ├── doctors_manage.php
│   └── test_db.php
├── db.php               ← Harus ada
└── dashboard-user.html  ← Harus ada
```

### 5. **CORS/Permission Issues**
**Masalah**: Browser block request karena CORS

**Solusi**:
- Pastikan mengakses via `http://localhost/SIMRSYKMadira/dashboard-user.html`
- Jangan buka file langsung (file://)

## 🔧 **Quick Fix (Sementara)**

Jika masih error, sistem sudah dilengkapi **fallback dummy data**:

1. **Otomatis**: Jika database error, akan load data dummy
2. **Manual**: Klik tombol "Gunakan Data Contoh"

## 🧪 **Test Database Connection**

Buka di browser: `http://localhost/SIMRSYKMadira/api/test_db.php`

**Response OK**:
```json
{
  "pdo_connection": "OK",
  "doctors_table_exists": true,
  "doctors_count": 9,
  "success": true
}
```

**Response Error**:
```json
{
  "success": false,
  "error": "SQLSTATE[HY000] [1049] Unknown database 'simrs_db'"
}
```

## 📋 **Checklist Troubleshooting**

- [ ] XAMPP Apache & MySQL running
- [ ] Database `simrs_db` exists
- [ ] Tabel `doctors` imported
- [ ] File `db.php` konfigurasi benar
- [ ] File `api/doctors.php` exists
- [ ] Akses via `http://localhost` (bukan file://)
- [ ] Browser console tidak ada error

## 🎯 **Solusi Cepat untuk Demo**

Jika butuh demo cepat tanpa setup database:

1. Sistem otomatis akan fallback ke dummy data
2. Atau klik "Gunakan Data Contoh" 
3. Website akan tetap jalan dengan 9 dokter contoh

**Data dummy sudah include**:
- ✅ 9 dokter dengan spesialisasi berbeda
- ✅ Foto dari Unsplash (online)
- ✅ Jadwal praktek lengkap
- ✅ Contact info email & telepon

Jadi website tetap bisa demo tanpa database setup! 🚀
