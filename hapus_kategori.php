<?php
require_once 'koneksi.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: kategori.php');
exit;
?>