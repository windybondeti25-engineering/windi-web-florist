# Dokumentasi REST API - Windi Florist

## 1. Rancangan Endpoint API (`/api/products.php`)

| Method | Endpoint | Deskripsi | Status Code | Body Request (JSON) |
| :--- | :--- | :--- | :--- | :--- |
| **GET** | `/api/products.php` | Ambil semua daftar produk buket | `200 OK` | Tidak ada |
| **GET** | `/api/products.php?id={id}` | Ambil detail 1 produk spesifik | `200 OK` / `404 Not Found` | Tidak ada |
| **POST** | `/api/products.php` | Tambah produk buket baru | `201 Created` / `422 Unprocessable` | `{"name": "...", "price": 150000, "category_id": 1, "description": "...", "image_url": "..."}` |
| **PUT** | `/api/products.php?id={id}` | Update data produk berdasarkan ID | `200 OK` / `404` / `422` | `{"name": "...", "price": 160000, "category_id": 1, "description": "...", "image_url": "..."}` |
| **DELETE**| `/api/products.php?id={id}` | Hapus produk berdasarkan ID | `200 OK` / `404 Not Found` | Tidak ada |

---

## 2. Uji Coba cURL / Postman

### Tambah Produk (POST)
```bash
curl -X POST http://localhost/WINDI_WEB_FLORIST/api/products.php \
  -H "Content-Type: application/json" \
  -d '{"name":"Buket Mawar Lily Deluxe","price":175000,"category_id":1,"description":"Buket mawar pink segar","image_url":""}'