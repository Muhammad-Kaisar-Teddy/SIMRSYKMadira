# SIMRS YK Madira - Struktur Proyek

## 📁 Struktur Folder

```
SIMRSYKMadira/
├── 📁 api/                     # Backend API endpoints
│   ├── bookings.php           # API untuk booking
│   ├── dashboard_summary.php  # API untuk dashboard summary
│   ├── doctors.php           # API untuk dokter
│   ├── doctors_manage.php    # API untuk manajemen dokter
│   ├── login.php            # API untuk login
│   └── test_db.php          # Test koneksi database
│
├── 📁 assets/                  # Static assets
│   ├── 📁 css/              # Stylesheet files
│   ├── 📁 js/               # JavaScript files
│   ├── 📁 icons/            # Icon files
│   └── 📁 img/              # Image files
│
├── 📁 database/               # Database related files
│   ├── bookings_table.sql    # Table booking
│   ├── doctors_table.sql     # Table dokter
│   ├── 📁 migrations/        # Database migrations
│   └── 📁 seeds/            # Database seeders
│
├── 📁 docs/                   # Documentation
│   ├── BOOKING_SYSTEM.md     # Dokumentasi sistem booking
│   ├── PROJECT_JOURNEY.md    # Journey pengembangan
│   ├── PROJECT_SUMMARY.md    # Ringkasan proyek
│   ├── README_DOCTORS.md     # Dokumentasi modul dokter
│   ├── ROADMAP.md           # Roadmap pengembangan
│   └── TROUBLESHOOTING.md   # Panduan troubleshooting
│
├── 📁 src/                    # Source code utama
│   ├── 📁 config/           # Konfigurasi aplikasi
│   │   └── 📁 database/      # Konfigurasi database
│   │       └── db.php       # File konfigurasi database
│   │
│   ├── 📁 includes/         # File yang di-include
│   │   └── 📁 auth/         # File otentikasi
│   │       ├── logout.php   # Proses logout
│   │       └── proses_login.php # Proses login
│   │
│   └── 📁 views/            # Template dan view files
│       ├── 📁 admin/        # Views untuk admin
│       │   ├── bookings.html      # Halaman booking admin
│       │   ├── dashboard-admin.html # Dashboard admin
│       │   └── doctors.html       # Halaman dokter admin
│       │
│       ├── 📁 auth/         # Views untuk otentikasi
│       │   ├── login.html   # Halaman login
│       │   └── splash.html  # Halaman splash
│       │
│       ├── 📁 modules/      # View modules (untuk pengembangan)
│       ├── 📁 public/       # Public views
│       ├── 📁 shared/       # Shared components
│       └── 📁 user/         # Views untuk user
│           ├── booking.html         # Halaman booking user
│           ├── dashboard-user.html  # Dashboard user
│           ├── fasilitas-tarif.html # Halaman fasilitas & tarif
│           ├── pasien.html          # Halaman data pasien
│           └── rekam-medis.html     # Halaman rekam medis
│
├── 📁 uploads/               # Upload directory
│   └── 📁 bookings/         # Upload files untuk booking
│
├── 📁 fasilitas/            # Data fasilitas
├── index.php               # Main entry point dengan routing
└── .gitignore             # Git ignore file
```

## 🚀 Cara Menggunakan

### 1. Akses Aplikasi
- **URL Utama**: `http://localhost/SIMRSYKMadira/`
- **Login**: `http://localhost/SIMRSYKMadira/?page=login`
- **Dashboard Admin**: `http://localhost/SIMRSYKMadira/?page=dashboard-admin`
- **Dashboard User**: `http://localhost/SIMRSYKMadira/?page=dashboard-user`

### 2. Routing System
Aplikasi menggunakan sistem routing sederhana melalui parameter `page`:
- `?page=splash` - Halaman splash (default)
- `?page=login` - Halaman login
- `?page=booking` - Halaman booking user
- `?page=pasien` - Halaman data pasien
- `?page=admin-bookings` - Halaman booking admin
- dll.

## 🔧 Keuntungan Struktur Baru

1. **Terorganisir**: Setiap file berada di folder yang sesuai dengan fungsinya
2. **Scalable**: Mudah untuk menambah fitur baru
3. **Maintainable**: Mudah untuk maintenance dan debugging
4. **Standard**: Mengikuti best practice struktur proyek PHP
5. **Separation of Concerns**: API, Views, dan Config terpisah dengan jelas

## 📝 Next Steps

1. Update semua path dalam file HTML/PHP untuk menyesuaikan struktur baru
2. Buat file `.htaccess` untuk URL rewriting yang lebih bersih
3. Implementasi autoloader untuk PHP classes
4. Setup environment configuration
