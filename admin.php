<?php
require_once 'koneksi.php';

// Ambil data produk beserta nama kategorinya
$stmt_produk = $pdo->query("SELECT p.*, c.name AS category_name 
                            FROM products p 
                            LEFT JOIN categories c ON p.category_id = c.id 
                            ORDER BY p.id DESC");
$produk_list = $stmt_produk->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Windi Florist</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container { width: 90%; max-width: 1100px; margin: 40px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #ffccd5; padding-bottom: 15px; }
        .btn-add { background: #d63384; color: white; padding: 10px 18px; text-decoration: none; border-radius: 20px; font-weight: bold; }
        .btn-add:hover { background: #c9184a; }
        .btn-kat { background: #800f2f; color: white; padding: 10px 18px; text-decoration: none; border-radius: 20px; font-weight: bold; margin-right: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ffe6eb; }
        th { background-color: #fff0f3; color: #800f2f; }
        .action-btn { padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 0.85rem; font-weight: bold; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #dc3545; color: white; }
    </style>
</head>
<body>

<header>
    <div class="logo">🌸 Admin Windi Florist</div>
    <nav>
        <ul>
            <li><a href="index.php">Lihat Website</a></li>
            <li><a href="kategori.php">Kelola Kategori</a></li>
            <li><a href="tambah_produk.php">Tambah Produk</a></li>
        </ul>
    </nav>
</header>

<div class="admin-container">
    <div class="admin-header">
        <h2>Daftar Produk Windi Florist</h2>
        <div>
            <a href="kategori.php" class="btn-kat">Kelola Kategori</a>
            <a href="tambah_produk.php" class="btn-add">+ Tambah Produk</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($produk_list) > 0): ?>
                <?php $no = 1; foreach ($produk_list as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><img src="<?= htmlspecialchars($p['image_url'] ?: 'https://images.unsplash.com/photo-1561181286-d3fee7d55364?w=400') ?>" width="60" style="border-radius: 6px;"></td>
                        <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                        <td><?= htmlspecialchars($p['category_name'] ?: 'Tanpa Kategori') ?></td>
                        <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p['description']) ?></td>
                        <td>
                            <a href="edit_produk.php?id=<?= $p['id'] ?>" class="action-btn btn-edit">Edit</a>
                            <a href="hapus_produk.php?id=<?= $p['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #888;">Belum ada data produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>