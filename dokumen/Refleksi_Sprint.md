# Jawaban Cek Pemahaman & Refleksi Sprint - Windi Florist

## A. Jawaban Cek Pemahaman

1. **Mengapa endpoint memakai kata benda, bukan kata kerja?**
   - Karena REST API berorientasi pada resource (sumber data). URL/endpoint berfungsi menunjuk ke alamat sumber data tersebut (`/products`), sedangkan kata kerjanya diwakili oleh HTTP Method (`GET` untuk mengambil, `POST` untuk membuat, `PUT` untuk mengubah, `DELETE` untuk menghapus).

2. **Apa beda status code 400, 404, dan 422?**
   - **400 Bad Request**: Kiriman data JSON rusak secara sintaks (misal kurang tanda kurung kerawal atau koma salah).
   - **404 Not Found**: Endpoint atau ID produk yang dicari tidak ada di database.
   - **422 Unprocessable Entity**: Format JSON sudah benar, tetapi isi datanya tidak lolos validasi bisnis (misalnya nama produk kosong atau harga bernilai negatif).

3. **Mengapa POST yang berhasil memakai status code 201, bukan 200?**
   - Status `201 Created` secara spesifik menginformasikan kepada klien bahwa proses pembuatan resource baru di server telah berhasil dilakukan, sedangkan `200 OK` digunakan untuk aksi umum yang berhasil tanpa serta-merta membuat resource baru.

4. **Apa arti stateless pada REST?**
   - *Stateless* berarti setiap request yang dikirimkan oleh klien ke server harus berdiri sendiri dan membawa semua informasi yang dibutuhkan. Server tidak menyimpan riwayat sesi (*session/state*) dari request sebelumnya.

---

## B. Refleksi Sprint PBL

1. **Apa yang sudah benar-benar saya pahami?**
   - Memahami konsep arsitektur REST API, pembuatan fungsi pengiriman JSON pada PHP PDO, penggunaan HTTP Status Code yang tepat, serta mengintegrasikan data API ke antarmuka HTML menggunakan JavaScript `fetch()`.

2. **Bagian mana yang masih saya ikuti tanpa memahami?**
   - Pembacaan input mentah `php://input` untuk menangkap payload JSON pada method `POST` dan `PUT` awal mulanya membingungkan, tetapi setelah dicoba langsung menjadi lebih paham fungsinya.

3. **Bug/kesalahan apa yang muncul dan bagaimana saya memperbaikinya?**
   - *Error Connection Refused*: Terjadi karena Apache XAMPP belum diaktifkan. Solusinya dengan menekan tombol Start pada modul Apache dan MySQL di XAMPP Control Panel.

4. **Apa kontribusi saya pada sprint ini?**
   - Merancang struktur endpoint API produk, mengimplementasikan validasi input data JSON, membuat dokumentasi API, dan mengintegrasikan halaman katalog website Windi Florist dengan REST API secara terpisah (*decoupled architecture*).