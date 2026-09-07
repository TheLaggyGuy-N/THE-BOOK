# Penjelasan Proyek Berkas Internal

## 1. Proyek ini untuk apa?

Proyek ini adalah aplikasi **Berkas Internal** atau **e-Ekspedisi**. Aplikasi ini dipakai untuk mengirim dokumen di dalam lingkungan kerja.

Fitur utamanya:

- membuat akun pegawai;
- login dan logout;
- melihat dashboard;
- mengirim berkas ke satu pengguna atau semua pengguna;
- mengunggah file berkas;
- melihat berkas yang dikirim atau diterima;
- mengedit dan menghapus berkas milik sendiri;
- menandai berkas sebagai sudah diterima;
- mengganti password atau menggunakan fitur lupa password.

Bahasa pemrograman yang dipakai adalah PHP dengan pola sederhana seperti MVC:

```text
Halaman (View)
       ↓
index.php sebagai pengarah
       ↓
Controller
       ↓
Model
       ↓
Database MySQL
```

## 2. Struktur folder

```text
BerkasInternal - Penjelasan/
├── config/
│   ├── Koneksi.php
│   └── database.php
├── controller/
│   ├── BerkasController.php
│   ├── HomeController.php
│   ├── LoginController.php
│   ├── PasswordController.php
│   └── RegisterController.php
├── model/
│   ├── Berkas.php
│   └── User.php
├── uploads/
│   └── file-file yang diunggah
├── views/
│   ├── edit.php
│   ├── ganti_password.php
│   ├── home.php
│   ├── login.php
│   ├── register.php
│   ├── tambah.php
│   └── tampilan.php
├── e-berkas.sql
└── index.php
```

### Fungsi tiap bagian

- **`index.php`**: pintu masuk aplikasi dan pengatur route berdasarkan nilai `aksi`.
- **`controller/`**: menerima permintaan dari halaman, memeriksa session, lalu memanggil model.
- **`model/`**: berisi query untuk mengambil atau mengubah data.
- **`views/`**: halaman yang dilihat pengguna.
- **`config/Koneksi.php`**: membuat koneksi ke database.
- **`uploads/`**: tempat menyimpan file dokumen yang di-upload.
- **`e-berkas.sql`**: struktur tabel dan contoh data database.

## 3. Cara kerja `index.php`

Semua permintaan masuk lewat `index.php`. Program membaca parameter URL:

```php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'login';
```

Jika `aksi` tidak ditulis, halaman awalnya adalah login.

Contoh:

```text
index.php?aksi=berkas
```

akan menjalankan:

```text
BerkasController::index()
```

Berikut daftar lengkap route-nya:

| URL | Controller | Fungsi | Hasil |
|---|---|---|---|
| `aksi=login` | `LoginController` | `login()` | Menampilkan form login |
| `aksi=prosesLogin` | `LoginController` | `prosesLogin()` | Memeriksa username dan password |
| `aksi=register` | `RegisterController` | `register()` | Menampilkan form pendaftaran |
| `aksi=prosesRegister` | `RegisterController` | `prosesRegister()` | Menyimpan akun baru |
| `aksi=home` | `HomeController` | `index()` | Menampilkan dashboard |
| `aksi=logout` | `HomeController` | `logout()` | Menghapus session dan keluar |
| `aksi=gantiPassword` | `PasswordController` | `ganti()` | Menampilkan form password |
| `aksi=prosesGantiPassword` | `PasswordController` | `prosesGanti()` | Mengubah password |
| `aksi=berkas` | `BerkasController` | `index()` | Menampilkan daftar berkas |
| `aksi=tambah` | `BerkasController` | `tambah()` | Menampilkan form tambah berkas |
| `aksi=prosesTambah` | `BerkasController` | `prosesTambah()` | Menyimpan berkas baru |
| `aksi=edit&id=...` | `BerkasController` | `edit()` | Menampilkan form edit |
| `aksi=prosesEdit` | `BerkasController` | `prosesEdit()` | Menyimpan perubahan berkas |
| `aksi=hapus&id=...` | `BerkasController` | `hapus()` | Menghapus berkas |
| `aksi=terima&id=...` | `BerkasController` | `terima()` | Menandai berkas sudah diterima |

## 4. Alur login

File yang terlibat:

- `views/login.php`
- `controller/LoginController.php`
- `model/User.php`
- tabel `user`

Alurnya:

```text
Pengguna membuka index.php?aksi=login
↓
LoginController::login()
↓
views/login.php ditampilkan
↓
Form dikirim ke index.php?aksi=prosesLogin
↓
LoginController::prosesLogin()
↓
User::login($username)
↓
Data dicari di tabel user
↓
password_verify() memeriksa password
↓
Session id_user, nama, dan role dibuat
↓
Pengguna diarahkan ke index.php?aksi=home
```

Form login ada di `views/login.php` dan mengirim data dengan method `POST`.

Jika username tidak ditemukan, muncul pesan **Username tidak ditemukan**. Jika password tidak cocok, muncul **Password salah**.

## 5. Alur membuat akun

Alurnya:

```text
index.php?aksi=register
↓
RegisterController::register()
↓
views/register.php
↓
Form dikirim ke index.php?aksi=prosesRegister
↓
RegisterController::prosesRegister()
↓
Password diubah menjadi hash
↓
User::register(...)
↓
INSERT ke tabel user
↓
Kembali ke halaman login
```

Akun baru otomatis memiliki role `pegawai`. Role `admin` tidak dipilih dari form pendaftaran.

## 6. Alur dashboard

URL:

```text
index.php?aksi=home
```

`HomeController::index()` melakukan beberapa hal:

1. memulai session;
2. mengecek apakah pengguna sudah login;
3. membaca role pengguna;
4. jika pengguna adalah admin, mengambil statistik berkas, jumlah pengguna, dan lima berkas terbaru;
5. mengirim data tersebut ke `views/home.php`.

Data dashboard diambil dari:

- `Berkas::statistikDashboard()`;
- `User::jumlahPengguna()`;
- `Berkas::berkasTerbaru()`.

Jika belum login, pengguna diarahkan kembali ke halaman login.

## 7. Alur menampilkan daftar berkas

URL:

```text
index.php?aksi=berkas
```

Alurnya:

```text
BerkasController::index()
↓
Session diperiksa
↓
Berkas::tampilData(id_user)
↓
Data berkas dan nama pengguna diambil
↓
views/tampilan.php menampilkan tabel
```

Satu pengguna dapat melihat berkas jika:

- `id_tujuan` sama dengan ID pengguna yang sedang login;
- `tujuan_semua` bernilai `1`;
- pengguna tersebut adalah pengirimnya.

Query menggunakan tabel `berkas` dan tabel `user`. Tabel `user` dipakai dua kali:

- sebagai nama pengirim;
- sebagai nama penerima.

File yang sudah tersimpan di folder `uploads/` dibuka melalui link **Lihat Berkas**.

## 8. Alur menambah dan mengirim berkas

### Menampilkan form

```text
Klik "+ Tambah Berkas"
↓
index.php?aksi=tambah
↓
BerkasController::tambah()
↓
Berkas::tampilUser()
↓
views/tambah.php
```

Form menampilkan daftar pengguna lain sebagai tujuan. Pengguna yang sedang login tidak ditampilkan sebagai pilihan tujuan.

### Menyimpan berkas

Form `views/tambah.php` mengirim data ke:

```text
index.php?aksi=prosesTambah
```

Kemudian alurnya:

```text
BerkasController::prosesTambah()
↓
Mengambil data POST dan session
↓
Memeriksa file upload
↓
Membuat nama file baru dengan awalan timestamp
↓
Memindahkan file ke folder uploads/
↓
Berkas::tambahData(...)
↓
INSERT ke tabel berkas
↓
Kembali ke index.php?aksi=berkas
```

Ada dua pilihan tujuan:

1. **Satu pengguna**: `id_tujuan` diisi dan `tujuan_semua` bernilai `0`.
2. **Semua pengguna**: `id_tujuan` dikosongkan dan `tujuan_semua` bernilai `1`.

Data yang disimpan antara lain nama dokumen, tanggal kirim, ID pengirim, ID tujuan, keterangan, dan nama file.

## 9. Alur mengedit berkas

Tombol edit hanya ditampilkan untuk berkas yang `id_pengirim`-nya sama dengan ID pengguna yang sedang login.

Alurnya:

```text
Klik Edit
↓
index.php?aksi=edit&id=id_berkas
↓
BerkasController::edit()
↓
Berkas::editData(id)
↓
views/edit.php
↓
Form dikirim ke index.php?aksi=prosesEdit
↓
BerkasController::prosesEdit()
↓
Jika ada file baru, file dipindahkan ke uploads/
↓
Berkas::prosesEdit(...)
↓
UPDATE tabel berkas
```

Saat berkas diedit, tanggal terima di-reset menjadi `NULL`. Status juga dikembalikan menjadi **`Dikirim`**, karena berkas dianggap dikirim ulang dan belum diterima lagi.

Jika tidak memilih file baru, file lama tetap digunakan.

## 10. Alur menghapus berkas

Alurnya:

```text
Klik Hapus
↓
index.php?aksi=hapus&id=id_berkas
↓
BerkasController::hapus()
↓
Berkas::hapusData(id)
↓
DELETE dari tabel berkas
↓
Kembali ke daftar berkas
```

Sebelum link hapus dijalankan, halaman meminta konfirmasi **Yakin ingin menghapus berkas ini?**

## 11. Alur menerima berkas

Tombol **Terima** muncul jika:

- pengguna bukan pengirim berkas;
- berkas belum memiliki tanggal terima.

Alurnya:

```text
Klik Terima
↓
index.php?aksi=terima&id=id_berkas
↓
BerkasController::terima()
↓
Berkas::terimaData(id_berkas, id_user)
↓
tgl_terima diisi tanggal hari ini
↓
status diubah menjadi Diterima
↓
Kembali ke daftar berkas
```

Model hanya mengizinkan penerimaan jika:

- `id_tujuan` sama dengan pengguna yang login; atau
- berkas dikirim ke semua pengguna (`tujuan_semua = 1`).

Sekarang dua informasi sudah diperbarui bersama:

```text
tgl_terima = tanggal hari ini
status     = 'Diterima'
```

Dengan begitu kolom `status` tidak lagi tertinggal dengan kondisi `tgl_terima`.

## 12. Alur mengganti password

Fitur ini dipakai untuk dua keadaan:

- pengguna yang sudah login ingin mengganti password;
- pengguna lupa password dan melakukan verifikasi username serta email.

Alurnya:

```text
index.php?aksi=gantiPassword
↓
PasswordController::ganti()
↓
views/ganti_password.php
↓
Form dikirim ke index.php?aksi=prosesGantiPassword
↓
PasswordController::prosesGanti()
↓
Password lama atau username-email diperiksa
↓
Konfirmasi password diperiksa
↓
Verifikasi angka dijumlahkan
↓
Password baru di-hash
↓
User::gantiPassword(...)
↓
UPDATE tabel user
```

Password baru harus minimal enam karakter dan harus sama dengan konfirmasinya.

Program menyimpan informasi perubahan password pada tabel `user` melalui kolom:

- `pw_diganti`: waktu terakhir password diganti;
- `pw_batas`: jumlah perubahan password;
- `pw_waktuganti`: awal periode penghitungan.

Tabel `password_changes` juga tersedia di database sebagai rancangan untuk riwayat perubahan password secara detail, tetapi kode saat ini belum melakukan `INSERT` ke tabel tersebut.

## 13. Struktur database

Database yang digunakan bernama `e-berkas`.

### Tabel `user`

Tabel ini menyimpan data pengguna:

| Kolom | Kegunaan |
|---|---|
| `id_user` | ID unik pengguna |
| `nama` | Nama pengguna |
| `username` | Nama untuk login |
| `password` | Password yang sudah di-hash |
| `bagian` | Bagian atau divisi pengguna |
| `no_tlp` | Nomor telepon |
| `email` | Email pengguna |
| `role` | `admin` atau `pegawai` |
| `pw_diganti` | Waktu terakhir password diganti |
| `pw_batas` | Jumlah perubahan password |
| `pw_waktuganti` | Awal periode penghitungan password |

### Tabel `berkas`

Tabel ini menyimpan dokumen yang dikirim:

| Kolom | Kegunaan |
|---|---|
| `id_berkas` | ID unik berkas |
| `n_dokumen` | Nama dokumen |
| `tgl_kirim` | Tanggal berkas dikirim |
| `id_pengirim` | ID pengguna yang mengirim |
| `id_tujuan` | ID penerima tertentu |
| `tujuan_semua` | Penanda apakah dikirim ke semua pengguna |
| `tgl_terima` | Tanggal berkas diterima |
| `tujuan` | Kolom tambahan tujuan |
| `keterangan` | Catatan tentang berkas |
| `file_berkas` | Nama file di folder `uploads` |
| `status` | `Dikirim` atau `Diterima` |

Hubungan pengguna dengan berkas:

```text
user.id_user → berkas.id_pengirim
user.id_user → berkas.id_tujuan
```

Satu user bisa menjadi pengirim pada satu berkas dan penerima pada berkas lainnya.

### Tabel `password_changes`

Struktur tabel ini adalah:

| Kolom | Kegunaan |
|---|---|
| `id_change` | ID riwayat |
| `id_user` | Pemilik riwayat |
| `changed_at` | Waktu perubahan password |

Tabel ini memiliki foreign key ke tabel `user`. Namun, pada versi kode sekarang, tabel ini belum dipakai untuk mencatat setiap perubahan password.

## 14. Koneksi database

Koneksi yang dipakai model ada di `config/Koneksi.php`:

```text
Host     : localhost
Username : root
Password : kosong
Database : e-berkas
```

Setiap model membuat objek `Koneksi`, kemudian memakai koneksi tersebut untuk menjalankan query.

`config/database.php` juga berisi koneksi database, tetapi model utama saat ini menggunakan `config/Koneksi.php`.

## 15. Ringkasan alur paling penting

### Login

```text
login.php
→ LoginController::prosesLogin()
→ User::login()
→ tabel user
→ session
→ home.php
```

### Kirim berkas

```text
tambah.php
→ BerkasController::prosesTambah()
→ uploads/
→ Berkas::tambahData()
→ tabel berkas
```

### Terima berkas

```text
tampilan.php
→ BerkasController::terima()
→ Berkas::terimaData()
→ tgl_terima diisi
→ status menjadi Diterima
```

### Edit berkas

```text
edit.php
→ BerkasController::prosesEdit()
→ Berkas::prosesEdit()
→ tgl_terima dikosongkan
→ status menjadi Dikirim
```

## 16. Catatan pengembangan

Secara fungsi dasar aplikasi sudah memiliki alur utama yang lengkap. Beberapa hal yang dapat diperbaiki pada pengembangan berikutnya:

1. Query yang masih menggabungkan input langsung ke SQL sebaiknya diubah menjadi prepared statement.
2. Hak akses edit dan hapus sebaiknya diperiksa juga di controller atau model, bukan hanya disembunyikan dari tampilan.
3. Upload file sebaiknya diberi batas ukuran dan pemeriksaan tipe file.
4. Jika ingin riwayat password lengkap, tambahkan `INSERT` ke tabel `password_changes` setiap kali password berhasil diubah.
5. Kolom `status` dan `tgl_terima` sekarang sudah diperbarui bersama saat berkas diterima.

