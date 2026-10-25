<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
        header('Location: kategori.php');
        exit;
    }
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kategori - Windi Florist</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { width: 90%; max-width: 900px; margin: 40px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ffe6eb; }
        th { background-color: #fff0f3; color: #800f2f; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #800f2f; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ffccd5; border-radius: 8px; }
        .btn-save { background: #d63384; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold; }
        .btn-edit { background: #ffc107; color: #333; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
        .btn-del { background: #dc3545; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
    </style>
</head>
<body>

<header>
    <div class="logo">🌸 Kategori Windi Florist</div>
    <nav>
        <ul>
            <li><a href="admin.php">Kembali ke Dashboard Admin</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2 style="color: #800f2f; margin-bottom: 15px;">Tambah Kategori Produk Baru</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="name" required placeholder="Contoh: Buket Acrylic / Money Bouquet">
        </div>
        <div class="form-group">
            <label>Deskripsi Kategori</label>
            <textarea name="description" rows="2" placeholder="Penjelasan singkat kategori..."></textarea>
        </div>
        <button type="submit" class="btn-save">Simpan Kategori</button>
    </form>

    <hr style="margin: 30px 0; border: none; border-top: 1px solid #ffccd5;">

    <h3 style="color: #800f2f;">Daftar Kategori</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><strong><?= htmlspecialchars($cat['name']) ?></strong></td>
                    <td><?= htmlspecialchars($cat['description']) ?></td>
                    <td>
                        <a href="edit_kategori.php?id=<?= $cat['id'] ?>" class="btn-edit">Edit</a>
                        <a href="hapus_kategori.php?id=<?= $cat['id'] ?>" class="btn-del" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>