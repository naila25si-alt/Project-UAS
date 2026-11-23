LABINVENT: PODCAST STUDIO - PANDUAN INSTALASI

Paket ini berisi file tambahan untuk project Laravel yang sudah ada.
Jangan membuat project Laravel baru.

1. BUAT DATABASE MYSQL
- Jalankan XAMPP, aktifkan Apache dan MySQL.
- Buka http://localhost/phpmyadmin
- Klik New / Baru.
- Buat database dengan nama: podcast_studio
- Collation: utf8mb4_unicode_ci (jika diminta).

2. SALIN FILE
Ekstrak ZIP ini ke komputer.
Salin folder dan file ke folder project Laravel kamu dengan mempertahankan struktur:
- app/Models
- app/Http/Controllers
- database/migrations
- database/seeders
- resources/views
- public/css

PENTING: routes/web.php.example adalah contoh pengaturan route.
Buka file tersebut, salin route booking yang diperlukan ke routes/web.php kamu.
Jangan menimpa route login yang sudah ada. Jika sudah ada route login, pertahankan route login tersebut dan tambahkan route booking.

3. ATUR FILE .env
Buka .env pada root project dan sesuaikan bagian database. Contoh untuk XAMPP lokal:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=podcast_studio
DB_USERNAME=root
DB_PASSWORD=

Jika MySQL kamu memakai password, isi DB_PASSWORD sesuai password MySQL.

4. JALANKAN PERINTAH
Di terminal pada folder project Laravel:

php artisan optimize:clear
php artisan migrate --seed
php artisan serve

5. BUKA DI BROWSER
Halaman booking:
http://127.0.0.1:8000/booking

Halaman dashboard sementara:
http://127.0.0.1:8000/dashboard

Daftar booking:
http://127.0.0.1:8000/my-bookings

6. CATATAN
- Halaman booking sementara dapat dibuka tanpa login.
- Booking disimpan ke database dengan status pending.
- Sistem memeriksa bentrok jadwal studio.
- Harga dihitung berdasarkan tarif per jam, dibulatkan ke atas.
- Foto studio memakai URL gambar eksternal; jika internet tidak tersedia, bagian foto bisa kosong tetapi form tetap dapat digunakan.
- Ini adalah starter untuk tahap pengembangan. Sebelum produksi, aktifkan autentikasi, proteksi akses daftar booking, CSRF (sudah digunakan), serta aturan stok equipment dan persetujuan admin.
- File booking.blade.php ini menggantikan view booking lama. Backup dulu file lama sebelum menimpa.
