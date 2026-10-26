<?php
// Set header agar respons selalu berformat JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Panggil koneksi database (naik 1 folder ke atas)
require_once "../koneksi.php";

// Fungsi helper untuk mengirim respons JSON & HTTP Status Code
function kirim($data, $kode = 200) {
    http_response_code($kode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int)$_GET['id'] : null;
$input  = file_get_contents("php://input");
$body   = json_decode($input, true);

// ------------------------------------------------------------------
// 1. METHOD GET: Ambil Semua Produk / Detail Produk Berdasarkan ID
// ------------------------------------------------------------------
if ($method === 'GET') {
    if ($id) {
        $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
        $stmt->execute([$id]);
        $produk = $stmt->fetch();

        if ($produk) {
            kirim(["status" => "success", "data" => $produk], 200);
        } else {
            kirim(["status" => "error", "message" => "Produk tidak ditemukan"], 404);
        }
    } else {
        $stmt = $pdo->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
        $rows = $stmt->fetchAll();
        kirim(["status" => "success", "total" => count($rows), "data" => $rows], 200);
    }
}

// ------------------------------------------------------------------
// 2. METHOD POST: Tambah Produk Baru
// ------------------------------------------------------------------
if ($method === 'POST') {
    if ($body === null && !empty($input)) {
        kirim(["status" => "error", "message" => "Format JSON tidak valid"], 400);
    }

    $name        = trim($body['name'] ?? '');
    $price       = $body['price'] ?? null;
    $category_id = $body['category_id'] ?? null;
    $description = trim($body['description'] ?? '');
    $image_url   = trim($body['image_url'] ?? '');

    // Validasi data masukan
    if (empty($name) || !is_numeric($price) || $price < 0) {
        kirim(["status" => "error", "message" => "Nama produk wajib diisi dan harga harus berupa angka positif"], 422);
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, price, category_id, description, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $category_id, $description, $image_url]);
    $newId = $pdo->lastInsertId();

    kirim([
        "status" => "success",
        "message" => "Produk berhasil ditambahkan",
        "data" => [
            "id" => (int)$newId,
            "name" => $name,
            "price" => (float)$price,
            "category_id" => $category_id
        ]
    ], 201);
}

// ------------------------------------------------------------------
// 3. METHOD PUT: Ubah / Update Data Produk
// ------------------------------------------------------------------
if ($method === 'PUT') {
    if (!$id) {
        kirim(["status" => "error", "message" => "Parameter ID produk diperlukan"], 400);
    }

    $stmtCek = $pdo->prepare("SELECT id FROM products WHERE id = ?");
    $stmtCek->execute([$id]);
    if (!$stmtCek->fetch()) {
        kirim(["status" => "error", "message" => "Produk dengan ID $id tidak ditemukan"], 404);
    }

    $name        = trim($body['name'] ?? '');
    $price       = $body['price'] ?? null;
    $category_id = $body['category_id'] ?? null;
    $description = trim($body['description'] ?? '');
    $image_url   = trim($body['image_url'] ?? '');

    if (empty($name) || !is_numeric($price) || $price < 0) {
        kirim(["status" => "error", "message" => "Nama produk dan harga valid wajib diisi"], 422);
    }

    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, category_id = ?, description = ?, image_url = ? WHERE id = ?");
    $stmt->execute([$name, $price, $category_id, $description, $image_url, $id]);

    kirim(["status" => "success", "message" => "Produk berhasil diperbarui"], 200);
}

// ------------------------------------------------------------------
// 4. METHOD DELETE: Hapus Produk Berdasarkan ID
// ------------------------------------------------------------------
if ($method === 'DELETE') {
    if (!$id) {
        kirim(["status" => "error", "message" => "Parameter ID produk diperlukan"], 400);
    }

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        kirim(["status" => "success", "message" => "Produk berhasil dihapus"], 200);
    } else {
        kirim(["status" => "error", "message" => "Produk tidak ditemukan"], 404);
    }
}

// Jika method HTTP selain GET, POST, PUT, DELETE
kirim(["status" => "error", "message" => "Method HTTP tidak didukung"], 405);