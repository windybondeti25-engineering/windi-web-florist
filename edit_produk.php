<?php
require_once 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: admin.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();
if (!$produk) { header('Location: admin.php'); exit; }

$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'] ?: null;
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']);

    if ($name && $price) {
        $stmt_upd = $pdo->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, image_url = ? WHERE id = ?");
        $stmt_upd->execute([$category_id, $name, $description, $price, $image_url, $id]);
        header('Location: admin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - Windi Florist</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container { width: 90%; max-width: 600px; margin: 40px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #800f2f; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ffccd5; border-radius: 8px; font-size: 1rem; }
        .btn-submit { background: #d63384; color: white; border: none; padding: 12px 20px; border-radius: 20px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-submit:hover { background: #c9184a; }
    </style>
</head>
<body>
<div class="form-container">
    <h2 style="color: #800f2f; margin-bottom: 20px;">Edit Produk Windi Florist</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="name" value="<?= htmlspecialchars($produk['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $produk['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="price" value="<?= $produk['price'] ?>" required>
        </div>
        <div class="form-group">
            <label>URL Gambar</label>
            <input type="url" name="image_url" value="<?= htmlspecialchars($produk['image_url']) ?>">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="4"><?= htmlspecialchars($produk['description']) ?></textarea>
        </div>
        <button type="submit" class="btn-submit">Update Produk</button>
        <p style="text-align: center; margin-top: 15px;"><a href="admin.php" style="color: #800f2f;">Batal / Kembali</a></p>
    </form>
</div>
</body>
</html>