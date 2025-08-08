# Panduan Instalasi Database Dokter (Dengan Foto Dummy Otomatis!)

## 🎉 **Fitur Baru: Foto Dummy Otomatis!**
Tidak perlu upload foto manual lagi! Sistem akan otomatis:
- ✅ Menggunakan foto dari Unsplash untuk data sampel
- ✅ Generate avatar otomatis berdasarkan nama dokter
- ✅ Fallback ke UI-Avatars jika foto error

## 1. **Import Database**
Jalankan file SQL berikut di phpMyAdmin atau MySQL:
```sql
-- File: database/doctors_table.sql
```
*Database sudah include foto dummy dari Unsplash!*

## 2. **Cara Menggunakan**

### **Menampilkan Data Dokter:**
- Buka `dashboard-user.html`
- Data dokter dengan foto dummy akan otomatis dimuat
- Jika foto dari database error, akan otomatis generate avatar dengan inisial nama

### **Menambahkan Dokter Baru:**
- Buka `admin/doctors.html`
- Isi form (foto bersifat OPSIONAL!)
- Jika tidak mengisi foto, sistem akan otomatis generate avatar berdasarkan nama
- Contoh avatar auto: "Dr. John Doe" → Avatar dengan inisial "JD"

## 3. **Sistem Foto Dummy**

### **Tingkat Fallback:**
1. **Primary**: Foto dari database (URL lengkap atau path lokal)
2. **Secondary**: Avatar otomatis dari UI-Avatars berdasarkan nama
3. **Tertiary**: Avatar default jika semua gagal

### **Contoh Auto-Generated Avatar:**
```
Nama: "Dr. Ahmad Subanto"
Avatar URL: https://ui-avatars.com/api/?name=Dr.%20Ahmad%20Subanto&size=200&background=4C7990&color=fff&bold=true
Hasil: Avatar dengan inisial "AS" dengan background biru (#4C7990)
```

## 4. **Keuntungan Sistem Baru**

✅ **Zero Manual Work**: Tidak perlu upload foto satu per satu
✅ **Always Working**: Selalu ada foto, tidak akan kosong
✅ **Professional Look**: Avatar yang konsisten dan rapi
✅ **Scalable**: Mudah menambah dokter baru tanpa persiapan foto
✅ **Fast Loading**: Menggunakan CDN untuk foto dummy
✅ **Responsive**: Foto otomatis menyesuaikan ukuran

## 5. **Options Foto yang Tersedia**

### **Option 1: Kosongkan Field Foto**
- Sistem otomatis generate avatar berdasarkan nama
- Hasil: Avatar dengan inisial + background warna rumah sakit

### **Option 2: Gunakan URL External**
- Unsplash: `https://images.unsplash.com/photo-xxxxx?w=200&h=200&fit=crop&crop=face`
- Pexels: `https://images.pexels.com/photos/xxxxx/photo.jpg?w=200&h=200&fit=crop&crop=face`
- Lorem Picsum: `https://picsum.photos/200/200?random=1`

### **Option 3: Upload Manual (Advanced)**
- Upload ke folder `img/doctors/`
- Isi field foto dengan: `img/doctors/nama-file.jpg`

## 6. **API Response Example**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama_dokter": "Dr. Desti Handayani",
      "spesialisasi": "Spesialis Anak",
      "foto": "https://images.unsplash.com/photo-559839734-2b71ea197ec2?w=200&h=200&fit=crop&crop=face",
      "email": "desti@rsuykmaira.com",
      "telepon": "081234567801",
      "jadwal_hari": "Senin, Selasa - Sabtu",
      "jadwal_waktu": "18:30 - 20:00"
    }
  ]
}
```

## 7. **Quick Start (Super Easy!)**

1. **Import database** → ✅ Langsung ada 9 dokter dengan foto dummy
2. **Buka dashboard-user.html** → ✅ Langsung jalan tanpa setup apapun!
3. **Tambah dokter baru** → ✅ Tinggal isi nama & jadwal, foto otomatis!

**Sekarang sistem 100% plug-and-play!** 🚀

## 8. **Pro Tips**

💡 **Untuk Development**: Biarkan foto kosong, biar otomatis generate
💡 **Untuk Production**: Gunakan foto berkualitas dari Unsplash/Pexels
💡 **Untuk Konsistensi**: Gunakan avatar auto untuk semua dokter baru
💡 **Untuk Performance**: Avatar auto loading lebih cepat dari upload manual

Sistem foto dummy ini membuat pengembangan jadi super cepat dan tidak ribet! 🎉
