<?php
require_once 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: kategori.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();
if (!$cat) { header('Location: kategori.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    if ($name) {
        $stmt_upd = $pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
        $stmt_upd->execute([$name, $description, $id]);
        header('Location: kategori.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - Windi Florist</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { width: 90%; max-width: 500px; margin: 40px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #800f2f; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ffccd5; border-radius: 8px; }
        .btn-save { background: #d63384; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold; width: 100%; }
    </style>
</head>
<body>
<div class="container">
    <h2 style="color: #800f2f; margin-bottom: 15px;">Edit Kategori</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Deskripsi Kategori</label>
            <textarea name="description" rows="3"><?= htmlspecialchars($cat['description']) ?></textarea>
        </div>
        <button type="submit" class="btn-save">Update Kategori</button>
        <p style="text-align: center; margin-top: 15px;"><a href="kategori.php" style="color: #800f2f;">Batal</a></p>
    </form>
</div>
</body>
</html>