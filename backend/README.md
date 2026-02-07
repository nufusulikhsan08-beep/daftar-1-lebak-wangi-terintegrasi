# Daftar 1 Digital - Lebak Wangi

Sistem informasi digital untuk manajemen pendidikan di Kecamatan Lebak Wangi, Kabupaten Serang, Banten.

## Fitur Utama

- Manajemen data sekolah
- Manajemen data guru dan tenaga pendidik
- Manajemen data siswa
- Manajemen inventaris sekolah
- Laporan bulanan (Daftar 1)
- Impor/ekspor data Excel
- Sistem otentikasi dan otorisasi berbasis peran
- Pengingat otomatis untuk laporan

## Teknologi yang Digunakan

- Laravel 10.x
- MySQL
- Bootstrap 5
- Chart.js
- Laravel Excel
- PHP 8.1+

## Instalasi

### Prasyarat

- PHP 8.1+
- MySQL 8.0+
- Composer
- Node.js (opsional, untuk kompilasi asset)

### Langkah-langkah Instalasi

1. Clone repositori:
   ```bash
   git clone <repository-url>
   cd daftar1-lebakwangi
   ```

2. Instal dependensi PHP:
   ```bash
   composer install
   ```

3. Salin file konfigurasi lingkungan:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Konfigurasi database di file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=daftar1_lebakwangi
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. Jalankan migrasi database:
   ```bash
   php artisan migrate --seed
   ```

7. Instal dependensi Node.js (jika diperlukan):
   ```bash
   npm install
   npm run dev
   ```

8. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```

## Struktur Direktori

```
daftar1-lebakwangi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Services/
│   └── Notifications/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   └── css/
├── routes/
├── storage/
├── config/
└── public/
```

## Konfigurasi Cron Jobs

Untuk menjalankan tugas otomatis seperti pengingat laporan, tambahkan entri berikut ke crontab:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Hak Akses

Aplikasi ini mendukung beberapa peran pengguna:

- **Admin Dinas**: Akses penuh ke semua fungsi sistem
- **Kepala Sekolah**: Akses ke data sekolah masing-masing
- **Operator Sekolah**: Akses ke data sekolah masing-masing
- **Pengawas**: Akses untuk memonitor laporan

## API Endpoint

Beberapa endpoint API tersedia untuk integrasi:

- `/api/schools/dropdown` - Untuk dropdown sekolah
- Endpoint lainnya sesuai kebutuhan

## Backup dan Restore

Aplikasi ini menyediakan fitur backup otomatis:

- Backup harian dijalankan pukul 02:00
- Lokasi backup: `storage/backups/`
- Untuk restore: `php artisan backup:restore`

## Troubleshooting

### Masalah Umum

1. **Error saat migrasi**: Pastikan konfigurasi database benar dan database telah dibuat
2. **Permission error**: Pastikan direktori `storage` dan `bootstrap/cache` dapat ditulis
3. **Laravel Mix error**: Jalankan `npm install` dan `npm run dev`

### Log Aplikasi

File log aplikasi tersimpan di `storage/logs/laravel.log`.

## Deployment Production

Gunakan skrip deploy.sh untuk menyiapkan aplikasi di lingkungan production:

```bash
chmod +x deploy.sh
./deploy.sh
```

## Lisensi

Proyek ini dilisensikan di bawah lisensi MIT.