# Dokumentasi API TelurKu

Base URL: `http://<IP-VPS-ANDA>/api`

## Authentication

### Register
- **Endpoint**: `POST /register`
- **Body**:
  ```json
  {
    "name": "Nama User",
    "email": "user@example.com",
    "password": "password123"
  }
  ```
- **Response**: Token (simpan untuk request selanjutnya)

### Login
- **Endpoint**: `POST /login`
- **Body**:
  ```json
  {
    "email": "user@example.com",
    "password": "password123"
  }
  ```
- **Response**: Token

### Logout
- **Endpoint**: `POST /logout`
- **Headers**: `Authorization: Bearer <token>`

## Kandang

### List Kandang
- **Endpoint**: `GET /kandangs`
- **Headers**: `Authorization: Bearer <token>`

### Tambah Kandang
- **Endpoint**: `POST /kandangs`
- **Headers**: `Authorization: Bearer <token>`
- **Body**:
  ```json
  {
    "nama_kandang": "Kandang A",
    "kapasitas": 1000,
    "jumlah_ayam": 1000,
    "keterangan": "Opsional"
  }
  ```

## Laporan Harian

### List Laporan
- **Endpoint**: `GET /laporan-harian`
- **Headers**: `Authorization: Bearer <token>`
- **Params**: `?kandang_id=1&tanggal=2023-10-27` (Opsional)

### Buat Laporan
- **Endpoint**: `POST /laporan-harian`
- **Headers**: `Authorization: Bearer <token>`
- **Body**:
  ```json
  {
    "kandang_id": 1,
    "tanggal": "2023-10-27",
    "jumlah_telur": 850,
    "ayam_mati": 2,
    "ayam_sakit": 0,
    "pakan_kg": 110.5,
    "suhu_kandang": 28.5,
    "catatan": "Ayam sehat"
  }
  ```
  *Note: `ayam_mati` akan otomatis mengurangi `jumlah_ayam` di data Kandang.*

## Stok Pakan

### List Stok
- **Endpoint**: `GET /stok-pakan`
- **Headers**: `Authorization: Bearer <token>`

### Tambah Jenis Pakan Baru
- **Endpoint**: `POST /stok-pakan`
- **Headers**: `Authorization: Bearer <token>`
- **Body**:
  ```json
  {
    "nama_pakan": "Jagung Giling",
    "stok_kg": 0,
    "harga_per_kg": 5000
  }
  ```

### Transaksi Pakan (Masuk/Keluar)
- **Endpoint**: `POST /stok-pakan/transaksi`
- **Headers**: `Authorization: Bearer <token>`
- **Body**:
  ```json
  {
    "stok_pakan_id": 1,
    "tipe": "masuk", // atau "keluar"
    "jumlah_kg": 500,
    "keterangan": "Beli dari Supplier A"
  }
  ```
