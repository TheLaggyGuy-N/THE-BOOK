# Penjelasan Proyek Berkas Internal

## 1. Proyek ini untuk apa?

Proyek ini adalah aplikasi **Berkas Internal** atau **e-Ekspedisi**. Aplikasi ini dipakai untuk mengirim dokumen di dalam lingkungan kerja.

Fitur utamanya:

- membuat akun pegawai;
- login dan logout;
- melihat dashboard;
- mengirim berkas ke satu pengguna;
- mengunggah file berkas;
- melihat berkas yang dikirim atau diterima;
- mengedit dan menghapus berkas milik sendiri;
- menerima atau menolak berkas;
- memberi komentar dan pemberitahuan pada berkas;
- mencari berkas;
- mengubah data personal;
- mengganti password dengan verifikasi data personal;
- menyediakan pemantauan berkas dan pengelolaan akun untuk admin.

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
│   ├── tambah.php
│   ├── penerima.php
│   ├── pesan.php
│   ├── profile.php
│   └── list_berkas.php
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
| `aksi=prosesRegister` | `RegisterController` | `prosesRegister()` | Menyimpan akun baru |
| `aksi=home` | `HomeController` | `index()` | Menampilkan dashboard |
| `aksi=logout` | `HomeController` | `logout()` | Menghapus session dan keluar |
| `aksi=profile` | `HomeController` | `profile()` | Menampilkan profil dan data personal |
| `aksi=prosesDataPersonal` | `HomeController` | `prosesDataPersonal()` | Menyimpan data personal |
| `aksi=gantiPassword` | `PasswordController` | `ganti()` | Menampilkan form ganti password |
| `aksi=prosesGantiPassword` | `PasswordController` | `prosesGanti()` | Mengubah password mandiri atau admin |
| `aksi=berkas` | `BerkasController` | `index()` | Menampilkan daftar berkas |
| `aksi=penerima` | `BerkasController` | `penerima()` | Menampilkan berkas untuk pengguna |
| `aksi=prosesKomentar` | `BerkasController` | `prosesKomentar()` | Menyimpan komentar |
| `aksi=tambah` | `BerkasController` | `tambah()` | Menampilkan form tambah berkas |
| `aksi=prosesTambah` | `BerkasController` | `prosesTambah()` | Menyimpan berkas baru |
| `aksi=edit&id=...` | `BerkasController` | `edit()` | Menampilkan form edit |
| `aksi=prosesEdit` | `BerkasController` | `prosesEdit()` | Menyimpan perubahan berkas |
| `aksi=hapus&id=...` | `BerkasController` | `hapus()` | Menghapus berkas |
| `aksi=terima&id=...` | `BerkasController` | `terima()` | Menandai berkas sudah diterima |
| `aksi=terimaKelompok` | `BerkasController` | `terimaKelompok()` | Menerima satu kelompok berkas |
| `aksi=belumDapatDiterima` | `BerkasController` | `belumDapatDiterima()` | Memberi tahu pengirim bahwa berkas belum dapat diterima |
| `aksi=tolakKelompok` | `BerkasController` | `tolakKelompok()` | Menolak satu kelompok berkas |
| `aksi=kotakPesan` | `BerkasController` | `kotakPesan()` | Menampilkan pesan |
| `aksi=bacaPesan&id=...` | `BerkasController` | `bacaPesan()` | Menandai pesan sudah dibaca |
| `aksi=kirimPengingat` | `BerkasController` | `kirimPengingat()` | Mengirim pengingat penerimaan |

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
Password dibandingkan dengan data pada tabel user
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
Home admin
↓
Form pembuatan akun dikirim ke index.php?aksi=prosesRegister
↓
RegisterController::prosesRegister()
↓
Password diteruskan ke proses penyimpanan
↓
User::register(...)
↓
INSERT ke tabel user
↓
Kembali ke halaman home admin
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
views/list_berkas.php menampilkan tabel
```

Satu pengguna dapat melihat berkas jika:

- `id_tujuan` sama dengan ID pengguna yang sedang login;
- pengguna tersebut adalah pengirimnya.

Daftar berkas dapat dicari menggunakan parameter `q`. Pencarian dilakukan pada nama dokumen, nama pengguna, tanggal, status, dan keterangan melalui `Berkas::tampilData()`.

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

Tujuan pengiriman dipilih dari satu pengguna lain. `id_tujuan` diisi sesuai pengguna yang dipilih.

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
Komentar dan pesan terkait ikut dihapus
↓
File fisik di folder uploads/ ikut dihapus
↓
Kembali ke daftar berkas
```

Sebelum link hapus dijalankan, halaman meminta konfirmasi **Yakin ingin menghapus berkas ini?**. Model mengambil nama file, menghapus data terkait, menghapus baris berkas, lalu menjalankan `unlink()` pada file fisik jika file tersebut masih ada.

## 11. Alur menerima berkas

Tombol **Terima** muncul jika:

- pengguna bukan pengirim berkas;
- berkas masih berstatus `Dikirim`.

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

Model hanya mengizinkan penerimaan jika `id_tujuan` sama dengan pengguna yang login dan status berkas masih `Dikirim`.

Sekarang dua informasi sudah diperbarui bersama:

```text
tgl_terima = tanggal hari ini
status     = 'Diterima'
```

Dengan begitu kolom `status` tidak lagi tertinggal dengan kondisi `tgl_terima`.

### Alur menolak berkas

Penerima dapat memilih **Tolak Berkas** pada halaman `views/penerima.php`.

```text
Klik Tolak Berkas
↓
index.php?aksi=tolakKelompok
↓
BerkasController::tolakKelompok()
↓
Berkas::tolakKelompok()
↓
status diubah menjadi Ditolak
↓
Pesan penolakan dikirim kepada pengirim
↓
Kembali ke halaman penerima
```

Berkas berstatus `Ditolak` tidak dapat diterima lagi dan tidak dihitung sebagai berkas yang masih menunggu.

### Alur komentar dan pesan

Komentar dikirim melalui `aksi=prosesKomentar` dan disimpan di tabel `komentar_berkas`. Hanya pengirim atau penerima berkas yang dapat menambahkan komentar.

Pesan sistem, pengingat, dan notifikasi penolakan disimpan di tabel `pesan_berkas`. Daftar pesan ditampilkan melalui `aksi=kotakPesan`, sedangkan `aksi=bacaPesan` menandai pesan sebagai sudah dibaca.

### Alur data personal

Data personal pengguna terdiri dari:

- `hobi`;
- `makanan_favorit`;
- `hewan_favorit`.

Data diubah melalui `views/profile.php`, `HomeController::prosesDataPersonal()`, dan `User::ubahDataPersonal()`. Minimal satu dari tiga data tersebut harus diisi agar pengguna dapat mengirim berkas.

Jika pengguna belum mengisi data personal, halaman Home menampilkan alert dan proses pengiriman akan diarahkan kembali ke Profil.

### Alur ganti password mandiri

Pengguna dapat membuka `aksi=gantiPassword` dan mengisi salah satu data personal yang cocok. Pengecekan dilakukan oleh `User::verifikasiDataPersonal()`. Jika cocok, password diubah melalui `User::ubahPassword()`.

### Alur admin mengubah password

Hanya admin yang dapat mengubah password pengguna dari halaman home.

```text
Home admin
↓
Form dikirim ke index.php?aksi=prosesGantiPassword
↓
PasswordController::prosesGanti()
↓
Pengguna dipilih oleh admin
↓
Konfirmasi password diperiksa
↓
User::ubahPassword(...)
↓
UPDATE kolom password pada tabel user
```

Password baru harus minimal enam karakter dan harus sama dengan konfirmasinya. Pengguna biasa harus memberikan salah satu data personal yang cocok. Admin dapat mengganti password pengguna dari halaman Home.

## 13. Struktur database

Database yang digunakan bernama `e-berkas`.

### Tabel `user`

Tabel ini menyimpan data pengguna:

| Kolom | Kegunaan |
|---|---|
| `id_user` | ID unik pengguna |
| `nama` | Nama pengguna |
| `username` | Nama untuk login |
| `password` | Password akun |
| `bagian` | Bagian atau divisi pengguna |
| `role` | `admin` atau `pegawai` |
| `hobi` | Data personal untuk verifikasi |
| `makanan_favorit` | Data personal untuk verifikasi |
| `hewan_favorit` | Data personal untuk verifikasi |

### Tabel `berkas`

Tabel ini menyimpan dokumen yang dikirim:

| Kolom | Kegunaan |
|---|---|
| `id_berkas` | ID unik berkas |
| `n_dokumen` | Nama dokumen |
| `tgl_kirim` | Tanggal berkas dikirim |
| `id_pengirim` | ID pengguna yang mengirim |
| `id_tujuan` | ID penerima tertentu |
| `tujuan_semua` | Kolom lama untuk penanda tujuan semua pengguna |
| `tgl_terima` | Tanggal berkas diterima |
| `tujuan` | Kolom tambahan tujuan |
| `keterangan` | Catatan tentang berkas |
| `file_berkas` | Nama file di folder `uploads` |
| `status` | `Dikirim`, `Diterima`, atau `Ditolak` |

Hubungan pengguna dengan berkas:

```text
user.id_user → berkas.id_pengirim
user.id_user → berkas.id_tujuan
```

Relasi tersebut memakai foreign key dengan `ON DELETE SET NULL` dan `ON UPDATE CASCADE`. Jika user dihapus, histori berkas tetap dipertahankan dan ID user yang terkait menjadi `NULL`.

Satu user bisa menjadi pengirim pada satu berkas dan penerima pada berkas lainnya.

## 14. Koneksi database

Koneksi yang dipakai model ada di `config/Koneksi.php`:

```text
Host     : localhost
Username : root
Password : kosong
Database : e-berkas
```

Setiap model membuat objek `Koneksi`, kemudian memakai koneksi tersebut untuk menjalankan query.

Model utama saat ini menggunakan `config/Koneksi.php`.

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
list_berkas.php atau penerima.php
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

### Tolak berkas

```text
penerima.php
→ BerkasController::tolakKelompok()
→ Berkas::tolakKelompok()
→ status menjadi Ditolak
→ pesan dikirim kepada pengirim
```

## 16. Catatan pengembangan

Secara fungsi dasar aplikasi sudah memiliki alur utama yang lengkap. Beberapa hal yang dapat diperbaiki pada pengembangan berikutnya:

1. Password sebaiknya dipindahkan ke `password_hash()` dan `password_verify()`.
2. Query yang masih menggabungkan input langsung ke SQL sebaiknya diubah menjadi prepared statement.
3. Hak akses edit dan hapus sebaiknya diperiksa juga di controller atau model, bukan hanya disembunyikan dari tampilan.
4. Upload file sebaiknya diberi batas ukuran dan pemeriksaan tipe file.
5. Kolom `status` dan `tgl_terima` sekarang sudah diperbarui bersama saat berkas diterima.