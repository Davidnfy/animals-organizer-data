<?php

require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Hapus data dari database
$stmt = $conn->prepare("DELETE FROM pets WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?success=1");
} else {
    header("Location: index.php?error=" . urlencode("Gagal menghapus data: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
